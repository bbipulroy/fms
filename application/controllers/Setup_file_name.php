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
        elseif($action=='details')
        {
            $this->system_details($id);
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
            $data['item']=array
            (
                'id'=>0,
                'name'=>'',
                'id_category'=>'',
                'id_class'=>'',
                'id_type'=>'',
                'id_hc_location'=>'',
                'date_start'=>System_helper::display_date(time()),
                'ordering'=>99,
                'status'=>$this->config->item('system_status_active'),
                'remarks'=>'',
                'id_office'=>'',
                'id_department'=>'',
                'employee_responsible'=>''
            );
            $data['categories']=Query_helper::get_info($this->config->item('table_setup_file_category'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));
            $data['classes']=array();
            $data['types']=array();
            $data['hc_locations']=Query_helper::get_info($this->config->item('table_setup_file_hc_location'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));

            $LOGIN=$this->load->database('armalik_login',true);
            $LOGIN->select('id value,name text');
            $LOGIN->from($this->config->item('table_setup_office'));
            $data['offices']=$LOGIN->get()->result_array();

            $LOGIN->select('id value,name text');
            $LOGIN->from($this->config->item('table_setup_department'));
            $data['departments']=$LOGIN->get()->result_array();

            $data['employees']=array();
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
            $data['item']=$this->db->get()->row_array();
            $data['item']['date_start']=System_helper::display_date($data['item']['date_start']);
            $data['title']='Edit File Name ('.$data['item']['name'].')';
            $data['categories']=Query_helper::get_info($this->config->item('table_setup_file_category'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));
            $data['classes']=Query_helper::get_info($this->config->item('table_setup_file_class'),array('id value','name text'),array('id_category='.$data['item']['id_category']));
            $data['types']=Query_helper::get_info($this->config->item('table_setup_file_type'),array('id value','name text'),array('id_class='.$data['item']['id_class']));
            $data['hc_locations']=Query_helper::get_info($this->config->item('table_setup_file_hc_location'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));

            $LOGIN=$this->load->database('armalik_login',true);
            $LOGIN->select('id value,name text');
            $LOGIN->from($this->config->item('table_setup_office'));
            $data['offices']=$LOGIN->get()->result_array();

            $LOGIN->select('id value,name text');
            $LOGIN->from($this->config->item('table_setup_department'));
            $data['departments']=$LOGIN->get()->result_array();

            $LOGIN->select("u.id value,CONCAT('[',u.employee_id,'] ',ui.name) AS text");
            $LOGIN->from($this->config->item('table_setup_user').' u');
            $LOGIN->join($this->config->item('table_setup_user_info').' ui','u.id=ui.user_id');
            $LOGIN->where('u.status',$this->config->item('system_status_active'));
            $LOGIN->where('ui.revision',1);
            $LOGIN->where('ui.department_id',$data['item']['id_department']);
            $LOGIN->or_where('ui.office_id',$data['item']['id_office']);
            $LOGIN->group_by('u.id');
            $data['employees']=$LOGIN->get()->result_array();
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
            $data=$this->input->post('item');
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
        $this->form_validation->set_rules('item[name]',$this->lang->line('LABEL_NAME'),'required');
        $this->form_validation->set_rules('item[id_type]',$this->lang->line('LABEL_FILE_TYPE'),'required');
        $this->form_validation->set_rules('item[id_hc_location]',$this->lang->line('LABEL_HC_LOCATION'),'required');
        $this->form_validation->set_rules('item[date_start]','Start Date','required');
        $this->form_validation->set_rules('item[employee_responsible]','Responsible Employee','required');
        if($this->form_validation->run()==false)
        {
            $this->message=validation_errors();
            return false;
        }
        return true;
    }
    private function system_get_items()
    {
        $this->db->select('n.id,n.name,n.date_start,n.ordering,ctg.name category_name,cls.name class_name,t.name type_name,hl.name hardcopy_location,CONCAT(\'[\',u.employee_id,\'] \',ui.name) employee_name,d.name department_name,o.name office_name,SUM(CASE WHEN df.status=\''.$this->config->item('system_status_active').'\' THEN 1 ELSE 0 END) number_of_file');
        $this->db->from($this->config->item('table_setup_file_name').' n');
        $this->db->join($this->config->item('table_setup_file_type').' t','n.id_type=t.id');
        $this->db->join($this->config->item('table_setup_file_class').' cls','t.id_class=cls.id');
        $this->db->join($this->config->item('table_setup_file_category').' ctg','cls.id_category=ctg.id');
        $this->db->join($this->config->item('table_setup_file_hc_location').' hl','hl.id=n.id_hc_location');
        $this->db->join($this->config->item('system_login_database').'.'.$this->config->item('table_setup_user_info').' ui','ui.user_id=n.employee_responsible','left');
        $this->db->join($this->config->item('system_login_database').'.'.$this->config->item('table_setup_user').' u','ui.user_id=u.id');
        $this->db->join($this->config->item('system_login_database').'.'.$this->config->item('table_setup_department').' d','d.id=n.id_department','left');
        $this->db->join($this->config->item('system_login_database').'.'.$this->config->item('table_setup_office').' o','o.id=n.id_office','left');
        $this->db->join($this->config->item('table_tasks_digital_file').' df','df.id_file_name=n.id','left');
        $this->db->where('ui.revision',1);
        $this->db->order_by('n.ordering');
        $this->db->group_by('n.id');
        $temp=$this->db->get()->result_array();
        foreach($temp as &$val)
        {
            $val['date_start']=System_helper::display_date($val['date_start']);
        }
        $this->json_return($temp);
    }
}
