<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$CI= & get_instance();
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
            <label class="control-label pull-right">File Name:</label>
        </div>
        <div class="col-sm-4 col-xs-8">
            <label><?php echo $details['name'] ?></label>
        </div>
    </div>
    <div class="row show-grid">
        <div class="col-xs-4">
            <label class="control-label pull-right">Responsible Employee:</label>
        </div>
        <div class="col-sm-4 col-xs-8">
            <label><?php echo $details['employee_name'] ?></label>
        </div>
    </div>
    <div class="row show-grid">
        <div class="col-xs-4">
            <label class="control-label pull-right">Hardcopy Location:</label>
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
            <label class="control-label pull-right">File Category:</label>
        </div>
        <div class="col-sm-4 col-xs-8">
            <label><?php echo $details['category_name'] ?></label>
        </div>
    </div>
    <div class="row show-grid">
        <div class="col-xs-4">
            <label class="control-label pull-right">File Class:</label>
        </div>
        <div class="col-sm-4 col-xs-8">
            <label><?php echo $details['class_name'] ?></label>
        </div>
    </div>
    <div class="row show-grid">
        <div class="col-xs-4">
            <label class="control-label pull-right">File Type:</label>
        </div>
        <div class="col-sm-4 col-xs-8">
            <label><?php echo $details['type_name'] ?></label>
        </div>
    </div>
    <div class="row show-grid">
        <div class="col-xs-4">
            <label class="control-label pull-right">Office:</label>
        </div>
        <div class="col-sm-4 col-xs-8">
            <label><?php echo $details['office_name'] ?></label>
        </div>
    </div>
    <div class="row show-grid">
        <div class="col-xs-4">
            <label class="control-label pull-right">Department:</label>
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
            <label><?php echo $details['file_total'] ?></label>
        </div>
    </div>
</div>

<table class="table table-bordered table-responsive">
    <thead>
    <tr>
        <th>File Name</th>
        <th>Picture/Thumbnail</th>
        <th>Entry Date</th>
        <th>Remarks</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $location=$this->config->item('system_image_base_url').$details['id'].'/';
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
