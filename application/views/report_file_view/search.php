<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$CI= & get_instance();
?>
<form id="save_form" action="<?php echo site_url($CI->controller_url.'/index/list');?>" method="post">
    <div class="row widget">
        <div class="widget-header">
            <div class="title">
                <?php echo $title; ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="row">
            <div class="col-xs-6">
                <div style="" class="row show-grid">
                    <div class="col-xs-6">
                        <label for="id_category" class="control-label pull-right">
                            <?php echo $CI->lang->line('LABEL_FILE_CATEGORY');?>
                            <span style="color:#FF0000">*</span>
                        </label>
                    </div>
                    <div class="col-xs-6">
                        <select name="item[id_category]" id="id_category" class="form-control system_report_empty" tabindex="-1">
                            <?php
                            foreach($categories as $category)
                            {?>
                                <option value="<?php echo $category['value']?>" <?php if($category['value']==$item['id_category']){ echo 'selected';}?>><?php echo $category['text'];?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div style="<?php if(!($item['id_sub_category']>0)){echo 'display:none';} ?>" class="row show-grid" id="sub_category_container">
                    <div class="col-xs-6">
                        <label for="id_sub_category" class="control-label pull-right">
                            <?php echo $CI->lang->line('LABEL_FILE_SUB_CATEGORY');?>
                        </label>
                    </div>
                    <div class="col-xs-6">
                        <select name="item[id_sub_category]" id="id_sub_category" class="form-control system_report_empty" tabindex="-1">
                            <option value=""><?php echo $this->lang->line('SELECT');?></option>
                            <?php
                            foreach($sub_categories as $sub_category)
                            {?>
                                <option value="<?php echo $sub_category['value']?>" <?php if($sub_category['value']==$item['id_sub_category']){ echo 'selected';}?>><?php echo $sub_category['text'];?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div style="<?php if(!($item['id_class']>0)){echo 'display:none';} ?>" class="row show-grid" id="class_container">
                    <div class="col-xs-6">
                        <label for="id_class" class="control-label pull-right">
                            <?php echo $CI->lang->line('LABEL_FILE_CLASS');?>
                        </label>
                    </div>
                    <div class="col-xs-6">
                        <select name="item[id_class]" id="id_class" class="form-control system_report_empty" tabindex="-1">
                            <option value=""><?php echo $this->lang->line('SELECT');?></option>
                            <?php
                            foreach($classes as $class)
                            {?>
                                <option value="<?php echo $class['value']?>" <?php if($class['value']==$item['id_class']){ echo 'selected';}?>><?php echo $class['text'];?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div style="<?php if(!($item['id_type']>0)){echo 'display:none';} ?>" class="row show-grid" id="type_container">
                    <div class="col-xs-6">
                        <label for="id_type" class="control-label pull-right">
                            <?php echo $CI->lang->line('LABEL_FILE_TYPE');?>
                        </label>
                    </div>
                    <div class="col-xs-6">
                        <select name="item[id_type]" id="id_type" class="form-control system_report_empty">
                            <option value=""><?php echo $this->lang->line('SELECT');?></option>
                            <?php
                            foreach($types as $type)
                            {?>
                                <option value="<?php echo $type['value']?>" <?php if($type['value']==$item['id_type']){echo "selected";}?>><?php echo $type['text'];?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-xs-6">
                <div style="" class="row show-grid">
                    <div class="col-xs-6">
                        <select name="report_name" id="report_name" class="form-control system_report_empty" tabindex="-1">
                            <option value="files_list">Files List</option>
                            <option value="file_items_list">File Items List</option>
                        </select>
                    </div>
                    <div class="col-xs-6">
                        <label for="report_name" class="control-label pull-left">
                            <span style="color:#FF0000">*</span>
                            <?php echo 'Report Type'; ?>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row show-grid">
            <div class="col-xs-7"></div>
            <div class="col-xs-5">
                <button class="btn btn-success" id="button_action_report" data-form="#save_form">
                    View Report
                </button>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</form>
<div id="system_report_container">

</div>
<script type="text/javascript">
    jQuery(document).ready(function()
    {
        $(document).off("change","#id_category");
        $(document).off("change","#id_sub_category");
        $(document).off("change","#id_class");
        $(document).off("change","#id_type");
        $(document).off("click","#button_action_report");
        $(document).off("change", ".system_report_empty");

        $(document).on("change",".system_report_empty",function(e)
        {
            $('#system_report_container').html('');
        });
        $(document).on("change","#id_category",function()
        {
            $("#id_sub_category").val("");
            $("#id_class").val("");
            $("#id_type").val("");
            $("#id_name").val("");
            var id_category=$('#id_category').val();
            if(id_category>0)
            {
                $('#sub_category_container').show();
                $('#class_container').hide();
                $('#type_container').hide();
                $('#name_container').hide();
                $.ajax(
                    {
                        url: '<?php echo site_url('common_controller/get_sub_categories_by_category_id'); ?>',
                        type: 'POST',
                        datatype: "JSON",
                        data:
                        {
                            html_container_id:'#id_sub_category',
                            id_category:id_category
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
                $('#sub_category_container').hide();
                $('#class_container').hide();
                $('#type_container').hide();
                $('#name_container').hide();
            }
        });
        $(document).on("change","#id_sub_category",function()
        {
            $("#id_class").val("");
            $("#id_type").val("");
            $("#id_name").val("");
            var id_sub_category=$('#id_sub_category').val();
            if(id_sub_category>0)
            {
                $('#class_container').show();
                $('#type_container').hide();
                $('#name_container').hide();
                $.ajax(
                    {
                        url: '<?php echo site_url('common_controller/get_classes_by_sub_category_id'); ?>',
                        type: 'POST',
                        datatype: "JSON",
                        data:
                        {
                            html_container_id:'#id_class',
                            id_sub_category:id_sub_category
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
                $('#class_container').hide();
                $('#type_container').hide();
                $('#name_container').hide();
            }
        });
        $(document).on("change","#id_class",function()
        {
            $("#id_type").val("");
            $("#id_name").val("");
            var id_class=$('#id_class').val();
            if(id_class>0)
            {
                $('#type_container').show();
                $('#name_container').hide();
                $.ajax(
                    {
                        url: '<?php echo site_url('common_controller/get_types_by_class_id'); ?>',
                        type: 'POST',
                        datatype: "JSON",
                        data:
                        {
                            html_container_id:'#id_type',
                            id_class:id_class
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
                $('#type_container').hide();
                $('#name_container').hide();
            }
        });
    });
</script>
