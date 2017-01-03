<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    $CI= & get_instance();
    $old_files='';
    foreach($stored_files as $index=>$file)
    {
        $old_files.=$file['id'].',';
        $file_url=$CI->config->item('system_upload_folder').'/'.$file['id_file_entry'].'/'.$file['name_after_upload'];
        ?>
        <tr>
            <td>
                <div class="preview_container_file" id="preview_container_file_<?php echo $index+1;?>">
                    <?php
                    if($file['is_image'])
                    {
                        ?>
                        <img style="max-width: 250px;" src="<?php echo base_url($file_url); ?>">
                    <?php
                    }
                    else
                    {
                        echo $file['name_after_upload'];
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
        <?php
            if(strlen($old_files)>0)
            {
                ?>
                $('.system_button_add').attr("data-current-id","<?php echo sizeof($stored_files); ?>");
                <?php
            }
            else
            {
                ?>
                $('.system_button_add').attr("data-current-id","0");
                <?php
            }
            if($file_entry_info['id_hc_location']>0)
            {
                ?>
                $('#id_hc_location').val("<?php echo $file_entry_info['id_hc_location']; ?>");
                $('#date_entry_text').val("<?php echo $file_entry_info['date_entry_text']; ?>");
                $('#remarks').val("<?php echo $file_entry_info['remarks']; ?>");
                <?php
            }
            else
            {
                ?>
                $('#id_hc_location').val("");
                $('#date_entry_text').val($('#date_entry_text').data('predefined_date'));
                $('#remarks').val("");
                <?php
            }
        ?>
        $('.browse_button').filestyle({input: false,icon: false,buttonText: "Edit",buttonName: "btn-primary"});
    });
</script>
