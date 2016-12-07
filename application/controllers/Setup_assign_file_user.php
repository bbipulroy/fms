<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup_assign_file_user extends Root_Controller
{
    private $message;
    public $permissions;
    public $controller_url;
    public function __construct()
    {
        parent::__construct();
        $this->message='';
        $this->permissions=User_helper::get_permission('Setup_assign_file_user');
        $this->controller_url='setup_assign_file_user';
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
            $data['title']='List of Users to Assign Files';
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
    private function system_details($id)
    {
        if(isset($this->permissions['action0']) && ($this->permissions['action0']==1))
        {
            if(($this->input->post('id')))
            {
                $item_id=$this->input->post('id');
            }
            else
            {
                $item_id=$id;
            } //$stock_id
            $this->db->from($this->config->item('table_stockin_varieties').' stv');
            $this->db->select('stv.*');
            $this->db->select('v.crop_type_id crop_type_id');
            $this->db->select('type.crop_id crop_id');

            $this->db->join($this->config->item('table_setup_classification_varieties').' v','v.id = stv.variety_id','INNER');
            $this->db->join($this->config->item('table_setup_classification_crop_types').' type','type.id = v.crop_type_id','INNER');
            $this->db->where('stv.id',$item_id);
            $this->db->where('stv.status',$this->config->item('system_status_active'));

            $data['stock_in']=$this->db->get()->row_array();
            if(!$data['stock_in'])
            {
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
                $this->jsonReturn($ajax);
                die();
            }
            if($data['stock_in']['date_exp']==0)
            {
                $data['stock_in']['date_exp']='';
            }
            if($data['stock_in']['date_mfg']==0)
            {
                $data['stock_in']['date_mfg']='';
            }
            $data['title']="Detail of Purchase";
            $data['warehouses']=Query_helper::get_info($this->config->item('table_basic_setup_warehouse'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));
            $data['crops']=Query_helper::get_info($this->config->item('table_setup_classification_crops'),array('id value','name text'),array());
            $data['crop_types']=Query_helper::get_info($this->config->item('table_setup_classification_crop_types'),array('id value','name text'),array('crop_id ='.$data['stock_in']['crop_id']));
            $data['varieties']=Query_helper::get_info($this->config->item('table_setup_classification_varieties'),array('id value','name text'),array('crop_type_id ='.$data['stock_in']['crop_type_id']));
            $data['pack_sizes']=Query_helper::get_info($this->config->item('table_setup_classification_vpack_size'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'),0,0,array('name ASC'));

            $ajax['status']=true;
            $ajax['system_content'][]=array("id"=>"#system_content","html"=>$this->load->view("stockin_variety/details",$data,true));
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=site_url($this->controller_url.'/index/details/'.$item_id);
            $this->jsonReturn($ajax);
        }
        else
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
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
            $data['items']=Query_helper::get_info($this->config->item('table_setup_file_category'),'*',array('id ='.$item_id),1);
            $data['title']='Edit File Category ('.$data['items']['name'].')';
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
                Query_helper::update($this->config->item('table_setup_file_category'),$data,array('id='.$id));
            }
            else
            {
                $data['user_created']=$user->user_id;
                $data['date_created']=time();
                Query_helper::add($this->config->item('table_setup_file_category'),$data);
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
        if($this->form_validation->run()==false)
        {
            $this->message=validation_errors();
            return false;
        }
        return true;
    }
    private function system_get_items()
    {
        $user=User_helper::get_user();
        $db_login=$this->load->database('armalik_login',true);
        $db_login->from($this->config->item('table_setup_user').' user');
        $db_login->select('user.id,user.employee_id,user.user_name');
        $db_login->select('user_info.name');
        $db_login->select('designation.name designation_name');
        $db_login->select('department.name department_name');
        $db_login->select('office.name office_name');
        $db_login->join($this->config->item('table_setup_user_info').' user_info','user.id=user_info.user_id','INNER');
        $db_login->join($this->config->item('table_setup_users_other_sites').' uos','uos.user_id=user.id','INNER');
        $db_login->join($this->config->item('table_system_other_sites').' os','os.id=uos.site_id','INNER');
        $db_login->join($this->config->item('table_setup_designation').' designation','designation.id=user_info.designation','LEFT');
        $db_login->join($this->config->item('table_setup_department').' department','department.id=user_info.department_id','LEFT');
        $db_login->join($this->config->item('table_setup_office').' office','office.id=user_info.office_id','LEFT');

        $db_login->where('user_info.revision',1);
        $db_login->where('uos.revision',1);
        $db_login->where('os.short_name',$this->config->item('system_site_short_name'));
        $db_login->order_by('user_info.ordering','ASC');
        if($user->user_group!=1)
        {
            $db_login->where('user_info.user_group !=',1);
        }
        $items=$db_login->get()->result_array();

        $this->db->from($this->config->item('table_system_assigned_group').' ag');
        $this->db->select('ag.user_id');
        $this->db->select('ug.name group_name');
        $this->db->join($this->config->item('table_system_user_group').' ug','ug.id = ag.user_group','INNER');
        $this->db->where('ag.revision',1);
        $results=$this->db->get()->result_array();

        $groups=array();
        foreach($results as $result)
        {
            $groups[$result['user_id']]['group_name']=$result['group_name'];
        }
        foreach($items as &$item)
        {
            if(isset($groups[$item['id']]['group_name']))
            {
                $item['group_name']=$groups[$item['id']]['group_name'];
            }
            else
            {
                $item['group_name']='Not Assigned';
            }
        }
        $this->json_return($items);
    }
}
