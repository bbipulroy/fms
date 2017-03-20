<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$CI=& get_instance();
$action_buttons=array();
$action_buttons[]=array(
    'label'=>$CI->lang->line("ACTION_BACK"),
    'href'=>site_url($CI->controller_url)
);
$action_buttons[]=array(
    'type'=>'button',
    'label'=>$CI->lang->line("ACTION_SAVE"),
    'id'=>'button_action_save',
    'data-form'=>'#save_form'
);
$action_buttons[]=array(
    'label'=>$CI->lang->line("ACTION_REFRESH"),
    'href'=>site_url($CI->controller_url.'/index/edit/'.$item['id'])
);
$CI->load->view('action_buttons',array('action_buttons'=>$action_buttons));
?>
<form id="save_form" action="<?php echo site_url($CI->controller_url.'/index/save');?>" method="post">
    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
    <input type="hidden" name="file_open_time_for_edit" value="<?php echo time(); ?>">
    <div class="row widget">
        <div class="widget-header">
            <div class="title">
                Entry pages in <?php echo $item['name']; ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_FILE_NAME'); ?>:</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label><?php echo $item['name'] ?></label>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_RESPONSIBLE_EMPLOYEE'); ?>:</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label><?php echo $item['employee_name'] ?></label>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_HC_LOCATION'); ?>:</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label><?php echo $item['hardcopy_location'] ?></label>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right">Opening Date:</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label><?php echo System_helper::display_date($item['date_start']); ?></label>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_FILE_CATEGORY'); ?>:</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label><?php echo $item['category_name'] ?></label>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_FILE_SUB_CATEGORY'); ?>:</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label><?php echo $item['sub_category_name'] ?></label>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_FILE_CLASS'); ?>:</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label><?php echo $item['class_name'] ?></label>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_FILE_TYPE'); ?>:</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label><?php echo $item['type_name'] ?></label>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_COMPANY_NAME'); ?>:</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label><?php echo $item['company_name'] ?></label>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_DEPARTMENT'); ?>:</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label><?php echo $item['department_name'] ?></label>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right">Number of Pages:</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label><?php echo $item['number_of_page'] ?></label>
            </div>
        </div>

        <div id="files_container">
            <div style="overflow-x: auto;" class="row show-grid">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="min-width: 250px;">File/Picture</th>
                            <th style="min-width: 50px;">Upload</th>
                            <th style="min-width: 50px;">Entry Date</th>
                            <th style="min-width: 100px;"><?php echo $CI->lang->line('LABEL_REMARKS'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $location=$this->config->item('system_image_base_url');
                        foreach($stored_files as $index=>$file)
                        {
                            ?>
                            <tr>
                                <td>
                                    <div class="preview_container_file" id="preview_container_file_old_<?php echo $file['id']; ?>">
                                        <?php
                                        if(substr($file['mime_type'],0,5)=='image')
                                        {
                                            ?>
                                            <img style="max-width: 250px;" src="<?php echo $location.$file['file_path']; ?>">
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <a href="<?php echo $location.$file['file_path']; ?>" class="external" target="_blank"><?php echo $file['name']; ?></a>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </td>
                                <td>
                                    <?php
                                        if($file_permissions['action2']==1)
                                        {
                                            ?>
                                            <input type="file" name="file_old_<?php echo $file['id']; ?>" data-current-id="<?php echo $file['id']; ?>" data-preview-container="#preview_container_file_old_<?php echo $file['id']; ?>" class="browse_button_old"><br>
                                            <?php
                                        }
                                        if($file_permissions['action3']==1)
                                        {
                                            ?>
                                            <button type="button" class="btn btn-danger system_button_add_delete"><?php echo $CI->lang->line('DELETE'); ?></button>
                                            <?php
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        if($file_permissions['action2']==1)
                                        {
                                            ?>
                                            <input type="text" name="items_old[<?php echo $file['id']; ?>][date_entry]" class="form-control datepicker_old" value="<?php echo System_helper::display_date($file['date_entry']); ?>">
                                            <?php
                                        }
                                        elseif($file_permissions['action3']==1)
                                        {
                                            ?>
                                            <input type="hidden" name="items_old[<?php echo $file['id']; ?>][date_entry]" value="<?php echo System_helper::display_date($file['date_entry']); ?>">
                                            <?php
                                        }
                                        else
                                        {
                                            echo System_helper::display_date($file['date_entry']);
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if($file_permissions['action2']==1)
                                    {
                                        ?>
                                        <textarea  name="items_old[<?php echo $file['id']; ?>][remarks]" class="form-control"><?php echo $file['remarks']; ?></textarea>
                                        <?php
                                    }
                                    elseif($file_permissions['action3']==1)
                                    {
                                        ?>
                                        <input type="hidden" name="items_old[<?php echo $file['id']; ?>][remarks]" value="<?php echo $file['remarks']; ?>">
                                        <?php
                                    }
                                    else
                                    {
                                        echo $file['remarks'];
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
                        }
                    ?>
                    </tbody>
                </table>
            </div>
            <?php
                if($file_permissions['action1']==1)
                {
                    ?>
                    <div class="row show-grid">
                        <div class="col-xs-4"></div>
                        <div class="col-xs-4">
                            <button type="button" class="btn btn-warning system_button_add_more" data-current-id="0">
                                <?php echo $CI->lang->line('LABEL_ADD_MORE'); ?>
                            </button>
                        </div>
                        <div class="col-xs-4"></div>
                    </div>
                    <?php
                }
            ?>
        </div>
    </div>
    <div class="clearfix"></div>
</form>

<div id="system_content_add_more" style="display: none;">
    <table>
        <tbody>
            <tr>
                <td>
                    <div class="preview_container_file">
                    </div>
                </td>
                <td>
                    <input type="file" class="browse_button_new"><br>
                    <button type="button" class="btn btn-danger system_button_add_delete"><?php echo $CI->lang->line('DELETE'); ?></button>
                </td>
                <td>
                    <input type="text" class="form-control date_entry" value="<?php echo System_helper::display_date(time()); ?>">
                </td>
                <td>
                    <textarea class="form-control remarks"></textarea>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<script type="text/javascript">
    jQuery(document).ready(function()
    {
        $(document).off("click",".system_button_add_more");
        $(document).off("click",".system_button_add_delete");
        
        $('.datepicker_old').datepicker({dateFormat : display_date_format});
        $('.browse_button_old').filestyle({input: false,icon: false,buttonText: "Edit",buttonName: "btn-primary"});
        $(document).on("click", ".system_button_add_more", function(event)
        {
            var current_id=parseInt($('.system_button_add_more').attr('data-current-id'))+1;
            $('.system_button_add_more').attr('data-current-id',current_id);
            var content_id='#system_content_add_more table tbody';

            $(content_id+' .preview_container_file').attr('id','preview_container_file_'+current_id);

            $(content_id+' .browse_button_new').attr('data-preview-container','#preview_container_file_'+current_id);
            $(content_id+' .browse_button_new').attr('name','file_new_'+current_id);
            $(content_id+' .browse_button_new').attr('id','file_new_'+current_id);
            $(content_id+' .browse_button_new').attr('data-current-id',current_id);

            $(content_id+' .date_entry').attr('name','items_new['+current_id+'][date_entry]');
            $(content_id+' .date_entry').attr('id','date_entry_'+current_id);

            $(content_id+' .remarks').attr('name','items_new['+current_id+'][remarks]');

            var html=$(content_id).html();
            $('#files_container table tbody').append(html);

            $(content_id+' .preview_container_file').removeAttr('id');


            $(content_id+' .browse_button_new').removeAttr('data-preview-container');
            $(content_id+' .browse_button_new').removeAttr('name');
            $(content_id+' .browse_button_new').removeAttr('id');
            $(content_id+' .browse_button_new').removeAttr('data-current-id');

            $(content_id+' .date_entry').removeAttr('name');
            $(content_id+' .date_entry').removeAttr('id');
            $(content_id+' .remarks').removeAttr('name');

            $('#file_new_'+current_id).filestyle({input: false,icon: false,buttonText: "Upload",buttonName: "btn-primary"});
            $('#date_entry_'+current_id).datepicker({dateFormat : display_date_format});
        });
        $(document).on("click", ".system_button_add_delete", function(event)
        {
            $(this).closest('tr').remove();
        });
    });
</script>
