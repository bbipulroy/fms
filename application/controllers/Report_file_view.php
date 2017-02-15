<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_file_view extends Root_Controller
{
    private $message;
    public $permissions;
    public $controller_url;
    public function __construct()
    {
        parent::__construct();
        $this->message='';
        $this->permissions=User_helper::get_permission('Report_file_view');
        $this->controller_url='report_file_view';
    }
    public function index($action='search',$id=0)
    {
        if($action=='search')
        {
            $this->system_search();
        }
        elseif($action=='list')
        {
            $this->system_list();
        }
        elseif($action=='get_items')
        {
            $this->system_get_items();
        }
        elseif($action=='details')
        {
            $this->system_details($id);
        }
        else
        {
            $this->system_search();
        }
    }
    private function system_search()
    {
        if(isset($this->permissions['action1']) && ($this->permissions['action1']==1))
        {
            $data['title']='Report View';
            $data['item']=array
            (
                'id_category'=>'',
                'id_class'=>'',
                'id_type'=>'',
                'id_name'=>'',
                'date_from_start_file'=>'',
                'date_to_start_file'=>'',
                'date_from_start_page'=>'',
                'date_to_start_page'=>'',
                'id_office'=>'',
                'id_department'=>'',
                'employee_responsible'=>''
            );
            $data['categories']=Query_helper::get_info($this->config->item('table_fms_setup_file_category'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'),0,0,array('ordering ASC'));
            $data['classes']=array();
            $data['types']=array();
            $data['names']=array();

            $this->db->select('id value,name text');
            $this->db->from($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_offices'));
            $this->db->where('status',$this->config->item('system_status_active'));
            $this->db->order_by('ordering');
            $data['offices']=$this->db->get()->result_array();

            $this->db->select('id value,name text');
            $this->db->from($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_department'));
            $this->db->where('status',$this->config->item('system_status_active'));
            $this->db->order_by('ordering');
            $data['departments']=$this->db->get()->result_array();

            $data['employees']=array();
            $ajax['system_page_url']=site_url($this->controller_url.'/index/search');
            $ajax['system_content'][]=array('id'=>'#system_content','html'=>$this->load->view($this->controller_url.'/search',$data,true));
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['status']=true;
            $this->json_return($ajax);
        }
        else
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->lang->line('YOU_DONT_HAVE_ACCESS');
            $this->json_return($ajax);
        }
    }
    private function system_list()
    {
        if(isset($this->permissions['action0']) && ($this->permissions['action0']==1))
        {
            $item=$this->input->post('item');
            if($item['id_name']>0)
            {
                $data=array();
                $this->get_data($data,$item['id_name'],System_helper::get_time($item['date_from_start_page']),System_helper::get_time($item['date_to_start_page']));
                $ajax['system_content'][]=array('id'=>'#system_report_container','html'=>$this->load->view($this->controller_url.'/details',$data,true));
            }
            else
            {
                $data['title']='Report for '.$this->lang->line('LABEL_FILE_NAME').' List';
                $ajax_post='';
                foreach($item as $key=>$val)
                {
                    $ajax_post.=$key.':"'.$val.'",';
                }
                $data['ajax_post']=substr($ajax_post,0,-1);
                $ajax['system_content'][]=array('id'=>'#system_report_container','html'=>$this->load->view($this->controller_url.'/list',$data,true));
            }
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=site_url($this->controller_url.'/index/search');
            $ajax['status']=true;
            $this->json_return($ajax);
        }
        else
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->lang->line('YOU_DONT_HAVE_ACCESS');
            $this->json_return($ajax);
        }
    }
    private function system_details($id)
    {
        $id=$this->input->post('id');
        $html_id=$this->input->post('html_container_id');
        $date_from_start_page=System_helper::get_time($this->input->post('date_from_start_page'));
        $date_to_start_page=System_helper::get_time($this->input->post('date_to_start_page'));

        $data=array();
        $this->get_data($data,$id,$date_from_start_page,$date_to_start_page);
        $ajax['system_content'][]=array('id'=>$html_id,'html'=>$this->load->view($this->controller_url.'/details',$data,true));
        if($this->message)
        {
            $ajax['system_message']=$this->message;
        }
        $ajax['status']=true;
        $this->json_return($ajax);
    }
    private function get_data(&$data,$id_file_name,$date_from_start_page,$date_to_start_page)
    {
        $this->db->select('n.id,n.name,n.date_start,ctg.name category_name,cls.name class_name,t.name type_name,hl.name hardcopy_location,CONCAT(ui.name,\' - \',u.employee_id) employee_name,d.name department_name,o.name office_name');
        $this->db->select('SUM(CASE WHEN df.status=\''.$this->config->item('system_status_active').'\' AND df.type=\''.$this->config->item('system_digital_file_image').'\' THEN 1 ELSE 0 END) number_of_page');
        $this->db->from($this->config->item('table_fms_setup_file_name').' n');
        $this->db->join($this->config->item('table_fms_setup_file_type').' t','n.id_type=t.id');
        $this->db->join($this->config->item('table_fms_setup_file_class').' cls','t.id_class=cls.id');
        $this->db->join($this->config->item('table_fms_setup_file_category').' ctg','cls.id_category=ctg.id');
        $this->db->join($this->config->item('table_fms_setup_file_hc_location').' hl','hl.id=n.id_hc_location');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_user_info').' ui','ui.user_id=n.employee_responsible','left');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_user').' u','ui.user_id=u.id');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_department').' d','d.id=n.id_department','left');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_offices').' o','o.id=n.id_office','left');
        $this->db->join($this->config->item('table_fms_tasks_digital_file').' df','df.id_file_name=n.id','left');
        $this->db->where('ui.revision',1);
        $this->db->where('n.id',$id_file_name);
        $this->db->where('n.status',$this->config->item('system_status_active'));
        $data['details']=$this->db->get()->row_array();

        $this->db->select('name,date_entry,remarks,mime_type');
        $this->db->from($this->config->item('table_fms_tasks_digital_file'));
        $this->db->where('id_file_name',$id_file_name);
        $this->db->where('status',$this->config->item('system_status_active'));
        $this->two_date_between_query_generator($date_from_start_page,$date_to_start_page,'date_entry');
        $data['files_info']=$this->db->get()->result_array();
    }
    private function system_get_items()
    {
        $id_category=$this->input->post('id_category');
        $id_class=$this->input->post('id_class');
        $id_type=$this->input->post('id_type');
        $employee_responsible=$this->input->post('employee_responsible');
        $id_department=$this->input->post('id_department');
        $id_office=$this->input->post('id_office');
        $date_from_start_file=$this->input->post('date_from_start_file');
        $date_to_start_file=$this->input->post('date_to_start_file');

        $this->db->select('n.id,n.name,n.date_start,n.ordering,hl.name hardcopy_location,t.name type_name,cls.name class_name,ctg.name category_name,CONCAT(ui.name,\' - \',u.employee_id) employee_name,d.name department_name,o.name office_name');
        $this->db->from($this->config->item('table_fms_setup_file_name').' n');
        $this->db->from($this->config->item('table_fms_setup_file_hc_location').' hl','hl.id=n.id_hc_location');
        $this->db->join($this->config->item('table_fms_setup_file_type').' t','t.id=n.id_type');
        $this->db->join($this->config->item('table_fms_setup_file_class').' cls','cls.id=t.id_class');
        $this->db->join($this->config->item('table_fms_setup_file_category').' ctg','ctg.id=cls.id_category');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_user_info').' ui','ui.user_id=n.employee_responsible','left');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_user').' u','ui.user_id=u.id');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_department').' d','d.id=n.id_department','left');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_offices').' o','o.id=n.id_office','left');
        $this->db->where('ui.revision',1);
        if($id_type>0)
        {
            $this->db->where('n.id_type',$id_type);
        }
        elseif($id_class>0)
        {
            $where_in='SELECT id FROM '.$this->config->item('table_fms_setup_file_type').' WHERE id_class='.$id_class;
            $this->db->where_in('n.id_type',$where_in,false);
        }
        elseif($id_category>0)
        {
            $where_in='SELECT id FROM '.$this->config->item('table_fms_setup_file_type').' WHERE id_class IN (SELECT id FROM '.$this->config->item('table_fms_setup_file_class').' WHERE id_category='.$id_category.')';
            $this->db->where_in('n.id_type',$where_in,false);
        }


        if($id_office>0 && $id_department>0 && $employee_responsible>0)
        {
            $where='(n.id_office='.$id_office.' OR '.'n.id_department='.$id_department.' OR '.'n.employee_responsible='.$employee_responsible.')';
            $this->db->where($where,'',false);
        }
        elseif($id_office>0 && $id_department>0)
        {
            $where='(n.id_office='.$id_office.' OR '.'n.id_department='.$id_department.')';
            $this->db->where($where,'',false);
        }
        elseif($id_office>0 && $employee_responsible>0)
        {
            $where='(n.id_office='.$id_office.' OR '.'n.employee_responsible='.$employee_responsible.')';
            $this->db->where($where,'',false);
        }
        elseif($id_department>0 && $employee_responsible>0)
        {
            $where='(n.id_department='.$id_department.' OR '.'n.employee_responsible='.$employee_responsible.')';
            $this->db->where($where,'',false);
        }
        elseif($id_office>0)
        {
            $this->db->where('n.id_office',$id_office);
        }
        elseif($id_department>0)
        {
            $this->db->where('n.id_department',$id_department);
        }
        elseif($employee_responsible>0)
        {
            $this->db->where('n.employee_responsible',$employee_responsible);
        }
        $this->two_date_between_query_generator(System_helper::get_time($date_from_start_file),System_helper::get_time($date_to_start_file),'n.date_start');
        $this->db->where('n.status',$this->config->item('system_status_active'));
        $this->db->group_by('n.id');
        $this->db->order_by('n.ordering');
        $temp=$this->db->get()->result_array();
        foreach($temp as &$value)
        {
            $value['date_start']=System_helper::display_date($value['date_start']);
        }
        $this->json_return($temp);
    }
    private function two_date_between_query_generator($start_date,$end_date,$field)
    {
        if($start_date>0)
        {
            $this->db->where($field.'>=',$start_date);
        }
        if($end_date>0)
        {
            $this->db->where($field.'<=',$end_date);
        }
    }
}
