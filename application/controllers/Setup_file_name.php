<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup_file_name extends Root_Controller
{
    private $message;
    public $permissions;
    public $controller_url;
    public function __construct()
    {
        parent::__construct();
        $this->message='';
        $this->permissions=User_helper::get_permission('Setup_file_name');
        $this->controller_url='setup_file_name';
    }
    public function index($action='list',$id=0)
    {
        if($action=='list')
        {
            $this->system_list($id);
        }
        elseif($action=='get_items')
        {
            $this->system_get_items();
        }
        elseif($action=='add')
        {
            $this->system_add();
        }
        elseif($action=='edit')
        {
            $this->system_edit($id);
        }
        elseif($action=='save')
        {
            $this->system_save();
        }
        else
        {
            $this->system_list($id);
        }
    }
    private function system_list()
    {
        if(isset($this->permissions['action0']) && ($this->permissions['action0']==1))
        {
            $data['title']='File Name List';
            $ajax['system_content'][]=array('id'=>$this->config->item('system_div_id'),'html'=>$this->load->view($this->controller_url.'/list',$data,true));
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=site_url($this->controller_url);
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
    private function system_add()
    {
        if(isset($this->permissions['action1']) && ($this->permissions['action1']==1))
        {
            $data['title']='Create New File Name';
            $data['items']=array
            (
                'id'=>0,
                'name'=>'',
                'id_category'=>'',
                'id_class'=>'',
                'id_type'=>'',
                'id_hc_location'=>'',
                'date_start'=>System_helper::display_date(time()),
                'ordering'=>99,
                'status'=>$this->config->item('system_status_active')
            );
            $data['categories']=Query_helper::get_info($this->config->item('table_setup_file_category'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));
            $data['classes']=array();
            $data['types']=array();
            $data['hc_locations']=Query_helper::get_info($this->config->item('table_setup_file_hc_location'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));
            $ajax['system_page_url']=site_url($this->controller_url.'/index/add');
            $ajax['system_content'][]=array('id'=>$this->config->item('system_div_id'),'html'=>$this->load->view($this->controller_url.'/add_edit',$data,true));
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
    private function system_edit($id)
    {
        if(isset($this->permissions['action2']) && ($this->permissions['action2']==1))
        {
            if(($this->input->post('id')))
            {
                $item_id=$this->input->post('id');
            }
            else
            {
                $item_id=$id;
            }
            $this->db->select('n.*,t.id_class,cls.id_category');
            $this->db->from($this->config->item('table_setup_file_name').' n');
            $this->db->join($this->config->item('table_setup_file_type').' t','n.id_type=t.id');
            $this->db->join($this->config->item('table_setup_file_class').' cls','t.id_class=cls.id');
            $this->db->where('n.id',$item_id);
            $data['items']=$this->db->get()->row_array();
            $data['items']['date_start']=System_helper::display_date($data['items']['date_start']);
            $data['title']='Edit File Name ('.$data['items']['name'].')';
            $data['categories']=Query_helper::get_info($this->config->item('table_setup_file_category'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));
            $data['classes']=Query_helper::get_info($this->config->item('table_setup_file_class'),array('id value','name text'),array('id_category='.$data['items']['id_category']));
            $data['types']=Query_helper::get_info($this->config->item('table_setup_file_type'),array('id value','name text'),array('id_class='.$data['items']['id_class']));
            $data['hc_locations']=Query_helper::get_info($this->config->item('table_setup_file_hc_location'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));
            $ajax['system_content'][]=array('id'=>$this->config->item('system_div_id'),'html'=>$this->load->view($this->controller_url.'/add_edit',$data,true));
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=site_url($this->controller_url.'/index/edit/'.$item_id);
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
    private function system_save()
    {
        $id=$this->input->post('id');
        $user=User_helper::get_user();
        if($id>0)
        {
            if(!(isset($this->permissions['action2']) && ($this->permissions['action2']==1)))
            {
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line('YOU_DONT_HAVE_ACCESS');
                $this->json_return($ajax);
                die();
            }
        }
        else
        {
            if(!(isset($this->permissions['action1']) && ($this->permissions['action1']==1)))
            {
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line('YOU_DONT_HAVE_ACCESS');
                $this->json_return($ajax);
                die();
            }
        }
        if(!$this->check_validation())
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->message;
            $this->json_return($ajax);
        }
        else
        {
            $data=$this->input->post('items');
            $data['date_start']=System_helper::get_time($data['date_start']);
            $this->db->trans_start(); //DB Transaction Handle START
            if($id>0)
            {
                $data['user_updated']=$user->user_id;
                $data['date_updated']=time();
                Query_helper::update($this->config->item('table_setup_file_name'),$data,array('id='.$id));
            }
            else
            {
                $data['user_created']=$user->user_id;
                $data['date_created']=time();
                Query_helper::add($this->config->item('table_setup_file_name'),$data);
            }
            $this->db->trans_complete(); //DB Transaction Handle END
            if($this->db->trans_status()===true)
            {
                $save_and_new=$this->input->post('system_save_new_status');
                $this->message=$this->lang->line('MSG_SAVED_SUCCESS');
                if($save_and_new==1)
                {
                    $this->system_add();
                }
                else
                {
                    $this->system_list();
                }
            }
            else
            {
                $ajax['status']=false;
                $ajax['desk_message']=$this->lang->line('MSG_SAVED_FAIL');
                $this->json_return($ajax);
            }
        }
    }
    private function check_validation()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('items[name]',$this->lang->line('LABEL_NAME'),'required');
        $this->form_validation->set_rules('items[id_type]',$this->lang->line('LABEL_FILE_TYPE'),'required');
        $this->form_validation->set_rules('items[id_hc_location]',$this->lang->line('LABEL_HC_LOCATION'),'required');
        $this->form_validation->set_rules('items[date_start]','Start Date','required');
        if($this->form_validation->run()==false)
        {
            $this->message=validation_errors();
            return false;
        }
        return true;
    }
    private function system_get_items()
    {
        $this->db->select('n.id,n.name,n.status,n.ordering,ctg.name category_name,cls.name class_name,t.name type_name');
        $this->db->from($this->config->item('table_setup_file_name').' n');
        $this->db->join($this->config->item('table_setup_file_type').' t','n.id_type=t.id');
        $this->db->join($this->config->item('table_setup_file_class').' cls','t.id_class=cls.id');
        $this->db->join($this->config->item('table_setup_file_category').' ctg','cls.id_category=ctg.id');
        $this->db->order_by('n.ordering');
        $this->json_return($this->db->get()->result_array());
    }
}
