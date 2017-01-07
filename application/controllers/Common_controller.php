<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_controller extends Root_Controller
{
    private $message;
    public function __construct()
    {
        parent::__construct();
        $this->message='';
    }
    public function get_dropdown_with_select()
    {
        $html_container_id=$this->input->post('html_container_id');
        $table=$this->input->post('table');
        $table_column=$this->input->post('table_column');
        $table_column_value=$this->input->post('table_column_value');
        
        $data['items']=Query_helper::get_info($table,array('id value','name text'),array($table_column.'='.$table_column_value,'status="'.$this->config->item('system_status_active').'"'),0,0,array('ordering ASC'));
        $ajax['system_content'][]=array('id'=>$html_container_id,'html'=>$this->load->view('dropdown_with_select',$data,true));
        $ajax['status']=true;
        $this->json_return($ajax);
    }
    public function get_dropdown_with_select_by_user_id()
    {
        $html_container_id=$this->input->post('html_container_id');
        $table=$this->input->post('table');
        $table_column=$this->input->post('table_column');
        $table_column_value=$this->input->post('table_column_value');
        
        $data['items']=Query_helper::get_info($table,array('id value','name text'),array($table_column.'='.$table_column_value,'status="'.$this->config->item('system_status_active').'"'),0,0,array('ordering ASC'));
        $ajax['system_content'][]=array('id'=>$html_container_id,'html'=>$this->load->view('dropdown_with_select',$data,true));
        $ajax['status']=true;
        $this->json_return($ajax);
    }
    public function get_departments()
    {
        $html_container_id=$this->input->post('html_container_id');
        $LOGIN=$this->load->database('armalik_login',true);
        $LOGIN->select('id value,name text');
        $LOGIN->from($this->config->item('table_setup_department'));
        $data['items']=$LOGIN->get()->result_array();
        $ajax['system_content'][]=array('id'=>$html_container_id,'html'=>$this->load->view('dropdown_with_select',$data,true));
        $ajax['status']=true;
        $this->json_return($ajax);
    }
    public function get_employees()
    {
        $html_container_id=$this->input->post('html_container_id');
        $id_department=$this->input->post('id_department');
        $LOGIN=$this->load->database('armalik_login',true);
        $LOGIN->select("u.id value,CONCAT('[',u.employee_id,'] ',ui.name) AS text");
        $LOGIN->from($this->config->item('table_setup_user').' u');
        $LOGIN->join($this->config->item('table_setup_user_info').' ui','u.id=ui.user_id');
        $LOGIN->where('u.status',$this->config->item('system_status_active'));
        $LOGIN->where('ui.revision',1);
        $LOGIN->where('ui.department_id',$id_department);
        $data['items']=$LOGIN->get()->result_array();
        $ajax['system_content'][]=array('id'=>$html_container_id,'html'=>$this->load->view('dropdown_with_select',$data,true));
        $ajax['status']=true;
        $this->json_return($ajax);
    }
}
