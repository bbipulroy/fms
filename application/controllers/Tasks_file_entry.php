<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks_file_entry extends Root_Controller
{
    private $message;
    public $permissions;
    public $controller_url;
    public $file_permissions;
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
        if($this->get_file_permission($item_id))
        {
            if($this->file_permissions['action1']==1 || $this->file_permissions['action2']==1 || $this->file_permissions['action3']==1)
            {
                $data['item']=$this->get_file_info($item_id);

                $this->db->select('id,name,date_entry,remarks,mime_type');
                $this->db->from($this->config->item('table_fms_tasks_digital_file'));
                $this->db->where('id_file_name',$item_id);
                $this->db->where('status',$this->config->item('system_status_active'));
                $data['stored_files']=$this->db->get()->result_array();
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
        if($this->get_file_permission($item_id) && $this->file_permissions['action0']==1)
        {
            $data['details']=$this->get_file_info($item_id);
            if($data['details']['file_total']<1)
            {
                $ajax['system_message']='Your selected File is empty.';
                $ajax['status']=false;
                $this->json_return($ajax);
            }
            else
            {
                $this->db->select('name,date_entry,remarks,mime_type');
                $this->db->from($this->config->item('table_fms_tasks_digital_file'));
                $this->db->where('id_file_name',$item_id);
                $this->db->where('status',$this->config->item('system_status_active'));
                $data['files_info']=$this->db->get()->result_array();
            }
            $ajax['system_content'][]=array('id'=>'#system_content','html'=>$this->load->view($this->controller_url.'/details',$data,true));
            $ajax['system_page_url']=site_url($this->controller_url.'/index/details/'.$item_id);
            $ajax['status']=true;
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
        }
        else
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->lang->line('YOU_DONT_HAVE_ACCESS');
        }
        $this->json_return($ajax);
    }
    private function get_file_info($file_name_id)
    {
        $this->db->select('n.id,n.name,n.date_start,ctg.name category_name,cls.name class_name,t.name type_name,hl.name hardcopy_location,CONCAT(ui.name," - ",u.employee_id) employee_name,d.name department_name,o.name office_name,SUM(CASE WHEN df.status="'.$this->config->item('system_status_active').'" THEN 1 ELSE 0 END) file_total');
        $this->db->select('SUM(CASE WHEN df.status="'.$this->config->item('system_status_active').'" AND MID(df.mime_type,1,5)="image" THEN 1 ELSE 0 END) number_of_page');
        $this->db->from($this->config->item('table_fms_setup_file_name').' n');
        $this->db->join($this->config->item('table_fms_setup_file_type').' t','n.id_type=t.id');
        $this->db->join($this->config->item('table_fms_setup_file_class').' cls','t.id_class=cls.id');
        $this->db->join($this->config->item('table_fms_setup_file_category').' ctg','cls.id_category=ctg.id');
        $this->db->join($this->config->item('table_fms_setup_file_hc_location').' hl','hl.id=n.id_hc_location');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_user_info').' ui','ui.user_id=n.employee_responsible','left');
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
        $file_open_time_for_save=$this->input->post('file_open_time_for_edit');
        $time=time();

        $allowed_types='gif|jpg|png|doc|docx|pdf|xls|xlsx|ppt|pptx|txt';
        if($this->get_file_permission($id))
        {
            if($this->file_permissions['action1']==1 || $this->file_permissions['action2']==1 || $this->file_permissions['action3']==1)
            {
                $this->db->select('date_updated');
                $this->db->from($this->config->item('table_fms_setup_file_name'));
                $this->db->where('id',$id);
                $time_last_saved=$this->db->get()->row_array()['date_updated'];
                if($file_open_time_for_save<=$time_last_saved)
                {
                    $this->message='This file already saved by another person. Please try again.';
                    $this->system_edit($id);
                }

                $folder=FCPATH.$this->config->item('system_folder_upload').'/'.$id;
                if(!is_dir($folder))
                {
                    mkdir($folder,0777);
                }
                $upload_files=System_helper::upload_file($this->config->item('system_folder_upload').'/'.$id,$allowed_types);
                $check_validation=$this->check_validation($upload_files);
                if($check_validation!==true)
                {
                    $ajax['status']=false;
                    $ajax['system_message']=$check_validation;
                    $this->json_return($ajax);
                }
                else
                {
                    $this->db->trans_start(); //DB Transaction Handle START

                    $date_entry_new=$this->input->post('date_entry_new');
                    $remarks_new=$this->input->post('remarks_new');
                    $date_entry_old=$this->input->post('date_entry_old');
                    if(!is_array($date_entry_old))
                    {
                        $date_entry_old=array();
                    }
                    $remarks_old=$this->input->post('remarks_old');
                    if(!is_array($remarks_old))
                    {
                        $remarks_old=array();
                    }

                    $this->db->select('*');
                    $this->db->from($this->config->item('table_fms_tasks_digital_file'));
                    $this->db->where('id_file_name',$id);
                    $results=$this->db->get()->result_array();
                    $these_file_details=array(); //file_name's digital files
                    foreach($results as $result)
                    {
                        $these_file_details[$result['id']]=$result;
                    }

                    if($this->file_permissions['action1']==1 || $this->file_permissions['action2']==1)
                    {
                        $upload_file_data['id_file_name']=$id;
                        $upload_file_data['date_created']=$time;
                        $upload_file_data['user_created']=User_helper::get_user()->user_id;

                        foreach($upload_files as $key=>$value)
                        {
                            $index=explode('_',$key)[1];
                            $upload_file_data['date_entry']=System_helper::get_time($date_entry_new[$index]);
                            $upload_file_data['remarks']=$remarks_new[$index];
                            $upload_file_data['mime_type']=$value['info']['file_type'];
                            $upload_file_data['name']=$value['info']['file_name'];
                            Query_helper::add($this->config->item('table_fms_tasks_digital_file'),$upload_file_data);
                        }
                        unset($upload_file_data['mime_type']);
                        unset($upload_file_data['name']);
                        foreach ($_FILES as $key=>$value)
                        {
                            if(strlen($value['name'])==0)
                            {
                                $index=explode('_',$key)[1];
                                if(isset($date_entry_new[$index]))
                                {
                                    $upload_file_data['date_entry']=System_helper::get_time($date_entry_new[$index]);
                                    $upload_file_data['remarks']=$remarks_new[$index];
                                    Query_helper::add($this->config->item('table_fms_tasks_digital_file'),$upload_file_data);
                                }
                            }
                        }
                    }

                    if($this->file_permissions['action2']==1)
                    {
                        $update_data['date_updated']=$time;
                        $update_data['user_updated']=User_helper::get_user()->user_id;
                        foreach($date_entry_old as $key=>$value)
                        {
                            if(array_key_exists($key,$these_file_details))
                            {
                                $update_data['date_entry']=System_helper::get_time($value);
                                if(isset($remarks_old[$key]))
                                {
                                    $update_data['remarks']=$remarks_old[$key];
                                    if($update_data['date_entry']!=$these_file_details[$key]['date_entry'] || $update_data['remarks']!=$these_file_details[$key]['remarks'])
                                    {
                                        Query_helper::update($this->config->item('table_fms_tasks_digital_file'),$update_data,array('id='.$key));
                                    }
                                }
                                else
                                {
                                    System_helper::invalid_try('UPDATE',$id,$this->config->item('table_fms_tasks_digital_file').' try to update File Entry Date or Remarks in illegal way. ('.$key.')');
                                }
                            }
                            else
                            {
                                System_helper::invalid_try('UPDATE',$id,$this->config->item('table_fms_tasks_digital_file').' try to update File Entry Date or Remarks in illegal way. ('.$key.')');
                            }
                        }
                    }

                    if($this->file_permissions['action2']==1 || $this->file_permissions['action3']==1)
                    {
                        $form_files=$this->input->post('files');
                        if(!is_array($form_files))
                        {
                            $form_files=array();
                        }
                        $update_data=array();
                        $update_data['date_updated']=$time;
                        $update_data['user_updated']=User_helper::get_user()->user_id;
                        $update_data['status']=$this->config->item('system_status_delete');
                        foreach($these_file_details as $key=>$value)
                        {
                            if(!isset($form_files[$key]))
                            {
                                Query_helper::update($this->config->item('table_fms_tasks_digital_file'),$update_data,array('id='.$key));
                            }
                        }
                    }
                    $this->db->trans_complete(); //DB Transaction Handle END

                    if($this->db->trans_status()===true)
                    {
                        $this->db->set('date_updated',time());
                        $this->db->update($this->config->item('table_fms_setup_file_name'));
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
            }
            else
            {
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line('YOU_DONT_HAVE_ACCESS');
                $this->json_return($ajax);
            }
        }
        else
        {
            System_helper::invalid_try('UPDATE',$id,$this->config->item('table_fms_tasks_digital_file').' try to Entry File illegal way.');
            $ajax['status']=false;
            $ajax['system_message']='You violate your rules.';
            $this->json_return($ajax);
        }
    }
    private function get_file_permission($file_name_id)
    {
        $this->db->select('*');
        $this->db->from($this->config->item('table_fms_setup_assign_file_user_group'));
        $this->db->where('user_group_id',User_helper::get_user()->user_group);
        $this->db->where('id_file',$file_name_id);
        $this->db->where('revision',1);
        $actions=$this->db->get()->row_array();
        if($actions)
        {
            $this->file_permissions=$actions;
            return true;
        }
        else
        {
            return false;
        }
    }
    private function check_validation($upload_files)
    {
        $error_message='';
        foreach($upload_files as $file)
        {
            if($file['status']==false)
            {
                $error_message.=$file['message'];
            }
        }
        if(strlen($error_message)>0)
        {
            return $error_message;
        }
        else
        {
            return true;
        }
    }
    private function system_get_items()
    {
        $this->db->select('n.id,n.name,n.date_start,n.ordering,ctg.name category_name,cls.name class_name,t.name type_name,hl.name hardcopy_location,CONCAT(ui.name," - ",u.employee_id) employee_name,d.name department_name,o.name office_name');
        $this->db->select('SUM(CASE WHEN df.status="'.$this->config->item('system_status_active').'" AND MID(df.mime_type,1,5)="image" THEN 1 ELSE 0 END) number_of_page');
        $this->db->from($this->config->item('table_fms_setup_file_name').' n');
        $this->db->join($this->config->item('table_fms_setup_assign_file_user_group').' fug','n.id=fug.id_file');
        $this->db->join($this->config->item('table_fms_setup_file_type').' t','n.id_type=t.id');
        $this->db->join($this->config->item('table_fms_setup_file_class').' cls','t.id_class=cls.id');
        $this->db->join($this->config->item('table_fms_setup_file_category').' ctg','cls.id_category=ctg.id');
        $this->db->join($this->config->item('table_fms_setup_file_hc_location').' hl','hl.id=n.id_hc_location');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_user_info').' ui','ui.user_id=n.employee_responsible','left');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_user').' u','ui.user_id=u.id');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_department').' d','d.id=n.id_department','left');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_offices').' o','o.id=n.id_office','left');
        $this->db->join($this->config->item('table_fms_tasks_digital_file').' df','df.id_file_name=n.id','left');
        $this->db->where('n.status',$this->config->item('system_status_active'));
        $this->db->where('ui.revision',1);
        $this->db->where('fug.user_group_id',User_helper::get_user()->user_group);
        $this->db->where('fug.revision',1);
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
