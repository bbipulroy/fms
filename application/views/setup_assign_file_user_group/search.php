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
            <?php echo $title; ?>
        </div>
        <div class="clearfix"></div>
    </div>

    <div style="" class="row show-grid">
        <div class="col-xs-4">
            <label for="id_category" class="control-label pull-right">
                <?php echo $CI->lang->line('LABEL_FILE_CATEGORY');?>
                <span style="color:#FF0000">*</span>
            </label>
        </div>
        <div class="col-sm-4 col-xs-8">
            <select id="id_category" class="form-control" data-id-user-group="<?php echo $item_id; ?>" tabindex="-1">
                <option value=""><?php echo $this->lang->line('SELECT');?></option>
                <?php
                foreach($categories as $category)
                {
                    ?>
                    <option value="<?php echo $category['value']; ?>"><?php echo $category['text']; ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>
    <br/>
    <div id="edit_form"></div>
</div>

<script>
    jQuery(document).ready(function()
    {
        $(document).off("change", "#id_category");
        $(document).off("click", ".system-prevent-click");
        $(document).on("change","#id_category",function()
        {
            var id_category=$('#id_category').val();
            if(id_category>0)
            {
                $.ajax(
                    {
                        url: '<?php echo site_url($CI->controller_url.'/index/edit'); ?>',
                        type: 'POST',
                        datatype: "JSON",
                        data:
                        {
                            id_category:id_category,
                            id_user_group:$(this).attr("data-id-user-group")
                        },
                        success: function (data, status)
                        {

                        },
                        error: function (xhr, desc, err)
                        {
                            console.log("error");
                        }
                    });
            }
            else
            {
                $('#edit_form').empty();
            }
        });
        $(document).on('click','.system-prevent-click',function()
        {
            var obj=$(this);
            if(obj.is(':checked'))
            {
                var attr_data_type=obj.attr('data-type');
                $('.'+attr_data_type+obj.attr('data-id')).prop('checked',true);
                if(attr_data_type!='action')
                {
                    $('.'+attr_data_type+obj.attr('data-id')+'.action3').prop('checked',false);
                    $('.'+attr_data_type+obj.attr('data-id')+'.action2').prop('checked',false);
                }
            }
            else
            {
                $('.'+obj.attr('data-type')+obj.attr('data-id')).prop('checked',false);
            }
        });
    });
</script>
