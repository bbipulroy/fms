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
            $data['title']=$this->lang->line('LABEL_FILE_NAME').' List';
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
        $this->db->select('n.*');
        $this->db->select('ctg.name category_name');
        $this->db->select('sctg.name sub_category_name');
        $this->db->select('cls.name class_name');
        $this->db->select('t.name type_name');
        $this->db->select('hl.name hardcopy_location');
        $this->db->select('CONCAT(ui.name," - ",u.employee_id) employee_name');
        $this->db->select('d.name department_name');
        $this->db->select('comp.full_name company_name');
        $this->db->select('SUM(CASE WHEN df.status="'.$this->config->item('system_status_active').'" AND SUBSTRING(df.mime_type,1,5)="image" THEN 1 ELSE 0 END) number_of_page');
        $this->db->from($this->config->item('table_fms_setup_file_name').' n');
        $this->db->join($this->config->item('table_fms_setup_file_type').' t','n.id_type=t.id');
        $this->db->join($this->config->item('table_fms_setup_file_class').' cls','t.id_class=cls.id');
        $this->db->join($this->config->item('table_fms_setup_file_sub_category').' sctg','cls.id_sub_category=sctg.id');
        $this->db->join($this->config->item('table_fms_setup_file_category').' ctg','sctg.id_category=ctg.id');
        $this->db->join($this->config->item('table_fms_setup_file_hc_location').' hl','hl.id=n.id_hc_location');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_user_info').' ui','ui.user_id=n.employee_id','left');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_user').' u','ui.user_id=u.id');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_department').' d','d.id=n.id_department','left');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_company').' comp','comp.id=n.id_company','left');
        $this->db->join($this->config->item('table_fms_tasks_digital_file').' df','df.id_file_name=n.id','left');
        $this->db->where('ctg.status=',$this->config->item('system_status_active'));
        $this->db->where('sctg.status=',$this->config->item('system_status_active'));
        $this->db->where('cls.status=',$this->config->item('system_status_active'));
        $this->db->where('t.status=',$this->config->item('system_status_active'));
        $this->db->where('n.status=',$this->config->item('system_status_active'));
        $this->db->where('ui.revision',1);
        $this->db->order_by('ctg.ordering');
        $this->db->order_by('sctg.ordering');
        $this->db->order_by('cls.ordering');
        $this->db->order_by('t.ordering');
        $this->db->order_by('n.ordering');
        $this->db->group_by('n.id');
        $items=$this->db->get()->result_array();
        foreach($items as &$item)
        {
            $item['date_start']=System_helper::display_date($item['date_start']);
        }
        $this->json_return($items);
    }
    private function system_add()
    {
        if(isset($this->permissions['action1']) && ($this->permissions['action1']==1))
        {
            $data['title']='Create New '.$this->lang->line('LABEL_FILE_NAME');
            $data['item']=array
            (
                'id'=>0,
                'name'=>'',
                'id_category'=>'',
                'id_sub_category'=>'',
                'id_class'=>'',
                'id_type'=>'',
                'id_hc_location'=>'',
                'date_start'=>System_helper::display_date(time()),
                'ordering'=>99,
                'status_file'=>$this->config->item('system_status_file_open'),
                'status'=>$this->config->item('system_status_active'),
                'remarks'=>'',
                'id_company'=>'',
                'id_department'=>'',
                'employee_id'=>''
            );
            $data['categories']=Query_helper::get_info($this->config->item('table_fms_setup_file_category'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'),0,0,array('ordering ASC'));
            $data['sub_categories']=array();
            $data['classes']=array();
            $data['types']=array();
            $data['hc_locations']=Query_helper::get_info($this->config->item('table_fms_setup_file_hc_location'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'),0,0,array('ordering ASC'));

            $data['companies']=Query_helper::get_info($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_company'),array('id value','full_name text'),array('status ="'.$this->config->item('system_status_active').'"'),0,0,array('ordering ASC'));
            $data['departments']=Query_helper::get_info($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_department'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'),0,0,array('ordering ASC'));
            $data['employees']=array();
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
            $this->db->select('n.*');
            $this->db->select('t.id_class');
            $this->db->select('cls.id_sub_category');
            $this->db->select('sctg.id_category');
            $this->db->from($this->config->item('table_fms_setup_file_name').' n');
            $this->db->join($this->config->item('table_fms_setup_file_type').' t','n.id_type=t.id');
            $this->db->join($this->config->item('table_fms_setup_file_class').' cls','t.id_class=cls.id');
            $this->db->join($this->config->item('table_fms_setup_file_sub_category').' sctg','cls.id_sub_category=sctg.id');
            $this->db->where('n.id',$item_id);
            $data['item']=$this->db->get()->row_array();

            $data['item']['date_start']=System_helper::display_date($data['item']['date_start']);
            $data['title']='Edit '.$this->lang->line('LABEL_FILE_NAME').' ('.$data['item']['name'].')';

            $data['categories']=Query_helper::get_info($this->config->item('table_fms_setup_file_category'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'),0,0,array('ordering ASC'));
            $data['sub_categories']=Query_helper::get_info($this->config->item('table_fms_setup_file_sub_category'),array('id value','name text'),array('id_category='.$data['item']['id_category'],'status ="'.$this->config->item('system_status_active').'"'),0,0,array('ordering ASC'));
            $data['classes']=Query_helper::get_info($this->config->item('table_fms_setup_file_class'),array('id value','name text'),array('id_sub_category='.$data['item']['id_sub_category'],'status ="'.$this->config->item('system_status_active').'"'),0,0,array('ordering ASC'));
            $data['types']=Query_helper::get_info($this->config->item('table_fms_setup_file_type'),array('id value','name text'),array('id_class='.$data['item']['id_class'],'status ="'.$this->config->item('system_status_active').'"'),0,0,array('ordering ASC'));
            $data['hc_locations']=Query_helper::get_info($this->config->item('table_fms_setup_file_hc_location'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'),0,0,array('ordering ASC'));

            $data['companies']=Query_helper::get_info($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_company'),array('id value','full_name text'),array('status ="'.$this->config->item('system_status_active').'"'),0,0,array('ordering ASC'));
            $data['departments']=Query_helper::get_info($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_department'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'),0,0,array('ordering ASC'));

            $this->db->select("u.id value,CONCAT(ui.name,' - ',u.employee_id) AS text");
            $this->db->from($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_user').' u');
            $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_user_info').' ui','u.id=ui.user_id');
            $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_users_company').' uc','u.id=uc.user_id');
            $this->db->where('u.status',$this->config->item('system_status_active'));
            $this->db->where('ui.revision',1);
            $this->db->where('uc.company_id',$data['item']['id_company']);
            $this->db->where('uc.revision',1);
            $this->db->where('ui.department_id',$data['item']['id_department']);
            $this->db->order_by('u.employee_id');
            $this->db->group_by('u.id');
            $data['employees']=$this->db->get()->result_array();

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
            $data['date_start']=System_helper::get_time($data['date_start']);
            $this->db->trans_start(); //DB Transaction Handle START
            if($id>0)
            {
                $data['user_updated']=$user->user_id;
                $data['date_updated']=time();
                Query_helper::update($this->config->item('table_fms_setup_file_name'),$data,array('id='.$id));
            }
            else
            {
                $data['user_created']=$user->user_id;
                $data['date_created']=time();
                Query_helper::add($this->config->item('table_fms_setup_file_name'),$data);
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
        $this->form_validation->set_rules('item[date_start]',$this->lang->line('LABEL_DATE_START'),'required');
        $this->form_validation->set_rules('item[status_file]',$this->lang->line('LABEL_FILE_STATUS'),'required');
        $this->form_validation->set_rules('item[employee_id]',$this->lang->line('LABEL_RESPONSIBLE_EMPLOYEE'),'required');
        $this->form_validation->set_rules('item[id_company]',$this->lang->line('LABEL_COMPANY_NAME'),'required');
        $this->form_validation->set_rules('item[id_department]',$this->lang->line('LABEL_DEPARTMENT'),'required');
        if($this->form_validation->run()==false)
        {
            $this->message=validation_errors();
            return false;
        }
        return true;
    }
}
