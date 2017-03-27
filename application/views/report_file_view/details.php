<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$CI= & get_instance();
?>
<div class="row widget">
    <div class="widget-header">
        <div class="title">
            Details for <?php echo $item['name']; ?>
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
</div>

<div class="panel-group" id="accordion">
    <?php
    $location=$this->config->item('system_image_base_url');
    foreach($file_items as $file_item)
    {
        $show_item=true;
        if(!isset($item_files[$file_item['id']]) && $file_item['status']!=$this->config->item('system_status_active'))
        {
            $show_item=false;
        }
        if($show_item)
        {
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="external" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $file_item['id']; ?>"><?php echo $file_item['name']; ?></a>
                    </h4>
                </div>
                <div id="collapse_<?php echo $file_item['id']; ?>" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div style="overflow-x: auto;" class="row show-grid">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>File Name</th>
                                    <th>Picture/Thumbnail</th>
                                    <th>Entry Date</th>
                                    <th><?php echo $CI->lang->line('LABEL_REMARKS'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(!isset($item_files[$file_item['id']]))
                                {
                                    $item_files[$file_item['id']]=array();
                                }
                                foreach($item_files[$file_item['id']] as $file)
                                {
                                    ?>
                                    <tr>
                                        <td><?php echo $file['name']; ?></td>
                                        <td>
                                            <?php
                                            if(substr($file['mime_type'],0,5)=='image')
                                            {
                                                ?>
                                                <img src="<?php echo $location.$file['file_path']; ?>" style="max-width: 250px;max-height:150px">
                                            <?php
                                            }
                                            else
                                            {
                                                $extension=pathinfo($file['name'],PATHINFO_EXTENSION);
                                                if(strtolower($extension)=='pdf')
                                                {
                                                    $href_text='Read the PDF File';
                                                }
                                                else
                                                {
                                                    $href_text='Download the '.strtoupper($extension).' File';
                                                }
                                                ?>
                                                <a href="<?php echo $location.$file['file_path']; ?>" class="btn btn-success external" target="_blank"><?php echo $href_text; ?></a>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo System_helper::display_date($file['date_entry']); ?></td>
                                        <td><?php echo $file['remarks']; ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
    }
    ?>
</div>
