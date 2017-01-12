<script>
    jQuery(document).ready(function()
    {
        var label_obj;
        var input_id;
        var textarea_obj;
        <?php
            $CI= & get_instance();
            foreach($upload_files as $key=>$value)
            {
                ?>label_obj=$('#<?php echo $key; ?>').next().find('label');<?php
                if($value['status']==true)
                {
                    ?>
                    input_id=$('#<?php echo $key; ?>');
                    <?php
                    if(isset($CI->permissions['action2']) && ($CI->permissions['action2']==1))
                    {
                        $input='<input name="files['.$value['insert_id'].']" value="" type="hidden">';
                        ?>input_id.val('');
                        input_id.closest('td').append('<?php echo $input; ?>');
                        $('input[name="files[<?php echo $value['insert_id']; ?>]"]').attr("id","file-"+input_id.attr("data-current-id"));
                        label_obj.html('Edit');
                        label_obj.attr("class","btn btn-primary");
                        textarea_obj=input_id.closest('tr').find('td').eq(2).find('textarea');
                        textarea_obj.attr('name','remarks_old['+<?php echo $value['insert_id']; ?>+']');
                        <?php
                    }
                    else
                    {
                        ?>input_id.closest('tr').remove();<?php
                    }
                    ?>
                    <?php
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
