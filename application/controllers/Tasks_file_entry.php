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
                $this->session->set_userdata('active_files','');

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
        $time=time();

        $allowed_types='gif|jpg|png|doc|docx|pdf|xls|xlsx|ppt|pptx|txt';
        $file_types_array_for_page_count=array
        (
            'gif'=>$this->config->item('system_digital_file_image'),
            'jpg'=>$this->config->item('system_digital_file_image'),
            'png'=>$this->config->item('system_digital_file_image'),
            'doc'=>$this->config->item('system_digital_file_word'),
            'docx'=>$this->config->item('system_digital_file_word'),
            'pdf'=>$this->config->item('system_digital_file_pdf'),
            'txt'=>$this->config->item('system_digital_file_txt_file'),
            'xls'=>$this->config->item('system_digital_file_excel'),
            'xlsx'=>$this->config->item('system_digital_file_excel'),
            'ppt'=>$this->config->item('system_digital_file_power_point'),
            'pptx'=>$this->config->item('system_digital_file_power_point')
        );

        if($this->get_file_permission($id))
        {
            if($this->file_permissions['action1']==1 || $this->file_permissions['action2']==1 || $this->file_permissions['action3']==1)
            {
                if(!$this->check_validation())
                {
                    $ajax['status']=false;
                    $ajax['system_message']=$this->message;
                    $this->json_return($ajax);
                }
                else
                {
                    $uploading_error_files=0; // if codeigniter cannot upload file
                    $deleted_move_files_for_undo=array(); // if database transaction failed

                    $this->db->trans_start(); //DB Transaction Handle START

                    $folder=FCPATH.$this->config->item('system_folder_upload').'/'.$id;
                    if(!is_dir($folder))
                    {
                        mkdir($folder,0777);
                    }
                    $delete_folder=$folder.'/'.$this->config->item('system_folder_upload_delete');
                    if(!is_dir($delete_folder))
                    {
                        mkdir($delete_folder,0777);
                    }
                    if($this->file_permissions['action2']==1)
                    {
                        $this->db->select('id');
                        $this->db->from($this->config->item('table_fms_tasks_digital_file'));
                        $this->db->where('id_file_name',$id);
                        $results=$this->db->get()->result_array();
                        $these_file_files=array();
                        foreach($results as $result)
                        {
                            $these_file_files[]=$result['id'];
                        }

                        $remarks_old=$this->input->post('remarks_old');
                        if(!is_array($remarks_old))
                        {
                            $remarks_old=array();
                        }
                        $date_entry_old=$this->input->post('date_entry_old');
                        if(!is_array($date_entry_old))
                        {
                            $date_entry_old=array();
                        }

                        $update_data=array();
                        foreach($date_entry_old as $row_key=>$row_value)
                        {
                            if(in_array($row_key,$these_file_files))
                            {
                                $update_data['date_entry']=System_helper::get_time($row_value);
                                Query_helper::update($this->config->item('table_fms_tasks_digital_file'),$update_data,array('id='.$row_key));
                            }
                            else
                            {
                                System_helper::invalid_try('UPDATE',$row_key,$this->config->item('table_fms_tasks_digital_file').' try to update File Entry Date illegal way.');
                            }
                        }
                        $update_data=array();
                        foreach($remarks_old as $row_key=>$row_value)
                        {
                            if(in_array($row_key,$these_file_files))
                            {
                                $update_data['remarks']=$row_value;
                                Query_helper::update($this->config->item('table_fms_tasks_digital_file'),$update_data,array('id='.$row_key));
                            }
                            else
                            {
                                System_helper::invalid_try('UPDATE',$row_key,$this->config->item('table_fms_tasks_digital_file').' try to update File Remarks illegal way.');
                            }
                        }
                    }
                    $temp_session_active_files=$this->session->userdata('active_files');
                    if($this->file_permissions['action2']==1 || $this->file_permissions['action3']==1)
                    {
                        if(strlen($this->session->userdata('active_files'))>0)
                        {
                            $active_files=explode(',',$temp_session_active_files);
                            $form_files=$this->input->post('files');
                            if(!is_array($form_files))
                            {
                                $form_files=array();
                            }
                            foreach($active_files as $af)
                            {
                                if(array_key_exists($af,$form_files))
                                {
                                    //
                                }
                                else
                                {
                                    $temp_session_active_files=str_replace($af.',','',$temp_session_active_files);
                                    $temp_session_active_files=str_replace(','.$af,'',$temp_session_active_files);
                                    $temp_session_active_files=str_replace($af,'',$temp_session_active_files);

                                    $this->db->select('name');
                                    $this->db->from($this->config->item('table_fms_tasks_digital_file'));
                                    $this->db->where('id',$af);
                                    $file_delete=$this->db->get()->row_array();

                                    $update_delete_data['name']=$this->move_deleted_file($folder,$file_delete['name']);
                                    if($update_delete_data['name']===false)
                                    {
                                        continue;
                                    }
                                    $update_delete_data['user_updated']=$this->user_id;
                                    $update_delete_data['date_updated']=$time;
                                    $update_delete_data['status']=$this->config->item('system_status_delete');
                                    Query_helper::update($this->config->item('table_fms_tasks_digital_file'),$update_delete_data,array('id='.$af));
                                    $deleted_move_files_for_undo[$update_delete_data['name']]=$file_delete['name'];
                                }
                            }
                        }
                    }
                    if($this->file_permissions['action1']==1 || $this->file_permissions['action2']==1)
                    {
                        $upload_files=System_helper::upload_file($this->config->item('system_folder_upload').'/'.$id,$allowed_types);
                        $date_entry=$this->input->post('date_entry');
                        $remarks=$this->input->post('remarks');

                        $upload_file_data['id_file_name']=$id;
                        $upload_file_data['date_created']=$time;
                        $upload_file_data['user_created']=$this->user_id;

                        foreach($upload_files as $key=>$value)
                        {
                            $index=explode('_',$key)[1];
                            if($value['status']==true)
                            {
                                $upload_file_data['date_entry']=System_helper::get_time($date_entry[$index]);
                                $upload_file_data['remarks']=$remarks[$index];
                                $upload_file_data['mime_type']=$value['info']['file_type'];
                                $upload_file_data['type']=$file_types_array_for_page_count[strtolower(substr($value['info']['file_ext'],1))];
                                $upload_file_data['name']=$value['info']['file_name'];
                                $upload_files[$key]['insert_id']=Query_helper::add($this->config->item('table_fms_tasks_digital_file'),$upload_file_data);
                                if($this->file_permissions['action2']==1 || $this->file_permissions['action3']==1)
                                {
                                    $temp_session_active_files.=','.$upload_files[$key]['insert_id'];
                                }
                            }
                            else
                            {
                                ++$uploading_error_files;
                            }
                        }
                    }

                    $this->db->trans_complete(); //DB Transaction Handle END

                    if($this->db->trans_status()===true)
                    {
                        if($uploading_error_files>0)
                        {
                            if(substr($temp_session_active_files,0,1)==',')
                            {
                                $temp_session_active_files=substr($temp_session_active_files,1);
                            }
                            $this->session->set_userdata('active_files',$temp_session_active_files);

                            $upload_complete_info['upload_files']=$upload_files;
                            $upload_complete_info['id']=$id; //use for folder name

                            $ajax['status']=false;
                            $ajax['system_message']='Upload successful. But some errors occur.';
                            $ajax['system_content'][]=array('id'=>'#upload-complete-info','html'=>$this->load->view($this->controller_url.'/upload-result',$upload_complete_info,true));
                            $this->json_return($ajax);
                        }
                        $this->message=$this->lang->line('MSG_SAVED_SUCCESS');
                        $this->system_list();
                    }
                    else
                    {
                        foreach($deleted_move_files_for_undo as $deleted_name=>$real_name)
                        {
                            rename($delete_folder.'/'.$deleted_name,$folder.'/'.$real_name);
                        }
                        $ajax['status']=false;
                        $this->message=$this->lang->line('MSG_SAVED_FAIL');
                        $this->system_list();
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
    private function move_deleted_file($folder,$file_name)
    {
        if(file_exists($folder.'/'.$file_name))
        {
            $return_value=$file_name;
            $extension='.'.pathinfo($file_name,PATHINFO_EXTENSION);
            $raw_name=pathinfo($file_name,PATHINFO_FILENAME);
            $delete_folder=$this->config->item('system_folder_upload_delete');
            $i=0;
            $file=$folder.'/'.$delete_folder.'/'.$file_name;
            while(file_exists($file))
            {
                ++$i;
                $file=$folder.'/'.$delete_folder.'/'.$raw_name.$i.$extension;
                $return_value=$raw_name.$i.$extension;
            }
            rename($folder.'/'.$file_name,$file);
            return $return_value;
        }
        else
        {
            return false;
        }
    }
    private function check_validation()
    {
        /*$this->load->library('form_validation');
        $this->form_validation->set_rules('items[id_name]',$this->lang->line('LABEL_FILE_NAME'),'required');
        if($this->form_validation->run()==false)
        {
            $this->message=validation_errors();
            return false;
        }*/
        return true;
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
