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
        elseif($action=='files_list')
        {
            $this->system_get_files_list();
        }
        elseif($action=='file_items_list')
        {
            $this->system_get_file_items_list();
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
                'id_type'=>''
            );
            $data['categories']=Query_helper::get_info($this->config->item('table_fms_setup_file_category'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'),0,0,array('ordering ASC'));
            $data['sub_categories']=array();
            $data['classes']=array();
            $data['types']=array();

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
            $data['ajax_post']=$item;
            $report_name=$this->input->post('report_name');
            if($report_name=='files_list')
            {
                $data['title']='Files List';
                $ajax['system_content'][]=array('id'=>'#system_report_container','html'=>$this->load->view($this->controller_url.'/files_list',$data,true));
            }
            else
            {
                $data['title']='File Items List';
                $ajax['system_content'][]=array('id'=>'#system_report_container','html'=>$this->load->view($this->controller_url.'/file_items_list',$data,true));
            }
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
    private function system_get_files_list()
    {
        $id_category=$this->input->post('id_category');
        $id_sub_category=$this->input->post('id_sub_category');
        $id_class=$this->input->post('id_class');
        $id_type=$this->input->post('id_type');

        $this->db->select('ctg.name category_name,ctg.id category_id');
        $this->db->select('sctg.name sub_category_name,sctg.id sub_category_id');
        $this->db->select('cls.name class_name,cls.id class_id');
        $this->db->select('t.name type_name,t.id type_id');
        $this->db->select('n.name file_name,n.id file_id');

        $this->db->from($this->config->item('table_fms_setup_file_category').' ctg');
        $this->db->join($this->config->item('table_fms_setup_file_sub_category').' sctg','sctg.id_category=ctg.id AND sctg.status="'.$this->config->item('system_status_active').'"','left');
        $this->db->join($this->config->item('table_fms_setup_file_class').' cls','cls.id_sub_category=sctg.id AND cls.status="'.$this->config->item('system_status_active').'"','left');
        $this->db->join($this->config->item('table_fms_setup_file_type').' t','t.id_class=cls.id AND t.status="'.$this->config->item('system_status_active').'"','left');
        $this->db->join($this->config->item('table_fms_setup_file_name').' n','n.id_type=t.id AND n.status="'.$this->config->item('system_status_active').'"','left');

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
    private function system_get_file_items_list()
    {
        $id_category=$this->input->post('id_category');
        $id_sub_category=$this->input->post('id_sub_category');
        $id_class=$this->input->post('id_class');
        $id_type=$this->input->post('id_type');

        $this->db->select('ctg.name category_name,ctg.id category_id');
        $this->db->select('sctg.name sub_category_name,sctg.id sub_category_id');
        $this->db->select('cls.name class_name,cls.id class_id');
        $this->db->select('t.name type_name,t.id type_id');
        $this->db->select('i.name item_name,i.id item_id');

        $this->db->from($this->config->item('table_fms_setup_file_category').' ctg');
        $this->db->join($this->config->item('table_fms_setup_file_sub_category').' sctg','sctg.id_category=ctg.id AND sctg.status="'.$this->config->item('system_status_active').'"','left');
        $this->db->join($this->config->item('table_fms_setup_file_class').' cls','cls.id_sub_category=sctg.id AND cls.status="'.$this->config->item('system_status_active').'"','left');
        $this->db->join($this->config->item('table_fms_setup_file_type').' t','t.id_class=cls.id AND t.status="'.$this->config->item('system_status_active').'"','left');
        $this->db->join($this->config->item('table_fms_setup_file_item').' i','i.id_type=t.id AND i.status="'.$this->config->item('system_status_active').'"','left');

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
        $unique_items['category_ids']=array();
        $unique_items['sub_category_ids']=array();
        $unique_items['class_ids']=array();
        $unique_items['type_ids']=array();
        $temp=array();
        foreach($items as $file)
        {
            $temp=array();
            if(isset($unique_items['category_ids'][$file['category_id']]))
            {
                $temp['category_name']='';
            }
            else
            {
                $temp['category_name']=$file['category_name'];
                $unique_items['category_ids'][$file['category_id']]=$file['category_name'];
            }

            if(isset($unique_items['sub_category_ids'][$file['sub_category_id']]))
            {
                $temp['sub_category_name']='';
            }
            else
            {
                $temp['sub_category_name']=$file['sub_category_name'];
                $unique_items['sub_category_ids'][$file['sub_category_id']]=$file['sub_category_name'];
            }

            if(isset($unique_items['class_ids'][$file['class_id']]))
            {
                $temp['class_name']='';
            }
            else
            {
                $temp['class_name']=$file['class_name'];
                $unique_items['class_ids'][$file['class_id']]=$file['class_name'];
            }

            if(isset($unique_items['type_ids'][$file['type_id']]))
            {
                $temp['type_name']='';
            }
            else
            {
                $temp['type_name']=$file['type_name'];
                $unique_items['type_ids'][$file['type_id']]=$file['type_name'];
            }

            $temp[$index.'_name']=$file[$index.'_name'];
            $all_files[]=$temp;
        }
        return $all_files;
    }
}
