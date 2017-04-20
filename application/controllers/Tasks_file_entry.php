<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks_file_entry extends Root_Controller
{
    private $message;
    public $permissions;
    public $controller_url;
    public function __construct()
    {
        parent::__construct();
        $this->message='';
        $this->controller_url='tasks_file_entry';
        $this->permissions=User_helper::get_permission('Tasks_file_entry');
    }
    public function index($action='list',$id=0)
    {
        if($action=='list')
        {
            $this->system_list();
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
        elseif($action=='save_new_file')
        {
            $this->system_save_new_file();
        }
        else
        {
            $this->system_list();
        }
    }
    private function system_list()
    {
        if(isset($this->permissions['action0']) && ($this->permissions['action0']==1))
        {
            $data['title']='Permitted Files List for File Entry';
            $ajax['system_page_url']=site_url($this->controller_url.'/index/list');
            $ajax['system_content'][]=array('id'=>'#system_content','html'=>$this->load->view($this->controller_url.'/list',$data,true));
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
        $user=User_helper::get_user();
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
        $this->db->join($this->config->item('table_fms_setup_assign_file_user_group').' fug','n.id=fug.id_file');
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
        $this->db->where('ctg.status',$this->config->item('system_status_active'));
        $this->db->where('sctg.status',$this->config->item('system_status_active'));
        $this->db->where('cls.status',$this->config->item('system_status_active'));
        $this->db->where('t.status',$this->config->item('system_status_active'));
        $this->db->where('n.status',$this->config->item('system_status_active'));
        $this->db->where('ui.revision',1);
        $this->db->where('fug.user_group_id',$user->user_group);
        $this->db->where('fug.revision',1);
        $this->db->order_by('ctg.ordering');
        $this->db->order_by('sctg.ordering');
        $this->db->order_by('cls.ordering');
        $this->db->order_by('t.ordering');
        $this->db->order_by('n.ordering');
        $this->db->group_by('n.id');
        $this->db->limit($pagesize,$current_records);
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
            $user=User_helper::get_user();
            $data=array();

            $this->db->select('t.id type_id,t.name type_name');
            $this->db->select('cls.id class_id,cls.name class_name');
            $this->db->select('sctg.id sub_category_id,sctg.name sub_category_name');
            $this->db->select('ctg.id category_id,ctg.name category_name');
            $this->db->from($this->config->item('table_fms_setup_file_name').' n');
            $this->db->join($this->config->item('table_fms_setup_assign_file_user_group').' afug','afug.id_file=n.id');
            $this->db->join($this->config->item('table_fms_setup_file_type').' t','t.id=n.id_type');
            $this->db->join($this->config->item('table_fms_setup_file_class').' cls','cls.id=t.id_class');
            $this->db->join($this->config->item('table_fms_setup_file_sub_category').' sctg','sctg.id=cls.id_sub_category');
            $this->db->join($this->config->item('table_fms_setup_file_category').' ctg','ctg.id=sctg.id_category');
            $this->db->where('afug.user_group_id',$user->user_group);
            $this->db->where('afug.action0',1);
            $this->db->where('afug.revision',1);
            $this->db->where('ctg.status',$this->config->item('system_status_active'));
            $this->db->where('sctg.status',$this->config->item('system_status_active'));
            $this->db->where('cls.status',$this->config->item('system_status_active'));
            $this->db->where('t.status',$this->config->item('system_status_active'));
            $this->db->where('n.status',$this->config->item('system_status_active'));
            $this->db->order_by('ctg.ordering');
            $this->db->order_by('sctg.ordering');
            $this->db->order_by('cls.ordering');
            $this->db->order_by('t.ordering');
            $this->db->group_by('t.id');
            $results=$this->db->get()->result_array();
            if(sizeof($results)<1)
            {
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line('YOU_DONT_HAVE_ACCESS');
                $this->json_return($ajax);
            }
            $data['categories']=array();
            $data['sub_categories']=array();
            $data['classes']=array();
            $data['types']=array();
            $data['sub_category_counter']=0;
            $data['class_counter']=0;
            $data['type_counter']=count($results);
            foreach($results as $result)
            {
                $data['categories'][$result['category_id']]=array('value'=>$result['category_id'],'text'=>$result['category_name']);
                if(!isset($data['sub_categories'][$result['category_id']][$result['sub_category_id']]))
                {
                    $data['sub_categories'][$result['category_id']][$result['sub_category_id']]=array('value'=>$result['sub_category_id'],'text'=>$result['sub_category_name']);
                    ++$data['sub_category_counter'];
                }
                if(!isset($data['classes'][$result['sub_category_id']][$result['class_id']]))
                {
                    $data['classes'][$result['sub_category_id']][$result['class_id']]=array('value'=>$result['class_id'],'text'=>$result['class_name']);
                    ++$data['class_counter'];
                }
                $data['types'][$result['class_id']][$result['type_id']]=array('value'=>$result['type_id'],'text'=>$result['type_name']);
            }
            unset($results);

            $this->db->select('com.id value,com.full_name text');
            $this->db->from($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_company').' com');
            $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_users_company').' ucom','ucom.company_id=com.id');
            $this->db->where('com.status',$this->config->item('system_status_active'));
            $this->db->where('ucom.revision',1);
            $this->db->where('ucom.user_id',$user->user_id);
            $this->db->order_by('com.ordering');
            $data['companies']=$this->db->get()->result_array();

            if($user->department_id>0)
            {
                $result=Query_helper::get_info($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_department'),'name',array('id='.$user->department_id),1,0);
                $data['department']=array('value'=>$user->department_id,'text'=>$result['name']);
            }
            else
            {
                $data['department']=array('value'=>'','text'=>'Not Assigned');
            }
            $data['employee']=array('value'=>$user->user_id,'text'=>$user->name);
            $data['hc_locations']=Query_helper::get_info($this->config->item('table_fms_setup_file_hc_location'),'id value,name text',array(),0,0,'ordering');

            $data['title']='Create New '.$this->lang->line('LABEL_FILE_NAME');
            $ajax['system_page_url']=site_url($this->controller_url.'/index/add');
            $ajax['system_content'][]=array('id'=>'#system_content','html'=>$this->load->view($this->controller_url.'/add',$data,true));
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
    private function get_file_items($file_id)
    {
        $this->db->select('i.id,i.name,i.status');
        $this->db->from($this->config->item('table_fms_setup_file_item').' i');
        $this->db->join($this->config->item('table_fms_setup_file_type').' t','t.id=i.id_type');
        $this->db->join($this->config->item('table_fms_setup_file_name').' n','n.id_type=t.id');
        $this->db->where('n.id',$file_id);
        $this->db->order_by('i.ordering');
        $results=$this->db->get()->result_array();
        return $results;
    }
    private function system_edit($id)
    {
        if(!(isset($this->permissions['action2']) && ($this->permissions['action2']==1)))
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->lang->line('YOU_DONT_HAVE_ACCESS');
            $this->json_return($ajax);
        }

        if(($this->input->post('id')))
        {
            $item_id=$this->input->post('id');
        }
        else
        {
            $item_id=$id;
        }
        $file_permissions=$this->get_file_permission($item_id);
        if($file_permissions['action1']==1 || $file_permissions['action2']==1 || $file_permissions['action3']==1)
        {
            $data['item']=$this->get_file_info($item_id);
            $data['file_permissions']=$file_permissions;
            $data['file_items']=$this->get_file_items($item_id);
            $stored_files=Query_helper::get_info($this->config->item('table_fms_tasks_digital_file'),'*',array('id_file_name ='.$item_id,'status ="'.$this->config->item('system_status_active').'"'));
            $data['item_files']=array();
            foreach($stored_files as $file)
            {
                $data['item_files'][$file['id_file_item']][]=$file;
            }
            $data['hc_locations']=Query_helper::get_info($this->config->item('table_fms_setup_file_hc_location'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'),0,0,array('ordering ASC'));
            $ajax['system_page_url']=site_url($this->controller_url.'/index/edit/'.$item_id);
            $ajax['system_content'][]=array('id'=>'#system_content','html'=>$this->load->view($this->controller_url.'/edit',$data,true));
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
    private function system_details($id)
    {
        if(($this->input->post('id')))
        {
            $item_id=$this->input->post('id');
        }
        else
        {
            $item_id=$id;
        }
        $file_permissions=$this->get_file_permission($item_id);
        if($file_permissions['action0']==1)
        {
            $data['file_permissions']=$file_permissions;
            $data['item']=$this->get_file_info($item_id);
            $data['file_items']=$this->get_file_items($item_id);
            $stored_files=Query_helper::get_info($this->config->item('table_fms_tasks_digital_file'),'*',array('id_file_name ='.$item_id,'status ="'.$this->config->item('system_status_active').'"'));
            $data['item_files']=array();
            foreach($stored_files as $file)
            {
                $data['item_files'][$file['id_file_item']][]=$file;
            }
            $ajax['system_content'][]=array('id'=>'#system_content','html'=>$this->load->view($this->controller_url.'/details',$data,true));
            $ajax['system_page_url']=site_url($this->controller_url.'/index/details/'.$item_id);
            $ajax['status']=true;
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $this->json_return($ajax);
        }
        else
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->lang->line('YOU_DONT_HAVE_ACCESS');
            $this->json_return($ajax);
        }
    }
    private function get_file_info($file_name_id)
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
        $this->db->select('SUM(CASE WHEN df.status="'.$this->config->item('system_status_active').'" THEN 1 ELSE 0 END) file_total');
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
        $this->db->where('ui.revision',1);
        $this->db->where('n.id',$file_name_id);
        $this->db->where('n.status',$this->config->item('system_status_active'));
        return $this->db->get()->row_array();
    }
    private function system_save()
    {
        $id=$this->input->post('id');
        $user=User_helper::get_user();
        $time=time();
        $file_open_time_for_edit=$this->input->post('file_open_time_for_edit');
        $allowed_types='gif|jpg|png|doc|docx|pdf|xls|xlsx|ppt|pptx|txt';

        if(!(isset($this->permissions['action2']) && ($this->permissions['action2']==1)))
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->lang->line('YOU_DONT_HAVE_ACCESS');
            $this->json_return($ajax);
        }
        $file_permissions=$this->get_file_permission($id);
        if(!$file_permissions['editable'])
        {
            if($file_permissions['action1']==1 || $file_permissions['action2']==1 || $file_permissions['action3']==1)
            {
                if($this->input->post('id_hc_location'))
                {
                    $data=array();
                    $data['id_hc_location']=$this->input->post('id_hc_location');
                    $data['date_updated']=$time;
                    $data['user_updated']=$user->user_id;
                    $this->db->trans_start();
                    Query_helper::update($this->config->item('table_fms_setup_file_name'),$data,array('id ='.$id));
                    $this->db->trans_complete(); //DB Transaction Handle END
                    if($this->db->trans_status()!==true)
                    {
                        $ajax['status']=false;
                        $ajax['system_message']=$this->lang->line('MSG_SAVED_FAIL');
                        $this->json_return($ajax);
                    }
                }
            }
            $this->message=$this->lang->line('MSG_SAVED_SUCCESS');
            $this->system_list();
            exit();
        }
        if($file_permissions['action1']==1 || $file_permissions['action2']==1 || $file_permissions['action3']==1)
        {
            //check if already saved
            $result=Query_helper::get_info($this->config->item('table_fms_setup_file_name'),array('date_created','date_updated'),array('id ='.$id),1);
            $time_last_saved=$result['date_created'];
            if($result['date_updated']>0)
            {
                $time_last_saved=$result['date_updated'];
            }
            if($file_open_time_for_edit<=$time_last_saved)
            {
                $this->message='This file already saved by another person while you editing.<br>Please try again.';
                $this->system_edit($id);
            }
            //check if already saved finished

            //upload files and check if ok upload
            $folder=FCPATH.$this->config->item('system_folder_upload').'/'.$id;
            if(!is_dir($folder))
            {
                mkdir($folder,0777);
            }
            $uploaded_files=System_helper::upload_file($this->config->item('system_folder_upload').'/'.$id,$allowed_types);
            foreach($uploaded_files as $file)
            {
                if(!$file['status'])
                {
                    $ajax['status']=false;
                    $ajax['system_message']=$file['message'];
                    $this->json_return($ajax);
                    die();
                }
            }
            //upload files and check if ok upload
            $stored_files=array();
            $items_old=$this->input->post('items_old');
            if(!is_array($items_old))
            {
                $items_old=array();
            }
            //check validation of delete and edit
            if($file_permissions['action2']==1 || $file_permissions['action3']==1)
            {
                $stored_files=Query_helper::get_info($this->config->item('table_fms_tasks_digital_file'),'*',array('id_file_name ='.$id,'status ="'.$this->config->item('system_status_active').'"'));
                if(sizeof($stored_files)!=sizeof($items_old))
                {
                    if($file_permissions['action3']!=1)
                    {
                        System_helper::invalid_try('DELETE',$id,$this->config->item('table_fms_tasks_digital_file').' Try to Delete File illegal way.');
                        $ajax['status']=false;
                        $ajax['system_message']='Illegal Delete action';
                        $this->json_return($ajax);
                        die();
                    }
                }

            }
            //check validation of delete and edit complete
            $this->db->trans_start(); //DB Transaction Handle START
            if($file_permissions['action2']==1 || $file_permissions['action3']==1)
            {
                foreach($stored_files as $file)
                {
                    $data=array();
                    if(isset($items_old[$file['id']]))
                    {
                        if(isset($uploaded_files['file_old_'.$file['id']]))
                        {
                            $data['name']=$uploaded_files['file_old_'.$file['id']]['info']['file_name'];
                            $data['file_path']=$this->config->item('system_folder_upload').'/'.$id.'/'.$uploaded_files['file_old_'.$file['id']]['info']['file_name'];
                            $data['mime_type']=$uploaded_files['file_old_'.$file['id']]['info']['file_type'];
                        }
                        if($file['remarks']!=$items_old[$file['id']]['remarks'])
                        {
                            $data['remarks']=$items_old[$file['id']]['remarks'];
                        }
                        if($file['date_entry']!=System_helper::get_time($items_old[$file['id']]['date_entry']))
                        {
                            $data['date_entry']=System_helper::get_time($items_old[$file['id']]['date_entry']);
                        }
                    }
                    else
                    {
                        $data['status']=$this->config->item('system_status_delete');
                    }
                    if(sizeof($data)>0)
                    {
                        $data['date_updated']=$time;
                        $data['user_updated']=$user->user_id;
                        Query_helper::update($this->config->item('table_fms_tasks_digital_file'),$data,array('id ='.$file['id']));
                    }
                }

            }
            if($file_permissions['action1']==1)
            {
                $items_new=$this->input->post('items_new');
                if(is_array($items_new))
                {
                    foreach($items_new as $key=>$data)
                    {
                        $data['name']='no_image.jpg';
                        $data['file_path']='images/no_image.jpg';
                        $data['id_file_name']=$id;
                        $data['mime_type']='image/jpeg';
                        $data['date_entry']=System_helper::get_time($data['date_entry']);
                        $data['status']=$this->config->item('system_status_active');
                        $data['date_created']=$time;
                        $data['user_created']=$user->user_id;
                        if(isset($uploaded_files['file_new_'.$key]))
                        {
                            $data['name']=$uploaded_files['file_new_'.$key]['info']['file_name'];
                            $data['file_path']=$this->config->item('system_folder_upload').'/'.$id.'/'.$uploaded_files['file_new_'.$key]['info']['file_name'];
                            $data['mime_type']=$uploaded_files['file_new_'.$key]['info']['file_type'];
                        }
                        Query_helper::add($this->config->item('table_fms_tasks_digital_file'),$data);

                    }

                }
            }
            //last updated by
            $data=array();
            $data['date_updated']=$time;
            $data['user_updated']=$user->user_id;
            if(isset($this->permissions['action2']) && ($this->permissions['action2']==1))
            {
                if($this->input->post('id_hc_location'))
                {
                    $data['id_hc_location']=$this->input->post('id_hc_location');
                }
                if($this->input->post('status_file')==$this->config->item('system_status_file_open') || $this->input->post('status_file')==$this->config->item('system_status_file_close'))
                {
                    $data['status_file']=$this->input->post('status_file');
                }
            }
            Query_helper::update($this->config->item('table_fms_setup_file_name'),$data,array('id ='.$id));



            $this->db->trans_complete(); //DB Transaction Handle END

            if($this->db->trans_status()===true)
            {

                $this->message=$this->lang->line('MSG_SAVED_SUCCESS');
                $this->system_list();
            }
            else
            {
                $ajax['status']=false;
                $this->message=$this->lang->line('MSG_SAVED_FAIL');
                $this->system_edit($id);
            }

        }
        else
        {
            System_helper::invalid_try('UPDATE',$id,$this->config->item('table_fms_tasks_digital_file').' Try to Save File illegal way.');
            $ajax['status']=false;
            $ajax['system_message']=$this->lang->line('YOU_DONT_HAVE_ACCESS');
            $this->json_return($ajax);
        }
    }
    private function get_file_permission($file_name_id)
    {
        $user=User_helper::get_user();
        $this->db->select('*');
        $this->db->from($this->config->item('table_fms_setup_assign_file_user_group'));
        $this->db->where('user_group_id',$user->user_group);
        $this->db->where('id_file',$file_name_id);
        $this->db->where('revision',1);
        $actions=$this->db->get()->row_array();
        if(!$actions)
        {
            for($index=0;$index<$this->config->item('system_fms_max_actions');$index++)
            {
                $actions['action'.$index]=0;
            }
        }
        else
        {
            $result=Query_helper::get_info($this->config->item('table_fms_setup_file_name'),'status_file',array('id='.$file_name_id),1);
            $actions['editable']=false;
            if($result['status_file']==$this->config->item('system_status_file_open'))
            {
                $actions['editable']=true;
            }
        }
        return $actions;
    }
    private function system_save_new_file()
    {
        $user=User_helper::get_user();
        if(!(isset($this->permissions['action1']) && ($this->permissions['action1']==1)))
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->lang->line('YOU_DONT_HAVE_ACCESS');
            $this->json_return($ajax);
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
            $time=time();
            $data['date_start']=System_helper::get_time($data['date_start']);

            $this->db->trans_begin(); //DB Transaction Handle START

            $data['user_created']=$user->user_id;
            $data['date_created']=$time;
            $file_name_id=Query_helper::add($this->config->item('table_fms_setup_file_name'),$data);
            if($file_name_id===false)
            {
                $this->db->trans_rollback();
                $ajax['status']=false;
                $ajax['desk_message']=$this->lang->line('MSG_SAVED_FAIL');
                $this->json_return($ajax);
            }
            $data=array();
            $data['user_created']=$user->user_id;
            $data['date_created']=$time;
            $data['user_group_id']=$user->user_group;
            $data['id_file']=$file_name_id;
            $data['revision']=1;
            for($i=0;$i<$this->config->item('system_fms_max_actions');++$i)
            {
                $data['action'.$i]=0;
            }
            $data['action0']=1;
            $data['action1']=1;
            Query_helper::add($this->config->item('table_fms_setup_assign_file_user_group'),$data);

            if($this->db->trans_status()===true)
            {
                $this->db->trans_commit();
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
                $this->db->trans_rollback();
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
