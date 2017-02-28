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
    private function system_edit($id)
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
        if($file_permissions['action1']==1 || $file_permissions['action2']==1 || $file_permissions['action3']==1)
        {
            $data['item']=$this->get_file_info($item_id);
            $data['file_permissions']=$file_permissions;
            $data['stored_files']=Query_helper::get_info($this->config->item('table_fms_tasks_digital_file'),'*',array('id_file_name ='.$item_id,'status ="'.$this->config->item('system_status_active').'"'));
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
            if($data['item']['file_total']<1)
            {
                $ajax['system_message']='Your selected File is empty.';
                $ajax['status']=false;
                $this->json_return($ajax);
            }
            else
            {
                $data['stored_files']=Query_helper::get_info($this->config->item('table_fms_tasks_digital_file'),'*',array('id_file_name ='.$item_id,'status ="'.$this->config->item('system_status_active').'"'));
                $ajax['system_content'][]=array('id'=>'#system_content','html'=>$this->load->view($this->controller_url.'/details',$data,true));
                $ajax['system_page_url']=site_url($this->controller_url.'/index/details/'.$item_id);
                $ajax['status']=true;
                if($this->message)
                {
                    $ajax['system_message']=$this->message;
                }
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
    private function get_file_info($file_name_id)
    {
        $this->db->select('n.id,n.name,n.date_start');
        $this->db->select('ctg.name category_name');
        $this->db->select('cls.name class_name');
        $this->db->select('t.name type_name');
        $this->db->select('hl.name hardcopy_location');
        $this->db->select('CONCAT(ui.name," - ",u.employee_id) employee_name');
        $this->db->select('d.name department_name');
        $this->db->select('o.name office_name');
        $this->db->select('SUM(CASE WHEN df.status="'.$this->config->item('system_status_active').'" THEN 1 ELSE 0 END) file_total');
        $this->db->select('SUM(CASE WHEN df.status="'.$this->config->item('system_status_active').'" AND SUBSTRING(df.mime_type,1,5)="image" THEN 1 ELSE 0 END) number_of_page');
        $this->db->from($this->config->item('table_fms_setup_file_name').' n');
        $this->db->join($this->config->item('table_fms_setup_file_type').' t','n.id_type=t.id');
        $this->db->join($this->config->item('table_fms_setup_file_class').' cls','t.id_class=cls.id');
        $this->db->join($this->config->item('table_fms_setup_file_category').' ctg','cls.id_category=ctg.id');
        $this->db->join($this->config->item('table_fms_setup_file_hc_location').' hl','hl.id=n.id_hc_location');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_user_info').' ui','ui.user_id=n.employee_id','left');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_user').' u','ui.user_id=u.id');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_department').' d','d.id=n.id_department','left');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_offices').' o','o.id=n.id_office','left');
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

        $file_permissions=$this->get_file_permission($id);
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
        return $actions;
    }

    private function system_get_items()
    {
        $user=User_helper::get_user();
        $this->db->select('n.id,n.name,n.date_start,n.ordering');
        $this->db->select('ctg.name category_name');
        $this->db->select('cls.name class_name');
        $this->db->select('t.name type_name');
        $this->db->select('hl.name hardcopy_location');
        $this->db->select('CONCAT(ui.name," - ",u.employee_id) employee_name');
        $this->db->select('d.name department_name');
        $this->db->select('o.name office_name');
        $this->db->select('SUM(CASE WHEN df.status="'.$this->config->item('system_status_active').'" AND SUBSTRING(df.mime_type,1,5)="image" THEN 1 ELSE 0 END) number_of_page');
        $this->db->from($this->config->item('table_fms_setup_file_name').' n');
        $this->db->join($this->config->item('table_fms_setup_assign_file_user_group').' fug','n.id=fug.id_file');
        $this->db->join($this->config->item('table_fms_setup_file_type').' t','n.id_type=t.id');
        $this->db->join($this->config->item('table_fms_setup_file_class').' cls','t.id_class=cls.id');
        $this->db->join($this->config->item('table_fms_setup_file_category').' ctg','cls.id_category=ctg.id');
        $this->db->join($this->config->item('table_fms_setup_file_hc_location').' hl','hl.id=n.id_hc_location');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_user_info').' ui','ui.user_id=n.employee_id','left');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_user').' u','ui.user_id=u.id');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_department').' d','d.id=n.id_department','left');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_offices').' o','o.id=n.id_office','left');
        $this->db->join($this->config->item('table_fms_tasks_digital_file').' df','df.id_file_name=n.id','left');
        $this->db->where('n.status',$this->config->item('system_status_active'));
        $this->db->where('ui.revision',1);
        $this->db->where('fug.user_group_id',$user->user_group);
        $this->db->where('fug.revision',1);
        $this->db->order_by('ctg.ordering');
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
}
