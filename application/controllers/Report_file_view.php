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
        if(isset($this->permissions['action0']) && ($this->permissions['action0']==1))
        {
            $data['title']='Report View';
            $data['item']=array
            (
                'id_category'=>'',
                'id_sub_category'=>'',
                'id_class'=>'',
                'id_type'=>'',
                'id_name'=>'',
                'date_from_start_file'=>'',
                'date_to_start_file'=>'',
                'date_from_start_page'=>'',
                'date_to_start_page'=>'',
                'id_office'=>'',
                'id_department'=>'',
                'employee_id'=>''
            );
            $data['categories']=Query_helper::get_info($this->config->item('table_fms_setup_file_category'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'),0,0,array('ordering ASC'));
            $data['sub_categories']=array();
            $data['classes']=array();
            $data['types']=array();
            $data['names']=array();

            $data['offices']=Query_helper::get_info($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_offices'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'),0,0,array('ordering ASC'));
            $data['departments']=Query_helper::get_info($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_department'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'),0,0,array('ordering ASC'));

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
                $this->get_file_info($data,$item['id_name'],System_helper::get_time($item['date_from_start_page']),System_helper::get_time($item['date_to_start_page']));
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
        $this->get_file_info($data,$id,$date_from_start_page,$date_to_start_page);
        $ajax['system_content'][]=array('id'=>$html_id,'html'=>$this->load->view($this->controller_url.'/details',$data,true));
        if($this->message)
        {
            $ajax['system_message']=$this->message;
        }
        $ajax['status']=true;
        $this->json_return($ajax);
    }
    private function get_file_info(&$data,$id_file_name,$date_from_start_page,$date_to_start_page)
    {
        $this->db->select('n.id,n.name,n.date_start');
        $this->db->select('ctg.name category_name');
        $this->db->select('sctg.name sub_category_name');
        $this->db->select('cls.name class_name');
        $this->db->select('cls.name class_name');
        $this->db->select('t.name type_name');
        $this->db->select('t.name type_name');
        $this->db->select('hl.name hardcopy_location');
        $this->db->select('CONCAT(ui.name," - ",u.employee_id) employee_name');
        $this->db->select('d.name department_name');
        $this->db->select('o.name office_name');
        $this->db->select('SUM(CASE WHEN df.status="'.$this->config->item('system_status_active').'" AND SUBSTRING(df.mime_type,1,5)="image" THEN 1 ELSE 0 END) number_of_page');
        $this->db->from($this->config->item('table_fms_setup_file_name').' n');
        $this->db->join($this->config->item('table_fms_setup_file_type').' t','n.id_type=t.id');
        $this->db->join($this->config->item('table_fms_setup_file_class').' cls','t.id_class=cls.id');
        $this->db->join($this->config->item('table_fms_setup_file_sub_category').' sctg','cls.id_sub_category=sctg.id');
        $this->db->join($this->config->item('table_fms_setup_file_category').' ctg','sctg.id_category=ctg.id');
        $this->db->join($this->config->item('table_fms_setup_file_hc_location').' hl','hl.id=n.id_hc_location');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_user_info').' ui','ui.user_id=n.employee_id','left');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_user').' u','ui.user_id=u.id');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_department').' d','d.id=n.id_department','left');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_offices').' o','o.id=n.id_office','left');
        $this->db->join($this->config->item('table_fms_tasks_digital_file').' df','df.id_file_name=n.id','left');
        $this->db->where('ui.revision',1);
        $this->db->where('n.id',$id_file_name);
        $this->db->where('n.status',$this->config->item('system_status_active'));
        $data['item']=$this->db->get()->row_array();

        $this->db->select('name,date_entry,remarks,mime_type,file_path');
        $this->db->from($this->config->item('table_fms_tasks_digital_file'));
        $this->db->where('id_file_name',$id_file_name);
        $this->db->where('status',$this->config->item('system_status_active'));
        $this->two_date_between_query_generator($date_from_start_page,$date_to_start_page,'date_entry');
        $data['stored_files']=$this->db->get()->result_array();
    }
    private function system_get_items()
    {
        $id_category=$this->input->post('id_category');
        $id_sub_category=$this->input->post('id_sub_category');
        $id_class=$this->input->post('id_class');
        $id_type=$this->input->post('id_type');
        $employee_id=$this->input->post('employee_id');
        $id_department=$this->input->post('id_department');
        $id_office=$this->input->post('id_office');
        $date_from_start_file=$this->input->post('date_from_start_file');
        $date_to_start_file=$this->input->post('date_to_start_file');

        $this->db->select('n.id,n.name,n.date_start,n.ordering');
        $this->db->select('hl.name hardcopy_location');
        $this->db->select('t.name type_name');
        $this->db->select('t.name type_name');
        $this->db->select('cls.name class_name');
        $this->db->select('sctg.name sub_category_name');
        $this->db->select('ctg.name category_name');
        $this->db->select('CONCAT(ui.name," - ",u.employee_id) employee_name');
        $this->db->select('d.name department_name');
        $this->db->select('o.name office_name');
        $this->db->from($this->config->item('table_fms_setup_file_name').' n');
        $this->db->from($this->config->item('table_fms_setup_file_hc_location').' hl','hl.id=n.id_hc_location');
        $this->db->join($this->config->item('table_fms_setup_file_type').' t','t.id=n.id_type');
        $this->db->join($this->config->item('table_fms_setup_file_class').' cls','cls.id=t.id_class');
        $this->db->join($this->config->item('table_fms_setup_file_sub_category').' sctg','sctg.id=cls.id_sub_category');
        $this->db->join($this->config->item('table_fms_setup_file_category').' ctg','ctg.id=sctg.id_category');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_user_info').' ui','ui.user_id=n.employee_id','left');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_user').' u','ui.user_id=u.id');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_department').' d','d.id=n.id_department','left');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_offices').' o','o.id=n.id_office','left');
        $this->db->where('ui.revision',1);
        $where_in=false;
        if($id_type>0)
        {
            $this->db->where('n.id_type',$id_type);
        }
        elseif($id_class>0)
        {
            $where_in='SELECT id FROM '.$this->config->item('table_fms_setup_file_type').' WHERE id_class='.$id_class;
        }
        elseif($id_sub_category>0)
        {
            $where_in='SELECT id FROM '.$this->config->item('table_fms_setup_file_type').' WHERE id_class IN (SELECT id FROM '.$this->config->item('table_fms_setup_file_class').' WHERE id_sub_category='.$id_sub_category.')';
        }
        elseif($id_category>0)
        {
            $where_in='SELECT id FROM '.$this->config->item('table_fms_setup_file_type').' WHERE id_class IN (SELECT id FROM '.$this->config->item('table_fms_setup_file_class').' WHERE id_sub_category IN (SELECT id FROM '.$this->config->item('table_fms_setup_file_sub_category').' WHERE id_category='.$id_category.'))';
        }

        if($where_in!==false)
        {
            $this->db->where_in('n.id_type',$where_in,false);
        }

        if($employee_id>0)
        {
            $this->db->where('n.employee_id',$employee_id);
        }
        else
        {
            if($id_office>0)
            {
                $this->db->where('n.id_office',$id_office);
            }
            if($id_department>0)
            {
                $this->db->where('n.id_department',$id_department);
            }
        }

        $this->two_date_between_query_generator(System_helper::get_time($date_from_start_file),System_helper::get_time($date_to_start_file),'n.date_start');
        $this->db->where('n.status',$this->config->item('system_status_active'));
        $this->db->group_by('n.id');
        $this->db->order_by('ctg.ordering');
        $this->db->order_by('sctg.ordering');
        $this->db->order_by('cls.ordering');
        $this->db->order_by('t.ordering');
        $this->db->order_by('n.ordering');
        $items=$this->db->get()->result_array();
        foreach($items as &$item)
        {
            $item['date_start']=System_helper::display_date($item['date_start']);
        }
        $this->json_return($items);
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
