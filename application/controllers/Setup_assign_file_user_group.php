<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup_assign_file_user_group extends Root_Controller
{
    private $message;
    public $permissions;
    public $controller_url;

    public $permission_all_body='permission_all_body';
    public $permission_all_child='permission_all_child';
    public $file_type_1_name_array=array();
    public $file_type_2_name_array=array();
    public $file_type_2_parent_array=array();
    public $file_type_3_name_array=array();
    public $file_type_3_parent_array=array();
    public $file_type_4_name_array=array();
    public $file_type_4_parent_array=array();
    public $selected_array=array();

    public function __construct()
    {
        parent::__construct();
        $this->message='';
        $this->permissions=User_helper::get_permission('Setup_assign_file_user_group');
        $this->controller_url='setup_assign_file_user_group';
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
        elseif($action=='get_file_permission_list')
        {
            $this->system_get_file_permission_list($id);
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
            $data['title']='List of User Groups to Assign Files';
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
            $this->details_id=$item_id;

            $this->db->select('name');
            $this->db->from($this->config->item('table_system_user_group'));
            $this->db->where('id',$item_id);
            $user_group_name=$this->db->get()->row_array();
            $data['item_id']=$item_id;
            $data['title']='Details File Permissions for ('.$user_group_name['name'].')';

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
    private function system_get_file_permission_list($id)
    {
        $this->db->select('ft4.*,ft1.name ft1_name,ft2.name ft2_name,ft3.name ft3_name');
        $this->db->from($this->config->item('table_setup_assign_user_group_file').' ugf');
        $this->db->join($this->config->item('table_setup_file_type_4').' ft4','ft4.id=ugf.id_file');
        $this->db->join($this->config->item('table_setup_file_type_3').' ft3','ft3.id=ft4.id_file_type_3');
        $this->db->join($this->config->item('table_setup_file_type_2').' ft2','ft2.id=ft4.id_file_type_2');
        $this->db->join($this->config->item('table_setup_file_type_1').' ft1','ft1.id=ft4.id_file_type_1');
        $this->db->where('ugf.user_group_id',$id);
        $this->db->where('ugf.revision',1);
        $this->json_return($this->db->get()->result_array());
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

            $this->db->select('name');
            $this->db->from($this->config->item('table_system_user_group'));
            $this->db->where('id',$item_id);
            $user_group_name=$this->db->get()->row_array();
            $data['item_id']=$item_id;
            $data['title']='Edit File Permission to ('.$user_group_name['name'].')';

            $this->db->select('id_file');
            $this->db->from($this->config->item('table_setup_assign_user_group_file'));
            $this->db->where('user_group_id',$item_id);
            $this->db->where('revision',1);
            $selected_files=$this->db->get()->result_array();
            foreach($selected_files as $sf)
            {
                $this->selected_array[]=$sf['id_file'];
            }

            $this->file_type_1_name_array=$this->get_id_name_array($this->get_data('id,name',$this->config->item('table_setup_file_type_1')));

            $file_type_2_array=$this->get_data('id,name,id_file_type_1',$this->config->item('table_setup_file_type_2'));
            $this->file_type_2_name_array=$this->get_id_name_array($file_type_2_array);
            $this->file_type_2_parent_array=$this->get_parent_array($file_type_2_array,'id_file_type_1');
            unset($file_type_2_array);

            $file_type_3_array=$this->get_data('id,name,id_file_type_2',$this->config->item('table_setup_file_type_3'));
            $this->file_type_3_name_array=$this->get_id_name_array($file_type_3_array);
            $this->file_type_3_parent_array=$this->get_parent_array($file_type_3_array,'id_file_type_2');
            unset($file_type_3_array);

            $file_type_4_array=$this->get_data('id,name,id_file_type_3',$this->config->item('table_setup_file_type_4'));
            $this->file_type_4_name_array=$this->get_id_name_array($file_type_4_array);
            $this->file_type_4_parent_array=$this->get_parent_array($file_type_4_array,'id_file_type_3');
            unset($file_type_4_array);

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
        $data=$this->input->post();
        $id=$data['id'];
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
        if($id==0)
        {
            $ajax['status']=false;
            $ajax['system_message']='You violate our rules.';
            $this->json_return($ajax);
        }
        else
        {
            unset($data['id']);
            unset($data['system_save_new_status']);
            $this->db->trans_start(); //DB Transaction Handle START

            $this->db->set('revision','revision+1',false);
            $this->db->where('user_group_id',$id);
            $this->db->update($this->config->item('table_setup_assign_user_group_file'));

            $data_new=array();
            $data_new['user_group_id']=$id;
            $data_new['user_updated']=$user->user_id;
            $data_new['date_updated']=time();
            $data_new['revision']=1;
            $temp=array();
            foreach($data as $d=>$v)
            {
                $temp=explode('_',$d);
                $data_new['id_file']=end($temp);
                Query_helper::add($this->config->item('table_setup_assign_user_group_file'),$data_new);
            }
            $this->db->trans_complete(); //DB Transaction Handle END
            if($this->db->trans_status()===true)
            {
                $this->message=$this->lang->line('MSG_SAVED_SUCCESS');
                $this->system_list();
            }
            else
            {
                $ajax['status']=false;
                $ajax['desk_message']=$this->lang->line('MSG_SAVED_FAIL');
                $this->json_return($ajax);
            }
        }
    }
    private function system_get_items()
    {
        $user=User_helper::get_user();
        if($user->user_group==1)
        {
            $items=Query_helper::get_info($this->config->item('table_system_user_group'),array('id','name','status','ordering'),array('status !="'.$this->config->item('system_status_delete').'"'));
        }
        else
        {
            $items=Query_helper::get_info($this->config->item('table_system_user_group'),array('id','name','status','ordering'),array('id !=1','status !="'.$this->config->item('system_status_delete').'"'));
        }
        $this->json_return($items);
    }
    private function get_id_name_array($parent_array)
    {
        $new_array=array();
        foreach($parent_array as $a)
        {
            $new_array[$a['id']]=$a['name'];
        }
        return $new_array;
    }
    private function get_parent_array($parent_array,$column)
    {
        $new_array=array();
        foreach($parent_array as $a)
        {
            $new_array[$a[$column]][]=$a['id'];
        }
        return $new_array;
    }
    private function get_data($select,$table)
    {
        $this->db->select($select);
        $this->db->from($table);
        return $this->db->get()->result_array();
    }
    public function file_type_1s()
    {
        $file_type_1_html='';
        $file_type=$this->config->item('system_file_type_1');
        foreach($this->file_type_1_name_array as $id=>$name)
        {
            $input_name=$file_type.'_'.$id;
            $input_class=$file_type.' '.$this->permission_all_child;
            $input_child_class=$this->config->item('system_file_type_2').'_'.$id;
            $href='#'.$input_name;
            $child_panel='';
            if(array_key_exists($id,$this->file_type_2_parent_array))
            {
                $file_type_2s=$this->file_type_2s($id,$input_child_class);
                $child_panel='<div id="'.$input_name.'" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        '.$file_type_2s.'
                                    </div>
                                </div>';
            }
            $text='<div class="panel panel-default">
                   <div class="panel-heading">
                       <h4 class="panel-title">
                           <input type="checkbox" class="'.$input_class.'" child-class="'.$input_child_class.'">
                           <a class="external" data-toggle="collapse" href="'.$href.'">
                               '.$name.'
                           </a>
                       </h4>
                   </div>'.$child_panel.'
               </div>';
            $file_type_1_html.=$text;
        }
        echo $file_type_1_html;
    }
    private function file_type_2s($file_type_1_id,$fixed_class)
    {
        $file_type_2_html='';
        $file_type=$this->config->item('system_file_type_2');
        $file_type_2_array=$this->file_type_2_parent_array[$file_type_1_id];
        foreach($file_type_2_array as $id)
        {
            $name=$this->file_type_2_name_array[$id];
            $input_name=$fixed_class.'_'.$id;
            $input_class=$file_type.' '.$fixed_class.' '.$this->permission_all_child;
            $input_child_class=str_replace($file_type,$this->config->item('system_file_type_3'),$input_name);
            $href='#'.$input_name;
            $child_panel='';
            if(array_key_exists($id,$this->file_type_3_parent_array))
            {
                $file_type_3s=$this->file_type_3s($id,$input_child_class);
                $child_panel='<div id="'.$input_name.'" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        '.$file_type_3s.'
                                    </div>
                                </div>';
            }
            $text='<div class="panel panel-default">
                   <div class="panel-heading">
                       <h4 class="panel-title">
                           <input type="checkbox" class="'.$input_class.'" child-class="'.$input_child_class.'">
                           <a class="external" data-toggle="collapse" href="'.$href.'">
                               '.$name.'
                           </a>
                       </h4>
                   </div>'.$child_panel.'
               </div>';
            $file_type_2_html.=$text;
        }
        return $file_type_2_html;
    }
    private function file_type_3s($file_type_2_id,$fixed_class)
    {
        $file_type_3_html='';
        $file_type=$this->config->item('system_file_type_3');
        $file_type_3_array=$this->file_type_3_parent_array[$file_type_2_id];
        foreach($file_type_3_array as $id)
        {
            $name=$this->file_type_3_name_array[$id];
            $input_name=$fixed_class.'_'.$id;
            $input_class=$file_type.' '.$fixed_class.' '.$this->permission_all_child;
            $input_child_class=str_replace($file_type,$this->config->item('system_file_type_4'),$input_name);
            $href='#'.$input_name;
            $child_panel='';
            if(array_key_exists($id,$this->file_type_4_parent_array))
            {
                $file_type_4s=$this->file_type_4s($id,$input_child_class);
                $child_panel='<div id="'.$input_name.'" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        '.$file_type_4s.'
                                    </div>
                                </div>';
            }
            $text='<div class="panel panel-default">
                   <div class="panel-heading">
                       <h4 class="panel-title">
                           <input type="checkbox" class="'.$input_class.'" child-class="'.$input_child_class.'">
                           <a class="external" data-toggle="collapse" href="'.$href.'">
                               '.$name.'
                           </a>
                       </h4>
                   </div>'.$child_panel.'
               </div>';
            $file_type_3_html.=$text;
        }
        return $file_type_3_html;
    }
    private function file_type_4s($file_type_3_id,$fixed_class)
    {
        $file_type_4_html='';
        $file_type=$this->config->item('system_file_type_4');
        $file_type_4_array=$this->file_type_4_parent_array[$file_type_3_id];
        $checked='';
        foreach($file_type_4_array as $id)
        {
            $name=$this->file_type_4_name_array[$id];
            $input_name=$fixed_class.'_'.$id;
            $input_id=$fixed_class.'-'.$id;
            $input_class=$file_type.' '.$fixed_class.' '.$this->permission_all_child;
            $checked='';
            if(in_array($id,$this->selected_array))
            {
                $checked=' checked';
            }
            $text='<div class="form-group">
                        <input type="checkbox" name="'.$input_name.'" id="'.$input_id.'" class="'.$input_class.'"'.$checked.'>
                        <label for="'.$input_id.'">'.$name.'</label>
                   </div>';
            $file_type_4_html.=$text;
        }
        return $file_type_4_html;
    }
}
