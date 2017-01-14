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
            <label class="control-label pull-right">File Name:</label>
        </div>
        <div class="col-sm-4 col-xs-8">
            <label><?php echo $details['name'] ?></label>
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
        $location=base_url($this->config->item('system_upload_folder').'/'.$details['id']);
        foreach($files_info as $file)
        {
            echo '<tr><td>'.$file['name'].'</td>';
            if(substr($file['mime_type'],0,5)=='image')
            {
                echo '<td><img src="'.$location.'/'.$file['name'].'" width="250" height="150"></td>';
            }
            else
            {
                echo '<td></td>';
            }
            echo '
                    <td>'.System_helper::display_date($file['date_entry']).'</td>
                    <td>'.$file['remarks'].'</td>
                ';
        }
        ?>
    </tbody>
</table>
