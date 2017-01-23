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
<form id="save_form" action="<?php echo site_url($CI->controller_url.'/index/save');?>" method="post">
    <input type="hidden" id="id" name="id" value="<?php echo $item['id']; ?>">
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
                <label for="id_office" class="control-label pull-right">
                    Office
                    <span style="color:#FF0000">*</span>
                </label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <select id="id_office" name="item[id_office]" class="form-control" tabindex="-1">
                    <option value=""><?php echo $this->lang->line('SELECT');?></option>
                    <?php
                    foreach($offices as $office)
                    {?>
                        <option value="<?php echo $office['value']?>" <?php if($office['value']==$item['id_office']){ echo 'selected';}?>><?php echo $office['text'];?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>

        <div style="<?php if(!($item['id_department']>0)){echo 'display:none';} ?>" class="row show-grid" id="department_container">
            <div class="col-xs-4">
                <label for="id_department" class="control-label pull-right">
                    Department
                    <span style="color:#FF0000">*</span></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <select id="id_department" name="item[id_department]" class="form-control" tabindex="-1">
                    <option value=""><?php echo $this->lang->line('SELECT');?></option>
                    <?php
                    foreach($departments as $department)
                    {?>
                        <option value="<?php echo $department['value']?>" <?php if($department['value']==$item['id_department']){ echo 'selected';}?>><?php echo $department['text'];?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>

        <div style="<?php if(!($item['employee_responsible']>0)){echo 'display: none';} ?>" class="row show-grid" id="employee_responsible_container">
            <div class="col-xs-4">
                <label for="employee_responsible" class="control-label pull-right">
                    Responsible Employee
                    <span style="color:#FF0000">*</span></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <select id="employee_responsible" name="item[employee_responsible]" class="form-control" tabindex="-1">
                    <option value=""><?php echo $this->lang->line('SELECT');?></option>
                    <?php
                    foreach($employees as $employee)
                    {?>
                        <option value="<?php echo $employee['value']?>" <?php if($employee['value']==$item['employee_responsible']){ echo 'selected';}?>><?php echo $employee['text'];?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>

        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label for="id_category" class="control-label pull-right">
                    <?php echo $CI->lang->line('LABEL_FILE_CATEGORY');?>
                    <span style="color:#FF0000">*</span>
                </label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <select id="id_category" class="form-control" tabindex="-1">
                    <option value=""><?php echo $this->lang->line('SELECT');?></option>
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

        <div style="<?php if(!($item['id_class']>0)){echo 'display:none';} ?>" class="row show-grid" id="class_container">
            <div class="col-xs-4">
                <label for="id_class" class="control-label pull-right">
                    <?php echo $CI->lang->line('LABEL_FILE_CLASS');?>
                    <span style="color:#FF0000">*</span></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <select id="id_class" class="form-control" tabindex="-1">
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
            <div class="col-xs-4">
                <label for="id_type" class="control-label pull-right">
                    <?php echo $CI->lang->line('LABEL_FILE_TYPE');?>
                    <span style="color:#FF0000">*</span>
                </label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <select id="id_type" name="item[id_type]" class="form-control">
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

        <div class="row show-grid">
            <div class="col-xs-4">
                <label for="id_hc_location" class="control-label pull-right">
                    <?php echo $CI->lang->line('LABEL_HC_LOCATION');?>
                    <span style="color:#FF0000">*</span>
                </label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <select id="id_hc_location" name="item[id_hc_location]" class="form-control">
                    <option value=""><?php echo $this->lang->line('SELECT');?></option>
                    <?php
                    foreach($hc_locations as $hc_location)
                    {?>
                        <option value="<?php echo $hc_location['value']?>" <?php if($hc_location['value']==$item['id_hc_location']){echo "selected";}?>><?php echo $hc_location['text'];?></option>
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
                    <span style="color:#FF0000">*</span></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <input type="text" name="item[name]" id="name" class="form-control" value="<?php echo $item['name'];?>"/>
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
                <input type="text" name="item[ordering]" id="ordering" class="form-control" value="<?php echo $item['ordering'] ?>" >
            </div>
        </div>

        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label for="date_start" class="control-label pull-right">
                    Start Date:
                    <span style="color:#FF0000">*</span>
                </label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <input type="text" name="item[date_start]" id="date_start" class="form-control datepicker" value="<?php echo $item['date_start'] ?>" >
            </div>
        </div>

        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label for="remarks" class="control-label pull-right">
                    Remarks
                    <span style="color:#FF0000">*</span>
                </label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <textarea name="item[remarks]" id="remarks" class="form-control"><?php echo $item['remarks'] ?></textarea>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</form>
<script type="text/javascript">
    $(document).off("click", "#id_office");
    $(document).off("click", "#id_department");
    $(document).off("click", "#employee_responsible");
    $(document).off("click", "#id_category");
    $(document).off("click", "#id_class");
    $(document).off("click", "#id_type");
    $(document).off("click", "#id_hc_location");
    jQuery(document).ready(function()
    {
        $(".datepicker").datepicker({dateFormat : display_date_format});
        $(document).on("change","#id_office",function()
        {
            $("#id_department").val("");
            $("#employee_responsible").val("");
            var id_office=$('#id_office').val();
            if(id_office>0)
            {
                $('#department_container').show();
                $('#employee_responsible_container').hide();
            }
            else
            {
                $('#department_container').hide();
                $('#employee_responsible_container').hide();
            }
        });
        $(document).on("change","#id_department",function()
        {
            $("#employee_responsible").val("");
            var id_office=$('#id_office').val();
            var id_department=$('#id_department').val();
            if(id_department>0)
            {
                $('#employee_responsible_container').show();
                $.ajax(
                    {
                        url: base_url+"common_controller/get_employees",
                        type: 'POST',
                        datatype: "JSON",
                        data:
                        {
                            html_container_id:'#employee_responsible',
                            id_department:id_department,
                            id_office:id_office
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
                $('#employee_responsible_container').hide();
            }
        });
        $(document).on("change","#id_category",function()
        {
            $("#id_class").val("");
            $("#id_type").val("");
            var id_category=$('#id_category').val();
            if(id_category>0)
            {
                $('#class_container').show();
                $('#type_container').hide();
                $.ajax(
                {
                    url: base_url+"common_controller/get_dropdown_with_select",
                    type: 'POST',
                    datatype: "JSON",
                    data:
                    {
                        html_container_id:'#id_class',
                        table:'<?php echo $CI->config->item('table_setup_file_class'); ?>',
                        table_column:'id_category',
                        table_column_value:id_category
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
            }
        });
        $(document).on("change","#id_class",function()
        {
            $("#id_type").val("");
            var id_class=$('#id_class').val();
            if(id_class>0)
            {
                $('#type_container').show();
                $.ajax(
                    {
                        url: base_url+"common_controller/get_dropdown_with_select",
                        type: 'POST',
                        datatype: "JSON",
                        data:
                        {
                            html_container_id:'#id_type',
                            table:'<?php echo $CI->config->item('table_setup_file_type'); ?>',
                            table_column:'id_class',
                            table_column_value:id_class
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
            }
        });
    });
</script>
