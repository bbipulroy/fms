<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup_assign_file_user_group extends Root_Controller
{
    private $message;
    public $permissions;
    public $controller_url;

    public $permission_all_body='permission_all_body';
    public $permission_all_child='permission_all_child';
    public $category_name_array=array();
    public $class_name_array=array();
    public $class_parent_array=array();
    public $type_name_array=array();
    public $type_parent_array=array();
    public $name_name_array=array();
    public $name_parent_array=array();
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
        $this->db->select('n.*,ctg.name category_name,cls.name class_name,t.name type_name');
        $this->db->from($this->config->item('table_setup_assign_file_user_group').' fug');
        $this->db->join($this->config->item('table_setup_file_name').' n','n.id=fug.id_file');
        $this->db->join($this->config->item('table_setup_file_type').' t','t.id=n.id_type');
        $this->db->join($this->config->item('table_setup_file_class').' cls','cls.id=t.id_class');
        $this->db->join($this->config->item('table_setup_file_category').' ctg','ctg.id=cls.id_category');
        $this->db->where('fug.user_group_id',$id);
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
            $this->db->from($this->config->item('table_setup_assign_file_user_group'));
            $this->db->where('user_group_id',$item_id);
            $selected_files=$this->db->get()->result_array();
            foreach($selected_files as $sf)
            {
                $this->selected_array[]=$sf['id_file'];
            }

            $this->category_name_array=$this->get_id_name_array($this->get_data('id,name',$this->config->item('table_setup_file_category')));

            $class_array=$this->get_data('id,name,id_category',$this->config->item('table_setup_file_class'));
            $this->class_name_array=$this->get_id_name_array($class_array);
            $this->class_parent_array=$this->get_parent_array($class_array,'id_category');
            unset($class_array);

            $type_array=$this->get_data('id,name,id_class',$this->config->item('table_setup_file_type'));
            $this->type_name_array=$this->get_id_name_array($type_array);
            $this->type_parent_array=$this->get_parent_array($type_array,'id_class');
            unset($type_array);

            $name_array=$this->get_data('id,name,id_type',$this->config->item('table_setup_file_name'));
            $this->name_name_array=$this->get_id_name_array($name_array);
            $this->name_parent_array=$this->get_parent_array($name_array,'id_type');
            unset($name_array);

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
            $ajax['system_message']='You violate your rules.';
            $this->json_return($ajax);
        }
        else
        {
            unset($data['id']);
            $this->db->trans_start(); //DB Transaction Handle START

            $this->db->where('user_group_id',$id);
            $this->db->delete($this->config->item('table_setup_assign_file_user_group'));

            $data_new=array();
            $data_new['user_group_id']=$id;
            $data_new['user_updated']=$user->user_id;
            $data_new['date_updated']=time();
            $temp=array();
            foreach($data as $d=>$v)
            {
                $temp=explode('_',$d);
                $data_new['id_file']=end($temp);
                Query_helper::add($this->config->item('table_setup_assign_file_user_group'),$data_new);
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
    public function categories()
    {
        $categoriy_html='';
        foreach($this->category_name_array as $id=>$name)
        {
            $input_name='category_'.$id;
            $input_class='category'.' '.$this->permission_all_child;
            $input_child_class='class_'.$id;
            $href='#'.$input_name;
            $child_panel='';
            if(array_key_exists($id,$this->class_parent_array))
            {
                $classes=$this->classes($id,$input_child_class);
                $child_panel='<div id="'.$input_name.'" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        '.$classes.'
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
            $categoriy_html.=$text;
        }
        echo $categoriy_html;
    }
    private function classes($category_id,$fixed_class)
    {
        $class_html='';
        $class_array=$this->class_parent_array[$category_id];
        foreach($class_array as $id)
        {
            $name=$this->class_name_array[$id];
            $input_name=$fixed_class.'_'.$id;
            $input_class='class '.$fixed_class.' '.$this->permission_all_child;
            $input_child_class=str_replace('class','type',$input_name);
            $href='#'.$input_name;
            $child_panel='';
            if(array_key_exists($id,$this->type_parent_array))
            {
                $types=$this->types($id,$input_child_class);
                $child_panel='<div id="'.$input_name.'" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        '.$types.'
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
            $class_html.=$text;
        }
        return $class_html;
    }
    private function types($class_id,$fixed_class)
    {
        $type_html='';
        $type_array=$this->type_parent_array[$class_id];
        foreach($type_array as $id)
        {
            $name=$this->type_name_array[$id];
            $input_name=$fixed_class.'_'.$id;
            $input_class='type '.$fixed_class.' '.$this->permission_all_child;
            $input_child_class=str_replace('type','name',$input_name);
            $href='#'.$input_name;
            $child_panel='';
            if(array_key_exists($id,$this->name_parent_array))
            {
                $names=$this->names($id,$input_child_class);
                $child_panel='<div id="'.$input_name.'" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        '.$names.'
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
            $type_html.=$text;
        }
        return $type_html;
    }
    private function names($type_id,$fixed_class)
    {
        $name_html='';
        $name_array=$this->name_parent_array[$type_id];
        $checked='';
        foreach($name_array as $id)
        {
            $name=$this->name_name_array[$id];
            $input_name=$fixed_class.'_'.$id;
            $input_id=$fixed_class.'-'.$id;
            $input_class='name '.$fixed_class.' '.$this->permission_all_child;
            $checked='';
            if(in_array($id,$this->selected_array))
            {
                $checked=' checked';
            }
            $text='<div class="form-group">
                        <input type="checkbox" name="'.$input_name.'" id="'.$input_id.'" class="'.$input_class.'"'.$checked.'>
                        <label for="'.$input_id.'">'.$name.'</label>
                   </div>';
            $name_html.=$text;
        }
        return $name_html;
    }
}
