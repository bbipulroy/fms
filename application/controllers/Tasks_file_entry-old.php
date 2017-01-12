<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks_file_entry extends Root_Controller
{
    private $message;
    public $permissions;
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
        $this->permissions=User_helper::get_permission('Tasks_file_entry');
        $this->controller_url='tasks_file_entry';
    }
    public function index($action='edit',$id=0,$table='',$column='')
    {
       if($action=='edit')
        {
            $this->system_edit();
        }
        elseif($action=='details')
        {
            $this->system_details($id);
        }
        elseif($action=='save')
        {
            $this->system_save();
        }
        elseif($action=='get_drop_down')
        {
            $this->system_get_drop_down_with_select();
        }
        else
        {
            $this->system_edit();
        }
    }
    private function system_edit()
    {
        if(isset($this->permissions['action1']) && ($this->permissions['action1']==1))
        {
            $this->session->set_userdata('active_files','');
            $data['title']='Entry in a File';
            $data['items']=array
            (
                'id'=>0,
                'id_category'=>'',
                'id_class'=>'',
                'id_type'=>'',
                'id_name'=>''
            );
            $data['categories']=$this->get_category();
            $data['classes']=array();
            $data['types']=array();
            $data['names']=array();
            $data['stored_files']=array();
            $ajax['system_page_url']=site_url($this->controller_url.'/index/edit');
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
        if(isset($this->permissions['action1']) && ($this->permissions['action1']==1))
        {
            $data['id']=$item_id;
            $data['stored_files']=array();
            if(isset($this->permissions['action2']) && ($this->permissions['action2']==1))
            {
                $this->db->select('id,name,mime_type,remarks');
                $this->db->from($this->config->item('table_tasks_digital_file'));
                $this->db->where('id_file_name',$item_id);
                $this->db->where('status',$this->config->item('system_status_active'));
                $data['stored_files']=$this->db->get()->result_array();
            }
            $ajax['system_content'][]=array('id'=>'#files_container','html'=>$this->load->view($this->controller_url.'/details',$data,true));
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
    private function system_save()
    {
        $this->load->library('upload');
        $id=$this->input->post('id');
        $time=time();

        $this->db->select('id_file');
        $this->db->from($this->config->item('table_setup_assign_file_user_group'));
        $this->db->where('id_file',$id);
        $this->db->where('user_group_id',$this->user_group);
        if($this->db->get()->row_array())
        {
            if(isset($this->permissions['action1']) && ($this->permissions['action1']==1))
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
                    if(isset($this->permissions['action2']) && ($this->permissions['action2']==1))
                    {
                        $remarks_old=$this->input->post('remarks_old');
                        if(!is_array($remarks_old))
                        {
                            $remarks_old=array();
                        }
                        $upadate_data=array();
                        foreach($remarks_old as $ro_key=>$ro_value)
                        {
                            $upadate_data['remarks']=$ro_value;
                            $this->db->where('id',$ro_key);
                            $this->db->update($this->config->item('table_tasks_digital_file'),$upadate_data);
                        }
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
                    $upload_file_data['id_file_name']=$id;
                    $upload_file_data['date_created']=$time;
                    $upload_file_data['user_created']=$this->user_id;
                    $upload_files=array();
                    $errors=0;
                    $upload_files=System_helper::upload_file($this->config->item('system_upload_folder').'/'.$id);
                    $remarks=$this->input->post('remarks');
                    foreach($upload_files as $key=>$value)
                    {
                        if($value['status']==true)
                        {
                            $upload_file_data['remarks']=$remarks[explode('_',$key)[1]];
                            $upload_file_data['mime_type']=$value['info']['file_type'];
                            $upload_file_data['name']=$value['info']['file_name'];
                            $upload_files[$key]['insert_id']=Query_helper::add($this->config->item('table_tasks_digital_file'),$upload_file_data);
                            if(isset($this->permissions['action2']) && ($this->permissions['action2']==1))
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
                    }
                    else
                    {
                        $ajax['status']=true;
                        $ajax['system_message']=$this->lang->line('MSG_SAVED_SUCCESS');
                    }
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
        $extension=explode('.',$file_name);
        $raw_name=$extension[0];
        if($file_name!=end($extension))
        {
            $extension='.'.end($extension);
        }
        else
        {
            $extension='';
        }
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
        $this->load->library('form_validation');
        $this->form_validation->set_rules('items[id_name]',$this->lang->line('LABEL_FILE_NAME'),'required');
        if($this->form_validation->run()==false)
        {
            $this->message=validation_errors();
            return false;
        }
        return true;
    }
    private function get_category()
    {
        $this->db->select('ctg.name text,ctg.id value');
        $this->db->from($this->config->item('table_setup_assign_file_user_group').' fug');
        $this->db->join($this->config->item('table_setup_file_name').' n','fug.id_file=n.id','inner');
        $this->db->join($this->config->item('table_setup_file_type').' t','n.id_type=t.id','inner');
        $this->db->join($this->config->item('table_setup_file_class').' cls','t.id_class=cls.id','inner');
        $this->db->join($this->config->item('table_setup_file_category').' ctg','cls.id_category=ctg.id','inner');
        $this->db->where('fug.user_group_id',$this->user_group);
        $this->db->where('fug.status',$this->config->item('system_status_active'));
        $this->db->group_by('value');
        return $this->db->get()->result_array();
    }
    private function get_class($id_category)
    {
        $this->db->select('c.name text,c.id value');
        $this->db->from($this->config->item('table_setup_assign_file_user_group').' fug');
        $this->db->join($this->config->item('table_setup_file_name').' n','fug.id_file=n.id','inner');
        $this->db->join($this->config->item('table_setup_file_type').' t','n.id_type=t.id','inner');
        $this->db->join($this->config->item('table_setup_file_class').' c','t.id_class=c.id','inner');
        $this->db->where('fug.user_group_id',$this->user_group);
        $this->db->where('fug.status',$this->config->item('system_status_active'));
        $this->db->where('c.id_category',$id_category);
        $this->db->group_by('value');
        return $this->db->get()->result_array();
    }
    private function get_type($id_class)
    {
        $this->db->select('t.name text,t.id value');
        $this->db->from($this->config->item('table_setup_assign_file_user_group').' fug');
        $this->db->join($this->config->item('table_setup_file_name').' n','fug.id_file=n.id','inner');
        $this->db->join($this->config->item('table_setup_file_type').' t','n.id_type=t.id','inner');
        $this->db->where('fug.user_group_id',$this->user_group);
        $this->db->where('fug.status',$this->config->item('system_status_active'));
        $this->db->where('t.id_class',$id_class);
        $this->db->group_by('value');
        return $this->db->get()->result_array();
    }
    private function get_name($id_type)
    {
        $this->db->select('n.name text,n.id value');
        $this->db->from($this->config->item('table_setup_assign_file_user_group').' fug');
        $this->db->join($this->config->item('table_setup_file_name').' n','fug.id_file=n.id','inner');
        $this->db->where('fug.user_group_id',$this->user_group);
        $this->db->where('fug.status',$this->config->item('system_status_active'));
        $this->db->where('n.id_type',$id_type);
        return $this->db->get()->result_array();
    }
    private function system_get_drop_down_with_select()
    {
        $html_container_id=$this->input->post('html_container_id');
        $file_type=$this->input->post('file_type');
        $id=$this->input->post('id');
        $data['items']=array();
        if($file_type=='class')
        {
            $data['items']=$this->get_class($id);
        }
        elseif($file_type=='type')
        {
            $data['items']=$this->get_type($id);
        }
        elseif($file_type=='name')
        {
            $data['items']=$this->get_name($id);
        }
        $ajax['system_content'][]=array('id'=>$html_container_id,'html'=>$this->load->view('dropdown_with_select',$data,true));
        $ajax['status']=true;
        $this->json_return($ajax);
    }
}
