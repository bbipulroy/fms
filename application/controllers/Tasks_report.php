<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks_report extends Root_Controller
{
    private $message;
    public $permissions;
    public $controller_url;
    public function __construct()
    {
        parent::__construct();
        $this->message='';
        $this->permissions=User_helper::get_permission('Tasks_report');
        $this->controller_url='tasks_report';
    }
    public function index($action='details',$id=0)
    {
        if($action=='details')
        {
            $this->system_details();
        }
        elseif($action=='get_drop_down')
        {
            $this->system_get_drop_down_with_select();
        }
        else
        {
            $this->system_details();
        }
    }
    private function system_details()
    {
        if(isset($this->permissions['action0']) && ($this->permissions['action0']==1))
        {
            $user_group_id=User_helper::get_user()->user_group;
            $data['title']='Files Report';
            $data['items']=array
            (
                'id'=>0,
                'date_entry_text'=>System_helper::display_date(time()),
                'id_file_type_1'=>'',
                'id_file_type_2'=>'',
                'id_file_type_3'=>'',
                'id_file_type_4'=>'',
                'id_hc_location'=>'',
                'remarks'=>''
            );
            $data['file_type_1s']=$this->get_desire_file_type_by_user_group_id($user_group_id,$this->config->item('table_setup_file_type_1'),'id_file_type_1');
            $data['file_type_2s']=array();
            $data['file_type_3s']=array();
            $data['file_type_4s']=array();
            $data['hc_locations']=Query_helper::get_info($this->config->item('table_setup_file_hc_location'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));
            $data['stored_files']=array();
            $ajax['system_page_url']=site_url($this->controller_url.'/index/add');
            $ajax['system_content'][]=array('id'=>$this->config->item('system_div_id'),'html'=>$this->load->view($this->controller_url.'/add',$data,true));
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
    private function get_desire_file_type_by_user_group_id($user_group_id,$table,$column,$where='',$value='')
    {
        $this->db->select('ftd.name text,ftd.id value');
        $this->db->from($this->config->item('table_setup_file_type_4').' ft4');
        $this->db->join($table.' ftd','ft4.'.$column.'=ftd.id','inner');
        $this->db->join($this->config->item('table_setup_assign_user_group_file').' ugf','ft4.id=ugf.id_file','inner');
        if(strlen(trim($where))>0)
        {
            $this->db->where('ftd.'.$where,$value);
        }
        $this->db->where('ugf.user_group_id',$user_group_id);
        $this->db->where('ugf.revision',1);
        $this->db->group_by('value');
        return $this->db->get()->result_array();
    }
    private function get_file_type_4_by_user_group_id($user_group_id)
    {
        $this->db->select('ft4.name text,ft4.id value');
        $this->db->from($this->config->item('table_setup_file_type_4').' ft4');
        $this->db->join($this->config->item('table_setup_assign_user_group_file').' ugf','ft4.id=ugf.id_file','inner');
        $this->db->where('ugf.user_group_id',$user_group_id);
        $this->db->where('ugf.revision',1);
        return $this->db->get()->result_array();
    }
    private function system_get_drop_down_with_select()
    {
        $user_group_id=User_helper::get_user()->user_group;
        $table=$this->input->post('table');
        if($table==$this->config->item('table_setup_file_type_4'))
        {
            $data['items']=$this->get_file_type_4_by_user_group_id($user_group_id);
        }
        else
        {
            $table_column=$this->input->post('table_column');
            $table_column_check=$this->input->post('table_column_check');
            $table_column_value=$this->input->post('table_column_value');
            $data['items']=$this->get_desire_file_type_by_user_group_id($user_group_id,$table,$table_column,$table_column_check,$table_column_value);
        }
        $html_container_id=$this->input->post('html_container_id');

        $ajax['system_content'][]=array('id'=>$html_container_id,'html'=>$this->load->view('dropdown_with_select',$data,true));
        $ajax['status']=true;
        $this->json_return($ajax);
    }
}
