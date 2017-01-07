<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    $CI= & get_instance();
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
                <button type="button" class="btn btn-danger system_button_delete file_old" data-current-id="<?php echo $index+1; ?>"><?php echo $CI->lang->line('DELETE'); ?></button>
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
<script>
    jQuery(document).ready(function()
    {
        turn_off_triggers();
        $('.system_button_add').attr("data-current-id","<?php echo sizeof($stored_files); ?>");
        $('.browse_button').filestyle({input: false,icon: false,buttonText: "Edit",buttonName: "btn-primary"});
    });
</script>
