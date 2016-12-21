<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup_file_type_4 extends Root_Controller
{
    private $message;
    public $permissions;
    public $controller_url;
    public function __construct()
    {
        parent::__construct();
        $this->message='';
        $this->permissions=User_helper::get_permission('Setup_file_type_4');
        $this->controller_url='setup_file_type_4';
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
            $data['title']=$this->lang->line('LABEL_FILE_TYPE_4').' List';
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
            $data['title']='Create New '.$this->lang->line('LABEL_FILE_TYPE_4');
            $data['items']=array
            (
                'id'=>0,
                'name'=>'',
                'id_file_type_1'=>'',
                'id_file_type_2'=>'',
                'id_file_type_3'=>'',
                'ordering'=>99,
                'status'=>$this->config->item('system_status_active')
            );
            $data['file_type_1s']=Query_helper::get_info($this->config->item('table_setup_file_type_1'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));
            $data['file_type_2s']=array();
            $data['file_type_3s']=array();
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
            $this->db->select('ft4.*,ft3.id_file_type_2,ft2.id_file_type_1');
            $this->db->from($this->config->item('table_setup_file_type_4').' ft4');
            $this->db->join($this->config->item('table_setup_file_type_3').' ft3','ft4.id_file_type_3=ft3.id');
            $this->db->join($this->config->item('table_setup_file_type_2').' ft2','ft3.id_file_type_2=ft2.id');
            $this->db->where('ft4.id',$item_id);
            $data['items']=$this->db->get()->row_array();
            $data['title']='Edit '.$this->lang->line('LABEL_FILE_TYPE_4').' ('.$data['items']['name'].')';
            $data['file_type_1s']=Query_helper::get_info($this->config->item('table_setup_file_type_1'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));
            $data['file_type_2s']=Query_helper::get_info($this->config->item('table_setup_file_type_2'),array('id value','name text'),array('id_file_type_1='.$data['items']['id_file_type_1']));
            $data['file_type_3s']=Query_helper::get_info($this->config->item('table_setup_file_type_3'),array('id value','name text'),array('id_file_type_2='.$data['items']['id_file_type_2']));
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
            $this->db->trans_start(); //DB Transaction Handle START
            if($id>0)
            {
                $data['user_updated']=$user->user_id;
                $data['date_updated']=time();
                Query_helper::update($this->config->item('table_setup_file_type_4'),$data,array('id='.$id));
            }
            else
            {
                $data['user_created']=$user->user_id;
                $data['date_created']=time();
                Query_helper::add($this->config->item('table_setup_file_type_4'),$data);
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
        $this->form_validation->set_rules('items[id_file_type_3]',$this->lang->line('LABEL_FILE_TYPE_3'),'required');
        if($this->form_validation->run()==false)
        {
            $this->message=validation_errors();
            return false;
        }
        return true;
    }
    private function system_get_items()
    {
        $this->db->select('ft4.id,ft4.name,ft4.status,ft4.ordering,ft1.name file_type_1_name,ft2.name file_type_2_name,ft3.name file_type_3_name');
        $this->db->from($this->config->item('table_setup_file_type_4').' ft4');
        $this->db->join($this->config->item('table_setup_file_type_3').' ft3','ft4.id_file_type_3=ft3.id');
        $this->db->join($this->config->item('table_setup_file_type_2').' ft2','ft3.id_file_type_2=ft2.id');
        $this->db->join($this->config->item('table_setup_file_type_1').' ft1','ft2.id_file_type_1=ft1.id');
        $this->db->order_by('ft4.ordering');
        $this->json_return($this->db->get()->result_array());
    }
}
