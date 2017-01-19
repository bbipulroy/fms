<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$CI= & get_instance();
$action_data=array();
$action_data['action_back']=site_url($CI->controller_url);
$action_data['action_refresh']=site_url($CI->controller_url.'/index/edit/'.$items['id']);
$action_data['action_save']='#save_form';
$CI->load->view('action_buttons',$action_data);
?>
<form class="form_valid" id="save_form" action="<?php echo site_url($CI->controller_url.'/index/save');?>" method="post">
    <input type="hidden" name="id" value="<?php echo $items['id']; ?>">
    <input type="hidden" id="system_save_new_status" name="system_save_new_status" value="0">
    <div class="row widget">
        <div class="widget-header">
            <div class="title">
                Entry pages in <?php echo $items['name']; ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right">File Name:</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label><?php echo $items['name'] ?></label>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right">File Category:</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label><?php echo $items['category_name'] ?></label>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right">File Class:</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label><?php echo $items['class_name'] ?></label>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right">File Type:</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label><?php echo $items['type_name'] ?></label>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right">Number of Pages:</label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label><?php echo $items['file_total'] ?></label>
            </div>
        </div>

        <div id="files_container">
            <div style="overflow-x: auto;" class="row show-grid">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="min-width: 250px;">File/Picture</th>
                        <th style="min-width: 50px;">UPLOAD</th>
                        <th style="min-width: 50px;">Entry Date</th>
                        <th style="min-width: 100px;">Remarks</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $old_files='';
                        $location=$CI->config->item('system_image_base_url').$items['id'].'/';
                        foreach($stored_files as $index=>$file)
                        {
                            $old_files.=$file['id'].',';
                            $is_image=false;
                            if(substr($file['mime_type'],0,5)=='image')
                            {
                                $is_image=true;
                            }
                            ?>
                            <tr>
                                <td>
                                    <div class="preview_container_file" id="preview_container_file_<?php echo $index+1;?>">
                                        <?php
                                        if($is_image)
                                        {
                                            ?>
                                            <img style="max-width: 250px;" src="<?php echo $location.$file['name']; ?>">
                                        <?php
                                        }
                                        else
                                        {
                                            echo $file['name'];
                                        }
                                        ?>
                                    </div>
                                </td>
                                <td>
                                    <?php
                                        if($CI->is_edit)
                                        {
                                            ?>
                                            <input type="file" id="file_<?php echo $index+1; ?>" name="file_<?php echo $index+1; ?>" data-current-id="<?php echo $index+1; ?>" data-preview-container="#preview_container_file_<?php echo $index+1;?>" class="browse_button"><br>
                                            <?php
                                        }
                                        if($CI->is_edit || $CI->is_delete)
                                        {
                                            ?>
                                            <input id="file-<?php echo $index+1; ?>" type="hidden" name="files[<?php echo $file['id']; ?>]" value="">
                                            <?php
                                        }
                                        if($CI->is_delete)
                                        {
                                            ?>
                                            <button type="button" class="btn btn-danger system_button_delete" data-current-id="<?php echo $index+1; ?>"><?php echo $CI->lang->line('DELETE'); ?></button>
                                            <?php
                                        }
                                    ?>
                                </td>
                                <td>
                                    <input type="text" name="date_entry_old[<?php echo $file['id']; ?>]" class="form-control datepicker date_entry" value="<?php echo System_helper::display_date($file['date_entry']); ?>" <?php if(!$CI->is_edit){echo 'disabled';} ?>>
                                </td>
                                <td>
                                    <textarea name="remarks_old[<?php echo $file['id']; ?>]" class="form-control remarks" <?php if(!$CI->is_edit){echo 'disabled';} ?>><?php echo $file['remarks']; ?></textarea>
                                </td>
                            </tr>
                        <?php
                        }
                        if($CI->is_edit || $CI->is_delete)
                        {
                            if(strlen($old_files)>0)
                            {
                                $old_files=substr($old_files,0,-1);
                            }
                            $CI->session->set_userdata('active_files',$old_files);
                        }
                    ?>
                    </tbody>
                </table>
            </div>
            <?php
                if($CI->is_add)
                {
                    ?>
                    <div class="row show-grid">
                        <div class="col-xs-4"></div>
                        <div class="col-xs-4">
                            <button type="button" class="btn btn-warning system_button_add" data-current-id="<?php echo sizeof($stored_files); ?>">
                                <?php echo $CI->lang->line('LABEL_ADD_MORE'); ?>
                            </button>
                            <!--<button id="camera" type="button" class="btn btn-warning">
                                Camera
                            </button>
                            <button id="take-photo" type="button" class="btn btn-warning">
                                Take Photo
                            </button>
                            <button id="camera-close" type="button" class="btn btn-warning">
                                Camera Off
                            </button>-->
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

<div id="system_content_add" style="display: none;">
    <table>
        <tbody>
        <tr>
            <td>
                <div class="preview_container_file">
                </div>
            </td>
            <td>
                <input type="file" class="browse_button_new"><br>
                <button type="button" class="btn btn-danger system_button_delete"><?php echo $CI->lang->line('DELETE'); ?></button>
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

<div class="row show-grid">
    <div class="col-xs-12">
        <video id="video" width="1000" height="600" controls autoplay></video>
    </div>
</div>
<script type="text/javascript">
    var camera_stream;
    function camera_on()
    {
        $('video').show();
        if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia)
        {
            navigator.mediaDevices.getUserMedia(
            {
                video:true
            })
            .then(function(stream)
            {
                camera_stream=stream;
                video.src=window.URL.createObjectURL(stream);
                video.play();
            });
        }
    }
    jQuery(document).ready(function()
    {
        $('video').hide();
        $(document).off("click",".system_button_add");
        $(document).off("click",".system_button_delete");
        $('.datepicker').datepicker({dateFormat : display_date_format});
        $('.browse_button').filestyle({input: false,icon: false,buttonText: "Edit",buttonName: "btn-primary"});
        $(document).on("click", ".system_button_add", function(event)
        {
            var current_id=parseInt($('.system_button_add').attr('data-current-id'))+1;
            $('.system_button_add').attr('data-current-id',current_id);
            var content_id='#system_content_add table tbody';

            $(content_id+' .browse_button_new').attr('data-preview-container','#preview_container_file_'+current_id);
            $(content_id+' .browse_button_new').attr('name','file_'+current_id);
            $(content_id+' .browse_button_new').attr('id','file_'+current_id);
            $(content_id+' .browse_button_new').attr('data-current-id',current_id);
            $(content_id+' .preview_container_file').attr('id','preview_container_file_'+current_id);
            $(content_id+' .date_entry').attr('name','date_entry['+current_id+']');
            $(content_id+' .date_entry').attr('id','date_entry_'+current_id);
            $(content_id+' .remarks').attr('name','remarks['+current_id+']');

            var html=$(content_id).html();
            $('#files_container table tbody').append(html);

            $(content_id+' .browse_button_new').removeAttr('name');
            $(content_id+' .browse_button_new').removeAttr('data-preview-container');
            $(content_id+' .browse_button_new').removeAttr('id');
            $(content_id+' .browse_button_new').removeAttr('data-current-id');
            $(content_id+' .preview_container_file').removeAttr('id');
            $(content_id+' .date_entry').removeAttr('name');
            $(content_id+' .date_entry').removeAttr('id');
            $(content_id+' .remarks').removeAttr('name');

            $('#file_'+current_id).filestyle({input: false,icon: false,buttonText: "Upload",buttonName: "btn-primary"});
            $('#date_entry_'+current_id).datepicker({dateFormat : display_date_format});
        });
        $(document).on("click", ".system_button_delete", function(event)
        {
            $(this).closest('tr').remove();
        });
        $(document).on('click','#camera',function()
        {
            if(camera.data('check'))
            {
                camera_off();
                camera.data('check',false);
                take_photo.hide();
            }
            else
            {
                take_photo.show();
                camera.data('check',true);
                if(camera.data('no_need_to_on'))
                {
                    camera_on_false();
                }
                else
                {
                    camera_on();
                    camera.data('no_need_to_on',true);
                }
            }
        });
        $(document).on('click','#take-photo',function()
        {
            var canvas=document.createElement("canvas");
            canvas.width=video.videoWidth;
            canvas.height=video.videoHeight;
            canvas.getContext('2d').drawImage(video,0,0,canvas.width,canvas.height);
            var image_data=canvas.toDataURL();
            alert(image_data);
        });
        $(document).on('click','#camera-close',function()
        {
            camera_off();
            take_photo.hide();
            camera_stream.stop();
            camera.data('no_need_to_on',false);
        });
        function camera_off()
        {
            $('video').hide();
            video.pause();
        }
        function camera_on_false()
        {
            $('video').show();
            video.play();
        }
    });
</script>
<div id="upload-complete-info"></div>
