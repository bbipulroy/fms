<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks_file_entry extends Root_Controller
{
    private $message;
    public $permissions;
    public $is_view=false;
    public $is_add=false;
    public $is_edit=false;
    public $is_delete=false;
    public $controller_url;
    private $user_group;
    private $user_id;
    private $user;
    public function __construct()
    {
        parent::__construct();
        $this->message='';
        $this->user=User_helper::get_user();
        $this->user_group=$this->user->user_group;
        $this->user_id=$this->user->user_id;
        $this->controller_url='tasks_file_entry';
        $this->permissions=User_helper::get_permission('Tasks_file_entry');
        if(isset($this->permissions['action0']) && ($this->permissions['action0']==1))
        {
            $this->is_view=true;
        }
        if(isset($this->permissions['action1']) && ($this->permissions['action1']==1))
        {
            $this->is_add=true;
        }
        if(isset($this->permissions['action2']) && ($this->permissions['action2']==1))
        {
            $this->is_edit=true;
        }
        if(isset($this->permissions['action3']) && ($this->permissions['action3']==1))
        {
            $this->is_delete=true;
        }
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
        if($this->is_view)
        {
            $data['title']='Permitted Files List';
            $ajax['system_page_url']=site_url($this->controller_url.'/index/list');
            $ajax['system_content'][]=array('id'=>$this->config->item('system_div_id'),'html'=>$this->load->view($this->controller_url.'/list',$data,true));
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
        if($this->is_add || $this->is_edit || $this->is_delete)
        {
            $this->session->set_userdata('active_files','');
            if(($this->input->post('id')))
            {
                $item_id=$this->input->post('id');
            }
            else
            {
                $item_id=$id;
            }
            $this->db->select('n.id,n.name,t.name type_name,cls.name class_name,ctg.name category_name,COUNT(df.id) file_total');
            $this->db->from($this->config->item('table_setup_file_name').' n');
            $this->db->join($this->config->item('table_setup_file_type').' t','t.id=n.id_type');
            $this->db->join($this->config->item('table_setup_file_class').' cls','cls.id=t.id_class');
            $this->db->join($this->config->item('table_setup_file_category').' ctg','ctg.id=cls.id_category');
            $this->db->join($this->config->item('table_tasks_digital_file').' df','df.id_file_name=n.id','left');
            $this->db->where('n.id',$item_id);
            $this->db->where('n.status',$this->config->item('system_status_active'));
            $data['items']=$this->db->get()->row_array();

            $this->db->select('id,name,date_entry,remarks,mime_type');
            $this->db->from($this->config->item('table_tasks_digital_file'));
            $this->db->where('id_file_name',$item_id);
            $this->db->where('status',$this->config->item('system_status_active'));
            $data['stored_files']=$this->db->get()->result_array();

            $ajax['system_page_url']=site_url($this->controller_url.'/index/edit/'.$item_id);
            $ajax['system_content'][]=array('id'=>$this->config->item('system_div_id'),'html'=>$this->load->view($this->controller_url.'/edit',$data,true));
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
        if($this->is_view)
        {
            $this->db->select('n.id,n.name,t.name type_name,cls.name class_name,ctg.name category_name,COUNT(df.id) file_total');
            $this->db->from($this->config->item('table_setup_file_name').' n');
            $this->db->join($this->config->item('table_setup_file_type').' t','t.id=n.id_type');
            $this->db->join($this->config->item('table_setup_file_class').' cls','cls.id=t.id_class');
            $this->db->join($this->config->item('table_setup_file_category').' ctg','ctg.id=cls.id_category');
            $this->db->join($this->config->item('table_tasks_digital_file').' df','df.id_file_name=n.id','left');
            $this->db->where('n.id',$item_id);
            $this->db->where('n.status',$this->config->item('system_status_active'));
            $data['details']=$this->db->get()->row_array();
            if($data['details']['file_total']<1)
            {
                $ajax['system_message']='Your selected File is empty.';
                $ajax['status']=true;
                $this->json_return($ajax);
            }
            else
            {
                $this->db->select('name,date_entry,remarks,mime_type');
                $this->db->from($this->config->item('table_tasks_digital_file'));
                $this->db->where('id_file_name',$item_id);
                $this->db->where('status',$this->config->item('system_status_active'));
                $data['files_info']=$this->db->get()->result_array();
            }
            $ajax['system_content'][]=array('id'=>$this->config->item('system_div_id'),'html'=>$this->load->view($this->controller_url.'/details',$data,true));
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
    private function system_save()
    {
        $id=$this->input->post('id');
        $time=time();

        $this->db->select('id_file');
        $this->db->from($this->config->item('table_setup_assign_file_user_group'));
        $this->db->where('id_file',$id);
        $this->db->where('user_group_id',$this->user_group);
        if($this->db->get()->row_array())
        {
            if($this->is_add || $this->is_edit || $this->is_delete)
            {
                if(!$this->check_validation())
                {
                    $ajax['status']=false;
                    $ajax['system_message']=$this->message;
                    $this->json_return($ajax);
                }
                else
                {
                    $folder=FCPATH.$this->config->item('system_upload_folder').'/'.$id;
                    if(!is_dir($folder))
                    {
                        mkdir($folder,0777);
                    }
                    $delete_folder=$folder.'/'.$this->config->item('system_upload_delete_folder');
                    if(!is_dir($delete_folder))
                    {
                        mkdir($delete_folder,0777);
                    }
                    $temp_session_active_files=$this->session->userdata('active_files');
                    if($this->is_edit)
                    {
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
                            $update_data['date_entry']=System_helper::get_time($row_value);
                            $this->db->where('id',$row_key);
                            $this->db->update($this->config->item('table_tasks_digital_file'),$update_data);
                        }
                        $update_data=array();
                        foreach($remarks_old as $row_key=>$row_value)
                        {
                            $update_data['remarks']=$row_value;
                            $this->db->where('id',$row_key);
                            $this->db->update($this->config->item('table_tasks_digital_file'),$update_data);
                        }
                    }
                    if($this->is_edit || $this->is_delete)
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
                                    $this->db->from($this->config->item('table_tasks_digital_file'));
                                    $this->db->where('id',$af);
                                    $file_delete=$this->db->get()->row_array();
                                    $update_delete_data['name']=$this->move_deleted_file($folder,$file_delete['name']);
                                    $update_delete_data['user_updated']=$this->user_id;
                                    $update_delete_data['date_updated']=$time;
                                    $update_delete_data['status']=$this->config->item('system_status_delete');
                                    $this->db->where('id',$af);
                                    $this->db->update($this->config->item('table_tasks_digital_file'),$update_delete_data);
                                }
                            }
                        }
                    }
                    if($this->is_add || $this->is_edit)
                    {
                        $upload_file_data['id_file_name']=$id;
                        $upload_file_data['date_created']=$time;
                        $upload_file_data['user_created']=$this->user_id;
                        $upload_files=array();
                        $errors=0;
                        $upload_files=System_helper::upload_file($this->config->item('system_upload_folder').'/'.$id);
                        $date_entry=$this->input->post('date_entry');
                        $remarks=$this->input->post('remarks');
                        foreach($upload_files as $key=>$value)
                        {
                            if($value['status']==true)
                            {
                                $upload_file_data['date_entry']=System_helper::get_time($date_entry[explode('_',$key)[1]]);
                                $upload_file_data['remarks']=$remarks[explode('_',$key)[1]];
                                $upload_file_data['mime_type']=$value['info']['file_type'];
                                $upload_file_data['name']=$value['info']['file_name'];
                                $upload_files[$key]['insert_id']=Query_helper::add($this->config->item('table_tasks_digital_file'),$upload_file_data);
                                if($this->is_edit)
                                {
                                    $temp_session_active_files.=','.$upload_files[$key]['insert_id'];
                                }
                            }
                            else
                            {
                                ++$errors;
                            }
                        }
                        if($errors>0)
                        {
                            $ajax['status']=false;
                            $ajax['system_message']='Upload successful. But some errors occur.';
                            if(substr($temp_session_active_files,0,1)==',')
                            {
                                $temp_session_active_files=substr($temp_session_active_files,1);
                            }
                            $this->session->set_userdata('active_files',$temp_session_active_files);
                            $upload_complete_info['upload_files']=$upload_files;
                            $ajax['system_content'][]=array('id'=>'#upload-complete-info','html'=>$this->load->view($this->controller_url.'/upload-result',$upload_complete_info,true));
                            $this->json_return($ajax);
                        }
                    }
                    $this->message=$this->lang->line('MSG_SAVED_SUCCESS');
                    $this->system_list();
                }
            }
            else
            {
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line('YOU_DONT_HAVE_ACCESS');
                $this->json_return($ajax);
                die();
            }
        }
        else
        {
            $ajax['status']=false;
            $ajax['system_message']='You violate your rules.';
            $this->json_return($ajax);
            die();
        }
    }
    private function move_deleted_file($folder,$file_name)
    {
        $return_value=$file_name;
        $extension='.'.pathinfo($file_name,PATHINFO_EXTENSION);
        $raw_name=pathinfo($file_name,PATHINFO_FILENAME);
        $delete_folder=$this->config->item('system_upload_delete_folder');
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
        $this->db->select('n.id,n.name,n.date_start,t.name type_name,cls.name class_name,ctg.name category_name,COUNT(df.id_file_name) number_of_file');
        $this->db->from($this->config->item('table_setup_file_name').' n');
        $this->db->join($this->config->item('table_setup_assign_file_user_group').' fug','n.id=fug.id_file');
        $this->db->join($this->config->item('table_setup_file_type').' t','t.id=n.id_type');
        $this->db->join($this->config->item('table_setup_file_class').' cls','cls.id=t.id_class');
        $this->db->join($this->config->item('table_setup_file_category').' ctg','ctg.id=cls.id_category');
        $this->db->join($this->config->item('table_tasks_digital_file').' df','df.id_file_name=n.id','right');
        $this->db->group_by('n.id');
        $this->db->where('fug.user_group_id',$this->user_group);
        $this->db->where('fug.status',$this->config->item('system_status_active'));
        #$this->db->where('df.status',$this->config->item('system_status_active'));
        $temp=$this->db->get()->result_array();
        foreach($temp as &$val)
        {
            $val['date_start']=System_helper::display_date($val['date_start']);
        }
        $this->json_return($temp);
    }
}
