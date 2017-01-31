<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup_assign_file_user_group extends Root_Controller
{
    private $message;
    public $permissions;
    public $controller_url;
    public $all_files;
    public $permitted_files;

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
            $data['title']='List of '.$this->lang->line('LABEL_USER_GROUP').' to Assign Files';
            $ajax['system_content'][]=array('id'=>'#system_content','html'=>$this->load->view($this->controller_url.'/list',$data,true));
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

            $this->db->select('name');
            $this->db->from($this->config->item('table_system_user_group'));
            $this->db->where('id',$item_id);
            $user_group_name=$this->db->get()->row_array();
            $data['title']='Details File Permissions for ('.$user_group_name['name'].')';

            $this->edit_details_helper($item_id,'details');
            $data['action']='details';
            $ajax['system_content'][]=array('id'=>'#system_content','html'=>$this->load->view($this->controller_url.'/add_edit',$data,true));
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

            $this->edit_details_helper($item_id,'edit');
            $data['action']='edit';
            $ajax['system_content'][]=array('id'=>'#system_content','html'=>$this->load->view($this->controller_url.'/add_edit',$data,true));
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
        $id=$this->input->post('id');
        $data=$this->input->post('item');
        $actions=$this->input->post('actions');
        if(!is_array($data))
        {
            $data=array();
        }
        if(!is_array($actions))
        {
            $actions=array();
        }
        $user=User_helper::get_user();
        if($id>0)
        {
            if(!(isset($this->permissions['action2']) && ($this->permissions['action2']==1)))
            {
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line('YOU_DONT_HAVE_ACCESS');
                $this->json_return($ajax);
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
            $this->db->trans_start(); //DB Transaction Handle START

            $this->db->set('status',$this->config->item('system_status_delete'));
            $this->db->set('action1',0);
            $this->db->set('action2',0);
            $this->db->set('action3',0);
            $this->db->where('user_group_id',$id);
            $this->db->update($this->config->item('table_fms_setup_assign_file_user_group'));

            $this->db->select('id_file');
            $this->db->from($this->config->item('table_fms_setup_assign_file_user_group'));
            $this->db->where('user_group_id',$id);
            $permitted_files_for_process=$this->db->get()->result_array();

            $permitted_files=array();
            foreach($permitted_files_for_process as $pf)
            {
                $permitted_files[]=$pf['id_file'];
            }
            $data_add=array();
            $data_edit=array();

            $data_add['id_file']=null;
            $data_add['user_group_id']=$id;
            $data_add['user_created']=$user->user_id;
            $data_add['date_created']=time();
            $data_add['action1']=0;
            $data_add['action2']=0;
            $data_add['action3']=0;
            $data_add['status']=$this->config->item('system_status_active');

            $data_edit['user_updated']=$user->user_id;
            $data_edit['date_updated']=$data_add['date_created'];
            $data_edit['action1']=0;
            $data_edit['action2']=0;
            $data_edit['action3']=0;
            $data_edit['status']=$this->config->item('system_status_active');

            foreach($data as $id_file=>$v)
            {
                if(isset($actions[$id_file][1]))
                {
                    $data_add['action1']=1;
                    $data_edit['action1']=1;
                }
                else
                {
                    $data_add['action1']=0;
                    $data_edit['action1']=0;
                }
                if(isset($actions[$id_file][2]))
                {
                    $data_add['action2']=1;
                    $data_edit['action2']=1;
                }
                else
                {
                    $data_add['action2']=0;
                    $data_edit['action2']=0;
                }
                if(isset($actions[$id_file][3]))
                {
                    $data_add['action3']=1;
                    $data_edit['action3']=1;
                }
                else
                {
                    $data_add['action3']=0;
                    $data_edit['action3']=0;
                }
                if(in_array($id_file,$permitted_files))
                {
                    Query_helper::update($this->config->item('table_fms_setup_assign_file_user_group'),$data_edit,array('user_group_id='.$id,'id_file='.$id_file));
                }
                else
                {
                    $data_add['id_file']=$id_file;
                    Query_helper::add($this->config->item('table_fms_setup_assign_file_user_group'),$data_add);
                }
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
        $this->db->select('ug.id,ug.name,ug.status,ug.ordering,SUM(CASE WHEN fug.status=\''.$this->config->item('system_status_active').'\' THEN 1 ELSE 0 END) file_total');
        $this->db->from($this->config->item('table_system_user_group').' ug');
        $this->db->join($this->config->item('table_fms_setup_assign_file_user_group').' fug','fug.user_group_id=ug.id','left');
        $this->db->group_by('ug.id');
        $this->db->where('ug.status',$this->config->item('system_status_active'));
        if($user->user_group!=1)
        {
            $this->db->where('ug.id!=',1);
        }
        $items=$this->db->get()->result_array();
        $this->json_return($items);
    }
    private function edit_details_helper($user_group_id,$action)
    {
        if($action=='edit')
        {
            $this->db->select('id_file,action1,action2,action3');
            $this->db->from($this->config->item('table_fms_setup_assign_file_user_group'));
            $this->db->where('user_group_id',$user_group_id);
            $this->db->where('status',$this->config->item('system_status_active'));
            $selected_files=$this->db->get()->result_array();
            foreach($selected_files as $sf)
            {
                $this->permitted_files[$sf['id_file']]=$sf;
            }
            if(!is_array($this->permitted_files))
            {
                $this->permitted_files=array();
            }
        }

        $this->db->select('n.id name_id,n.name name_name,t.id type_id,t.name type_name,cls.id class_id,cls.name class_name,ctg.id category_id,ctg.name category_name');
        if($action=='details')
        {
            $this->db->select('fug.action1,fug.action2,fug.action3');
        }
        $this->db->from($this->config->item('table_fms_setup_file_name').' n');
        if($action=='details')
        {
            $this->db->join($this->config->item('table_fms_setup_assign_file_user_group').' fug','fug.id_file=n.id','left');
        }
        $this->db->join($this->config->item('table_fms_setup_file_type').' t','t.id=n.id_type');
        $this->db->join($this->config->item('table_fms_setup_file_class').' cls','cls.id=t.id_class');
        $this->db->join($this->config->item('table_fms_setup_file_category').' ctg','ctg.id=cls.id_category');
        $this->db->where('n.status',$this->config->item('system_status_active'));
        if($action=='details')
        {
            $this->db->where('fug.user_group_id',$user_group_id);
            $this->db->where('fug.status',$this->config->item('system_status_active'));
        }
        $this->db->order_by('category_id');
        $this->db->order_by('class_id');
        $this->db->order_by('type_id');
        $this->all_files=$this->db->get()->result_array();
        if(!is_array($this->all_files))
        {
            $this->all_files=array();
        }
    }
    public function table_cells($file,&$check_array,$action)
    {
        $is_first_category=false;
        $is_first_class=false;
        $is_first_type=false;
        if(isset($check_array['category'][$file['category_id']]))
        {
            $check_array['category'][$file['category_id']]+=1;
        }
        else
        {
            $is_first_category='_first';
            $check_array['category'][$file['category_id']]=1;
        }
        if(isset($check_array['class'][$file['class_id']]))
        {
            $check_array['class'][$file['class_id']]+=1;
        }
        else
        {
            $is_first_class='_first';
            $check_array['class'][$file['class_id']]=1;
        }
        if(isset($check_array['type'][$file['type_id']]))
        {
            $check_array['type'][$file['type_id']]+=1;
        }
        else
        {
            $is_first_type='_first';
            $check_array['type'][$file['type_id']]=1;
        }

        $name_checked='';
        $add_checked='';
        $edit_checked='';
        $delete_checked='';
        if($action=='edit')
        {
            if(array_key_exists($file['name_id'],$this->permitted_files))
            {
                $name_checked=' checked';
                if($this->permitted_files[$file['name_id']]['action1']==1)
                {
                    $add_checked=' checked';
                }
                if($this->permitted_files[$file['name_id']]['action2']==1)
                {
                    $edit_checked=' checked';
                }
                if($this->permitted_files[$file['name_id']]['action3']==1)
                {
                    $delete_checked=' checked';
                }
            }
        }
        else
        {
            $add_checked='remove';
            $edit_checked='remove';
            $delete_checked='remove';
            if($file['action1']==1)
            {
                $add_checked='ok';
            }
            if($file['action2']==1)
            {
                $edit_checked='ok';
            }
            if($file['action3']==1)
            {
                $delete_checked='ok';
            }
        }
        ?>
        <tr>
            <td class="category-<?php echo $file['category_id'].$is_first_category; ?>">
                <?php
                    if($action=='edit')
                    {
                        ?>
                        <input id="category-<?php echo $file['category_id']; ?>" type="checkbox" data-id="<?php echo $file['category_id']; ?>" data-type="category" class="all category">
                        <label for="category-<?php echo $file['category_id']; ?>"><?php echo $file['category_name']; ?></label>
                        <?php
                    }
                    else
                    {
                        echo $file['category_name'];
                    }
                ?>
            </td>
            <td class="class-<?php echo $file['class_id'].$is_first_class; ?>">
                <?php
                if($action=='edit')
                {
                    ?>
                    <input id="class-<?php echo $file['class_id']; ?>" type="checkbox" data-id="<?php echo $file['class_id']; ?>" data-type="class" class="all class category_<?php echo $file['category_id']; ?>">
                    <label for="class-<?php echo $file['class_id']; ?>"><?php echo $file['class_name']; ?></label>
                    <?php
                }
                else
                {
                    echo $file['class_name'];
                }
                ?>
            </td>
            <td class="type-<?php echo $file['type_id'].$is_first_type; ?>">
                <?php
                if($action=='edit')
                {
                    ?>
                    <input id="type-<?php echo $file['type_id']; ?>" type="checkbox" data-id="<?php echo $file['type_id']; ?>" data-type="type" class="all type category_<?php echo $file['category_id']; ?> class_<?php echo $file['class_id']; ?>">
                    <label for="type-<?php echo $file['type_id']; ?>"><?php echo $file['type_name']; ?></label>
                    <?php
                }
                else
                {
                    echo $file['type_name'];
                }
                ?>
            </td>
            <td>
                <?php
                if($action=='edit')
                {
                    ?>
                    <input name="item[<?php echo $file['name_id']; ?>]" id="name-<?php echo $file['name_id']; ?>" type="checkbox" data-id="<?php echo $file['name_id']; ?>" data-type="name" class="all name category_<?php echo $file['category_id']; ?> class_<?php echo $file['class_id']; ?> type_<?php echo $file['type_id']; ?>"<?php echo $name_checked; ?>>
                    <label for="name-<?php echo $file['name_id']; ?>"><?php echo $file['name_name']; ?></label>
                    <?php
                }
                else
                {
                    echo $file['name_name'];
                }
                ?>
            </td>
            <?php
            if($action=='edit')
            {
                ?>
                <td>
                    <input name="actions[<?php echo $file['name_id']; ?>][1]" type="checkbox" class="all action1 name category_<?php echo $file['category_id']; ?> class_<?php echo $file['class_id']; ?> type_<?php echo $file['type_id']; ?> name_<?php echo $file['name_id']; ?>"<?php echo $add_checked; ?>>
                </td>
                <td>
                    <input name="actions[<?php echo $file['name_id']; ?>][2]" type="checkbox" class="all action2 name category_<?php echo $file['category_id']; ?> class_<?php echo $file['class_id']; ?> type_<?php echo $file['type_id']; ?> name_<?php echo $file['name_id']; ?>"<?php echo $edit_checked; ?>>
                </td>
                <td>
                    <input name="actions[<?php echo $file['name_id']; ?>][3]" type="checkbox" class="all action3 name_<?php echo $file['name_id']; ?>"<?php echo $delete_checked; ?>>
                </td>
                <?php
            }
            else
            {
                ?>
                <td>
                    <span class="glyphicon glyphicon-<?php echo $add_checked; ?>" aria-hidden="true"></span>
                </td>
                <td>
                    <span class="glyphicon glyphicon-<?php echo $edit_checked; ?>" aria-hidden="true"></span>
                </td>
                <td>
                    <span class="glyphicon glyphicon-<?php echo $delete_checked; ?>" aria-hidden="true"></span>
                </td>
                <?php
            }
            ?>
        </tr>
    <?php
    }
    public function javascript_code_gen($array,$type)
    {
        foreach($array as $id=>$rowspan)
        {
            echo '$(".'.$type.'-'.$id.'").remove();';
            echo '$(".'.$type.'-'.$id.'_first").attr("rowspan","'.$rowspan.'");';
        }
    }
}
