<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$CI = & get_instance();
$action_data=array();
$action_data['action_back']=site_url($CI->controller_url);
$action_data['action_save']='#save_form';
$action_data['action_save_new']='#save_form';
$action_data['action_clear']='#save_form';
$CI->load->view('action_buttons',$action_data);
?>
<form class="form_valid" id="save_form" action="<?php echo site_url($CI->controller_url.'/index/save');?>" method="post">
    <input type="hidden" id="id" name="id" value="<?php echo $items['id']; ?>">
    <input type="hidden" id="system_save_new_status" name="system_save_new_status" value="0">
    <div class="row widget">
        <div class="widget-header">
            <div class="title">
                <?php echo $title; ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label for="id_file_type_1" class="control-label pull-right">
                    <?php echo $CI->lang->line('LABEL_FILE_TYPE_1');?>
                    <span style="color:#FF0000">*</span>
                </label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <select id="id_file_type_1" name="items[id_file_type_1]" class="form-control" tabindex="-1">
                    <option value=""><?php echo $this->lang->line('SELECT');?></option>
                    <?php
                    foreach($file_type_1s as $file_type_1)
                    {?>
                        <option value="<?php echo $file_type_1['value']?>" <?php if($file_type_1['value']==$items['id_file_type_1']){ echo 'selected';}?>><?php echo $file_type_1['text'];?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>

        <div style="<?php if(!($items['id_file_type_2']>0)){echo 'display:none';} ?>" class="row show-grid" id="id_file_type_2_container">
            <div class="col-xs-4">
                <label for="id_file_type_2" class="control-label pull-right">
                    <?php echo $CI->lang->line('LABEL_FILE_TYPE_2');?>
                    <span style="color:#FF0000">*</span>
                </label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <select id="id_file_type_2" name="items[id_file_type_2]" class="form-control">
                    <option value=""><?php echo $this->lang->line('SELECT');?></option>
                    <?php
                    foreach($file_type_2s as $file_type_2)
                    {?>
                        <option value="<?php echo $file_type_2['value']?>" <?php if($file_type_2['value']==$items['id_file_type_2']){echo "selected";}?>><?php echo $file_type_2['text'];?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="row show-grid">
            <div class="col-xs-4">
                <label for="name" class="control-label pull-right">
                    <?php echo $this->lang->line('LABEL_NAME');?>
                    <span style="color:#FF0000">*</span>
                </label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <input type="text" name="items[name]" id="name" class="form-control" value="<?php echo $items['name'];?>"/>
            </div>
        </div>

        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label for="ordering" class="control-label pull-right">
                    <?php echo $CI->lang->line('LABEL_ORDER');?>
                    <span style="color:#FF0000">*</span>
                </label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <input type="text" name="items[ordering]" id="ordering" class="form-control" value="<?php echo $items['ordering'] ?>" >
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</form>
<script type="text/javascript">
    jQuery(document).ready(function()
    {
        turn_off_triggers();
        $(document).on("change","#id_file_type_1",function()
        {
            $("#id_file_type_2").val("");
            var id_file_type_1=$('#id_file_type_1').val();
            if(id_file_type_1>0)
            {
                $('#id_file_type_2_container').show();
                $.ajax(
                {
                    url: base_url+"common_controller/get_dropdown_with_select",
                    type: 'POST',
                    datatype: "JSON",
                    data:
                    {
                        html_container_id:'#id_file_type_2',
                        table:'<?php echo $CI->config->item('table_setup_file_type_2'); ?>',
                        table_column:'id_file_type_1',
                        table_column_value:id_file_type_1
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
                $('#id_file_type_2_container').hide();
            }
        });
    });
</script>
