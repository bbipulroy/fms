<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup_assign_file_user_group extends Root_Controller
{
    private $message;
    public $permissions;
    public $controller_url;

    public function __construct()
    {
        parent::__construct();
        $this->message='';
        $this->permissions=User_helper::get_permission('Setup_assign_file_user_group');
        $this->controller_url='setup_assign_file_user_group';
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
        elseif($action=='details')
        {
            $this->system_details($id);
        }
        elseif($action=='search')
        {
            $this->system_search($id);
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
            $data['title']='List of '.$this->lang->line('LABEL_USER_GROUP').' to Assign Files';
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
    private function system_details($id)
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
            $data['item_id']=$item_id;

            $this->db->select('name');
            $this->db->from($this->config->item('table_system_user_group'));
            $this->db->where('id',$item_id);
            $user_group_name=$this->db->get()->row_array();
            $data['title']='Details File Permissions for ('.$user_group_name['name'].')';

            $this->db->select('n.id file_id,n.name file_name,t.id type_id,t.name type_name,cls.id class_id,cls.name class_name,ctg.id category_id,ctg.name category_name');
            $this->db->select('fug.*');
            $this->db->from($this->config->item('table_fms_setup_file_name').' n');
            $this->db->join($this->config->item('table_fms_setup_file_type').' t','t.id=n.id_type');
            $this->db->join($this->config->item('table_fms_setup_file_class').' cls','cls.id=t.id_class');
            $this->db->join($this->config->item('table_fms_setup_file_category').' ctg','ctg.id=cls.id_category');
            $this->db->join($this->config->item('table_fms_setup_assign_file_user_group').' fug','fug.id_file=n.id','left');
            $this->db->where('n.status',$this->config->item('system_status_active'));
            $this->db->where('fug.user_group_id',$item_id);
            $this->db->where('fug.revision',1);
            $this->db->order_by('ctg.id');
            $this->db->order_by('cls.id');
            $this->db->order_by('t.id');
            $this->db->order_by('n.id');
            $data['all_files']=$this->db->get()->result_array();

            $ajax['system_content'][]=array('id'=>'#system_content','html'=>$this->load->view($this->controller_url.'/details',$data,true));
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=site_url($this->controller_url.'/index/details/'.$item_id);
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
    private function system_search($id)
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

            $data['item_id']=$item_id;
            $this->db->select('name');
            $this->db->from($this->config->item('table_system_user_group'));
            $this->db->where('id',$item_id);
            $user_group_name=$this->db->get()->row_array();
            $data['title']='Edit File Permission to ('.$user_group_name['name'].')';
            $data['categories']=Query_helper::get_info($this->config->item('table_fms_setup_file_category'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'),0,0,array('ordering ASC'));
            $ajax['system_content'][]=array('id'=>'#system_content','html'=>$this->load->view($this->controller_url.'/search',$data,true));
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=site_url($this->controller_url.'/index/search/'.$item_id);
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
            $data['item_id']=$this->input->post('id_user_group');
            $data['id_category']=$this->input->post('id_category');
            if($data['item_id']>0 && $data['id_category']>0)
            {
                $data['permitted_files']=array();
                $this->db->from($this->config->item('table_fms_setup_assign_file_user_group'));
                $this->db->where('user_group_id',$data['item_id']);
                $this->db->where('action0',1);
                $this->db->where('revision',1);
                $results=$this->db->get()->result_array();
                foreach($results as $result)
                {
                    $data['permitted_files'][$result['id_file']]=$result;
                }

                $data['all_files']=array();
                $this->db->select('n.id file_id,n.name file_name,t.id type_id,t.name type_name,cls.id class_id,cls.name class_name');
                $this->db->from($this->config->item('table_fms_setup_file_name').' n');
                $this->db->join($this->config->item('table_fms_setup_file_type').' t','t.id=n.id_type');
                $this->db->join($this->config->item('table_fms_setup_file_class').' cls','cls.id=t.id_class');
                $this->db->where('cls.id_category',$data['id_category']);
                $this->db->where('n.status',$this->config->item('system_status_active'));

                $this->db->order_by('cls.id');
                $this->db->order_by('t.id');
                $this->db->order_by('n.id');
                $results=$this->db->get()->result_array();
                foreach($results as $result)
                {
                    $data['all_files'][$result['class_id']]['name']=$result['class_name'];
                    $data['all_files'][$result['class_id']]['types'][$result['type_id']]['name']=$result['type_name'];
                    $data['all_files'][$result['class_id']]['types'][$result['type_id']]['files'][$result['file_id']]['name']=$result['file_name'];
                }

                $ajax['system_content'][]=array('id'=>'#edit_form','html'=>$this->load->view($this->controller_url.'/add_edit',$data,true));
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
                $ajax['system_message']='You violate your rules.';
                $this->json_return($ajax);
            }
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
        $user=User_helper::get_user();
        $time=time();
        $id=$this->input->post('id');
        $id_category=$this->input->post('id_category');
        $data=$this->input->post('items');
        if(!is_array($data))
        {
            $data=array();
        }

        if($id>0)
        {
            if(!(isset($this->permissions['action2']) && ($this->permissions['action2']==1)))
            {
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line('YOU_DONT_HAVE_ACCESS');
                $this->json_return($ajax);
            }
        }
        if($id<=0)
        {
            $ajax['status']=false;
            $ajax['system_message']='You violate your rules.';
            $this->json_return($ajax);
        }
        else
        {
            $this->db->trans_start(); //DB Transaction Handle START


            $query='UPDATE '.$this->config->item('table_fms_setup_assign_file_user_group').' afug';
            $query.=' JOIN '.$this->config->item('table_fms_setup_file_name').' n ON n.id=afug.id_file';
            $query.=' JOIN '.$this->config->item('table_fms_setup_file_type').' t ON t.id=n.id_type';
            $query.=' JOIN '.$this->config->item('table_fms_setup_file_class').' cls ON cls.id=t.id_class';
            $query.=' SET afug.revision=afug.revision+1';
            $query.=' WHERE cls.id_category='.$id_category;
            $query.=' AND afug.user_group_id='.$id;
            $this->db->query($query);
            foreach($data as $id_file=>$actions)
            {
                $data_add=array();

                foreach($actions as $index=>$status)
                {
                    $data_add[$index]=1;
                }
                $data_add['action0']=1;
                $data_add['id_file']=$id_file;
                $data_add['user_group_id']=$id;
                $data_add['user_created']=$user->user_id;
                $data_add['date_created']=$time;
                Query_helper::add($this->config->item('table_fms_setup_assign_file_user_group'),$data_add);
            }
            $this->db->trans_complete(); //DB Transaction Handle END
            if($this->db->trans_status()===true)
            {
                $save_and_new=$this->input->post('system_save_new_status');
                $this->message=$this->lang->line('MSG_SAVED_SUCCESS');
                if($save_and_new==1)
                {
                    $this->system_search($id);
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
    private function system_get_items()
    {
        $user=User_helper::get_user();
        $this->db->from($this->config->item('table_system_user_group'));
        $this->db->select('*');
        if($user->user_group!=1)
        {
            $this->db->where('id !=1');
        }
        $user_groups=$this->db->get()->result_array();

        $this->db->from($this->config->item('table_fms_setup_assign_file_user_group'));
        $this->db->select('COUNT(id_file) file_total_permission',false);
        $this->db->select('user_group_id');
        $this->db->where('revision',1);
        $this->db->where('action0',1);
        $this->db->group_by('user_group_id');
        $results=$this->db->get()->result_array();

        $file_total_permissions=array();
        foreach($results as $result)
        {
            $file_total_permissions[$result['user_group_id']]['file_total_permission']=$result['file_total_permission'];
        }
        foreach($user_groups as &$user_group)
        {
            if(isset($file_total_permissions[$user_group['id']]['file_total_permission']))
            {
                $user_group['file_total_permission']=$file_total_permissions[$user_group['id']]['file_total_permission'];
            }
            else
            {
                $user_group['file_total_permission']=0;
            }
        }
        $this->json_return($user_groups);
    }
}
