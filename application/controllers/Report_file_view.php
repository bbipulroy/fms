<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_file_view extends Root_Controller
{
    private $message;
    public $permissions;
    public $controller_url;
    public function __construct()
    {
        parent::__construct();
        $this->message='';
        $this->permissions=User_helper::get_permission('Report_file_view');
        $this->controller_url='report_file_view';
    }
    public function index($action='search',$id=0)
    {
        if($action=='search')
        {
            $this->system_search();
        }
        elseif($action=='list')
        {
            $this->system_list();
        }
        elseif($action=='get_items_list_files')
        {
            $this->system_get_items_list_files();
        }
        elseif($action=='get_items_list_with_files_info')
        {
            $this->system_get_items_list_with_files_info();
        }
        elseif($action=='get_items_list_file_items')
        {
            $this->system_get_items_list_file_items();
        }
        elseif($action=='details')
        {
            $this->system_details($id);
        }
        else
        {
            $this->system_search();
        }
    }
    private function system_search()
    {
        if(isset($this->permissions['action0']) && ($this->permissions['action0']==1))
        {
            $data['title']='Report View';
            $data['item']=array
            (
                'id_category'=>'',
                'id_sub_category'=>'',
                'id_class'=>'',
                'id_type'=>'',
                'id_name'=>'',
                'date_from_start_file'=>'',
                'date_to_start_file'=>'',
                'date_from_start_page'=>'',
                'date_to_start_page'=>'',
                'id_company'=>'',
                'id_department'=>'',
                'employee_id'=>''
            );
            $data['categories']=Query_helper::get_info($this->config->item('table_fms_setup_file_category'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'),0,0,array('ordering ASC'));
            $data['sub_categories']=array();
            $data['classes']=array();
            $data['types']=array();
            $data['names']=array();

            $data['companies']=Query_helper::get_info($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_company'),array('id value','full_name text'),array('status ="'.$this->config->item('system_status_active').'"'),0,0,array('ordering ASC'));
            $data['departments']=Query_helper::get_info($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_department'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'),0,0,array('ordering ASC'));

            $data['employees']=array();
            $ajax['system_page_url']=site_url($this->controller_url.'/index/search');
            $ajax['system_content'][]=array('id'=>'#system_content','html'=>$this->load->view($this->controller_url.'/search',$data,true));
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
    private function system_list()
    {
        if(isset($this->permissions['action0']) && ($this->permissions['action0']==1))
        {
            $item=$this->input->post('item');
            if($item['id_name']>0)
            {
                $data=array();
                $this->get_file_info($data,$item['id_name'],System_helper::get_time($item['date_from_start_page']),System_helper::get_time($item['date_to_start_page']));
                $data['file_items']=$this->get_file_items($item['id_name']);
                $data['item_files']=array();
                foreach($data['stored_files'] as $file)
                {
                    $data['item_files'][$file['id_file_item']][]=$file;
                }
                unset($data['stored_files']);
                $ajax['system_content'][]=array('id'=>'#system_report_container','html'=>$this->load->view($this->controller_url.'/details',$data,true));
            }
            else
            {
                $ajax_post='';
                foreach($item as $key=>$val)
                {
                    $ajax_post.=$key.':"'.$val.'",';
                }
                $data['ajax_post']=substr($ajax_post,0,-1);
                $report_name=$this->input->post('report_name');
                if($report_name=='list_with_files_info')
                {
                    $data['title']='Files Information Report';
                    $ajax['system_content'][]=array('id'=>'#system_report_container','html'=>$this->load->view($this->controller_url.'/list_with_files_info',$data,true));
                }
                elseif($report_name=='list_files')
                {
                    $data['title']='Files List Report';
                    $ajax['system_content'][]=array('id'=>'#system_report_container','html'=>$this->load->view($this->controller_url.'/list_files',$data,true));
                }
                else
                {
                    $data['title']='File Items List Report';
                    $ajax['system_content'][]=array('id'=>'#system_report_container','html'=>$this->load->view($this->controller_url.'/list_file_items',$data,true));
                }
            }
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=site_url($this->controller_url.'/index/search');
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
    private function system_get_items_list_files()
    {
        $id_category=$this->input->post('id_category');
        $id_sub_category=$this->input->post('id_sub_category');
        $id_class=$this->input->post('id_class');
        $id_type=$this->input->post('id_type');

        $this->db->select('ctg.name category_name,ctg.id category_id,ctg.status category_status');
        $this->db->select('sctg.name sub_category_name,sctg.id sub_category_id,sctg.status sub_category_status');
        $this->db->select('cls.name class_name,cls.id class_id,cls.status class_status');
        $this->db->select('t.name type_name,t.id type_id,t.status type_status');
        $this->db->select('n.name file_name,n.id file_id,n.status file_status');

        $this->db->from($this->config->item('table_fms_setup_file_category').' ctg');
        $this->db->join($this->config->item('table_fms_setup_file_sub_category').' sctg','sctg.id_category=ctg.id','left');
        $this->db->join($this->config->item('table_fms_setup_file_class').' cls','cls.id_sub_category=sctg.id','left');
        $this->db->join($this->config->item('table_fms_setup_file_type').' t','t.id_class=cls.id','left');
        $this->db->join($this->config->item('table_fms_setup_file_name').' n','n.id_type=t.id','left');

        $this->db->where('ctg.status',$this->config->item('system_status_active'));
        $this->db->where('ctg.id',$id_category);
        if($id_sub_category>0)
        {
            $this->db->where('sctg.id',$id_sub_category);
        }
        if($id_class>0)
        {
            $this->db->where('cls.id',$id_class);
        }
        if($id_type>0)
        {
            $this->db->where('t.id',$id_type);
        }

        $this->db->order_by('ctg.ordering');
        $this->db->order_by('sctg.ordering');
        $this->db->order_by('cls.ordering');
        $this->db->order_by('t.ordering');
        $this->db->order_by('n.ordering');

        $items=$this->db->get()->result_array();
        $items=$this->get_filter_data($items);
        $this->json_return($items);
    }
    private function system_get_items_list_file_items()
    {
        $id_category=$this->input->post('id_category');
        $id_sub_category=$this->input->post('id_sub_category');
        $id_class=$this->input->post('id_class');
        $id_type=$this->input->post('id_type');

        $this->db->select('ctg.name category_name,ctg.id category_id,ctg.status category_status');
        $this->db->select('sctg.name sub_category_name,sctg.id sub_category_id,sctg.status sub_category_status');
        $this->db->select('cls.name class_name,cls.id class_id,cls.status class_status');
        $this->db->select('t.name type_name,t.id type_id,t.status type_status');
        $this->db->select('i.name item_name,i.id item_id,i.status item_status');

        $this->db->from($this->config->item('table_fms_setup_file_category').' ctg');
        $this->db->join($this->config->item('table_fms_setup_file_sub_category').' sctg','sctg.id_category=ctg.id','left');
        $this->db->join($this->config->item('table_fms_setup_file_class').' cls','cls.id_sub_category=sctg.id','left');
        $this->db->join($this->config->item('table_fms_setup_file_type').' t','t.id_class=cls.id','left');
        $this->db->join($this->config->item('table_fms_setup_file_item').' i','i.id_type=t.id','left');

        $this->db->where('ctg.status',$this->config->item('system_status_active'));
        $this->db->where('ctg.id',$id_category);
        if($id_sub_category>0)
        {
            $this->db->where('sctg.id',$id_sub_category);
        }
        if($id_class>0)
        {
            $this->db->where('cls.id',$id_class);
        }
        if($id_type>0)
        {
            $this->db->where('t.id',$id_type);
        }

        $this->db->order_by('ctg.ordering');
        $this->db->order_by('sctg.ordering');
        $this->db->order_by('cls.ordering');
        $this->db->order_by('t.ordering');
        $this->db->order_by('i.ordering');

        $items=$this->db->get()->result_array();
        $items=$this->get_filter_data($items,'item');
        $this->json_return($items);
    }
    private function get_filter_data($items,$index='file')
    {
        $all_files=array();
        $temp=array();
        foreach($items as $file)
        {
            $temp=array();
            $temp['category_name']=$file['category_name'];
            if($file['sub_category_status']!=$this->config->item('system_status_active'))
            {
                $temp['sub_category_name']='';
                $temp['class_name']='';
                $temp['type_name']='';
                $temp[$index.'_name']='Not Assigned';
                $all_files[]=$temp;
                continue;
            }
            $temp['sub_category_name']=$file['sub_category_name'];
            if($file['class_status']!=$this->config->item('system_status_active'))
            {
                $temp['class_name']='';
                $temp['type_name']='';
                $temp[$index.'_name']='Not Assigned';
                $all_files[]=$temp;
                continue;
            }
            $temp['class_name']=$file['class_name'];
            if($file['type_status']!=$this->config->item('system_status_active'))
            {
                $temp['type_name']='';
                $temp[$index.'_name']='Not Assigned';
                $all_files[]=$temp;
                continue;
            }
            $temp['type_name']=$file['type_name'];
            if($file[$index.'_status']!=$this->config->item('system_status_active'))
            {
                $temp[$index.'_name']='Not Assigned';
                $all_files[]=$temp;
                continue;
            }
            $temp[$index.'_name']=$file[$index.'_name'];
            $all_files[]=$temp;
        }
        return $all_files;
    }
    private function system_get_items_list_with_files_info()
    {
        $id_category=$this->input->post('id_category');
        $id_sub_category=$this->input->post('id_sub_category');
        $id_class=$this->input->post('id_class');
        $id_type=$this->input->post('id_type');
        $employee_id=$this->input->post('employee_id');
        $id_department=$this->input->post('id_department');
        $id_company=$this->input->post('id_company');
        $date_from_start_file=$this->input->post('date_from_start_file');
        $date_to_start_file=$this->input->post('date_to_start_file');

        $this->db->select('n.id,n.name,n.date_start,n.ordering');
        $this->db->select('hl.name hardcopy_location');
        $this->db->select('t.name type_name');
        $this->db->select('t.name type_name');
        $this->db->select('cls.name class_name');
        $this->db->select('sctg.name sub_category_name');
        $this->db->select('ctg.name category_name');
        $this->db->select('CONCAT(ui.name," - ",u.employee_id) employee_name');
        $this->db->select('d.name department_name');
        $this->db->select('comp.full_name company_name');
        $this->db->from($this->config->item('table_fms_setup_file_name').' n');
        $this->db->from($this->config->item('table_fms_setup_file_hc_location').' hl','hl.id=n.id_hc_location');
        $this->db->join($this->config->item('table_fms_setup_file_type').' t','t.id=n.id_type');
        $this->db->join($this->config->item('table_fms_setup_file_class').' cls','cls.id=t.id_class');
        $this->db->join($this->config->item('table_fms_setup_file_sub_category').' sctg','sctg.id=cls.id_sub_category');
        $this->db->join($this->config->item('table_fms_setup_file_category').' ctg','ctg.id=sctg.id_category');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_user_info').' ui','ui.user_id=n.employee_id','left');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_user').' u','ui.user_id=u.id');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_department').' d','d.id=n.id_department','left');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_company').' comp','comp.id=n.id_company','left');
        $this->db->where('ui.revision',1);
        $where_in=false;
        if($id_type>0)
        {
            $this->db->where('n.id_type',$id_type);
        }
        elseif($id_class>0)
        {
            $where_in='SELECT id FROM '.$this->config->item('table_fms_setup_file_type').' WHERE id_class='.$id_class;
        }
        elseif($id_sub_category>0)
        {
            $where_in='SELECT id FROM '.$this->config->item('table_fms_setup_file_type').' WHERE id_class IN (SELECT id FROM '.$this->config->item('table_fms_setup_file_class').' WHERE id_sub_category='.$id_sub_category.')';
        }
        elseif($id_category>0)
        {
            $where_in='SELECT id FROM '.$this->config->item('table_fms_setup_file_type').' WHERE id_class IN (SELECT id FROM '.$this->config->item('table_fms_setup_file_class').' WHERE id_sub_category IN (SELECT id FROM '.$this->config->item('table_fms_setup_file_sub_category').' WHERE id_category='.$id_category.'))';
        }

        if($where_in!==false)
        {
            $this->db->where_in('n.id_type',$where_in,false);
        }

        if($employee_id>0)
        {
            $this->db->where('n.employee_id',$employee_id);
        }
        else
        {
            if($id_company>0)
            {
                $this->db->where('n.id_company',$id_company);
            }
            if($id_department>0)
            {
                $this->db->where('n.id_department',$id_department);
            }
        }

        $this->two_date_between_query_generator(System_helper::get_time($date_from_start_file),System_helper::get_time($date_to_start_file),'n.date_start');
        $this->db->where('n.status',$this->config->item('system_status_active'));
        $this->db->group_by('n.id');
        $this->db->order_by('ctg.ordering');
        $this->db->order_by('sctg.ordering');
        $this->db->order_by('cls.ordering');
        $this->db->order_by('t.ordering');
        $this->db->order_by('n.ordering');
        $items=$this->db->get()->result_array();
        foreach($items as &$item)
        {
            $item['date_start']=System_helper::display_date($item['date_start']);
        }
        $this->json_return($items);
    }
    private function system_details($id)
    {
        $id=$this->input->post('id');
        $html_id=$this->input->post('html_container_id');
        $date_from_start_page=System_helper::get_time($this->input->post('date_from_start_page'));
        $date_to_start_page=System_helper::get_time($this->input->post('date_to_start_page'));

        $data=array();
        $this->get_file_info($data,$id,$date_from_start_page,$date_to_start_page);
        $data['file_items']=$this->get_file_items($id);
        $data['item_files']=array();
        foreach($data['stored_files'] as $file)
        {
            $data['item_files'][$file['id_file_item']][]=$file;
        }
        unset($data['stored_files']);
        $ajax['system_content'][]=array('id'=>$html_id,'html'=>$this->load->view($this->controller_url.'/details',$data,true));
        if($this->message)
        {
            $ajax['system_message']=$this->message;
        }
        $ajax['status']=true;
        $this->json_return($ajax);
    }
    private function get_file_items($file_id)
    {
        $this->db->select('i.id,i.name,i.status');
        $this->db->from($this->config->item('table_fms_setup_file_item').' i');
        $this->db->join($this->config->item('table_fms_setup_file_type').' t','t.id=i.id_type');
        $this->db->join($this->config->item('table_fms_setup_file_name').' n','n.id_type=t.id');
        $this->db->where('n.id',$file_id);
        $this->db->order_by('i.ordering');
        $results=$this->db->get()->result_array();
        return $results;
    }
    private function get_file_info(&$data,$id_file_name,$date_from_start_page,$date_to_start_page)
    {
        $this->db->select('n.id,n.name,n.date_start,n.status_file');
        $this->db->select('ctg.name category_name');
        $this->db->select('sctg.name sub_category_name');
        $this->db->select('cls.name class_name');
        $this->db->select('cls.name class_name');
        $this->db->select('t.name type_name');
        $this->db->select('t.name type_name');
        $this->db->select('hl.name hardcopy_location');
        $this->db->select('CONCAT(ui.name," - ",u.employee_id) employee_name');
        $this->db->select('d.name department_name');
        $this->db->select('comp.full_name company_name');
        $this->db->select('SUM(CASE WHEN df.status="'.$this->config->item('system_status_active').'" AND SUBSTRING(df.mime_type,1,5)="image" THEN 1 ELSE 0 END) number_of_page');
        $this->db->from($this->config->item('table_fms_setup_file_name').' n');
        $this->db->join($this->config->item('table_fms_setup_file_type').' t','n.id_type=t.id');
        $this->db->join($this->config->item('table_fms_setup_file_class').' cls','t.id_class=cls.id');
        $this->db->join($this->config->item('table_fms_setup_file_sub_category').' sctg','cls.id_sub_category=sctg.id');
        $this->db->join($this->config->item('table_fms_setup_file_category').' ctg','sctg.id_category=ctg.id');
        $this->db->join($this->config->item('table_fms_setup_file_hc_location').' hl','hl.id=n.id_hc_location');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_user_info').' ui','ui.user_id=n.employee_id','left');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_user').' u','ui.user_id=u.id');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_department').' d','d.id=n.id_department','left');
        $this->db->join($this->config->item('system_db_login').'.'.$this->config->item('table_login_setup_company').' comp','comp.id=n.id_company','left');
        $this->db->join($this->config->item('table_fms_tasks_digital_file').' df','df.id_file_name=n.id','left');
        $this->db->where('ui.revision',1);
        $this->db->where('n.id',$id_file_name);
        $this->db->where('n.status',$this->config->item('system_status_active'));
        $data['item']=$this->db->get()->row_array();

        $this->db->select('*');
        $this->db->from($this->config->item('table_fms_tasks_digital_file'));
        $this->db->where('id_file_name',$id_file_name);
        $this->db->where('status',$this->config->item('system_status_active'));
        $this->two_date_between_query_generator($date_from_start_page,$date_to_start_page,'date_entry');
        $data['stored_files']=$this->db->get()->result_array();
    }
    private function two_date_between_query_generator($start_date,$end_date,$field)
    {
        if($start_date>0)
        {
            $this->db->where($field.'>=',$start_date);
        }
        if($end_date>0)
        {
            $this->db->where($field.'<=',$end_date);
        }
    }
}
