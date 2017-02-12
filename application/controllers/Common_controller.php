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
        if($this->input->post('html_container_id'))
        {
            $html_container_id=$this->input->post('html_container_id');
        }
        $table=$this->input->post('table');
        $table_column=$this->input->post('table_column');
        $table_column_value=$this->input->post('table_column_value');
        
        $data['items']=Query_helper::get_info($table,array('id value','name text'),array($table_column.'='.$table_column_value,'status="'.$this->config->item('system_status_active').'"'),0,0,array('ordering ASC'));
        $ajax['system_content'][]=array('id'=>$html_container_id,'html'=>$this->load->view('dropdown_with_select',$data,true));
        $ajax['status']=true;
        $this->json_return($ajax);
    }
    public function get_classes_by_category_id()
    {
        $html_container_id='#id_class';
        if($this->input->post('html_container_id'))
        {
            $html_container_id=$this->input->post('html_container_id');
        }
        $id_category=$this->input->post('id_category');
        $data['items']=Query_helper::get_info($this->config->item('table_fms_setup_file_class'),array('id value','name text'),array('id_category='.$id_category,'status="'.$this->config->item('system_status_active').'"'),0,0,array('ordering ASC'));
        $ajax['system_content'][]=array('id'=>$html_container_id,'html'=>$this->load->view('dropdown_with_select',$data,true));
        $ajax['status']=true;
        $this->json_return($ajax);
    }
    public function get_types_by_class_id()
    {
        $html_container_id='#id_type';
        if($this->input->post('html_container_id'))
        {
            $html_container_id=$this->input->post('html_container_id');
        }
        $id_class=$this->input->post('id_class');
        $data['items']=Query_helper::get_info($this->config->item('table_fms_setup_file_type'),array('id value','name text'),array('id_class='.$id_class,'status="'.$this->config->item('system_status_active').'"'),0,0,array('ordering ASC'));
        $ajax['system_content'][]=array('id'=>$html_container_id,'html'=>$this->load->view('dropdown_with_select',$data,true));
        $ajax['status']=true;
        $this->json_return($ajax);
    }
    public function get_departments()
    {
        $html_container_id=$this->input->post('html_container_id');
        if($this->input->post('html_container_id'))
        {
            $html_container_id=$this->input->post('html_container_id');
        }
        $this->db->select('id value,name text');
        $this->db->from($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_department'));
        $data['items']=$this->db->get()->result_array();
        $ajax['system_content'][]=array('id'=>$html_container_id,'html'=>$this->load->view('dropdown_with_select',$data,true));
        $ajax['status']=true;
        $this->json_return($ajax);
    }
    public function get_employees()
    {
        $html_container_id='#employee_responsible';
        if($this->input->post('html_container_id'))
        {
            $html_container_id=$this->input->post('html_container_id');
        }
        $id_office=$this->input->post('id_office');
        $id_department=$this->input->post('id_department');

        $this->db->select("u.id value,CONCAT(u.employee_id,' - ',ui.name) text");
        $this->db->from($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_user').' u');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_user_info').' ui','u.id=ui.user_id');
        $this->db->where('u.status',$this->config->item('system_status_active'));
        $this->db->where('ui.revision',1);
        if($id_office>0 && $id_department>0)
        {
            $where='(ui.office_id='.$id_office.' OR ui.department_id='.$id_department.')';
            $this->db->where($where,'',false);
        }
        elseif($id_office>0)
        {
            $this->db->where('ui.office_id',$id_office);
        }
        elseif($id_department>0)
        {
            $this->db->where('ui.department_id',$id_department);
        }
        $this->db->order_by('u.employee_id');
        $this->db->group_by('u.id');
        $data['items']=$this->db->get()->result_array();
        $ajax['system_content'][]=array('id'=>$html_container_id,'html'=>$this->load->view('dropdown_with_select',$data,true));
        $ajax['status']=true;
        $this->json_return($ajax);
    }
}
