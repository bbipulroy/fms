<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    $CI= & get_instance();
?>
    <div style="overflow-x: auto;" class="row show-grid">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="min-width: 250px;">File/Picture</th>
                    <th style="min-width: 50px;">UPLOAD</th>
                    <th style="min-width: 100px;">Remarks</th>
                </tr>
            </thead>
            <tbody id="system_add_real_container">
            <?php
            $old_files='';
            foreach($stored_files as $index=>$file)
            {
                $old_files.=$file['id'].',';
                $file_url=$CI->config->item('system_upload_folder').'/'.$id.'/'.$file['name'];
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
                                <img style="max-width: 250px;" src="<?php echo base_url($file_url); ?>">
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
                        <input type="file" id="file_<?php echo $index+1; ?>" name="file_<?php echo $index+1; ?>" data-current-id="<?php echo $index+1; ?>" data-preview-container="#preview_container_file_<?php echo $index+1;?>" class="browse_button"><br>
                        <input id="file-<?php echo $index+1; ?>" type="hidden" name="files[<?php echo $file['id']; ?>]" value="">
                        <button type="button" class="btn btn-danger system_button_delete" data-current-id="<?php echo $index+1; ?>"><?php echo $CI->lang->line('DELETE'); ?></button>
                    </td>
                    <td>
                        <textarea name="remarks_old[<?php echo $file['id']; ?>]" class="form-control remarks"><?php echo $file['remarks']; ?></textarea>
                    </td>
                </tr>
            <?php
            }
            if(strlen($old_files)>0)
            {
                $old_files=substr($old_files,0,-1);
            }
            $CI->session->set_userdata('active_files',$old_files);
            ?>
            </tbody>
        </table>
    </div>
<div class="row show-grid">
    <div class="col-xs-4">

    </div>
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
    <div class="col-xs-4">

    </div>
</div>
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
                <textarea class="form-control remarks"></textarea>
            </td>
        </tr>
        </tbody>
    </table>
</div>

<script>
    jQuery(document).ready(function()
    {
        $(document).off("click",".system_button_add");
        $(document).off("click",".system_button_delete");
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
            $(content_id+' .remarks').attr('name','remarks['+current_id+']');

            var html=$(content_id).html();
            $('#system_add_real_container').append(html);

            $(content_id+' .browse_button_new').removeAttr('name');
            $(content_id+' .browse_button_new').removeAttr('data-preview-container');
            $(content_id+' .browse_button_new').removeAttr('id');
            $(content_id+' .browse_button_new').removeAttr('data-current-id');
            $(content_id+' .preview_container_file').removeAttr('id');
            $(content_id+' .remarks').removeAttr('name');

            $('#file_'+current_id).filestyle({input: false,icon: false,buttonText: "Upload",buttonName: "btn-primary"});
        });
        $(document).on("click", ".system_button_delete", function(event)
        {
            $(this).closest('tr').remove();
        });
    });
</script>
