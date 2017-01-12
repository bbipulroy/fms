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
            $data['items']=array
            (
                'id_category'=>'',
                'id_class'=>'',
                'id_type'=>'',
                'id_name'=>'',
                'date_start'=>'',
                'date_end'=>'',
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
            $report_parameters_info_start='<div class="alert alert-danger alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
            $report_parameters_info='Report Parameters Information.';

            $items=$this->input->post('items');
            if($items['id_name']>0)
            {
                #
            }
            elseif(System_helper::get_time($items['date_start'])>0 && System_helper::get_time($items['date_end'])>0)
            {
                #
            }
            elseif(System_helper::get_time($items['date_start'])>0)
            {
                #
            }
            elseif(System_helper::get_time($items['date_end'])>0)
            {
                #
            }
            else
            {
                #
            }

            $data['title']='File Name List';
            $ajax['system_content'][]=array('id'=>'#system_report_container','html'=>$this->load->view($this->controller_url.'/list',$data,true));
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=site_url($this->controller_url.'/index/search');
            $ajax['status']=true;
            $ajax['system_content'][]=array('id'=>'#report_parameters_info','html'=>$report_parameters_info_start.$report_parameters_info.'</div>');
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
        #
    }
}
