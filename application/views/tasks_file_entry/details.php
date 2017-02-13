<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$CI= & get_instance();
$action_data=array();
$action_data['action_back']=site_url($CI->controller_url);
$CI->load->view('action_buttons',$action_data);
?>
<div class="row widget">
    <div class="widget-header">
        <div class="title">
            Details for <?php echo $details['name']; ?>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="row show-grid">
        <div class="col-xs-4">
            <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_FILE_NAME'); ?>:</label>
        </div>
        <div class="col-sm-4 col-xs-8">
            <label><?php echo $details['name'] ?></label>
        </div>
    </div>
    <div class="row show-grid">
        <div class="col-xs-4">
            <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_RESPONSIBLE_EMPLOYEE'); ?>:</label>
        </div>
        <div class="col-sm-4 col-xs-8">
            <label><?php echo $details['employee_name'] ?></label>
        </div>
    </div>
    <div class="row show-grid">
        <div class="col-xs-4">
            <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_HC_LOCATION'); ?>:</label>
        </div>
        <div class="col-sm-4 col-xs-8">
            <label><?php echo $details['hardcopy_location'] ?></label>
        </div>
    </div>
    <div class="row show-grid">
        <div class="col-xs-4">
            <label class="control-label pull-right">Opening Date:</label>
        </div>
        <div class="col-sm-4 col-xs-8">
            <label><?php echo System_helper::display_date($details['date_start']); ?></label>
        </div>
    </div>
    <div class="row show-grid">
        <div class="col-xs-4">
            <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_FILE_CATEGORY'); ?>:</label>
        </div>
        <div class="col-sm-4 col-xs-8">
            <label><?php echo $details['category_name'] ?></label>
        </div>
    </div>
    <div class="row show-grid">
        <div class="col-xs-4">
            <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_FILE_CLASS'); ?>:</label>
        </div>
        <div class="col-sm-4 col-xs-8">
            <label><?php echo $details['class_name'] ?></label>
        </div>
    </div>
    <div class="row show-grid">
        <div class="col-xs-4">
            <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_FILE_TYPE'); ?>:</label>
        </div>
        <div class="col-sm-4 col-xs-8">
            <label><?php echo $details['type_name'] ?></label>
        </div>
    </div>
    <div class="row show-grid">
        <div class="col-xs-4">
            <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_OFFICE'); ?>:</label>
        </div>
        <div class="col-sm-4 col-xs-8">
            <label><?php echo $details['office_name'] ?></label>
        </div>
    </div>
    <div class="row show-grid">
        <div class="col-xs-4">
            <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_DEPARTMENT'); ?>:</label>
        </div>
        <div class="col-sm-4 col-xs-8">
            <label><?php echo $details['department_name'] ?></label>
        </div>
    </div>
    <div class="row show-grid">
        <div class="col-xs-4">
            <label class="control-label pull-right">Number of Pages:</label>
        </div>
        <div class="col-sm-4 col-xs-8">
            <label><?php echo $details['number_of_page'] ?></label>
        </div>
    </div>
</div>

<table class="table table-bordered table-responsive">
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
        $location=$this->config->item('system_image_base_url').$this->config->item('system_folder_upload').'/'.$details['id'].'/';
        foreach($files_info as $file)
        {
            ?>
            <tr>
                <td><?php echo $file['name']; ?></td>
            <?php
            if(substr($file['mime_type'],0,5)=='image')
            {
                ?>
                <td><img src="<?php echo $location.$file['name']; ?>" style="max-width: 250px;max-height:150px"></td>
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
                <td><a href="<?php echo $location.$file['name']; ?>" class="btn btn-success external" target="_blank"><?php echo $href_text; ?></a></td>
                <?php
            }
            ?>
            <td><?php echo System_helper::display_date($file['date_entry']); ?></td>
            <td><?php echo $file['remarks']; ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
