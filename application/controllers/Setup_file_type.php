<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup_file_type extends Root_Controller
{
    private $message;
    public $permissions;
    public $controller_url;
    public function __construct()
    {
        parent::__construct();
        $this->message='';
        $this->permissions=User_helper::get_permission('Setup_file_type');
        $this->controller_url='setup_file_type';
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
            $data['title']=$this->lang->line('LABEL_FILE_TYPE').' List';
            $ajax['system_content'][]=array('id'=>'#system_content','html'=>$this->load->view($this->controller_url.'/list',$data,true));
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
    private function system_get_items()
    {
        $current_records = $this->input->post('total_records');
        if(!$current_records)
        {
            $current_records=0;
        }
        $pagesize = $this->input->post('pagesize');
        if(!$pagesize)
        {
            $pagesize=40;
        }
        else
        {
            $pagesize=$pagesize*2;
        }
        $this->db->select('t.*');
        $this->db->select('cls.name class_name');
        $this->db->select('sctg.name sub_category_name');
        $this->db->select('ctg.name category_name');
        $this->db->from($this->config->item('table_fms_setup_file_type').' t');
        $this->db->join($this->config->item('table_fms_setup_file_class').' cls','t.id_class=cls.id');
        $this->db->join($this->config->item('table_fms_setup_file_sub_category').' sctg','sctg.id=cls.id_sub_category');
        $this->db->join($this->config->item('table_fms_setup_file_category').' ctg','ctg.id=sctg.id_category');
        $this->db->where('ctg.status=',$this->config->item('system_status_active'));
        $this->db->where('sctg.status=',$this->config->item('system_status_active'));
        $this->db->where('cls.status=',$this->config->item('system_status_active'));
        $this->db->where('t.status=',$this->config->item('system_status_active'));
        $this->db->order_by('ctg.ordering');
        $this->db->order_by('sctg.ordering');
        $this->db->order_by('cls.ordering');
        $this->db->order_by('t.ordering');
        $this->db->limit($pagesize,$current_records);
        $items=$this->db->get()->result_array();
        $this->json_return($items);
    }
    private function system_add()
    {
        if(isset($this->permissions['action1']) && ($this->permissions['action1']==1))
        {
            $data['title']='Create New '.$this->lang->line('LABEL_FILE_TYPE');
            $data['item']=array
            (
                'id'=>0,
                'name'=>'',
                'id_category'=>'',
                'id_sub_category'=>'',
                'id_class'=>'',
                'ordering'=>99,
                'status'=>$this->config->item('system_status_active'),
                'remarks'=>''
            );
            $data['categories']=Query_helper::get_info($this->config->item('table_fms_setup_file_category'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));
            $data['sub_categories']=array();
            $data['classes']=array();
            $ajax['system_page_url']=site_url($this->controller_url.'/index/add');
            $ajax['system_content'][]=array('id'=>'#system_content','html'=>$this->load->view($this->controller_url.'/add_edit',$data,true));
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
            $this->db->select('t.*');
            $this->db->select('cls.id_sub_category');
            $this->db->select('sctg.id_category');
            $this->db->from($this->config->item('table_fms_setup_file_type').' t');
            $this->db->join($this->config->item('table_fms_setup_file_class').' cls','cls.id=t.id_class');
            $this->db->join($this->config->item('table_fms_setup_file_sub_category').' sctg','sctg.id=cls.id_sub_category');
            $this->db->where('t.id',$item_id);
            $data['item']=$this->db->get()->row_array();
            $data['title']='Edit '.$this->lang->line('LABEL_FILE_TYPE').' ('.$data['item']['name'].')';
            $data['categories']=Query_helper::get_info($this->config->item('table_fms_setup_file_category'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));
            $data['sub_categories']=Query_helper::get_info($this->config->item('table_fms_setup_file_sub_category'),array('id value','name text'),array('id_category='.$data['item']['id_category'],'status ="'.$this->config->item('system_status_active').'"'));
            $data['classes']=Query_helper::get_info($this->config->item('table_fms_setup_file_class'),array('id value','name text'),array('id_sub_category='.$data['item']['id_sub_category'],'status ="'.$this->config->item('system_status_active').'"'));
            $ajax['system_content'][]=array('id'=>'#system_content','html'=>$this->load->view($this->controller_url.'/add_edit',$data,true));
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
            }
        }
        else
        {
            if(!(isset($this->permissions['action1']) && ($this->permissions['action1']==1)))
            {
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line('YOU_DONT_HAVE_ACCESS');
                $this->json_return($ajax);
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
            $data=$this->input->post('item');
            $this->db->trans_start(); //DB Transaction Handle START
            if($id>0)
            {
                $data['user_updated']=$user->user_id;
                $data['date_updated']=time();
                Query_helper::update($this->config->item('table_fms_setup_file_type'),$data,array('id='.$id));
            }
            else
            {
                $data['user_created']=$user->user_id;
                $data['date_created']=time();
                Query_helper::add($this->config->item('table_fms_setup_file_type'),$data);
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
        $this->form_validation->set_rules('item[name]',$this->lang->line('LABEL_NAME'),'required');
        $this->form_validation->set_rules('item[id_class]',$this->lang->line('LABEL_FILE_CLASS'),'required');
        if($this->form_validation->run()==false)
        {
            $this->message=validation_errors();
            return false;
        }
        return true;
    }
}
