<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup_assign_file_user_group extends Root_Controller
{
    private $message;
    public $permissions;
    public $controller_url;

    private $permission_all_child='permission_all_child';
    private $category_name_array=array();
    private $class_name_array=array();
    private $class_parent_array=array();
    private $type_name_array=array();
    private $type_parent_array=array();
    private $name_name_array=array();
    private $name_parent_array=array();
    public $selected_array=array();
    public $selected_process_check;
    public $selected_array_all=array();

    public function __construct()
    {
        parent::__construct();
        $this->message='';
        $this->permissions=User_helper::get_permission('Setup_assign_file_user_group');
        $this->controller_url='setup_assign_file_user_group';
    }
    public function index($action='list',$id=0,$js_prevent='')
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
        elseif($action=='edit')
        {
            $this->system_edit($id,$js_prevent);
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
        if(isset($this->permissions['action0']) && ($this->permissions['action0']==1))
        {
            if(($this->input->post('id')))
            {
                $item_id=$this->input->post('id');
            }
            else
            {
                $item_id=$id;
            } //$stock_id
            $this->db->from($this->config->item('table_stockin_varieties').' stv');
            $this->db->select('stv.*');
            $this->db->select('v.crop_type_id crop_type_id');
            $this->db->select('type.crop_id crop_id');

            $this->db->join($this->config->item('table_setup_classification_varieties').' v','v.id = stv.variety_id','INNER');
            $this->db->join($this->config->item('table_setup_classification_crop_types').' type','type.id = v.crop_type_id','INNER');
            $this->db->where('stv.id',$item_id);
            $this->db->where('stv.status',$this->config->item('system_status_active'));

            $data['stock_in']=$this->db->get()->row_array();
            if(!$data['stock_in'])
            {
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
                $this->jsonReturn($ajax);
                die();
            }
            if($data['stock_in']['date_exp']==0)
            {
                $data['stock_in']['date_exp']='';
            }
            if($data['stock_in']['date_mfg']==0)
            {
                $data['stock_in']['date_mfg']='';
            }
            $data['title']="Detail of Purchase";
            $data['warehouses']=Query_helper::get_info($this->config->item('table_basic_setup_warehouse'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));
            $data['crops']=Query_helper::get_info($this->config->item('table_setup_classification_crops'),array('id value','name text'),array());
            $data['crop_types']=Query_helper::get_info($this->config->item('table_setup_classification_crop_types'),array('id value','name text'),array('crop_id ='.$data['stock_in']['crop_id']));
            $data['varieties']=Query_helper::get_info($this->config->item('table_setup_classification_varieties'),array('id value','name text'),array('crop_type_id ='.$data['stock_in']['crop_type_id']));
            $data['pack_sizes']=Query_helper::get_info($this->config->item('table_setup_classification_vpack_size'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'),0,0,array('name ASC'));

            $ajax['status']=true;
            $ajax['system_content'][]=array("id"=>"#system_content","html"=>$this->load->view("stockin_variety/details",$data,true));
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=site_url($this->controller_url.'/index/details/'.$item_id);
            $this->jsonReturn($ajax);
        }
        else
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }
    private function system_edit($id,$js_prevent='')
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
            $data['js_prevent']=$js_prevent;
            $data['pre_system_page_url']=site_url($this->controller_url.'/index/edit/'.$item_id);
            $data['title']='Edit File Category ('.$user_group_name['name'].')';


            $this->db->select('id_file,type');
            $this->db->from($this->config->item('table_setup_assign_user_group_file'));
            $this->db->where('user_group_id',$item_id);
            $this->db->where('revision',1);
            $selected_files=$this->db->get()->result_array();
            if(sizeof($selected_files)<1)
            {
                $this->selected_process_check=false;
            }
            else
            {
                if($selected_files[0]['type']=='')
                {
                    $this->selected_process_check=false;
                }
                elseif($selected_files[0]['type']=='all' && $selected_files[0]['id_file']==0)
                {
                    $this->selected_array='permission_all';
                    $this->selected_process_check=false;
                }
                else
                {
                    $this->selected_process_check=true;
                    foreach($selected_files as $sf)
                    {
                        $this->selected_array[]=$sf['type'].$sf['id_file'];
                    }
                }
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
            
            if(sizeof($data)<1)
            {
                $data['user_group_id']=$id;
                $data['id_file']=0;
                $data['type']='';
                $data['user_updated']=$user->user_id;
                $data['date_updated']=time();
                $data['revision']=1;
            }
            elseif(isset($data['permission_all']))
            {
                unset($data['permission_all']);
                $data['user_group_id']=$id;
                $data['id_file']=0;
                $data['type']='all';
                $data['user_updated']=$user->user_id;
                $data['date_updated']=time();
                $data['revision']=1;
            }
            else
            {
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
                    $data_new['type']=$temp[0];
                    Query_helper::add($this->config->item('table_setup_assign_user_group_file'),$data_new);
                }
                unset($data);
            }
            if(isset($data))
            {
               Query_helper::add($this->config->item('table_setup_assign_user_group_file'),$data);
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
        $category_html='';
        $panel_group_html_id='category';
        foreach($this->category_name_array as $id=>$name)
        {
            $input_name=$panel_group_html_id.'_'.$id;
            $input_id=$panel_group_html_id.'-'.$id;
            if($this->selected_process_check)
            {
                $this->selected_array_all['category'.$id]=$input_id;
            }
            $input_class=$panel_group_html_id.' '.$this->permission_all_child;
            $input_parent_id=$this->permission_all_child;
            $input_child_class='class_'.$id;
            $data_parent='#'.$panel_group_html_id;
            $href='#'.$input_name;
            $child_panel_id=$input_name;
            $child_panel='';
            if(array_key_exists($id,$this->class_parent_array))
            {
                $classes=$this->classes($id,$input_child_class,$input_id);
                $classes='<div class="panel-group" id="'.$input_child_class.'">'.$classes.'</div>';
                $child_panel='<div id="'.$child_panel_id.'" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        '.$classes.'
                                    </div>
                                </div>';
            }
            $text='<div class="panel panel-default">
                   <div class="panel-heading">
                       <h4 class="panel-title">
                           <input type="checkbox" name="'.$input_name.'" id="'.$input_id.'" class="'.$input_class.'" parent-id="'.$input_parent_id.'" child-class="'.$input_child_class.'">
                           <a class="external" data-toggle="collapse" data-parent="'.$data_parent.'" href="'.$href.'">
                               '.$name.'
                           </a>
                       </h4>
                   </div>'.$child_panel.'
               </div>';
            $category_html.=$text;
        }
        echo $category_html;
    }
    private function classes($category_id,$panel_group_html_id,$parent_input_id)
    {
        $class_html='';
        $class_array=$this->class_parent_array[$category_id];
        foreach($class_array as $id)
        {
            $name=$this->class_name_array[$id];
            $input_name=$panel_group_html_id.'_'.$id;
            $input_id=$panel_group_html_id.'-'.$id;
            if($this->selected_process_check)
            {
                $this->selected_array_all['class'.$id]=$input_id;
            }
            $input_class='class '.$panel_group_html_id.' '.$this->permission_all_child;
            $input_parent_id=$parent_input_id;
            $input_child_class=str_replace('class','type',$input_name);
            $data_parent='#'.$panel_group_html_id;
            $href='#'.$input_name;
            $child_panel_id=$input_name;
            $child_panel='';
            if(array_key_exists($id,$this->type_parent_array))
            {
                $types=$this->types($id,$input_child_class,$input_id);
                $types='<div class="panel-group" id="'.$input_child_class.'">'.$types.'</div>';
                $child_panel='<div id="'.$child_panel_id.'" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        '.$types.'
                                    </div>
                                </div>';
            }
            $text='<div class="panel panel-default">
                   <div class="panel-heading">
                       <h4 class="panel-title">
                           <input type="checkbox" name="'.$input_name.'" id="'.$input_id.'" class="'.$input_class.'" parent-id="'.$input_parent_id.'" child-class="'.$input_child_class.'">
                           <a class="external" data-toggle="collapse" data-parent="'.$data_parent.'" href="'.$href.'">
                               '.$name.'
                           </a>
                       </h4>
                   </div>'.$child_panel.'
               </div>';
            $class_html.=$text;
        }
        return $class_html;
    }
    private function types($class_id,$panel_group_html_id,$parent_input_id)
    {
        $type_html='';
        $type_array=$this->type_parent_array[$class_id];
        foreach($type_array as $id)
        {
            $name=$this->type_name_array[$id];
            $input_name=$panel_group_html_id.'_'.$id;
            $input_id=$panel_group_html_id.'-'.$id;
            if($this->selected_process_check)
            {
                $this->selected_array_all['type'.$id]=$input_id;
            }
            $input_class='type '.$panel_group_html_id.' '.$this->permission_all_child;
            $input_parent_id=$parent_input_id;
            $input_child_class=str_replace('type','name',$input_name);
            $data_parent='#'.$panel_group_html_id;
            $href='#'.$input_name;
            $child_panel_id=$input_name;
            $child_panel='';
            if(array_key_exists($id,$this->name_parent_array))
            {
                $names=$this->names($id,$input_child_class,$input_id);
                $names='<div id="'.$input_child_class.'">'.$names.'</div>';
                $child_panel='<div id="'.$child_panel_id.'" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        '.$names.'
                                    </div>
                                </div>';
            }
            $text='<div class="panel panel-default">
                   <div class="panel-heading">
                       <h4 class="panel-title">
                           <input type="checkbox" name="'.$input_name.'" id="'.$input_id.'" class="'.$input_class.'" parent-id="'.$input_parent_id.'" child-class="'.$input_child_class.'">
                           <a class="external" data-toggle="collapse" data-parent="'.$data_parent.'" href="'.$href.'">
                               '.$name.'
                           </a>
                       </h4>
                   </div>'.$child_panel.'
               </div>';
            $type_html.=$text;
        }
        return $type_html;
    }
    private function names($type_id,$panel_group_html_id,$parent_input_id)
    {
        $name_html='';
        $name_array=$this->name_parent_array[$type_id];
        foreach($name_array as $id)
        {
            $name=$this->name_name_array[$id];
            $input_name=$panel_group_html_id.'_'.$id;
            $input_id=$panel_group_html_id.'-'.$id;
            if($this->selected_process_check)
            {
                $this->selected_array_all['name'.$id]=$input_id;
            }
            $input_class='name '.$panel_group_html_id.' '.$this->permission_all_child;
            $input_parent_id=$parent_input_id;
            $text='<div class="form-group">
                        <input type="checkbox" name="'.$input_name.'" id="'.$input_id.'" class="'.$input_class.'" parent-id="'.$input_parent_id.'">
                        <label for="'.$input_id.'">'.$name.'</label>
                   </div>';
            $name_html.=$text;
        }
        return $name_html;
    }
}
