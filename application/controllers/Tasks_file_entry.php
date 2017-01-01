<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks_file_entry extends Root_Controller
{
    private $message;
    public $permissions;
    public $controller_url;
    private $months_name_num=array('jan'=>'01','feb'=>'02','mar'=>'03','apr'=>'04','may'=>'05','jun'=>'06','jul'=>'07','aug'=>'08','sep'=>'09','oct'=>'10','nov'=>'11','dec'=>'12');
    private $months_num_name=array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');
    public function __construct()
    {
        parent::__construct();
        $this->message='';
        $this->permissions=User_helper::get_permission('Tasks_file_entry');
        $this->controller_url='tasks_file_entry';
    }
    public function index($action='add',$id=0,$table='',$column='')
    {
        if($action=='add')
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
        elseif($action=='get_drop_down')
        {
            $this->system_get_drop_down_with_select();
        }
        else
        {
            $this->system_add();
        }
    }
    private function system_add()
    {
        if(isset($this->permissions['action1']) && ($this->permissions['action1']==1))
        {
            $user_group_id=User_helper::get_user()->user_group;
            $data['title']='Entry New File';
            $data['items']=array
            (
                'id'=>0,
                'date_entry_text'=>System_helper::display_date(time()),
                'id_file_type_1'=>'',
                'id_file_type_2'=>'',
                'id_file_type_3'=>'',
                'id_file_type_4'=>'',
                'id_hc_location'=>'',
                'remarks'=>''
            );
            $data['file_type_1s']=$this->get_desire_file_type_by_user_group_id($user_group_id,$this->config->item('table_setup_file_type_1'),'id_file_type_1');
            $data['file_type_2s']=array();
            $data['file_type_3s']=array();
            $data['file_type_4s']=array();
            $data['hc_locations']=Query_helper::get_info($this->config->item('table_setup_file_hc_location'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));
            $data['stored_files']=array();
            $ajax['system_page_url']=site_url($this->controller_url.'/index/add');
            $ajax['system_content'][]=array('id'=>$this->config->item('system_div_id'),'html'=>$this->load->view($this->controller_url.'/add',$data,true));
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
    private function get_desire_file_type_by_user_group_id($user_group_id,$table,$column,$where='',$value='')
    {
        $this->db->select('ftd.name text,ftd.id value');
        $this->db->from($this->config->item('table_setup_file_type_4').' ft4');
        $this->db->join($table.' ftd','ft4.'.$column.'=ftd.id','inner');
        $this->db->join($this->config->item('table_setup_assign_user_group_file').' ugf','ft4.id=ugf.id_file','inner');
        if(strlen(trim($where))>0)
        {
            $this->db->where('ftd.'.$where,$value);
        }
        $this->db->where('ugf.user_group_id',$user_group_id);
        $this->db->where('ugf.revision',1);
        $this->db->group_by('value');
        return $this->db->get()->result_array();
    }
    private function get_file_type_4_by_user_group_id($user_group_id)
    {
        $this->db->select('ft4.name text,ft4.id value');
        $this->db->from($this->config->item('table_setup_file_type_4').' ft4');
        $this->db->join($this->config->item('table_setup_assign_user_group_file').' ugf','ft4.id=ugf.id_file','inner');
        $this->db->where('ugf.user_group_id',$user_group_id);
        $this->db->where('ugf.revision',1);
        return $this->db->get()->result_array();
    }
    private function system_get_drop_down_with_select()
    {
        $user_group_id=User_helper::get_user()->user_group;
        $table=$this->input->post('table');
        if($table==$this->config->item('table_setup_file_type_4'))
        {
            $data['items']=$this->get_file_type_4_by_user_group_id($user_group_id);
        }
        else
        {
            $table_column=$this->input->post('table_column');
            $table_column_check=$this->input->post('table_column_check');
            $table_column_value=$this->input->post('table_column_value');
            $data['items']=$this->get_desire_file_type_by_user_group_id($user_group_id,$table,$table_column,$table_column_check,$table_column_value);
        }
        $html_container_id=$this->input->post('html_container_id');

        $ajax['system_content'][]=array('id'=>$html_container_id,'html'=>$this->load->view('dropdown_with_select',$data,true));
        $ajax['status']=true;
        $this->json_return($ajax);
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
        if(isset($this->permissions['action1']) && ($this->permissions['action1']==1))
        {
            $this->db->select('id_hc_location,date_entry_text,remarks');
            $this->db->from($this->config->item('table_tasks_file_entry'));
            $this->db->where('id_file_type_4',$item_id);
            $data['file_entry_info']=$this->db->get()->row_array();
            if(sizeof($data['file_entry_info'])>0)
            {
                $data['file_entry_info']['date_entry_text']=$this->date_helper($data['file_entry_info']['date_entry_text'],'db_to_user');
            }
            else
            {
                $data['file_entry_info']['date_entry_text']=System_helper::display_date(time());
                $data['file_entry_info']['id_hc_location']='';
                $data['file_entry_info']['remarks']='';
            }
            $data['stored_files']=array();

            if(isset($this->permissions['action2']) && ($this->permissions['action2']==1))
            {
                $this->db->select('id,id_file_entry,name_after_upload,is_image');
                $this->db->from($this->config->item('table_tasks_digital_file'));
                $this->db->where('id_file_type_4',$item_id);
                $this->db->where('status',$this->config->item('system_status_active'));
                $data['stored_files']=$this->db->get()->result_array();
            }

            $ajax['system_content'][]=array('id'=>$this->input->post('html_container_id'),'html'=>$this->load->view($this->controller_url.'/edit',$data,true));
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
    private function system_save_new()
    {
        print_r($_FILES);
        print_r($_POST);
    }
    private function system_save()
    {
        $this->load->library('upload');
        $id=$this->input->post('id');
        $user=User_helper::get_user();
        $user_id=$user->user_id;
        $user_group_id=$user->user_group;
        $time=time();

        $this->db->select('id_file');
        $this->db->from($this->config->item('table_setup_assign_user_group_file'));
        $this->db->where('id_file',$id);
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
                    $this->db->trans_begin();
                    $data=$this->input->post('items');
                    $this->db->select('id,id_hc_location,date_entry_text,history_hc_location');
                    $this->db->from($this->config->item('table_tasks_file_entry'));
                    $this->db->where('id_file_type_4',$id);
                    $file_entry_table_data=$this->db->get()->row_array();
                    $date_entry_text=$this->date_helper($data['date_entry_text'],'user_to_db');
                    if(sizeof($file_entry_table_data)>0)
                    {
                        $action='edit';
                        $id_file_entry=$file_entry_table_data['id'];
                        if($file_entry_table_data['id_hc_location']!=$data['id_hc_location'])
                        {
                            $update_data['id_hc_location']=$data['id_hc_location'];
                            // user_id,timestamp,previous,next
                            $update_data['history_hc_location']=$user_id.','.$time.','.$file_entry_table_data['id_hc_location'].','.$data['id_hc_location'].'|'.$file_entry_table_data['history_hc_location'];
                        }
                        if($file_entry_table_data['date_entry_text']!=$date_entry_text)
                        {
                            $update_data['date_entry_text']=$date_entry_text;
                        }
                        $update_data['remarks']=$data['remarks'];
                        $this->db->where('id',$id_file_entry);
                        $this->db->update($this->config->item('table_tasks_file_entry'),$update_data);
                    }
                    else
                    {
                        $action='add';
                        $data['date_entry_time']=System_helper::get_time($data['date_entry_text']);
                        $data['entry_time_original']=$time;
                        $data['id_user']=$user_id;
                        $data['date_entry_text']=$date_entry_text;
                        $id_file_entry=Query_helper::add($this->config->item('table_tasks_file_entry'),$data);
                    }
                    $folder=FCPATH.$this->config->item('system_upload_folder').'/'.$id_file_entry;
                    if(!is_dir($folder))
                    {
                        mkdir($folder,0777);
                    }
                    $delete_folder=$folder.'/'.$this->config->item('system_upload_delete_folder');
                    if(!is_dir($delete_folder))
                    {
                        mkdir($delete_folder,0777);
                    }
                    if(isset($this->permissions['action2']) && ($this->permissions['action2']==1))
                    {
                        $file_olds=$this->input->post('file_old');
                        $file_deletes=$this->input->post('file_delete');
                        if(strlen($file_deletes)>0)
                        {
                            $file_olds=explode(',',$file_olds);
                            $file_deletes=explode(',',$file_deletes);
                            foreach($file_olds as $old_array_false)
                            {
                                $old_array_false=explode('_',$old_array_false);
                                if(in_array($old_array_false[0],$file_deletes))
                                {
                                    $this->db->select('name_after_upload,extension');
                                    $this->db->from($this->config->item('table_tasks_digital_file'));
                                    $this->db->where('id',$old_array_false[1]);
                                    $file_delete=$this->db->get()->row_array();
                                    $update_delete_data['name_after_deleted']=$this->move_deleted_file($folder,$file_delete['name_after_upload'],$file_delete['extension']);
                                    $update_delete_data['user_deleted']=$user_id;
                                    $update_delete_data['time_deleted']=$time;
                                    $update_delete_data['status']=$this->config->item('system_status_delete');
                                    $this->db->where('id',$old_array_false[1]);
                                    $this->db->update($this->config->item('table_tasks_digital_file'),$update_delete_data);
                                }
                            }
                        }
                    }
                    $config=array();
                    $config['upload_path']=$folder;
                    $config['allowed_types']='gif|jpg|png|pdf|doc|docx|xls|xlsx|ppt|pptx|txt';
                    $config['max_size']=$this->config->item('max_file_size');
                    $config['overwrite']=false;
                    $config['remove_spaces']=true;

                    $upload_new_file_data=$this->input->post('items');
                    unset($upload_new_file_data['date_entry_text']);
                    unset($upload_new_file_data['id_hc_location']);
                    unset($upload_new_file_data['remarks']);
                    $upload_new_file_data['id_file_entry']=$id_file_entry;
                    $upload_new_file_data['time_upload']=$time;
                    $upload_new_file_data['user_upload']=$user_id;
                    $errors=array();
                    foreach($_FILES as $key=>$value)
                    {
                        if(strlen($value['name'])>0)
                        {
                            $array=$this->upload_file($key,$config);
                            if(is_array($array))
                            {
                                $upload_new_file_data['size']=$value['size'];
                                $upload_new_file_data['name_pre_upload']=$array['orig_name'];
                                $upload_new_file_data['mime_type']=$array['file_type'];
                                $upload_new_file_data['name_after_upload']=$array['file_name'];
                                $upload_new_file_data['is_image']=$array['is_image'];
                                $upload_new_file_data['extension']=$array['file_ext'];
                                Query_helper::add($this->config->item('table_tasks_digital_file'),$upload_new_file_data);
                            }
                            else
                            {
                                $errors[$key]=$array;
                            }
                        }
                    }
                    $this->db->trans_commit();
                    $ajax['system_redirect_url']=site_url($this->controller_url);
                    if(sizeof($errors)>0)
                    {
                        $ajax['status']=false;
                        $ajax['system_message']='upload successfull but, some errors occured.';
                        $this->json_return($ajax);
                    }
                    else
                    {
                        $ajax['status']=true;
                        $ajax['system_message']=$this->lang->line('MSG_SAVED_SUCCESS');
                        $this->json_return($ajax);
                    }
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
    public function date_helper($text,$action)
    {
        $text=explode('-',$text);
        if($action=='user_to_db')
        {
            $d=$text[0];
            $m=strtolower($text[1]);
            $m=$this->months_name_num[$m];
            $y=$text[2];
            return $y.'-'.$m.'-'.$d;
        }
        else
        {
            $d=$text[2];
            $m=$text[1];
            $m=$this->months_num_name[$m];
            $y=$text[0];
            return $d.'-'.$m.'-'.$y;
        }
    }
    private function move_deleted_file($folder,$file,$extension)
    {
        $return_value=$file;
        $delete_folder=$this->config->item('system_upload_delete_folder');
        $raw_name=explode('.',$file)[0];
        $i=0;
        $file=$folder.'/'.$delete_folder.'/'.$file;
        while(file_exists($file))
        {
            ++$i;
            $file=$folder.'/'.$delete_folder.'/'.$raw_name.$i.$extension;
            $return_value=$raw_name.$i.$extension;
        }
        if(rename($folder.'/'.$raw_name.$extension,$file))
        {
            return $return_value;
        }
        return false;
    }
    private function upload_file($key,$config)
    {
        $value=$_FILES[$key];
        if(strlen($value['name'])>0)
        {
            $this->upload->initialize($config);
            if ($this->upload->do_upload($key))
            {
                return $this->upload->data();
            }
            else
            {
                return $this->upload->display_errors();
            }
        }
    }
    private function check_validation()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('items[id_file_type_4]',$this->lang->line('LABEL_FILE_TYPE_4'),'required');
        $this->form_validation->set_rules('items[id_hc_location]','Hardcopy Location','required');
        if($this->form_validation->run()==false)
        {
            $this->message=validation_errors();
            return false;
        }
        return true;
    }
}
