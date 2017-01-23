<script>
    jQuery(document).ready(function()
    {
        var input_obj;
        var label_obj;
        var tr_obj;
        var remarks_obj;
        var date_entry_obj;
        var delete_obj;
        var preview_obj;
        <?php
            $CI= & get_instance();
            $location=$CI->config->item('system_image_base_url').$id.'/';
            foreach($upload_files as $key=>$value)
            {
                ?>
                input_obj=$('#<?php echo $key; ?>');
                label_obj=input_obj.next().find('label');
                <?php
                if($value['status']==true)
                {
                    $input='<input name="files['.$value['insert_id'].']" value="" type="hidden">';
                    if(substr($value['info']['file_type'],0,5)=='image')
                    {
                        $html='<img style="max-width: 250px;" src="'.$location.$value['info']['file_name'].'">';
                    }
                    else
                    {
                        $html='<a href="'.$location.$value['info']['file_name'].'" class="external" target="_blank">'.$value['info']['file_name'].'</a>';
                    }
                    ?>
                    tr_obj=input_obj.closest('tr');
                    preview_obj=tr_obj.find('.preview_container_file');
                    preview_obj.html('<?php echo $html; ?>');
                    date_entry_obj=tr_obj.find('.date_entry');
                    remarks_obj=tr_obj.find('.remarks');
                    delete_obj=tr_obj.find('.system_button_delete');
                    <?php
                    if($CI->is_edit && $CI->is_delete)
                    {
                        ?>
                        input_obj.val('');
                        input_obj.closest('td').append('<?php echo $input; ?>');
                        $('input[name="files[<?php echo $value['insert_id']; ?>]"]').attr("id","file-"+input_obj.attr("data-current-id"));
                        label_obj.html('Edit');
                        date_entry_obj.attr('name','date_entry_old['+<?php echo $value['insert_id']; ?>+']');
                        remarks_obj.attr('name','remarks_old['+<?php echo $value['insert_id']; ?>+']');
                        <?php
                    }
                    elseif($CI->is_edit)
                    {
                        $input='<input name="files['.$value['insert_id'].']" value="" type="hidden">';
                        ?>
                        input_obj.val('');
                        input_obj.closest('td').append('<?php echo $input; ?>');
                        $('input[name="files[<?php echo $value['insert_id']; ?>]"]').attr("id","file-"+input_obj.attr("data-current-id"));
                        label_obj.html('Edit');
                        date_entry_obj.attr('name','date_entry_old['+<?php echo $value['insert_id']; ?>+']');
                        remarks_obj.attr('name','remarks_old['+<?php echo $value['insert_id']; ?>+']');
                        delete_obj.remove();
                        <?php
                    }
                    elseif($CI->is_delete)
                    {
                        ?>
                        input_obj.closest('td').append('<?php echo $input; ?>');
                        $('input[name="files[<?php echo $value['insert_id']; ?>]"]').attr("id","file-"+input_obj.attr("data-current-id"));
                        input_obj.remove();
                        label_obj.remove();
                        date_entry_obj.attr("disabled",true);
                        remarks_obj.attr("disabled",true);
                        <?php
                    }
                    elseif($CI->is_add)
                    {
                        ?>
                        input_obj.remove();
                        label_obj.remove();
                        delete_obj.remove();
                        date_entry_obj.attr("disabled",true);
                        remarks_obj.attr("disabled",true);
                        <?php
                    }
                }
                else
                {
                    ?>
                    label_obj.html('Incomplete');
                    label_obj.attr("class","btn btn-success");
                    <?php
                }
            }
        ?>
    });
</script>
