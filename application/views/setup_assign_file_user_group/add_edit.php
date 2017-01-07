<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$CI = & get_instance();
$action_data=array();
$action_data['action_back']=site_url($CI->controller_url);
$action_data['action_save']='#save_form';
$action_data['action_clear']='#save_form';
$CI->load->view('action_buttons',$action_data);
?>
<form class="form_valid" id="save_form" action="<?php echo site_url($CI->controller_url.'/index/save');?>" method="post">
    <input type="hidden" id="id" name="id" value="<?php echo $item_id; ?>">

    <div class="row widget">
        <div class="widget-header">
            <div class="title">
                <?php echo $title; ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="row show-grid">
            <table class="table">
                <thead>
                <tr>
                    <th>File Category</th>
                    <th>File Class</th>
                    <th>File Type</th>
                    <th>
                        <input id="name" type="checkbox" data-id="" data-type="name">
                        <label for="name">File Name</label>
                    </th>
                </tr>
                </thead>
                <tbody>
                    <?php
                        $check_array=array();
                        foreach($CI->category_name_array as $category_id=>$category_name)
                        {
                            if(array_key_exists($category_id,$CI->class_parent_array))
                            {
                                $temp_class_id_array=$CI->class_parent_array[$category_id];
                                foreach($temp_class_id_array as $class_index=>$class_id)
                                {
                                    if(array_key_exists($class_id,$CI->type_parent_array))
                                    {
                                        $temp_type_id_array=$CI->type_parent_array[$class_id];
                                        foreach($temp_type_id_array as $type_index=>$type_id)
                                        {
                                            if(array_key_exists($type_id,$CI->name_parent_array))
                                            {
                                                $temp_name_id_array=$CI->name_parent_array[$type_id];
                                                foreach($temp_name_id_array as $name_id)
                                                {
                                                    $CI->table_cells($category_id,$category_name,$class_id,$CI->class_name_array[$class_id],$type_id,$CI->type_name_array[$type_id],$name_id,$CI->name_name_array[$name_id],$check_array,$CI->selected_array);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
    <div class="clearfix"></div>
</form>
<script>
    jQuery(document).ready(function()
    {
        <?php
        $CI->javascript_code_gen($check_array['category'],'category');
        $CI->javascript_code_gen($check_array['class'],'class');
        $CI->javascript_code_gen($check_array['type'],'type');
        ?>
        $(document).on('change','input[type="checkbox"]',function()
        {
            var obj=$(this);
            var child_type="."+obj.attr("data-type");
            if(obj.attr("data-id")!="")
            {
                child_type+="_"+obj.attr("data-id");
            }
            if($(this).is(':checked'))
            {
                $(child_type).prop('checked',true);
            }
            else
            {
                $(child_type).prop('checked',false);
            }
        });
    });
</script>
