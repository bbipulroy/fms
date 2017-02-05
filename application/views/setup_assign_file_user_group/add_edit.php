<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$CI= & get_instance();
$action_data=array();
$action_data['action_back']=site_url($CI->controller_url);
$action_data['action_save']='#save_form';
$action_data['action_clear']='#save_form';
$CI->load->view('action_buttons',$action_data);
?>
<form id="save_form" action="<?php echo site_url($CI->controller_url.'/index/save');?>" method="post">
    <input type="hidden" id="id" name="id" value="<?php echo $item_id; ?>">
    <div class="row widget">
        <div class="widget-header">
            <div class="title">
                <?php echo $title; ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="row show-grid">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>File Category</th>
                        <th>File Class</th>
                        <th>File Type</th>
                        <th>
                            <label><input type="checkbox" class="system-prevent-click" data-type="file" data-id=""> File Name</label>
                        </th>
                            <?php
                            for($index=0;$index<$CI->config->item('system_fms_max_actions');$index++)
                            {
                                ?>
                                <th>
                                    <label><input class="system-prevent-click" type="checkbox" data-type="action" data-id="<?php echo $index; ?>"> <?php echo $CI->lang->line('LABEL_ACTION'.$index); ?></label>
                                </th>
                                <?php
                            }
                            ?>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach($all_files as $category_id=>$category)
                {
                    $k=0;
                    foreach($category['classes'] as $class_id=>$class)
                    {
                        $j=0;
                        foreach($class['types'] as $type_id=>$type)
                        {
                            $i=0;
                            foreach($type['files'] as $file_id=>$file)
                            {
                                ?>
                                <tr>
                                    <td>
                                        <?php
                                        if($k==0)
                                        {
                                            ?>
                                            <label><input class="system-prevent-click category" type="checkbox" data-type="category" data-id="<?php echo $category_id; ?>"> <?php echo $category['name']; ?></label>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if($j==0)
                                        {
                                            ?>
                                            <label><input class="system-prevent-click class category<?php echo $category_id; ?>" type="checkbox" data-type="class" data-id="<?php echo $class_id; ?>"> <?php echo $class['name']; ?></label>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if($i==0)
                                        {
                                            ?>
                                            <label><input class="system-prevent-click type category<?php echo $category_id; ?> class<?php echo $class_id; ?>" type="checkbox" data-type="type" data-id="<?php echo $type_id; ?>"> <?php echo $type['name']; ?></label>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td><label><input class="system-prevent-click file category<?php echo $category_id; ?> class<?php echo $class_id; ?> type<?php echo $type_id; ?>" type="checkbox" data-type="file" data-id="<?php echo $file_id; ?>"> <?php echo $file['name']; ?></label></td>
                                    <?php
                                    for($index=0;$index<$CI->config->item('system_fms_max_actions');$index++)
                                    {
                                        ?>
                                        <td>
                                            <input name="items[<?php echo $file_id; ?>][action<?php echo $index; ?>]" class="action<?php echo $index;?> file category<?php echo $category_id; ?> class<?php echo $class_id; ?> type<?php echo $type_id; ?> file<?php echo $file_id; ?>" type="checkbox" <?php if(isset($permitted_files[$file_id]) && ($permitted_files[$file_id]['action'.$index]==1) ){echo 'checked';} ?>>
                                        </td>
                                        <?php
                                    }
                                    ?>
                                </tr>
                                <?php
                                $i++;
                                $j++;
                                $k++;
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
        $(document).off("click", ".system-prevent-click");
        $(document).on('click','.system-prevent-click',function()
        {
            var obj=$(this);
            if(obj.is(':checked'))
            {
                var attr_data_type=obj.attr('data-type');
                $('.'+attr_data_type+obj.attr('data-id')).prop('checked',true);
                if(attr_data_type!='action')
                {
                    $('.'+attr_data_type+obj.attr('data-id')+'.action3').prop('checked',false);
                }
            }
            else
            {
                $('.'+obj.attr('data-type')+obj.attr('data-id')).prop('checked',false);
            }
        });
    });
</script>
