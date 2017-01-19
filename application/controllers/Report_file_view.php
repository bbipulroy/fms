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
        elseif($action=='details_popup')
        {
            $this->system_details_popup($id);
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
            $data['items']=array
            (
                'id_category'=>'',
                'id_class'=>'',
                'id_type'=>'',
                'id_name'=>'',
                'date_start_file'=>'',
                'date_end_file'=>'',
                'date_start_page'=>'',
                'date_end_page'=>'',
                'id_office'=>'',
                'id_department'=>'',
                'employee_responsible'=>''
            );
            $data['categories']=Query_helper::get_info($this->config->item('table_setup_file_category'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));
            $data['classes']=array();
            $data['types']=array();
            $data['names']=array();

            $LOGIN=$this->load->database('armalik_login',true);
            $LOGIN->select('id value,name text');
            $LOGIN->from($this->config->item('table_setup_office'));
            $data['offices']=$LOGIN->get()->result_array();

            $LOGIN->select('id value,name text');
            $LOGIN->from($this->config->item('table_setup_department'));
            $data['departments']=$LOGIN->get()->result_array();

            $data['employees']=array();
            $ajax['system_page_url']=site_url($this->controller_url.'/index/search');
            $ajax['system_content'][]=array('id'=>$this->config->item('system_div_id'),'html'=>$this->load->view($this->controller_url.'/search',$data,true));
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
            $items=$this->input->post('items');
            if($items['id_name']>0)
            {
                $data=array();
                $this->get_data($data,$items['id_name']);
                $ajax['system_content'][]=array('id'=>'#system_report_container','html'=>$this->load->view($this->controller_url.'/details',$data,true));
            }
            else
            {
                $data['title']='Report for '.$this->lang->line('LABEL_FILE_NAME').' List';
                $ajax_post='';
                foreach($items as $key=>$val)
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
    private function system_details_popup($id)
    {
        $id=$this->input->post('id');
        $html_id=$this->input->post('html_container_id');
        $data=array();
        $this->get_data($data,$id);
        $ajax['system_content'][]=array('id'=>$html_id,'html'=>$this->load->view($this->controller_url.'/details',$data,true));
        if($this->message)
        {
            $ajax['system_message']=$this->message;
        }
        $ajax['status']=true;
        $this->json_return($ajax);
    }
    private function get_data(&$data,$id_file_name)
    {
        $this->db->select('n.id,n.name,t.name type_name,cls.name class_name,ctg.name category_name,COUNT(df.id) file_total');
        $this->db->from($this->config->item('table_setup_file_name').' n');
        $this->db->join($this->config->item('table_setup_file_type').' t','t.id=n.id_type');
        $this->db->join($this->config->item('table_setup_file_class').' cls','cls.id=t.id_class');
        $this->db->join($this->config->item('table_setup_file_category').' ctg','ctg.id=cls.id_category');
        $this->db->join($this->config->item('table_tasks_digital_file').' df','df.id_file_name=n.id','left');
        $this->db->where('n.id',$id_file_name);
        $this->db->where('n.status',$this->config->item('system_status_active'));
        $this->db->where('df.status',$this->config->item('system_status_active'));
        $data['details']=$this->db->get()->row_array();

        $this->db->select('name,date_entry,remarks,mime_type');
        $this->db->from($this->config->item('table_tasks_digital_file'));
        $this->db->where('id_file_name',$id_file_name);
        $this->db->where('status',$this->config->item('system_status_active'));
        $data['files_info']=$this->db->get()->result_array();
    }
    private function system_get_items()
    {
        $LOGIN=$this->load->database('armalik_login',true);
        $id_type=$this->input->post('id_type');
        $id_class=$this->input->post('id_class');
        $id_category=$this->input->post('id_category');
        $employee_responsible=$this->input->post('employee_responsible');
        $id_department=$this->input->post('id_department');
        $id_office=$this->input->post('id_office');
        $date_start=$this->input->post('date_start');
        $date_end=$this->input->post('date_end');

        $this->db->select('n.id,n.name,n.date_start,t.name type_name,cls.name class_name,ctg.name category_name,ui.name employee_name,d.name department_name,o.name office_name');
        $this->db->from($this->config->item('table_setup_file_name').' n');
        $this->db->join($this->config->item('table_setup_file_type').' t','t.id=n.id_type');
        $this->db->join($this->config->item('table_setup_file_class').' cls','cls.id=t.id_class');
        $this->db->join($this->config->item('table_setup_file_category').' ctg','ctg.id=cls.id_category');
        $this->db->join($this->config->item('system_login_database').'.'.$this->config->item('table_setup_user_info').' ui','ui.user_id=n.employee_responsible');
        $this->db->join($this->config->item('system_login_database').'.'.$this->config->item('table_setup_department').' d','d.id=ui.department_id');
        $this->db->join($this->config->item('system_login_database').'.'.$this->config->item('table_setup_office').' o','o.id=ui.office_id');
        $this->db->where('ui.revision',1);
        if($id_type>0)
        {
            $this->db->where('n.id_type',$id_type);
        }
        elseif($id_class>0)
        {
            $where_in='SELECT id FROM '.$this->config->item('table_setup_file_type').' WHERE id_class='.$id_class;
            $this->db->where_in('n.id_type',$where_in,false);
        }
        elseif($id_category>0)
        {
            $where_in='SELECT id FROM '.$this->config->item('table_setup_file_type').' WHERE id_class IN (SELECT id FROM '.$this->config->item('table_setup_file_class').' WHERE id_category='.$id_category.')';
            $this->db->where_in('n.id_type',$where_in,false);
        }
        if($employee_responsible>0)
        {
            $this->db->where('n.employee_responsible',$employee_responsible);
        }
        elseif($id_department>0)
        {
            $where_in='SELECT user_id FROM '.$this->config->item('system_login_database').'.'.$this->config->item('table_setup_user_info').' WHERE department_id='.$id_department;
            $this->db->where_in('n.employee_responsible',$where_in,false);
        }
        elseif($id_office>0)
        {
            $where_in='SELECT user_id FROM '.$this->config->item('system_login_database').'.'.$this->config->item('table_setup_user_info').' WHERE office_id='.$id_office;
            $this->db->where_in('n.employee_responsible',$where_in,false);
        }
        $this->add_extra_query(System_helper::get_time($date_start),System_helper::get_time($date_end),'n.date_start');
        $temp=$this->db->get()->result_array();
        foreach($temp as &$value)
        {
            $value['date_start']=System_helper::display_date($value['date_start']);
        }
        $this->jsonReturn($temp);
    }
    private function add_extra_query($start,$end,$field)
    {
        if($start>0)
        {
            $this->db->where($field.'>=',$start);
        }
        if($end>0)
        {
            $this->db->where($field.'<=',$end);
        }
    }
}