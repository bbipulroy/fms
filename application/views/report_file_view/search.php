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

        <div class="col-xs-6">
            <!--<div style="" class="row show-grid">
                <div class="col-xs-6">
                    <label for="year" class="control-label pull-right">
                        Year
                    </label>
                </div>
                <div class="col-xs-6">
                    <select name="items[year]" id="year" class="form-control" tabindex="-1">
                        <option value=""><?php /*echo $this->lang->line('SELECT');*/?></option>
                        <?php
/*                        for($i=date('Y');$i>(date('Y')-6);--$i)
                        {*/?>
                            <option value="<?php /*echo $i; */?>" <?php /*if($i==$items['year']){ echo 'selected';}*/?>><?php /*echo $i; */?></option>
                        <?php
/*                        }
                        */?>
                    </select>
                </div>
            </div>-->

            <div style="" class="row show-grid">
                <div class="col-xs-6">
                    <label for="id_category" class="control-label pull-right">
                        <?php echo $CI->lang->line('LABEL_FILE_CATEGORY');?>
                    </label>
                </div>
                <div class="col-xs-6">
                    <select name="items[id_category]" id="id_category" class="form-control" tabindex="-1">
                        <option value=""><?php echo $this->lang->line('SELECT');?></option>
                        <?php
                        foreach($categories as $category)
                        {?>
                            <option value="<?php echo $category['value']?>" <?php if($category['value']==$items['id_category']){ echo 'selected';}?>><?php echo $category['text'];?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div style="<?php if(!($items['id_class']>0)){echo 'display:none';} ?>" class="row show-grid" id="class_container">
                <div class="col-xs-6">
                    <label for="id_class" class="control-label pull-right">
                        <?php echo $CI->lang->line('LABEL_FILE_CLASS');?>
                </div>
                <div class="col-xs-6">
                    <select name="items[id_class]" id="id_class" class="form-control" tabindex="-1">
                        <option value=""><?php echo $this->lang->line('SELECT');?></option>
                        <?php
                        foreach($classes as $class)
                        {?>
                            <option value="<?php echo $class['value']?>" <?php if($class['value']==$items['id_class']){ echo 'selected';}?>><?php echo $class['text'];?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div style="<?php if(!($items['id_type']>0)){echo 'display:none';} ?>" class="row show-grid" id="type_container">
                <div class="col-xs-6">
                    <label for="id_type" class="control-label pull-right">
                        <?php echo $CI->lang->line('LABEL_FILE_TYPE');?>
                    </label>
                </div>
                <div class="col-xs-6">
                    <select name="items[id_type]" id="id_type" class="form-control">
                        <option value=""><?php echo $this->lang->line('SELECT');?></option>
                        <?php
                        foreach($types as $type)
                        {?>
                            <option value="<?php echo $type['value']?>" <?php if($type['value']==$items['id_type']){echo "selected";}?>><?php echo $type['text'];?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div style="<?php if(!($items['id_name']>0)){echo 'display:none';} ?>" class="row show-grid" id="name_container">
                <div class="col-xs-6">
                    <label for="id_name" class="control-label pull-right">
                        <?php echo $CI->lang->line('LABEL_FILE_NAME');?>
                    </label>
                </div>
                <div class="col-xs-6">
                    <select name="items[id_name]" id="id_name" class="form-control">
                        <option value=""><?php echo $this->lang->line('SELECT');?></option>
                        <?php
                        foreach($names as $name)
                        {?>
                            <option value="<?php echo $name['value']?>" <?php if($name['value']==$items['id_name']){echo "selected";}?>><?php echo $name['text'];?></option>
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
                    <select name="items[id_office]" id="id_office" class="form-control" tabindex="-1">
                        <option value=""><?php echo $this->lang->line('SELECT');?></option>
                        <?php
                        foreach($offices as $office)
                        {?>
                            <option value="<?php echo $office['value']?>" <?php if($office['value']==$items['id_office']){ echo 'selected';}?>><?php echo $office['text'];?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-xs-6">
                    <label for="id_office" class="control-label pull-left">
                        Office
                    </label>
                </div>
            </div>

            <div style="<?php if(!($items['id_department']>0)){echo 'display:none';} ?>" class="row show-grid" id="department_container">
                <div class="col-xs-6">
                    <select name="items[id_department]" id="id_department" class="form-control" tabindex="-1">
                        <option value=""><?php echo $this->lang->line('SELECT');?></option>
                        <?php
                        foreach($departments as $department)
                        {?>
                            <option value="<?php echo $department['value']?>" <?php if($department['value']==$items['id_department']){ echo 'selected';}?>><?php echo $department['text'];?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-xs-6">
                    <label for="id_department" class="control-label pull-left">
                        Department
                    </label>
                </div>
            </div>

            <div style="<?php if(!($items['employee_responsible']>0)){echo 'display: none';} ?>" class="row show-grid" id="employee_responsible_container">
                <div class="col-xs-6">
                    <select name="items[employee_responsible]" id="employee_responsible" class="form-control" tabindex="-1">
                        <option value=""><?php echo $this->lang->line('SELECT');?></option>
                        <?php
                        foreach($employees as $employee)
                        {?>
                            <option value="<?php echo $employee['value']?>" <?php if($employee['value']==$items['employee_responsible']){ echo 'selected';}?>><?php echo $employee['text'];?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-xs-6">
                    <label for="employee_responsible" class="control-label pull-left">
                        Responsible Employee
                </div>
            </div>

            <div style="" class="row show-grid">
                <div class="col-xs-6">
                    <input name="items[date_start]" type="text" id="date_start" class="form-control datepicker" value="<?php echo $items['date_start'] ?>" placeholder="Start Date">
                </div>
                <div class="col-xs-6">
                    <label for="date_start" class="control-label pull-left">
                        Start Date
                    </label>
                </div>
            </div>

            <div style="" class="row show-grid">
                <div class="col-xs-6">
                    <input name="items[date_end]" type="text" id="date_end" class="form-control datepicker" value="<?php echo $items['date_end'] ?>" placeholder="End Date">
                </div>
                <div class="col-xs-6">
                    <label for="date_end" class="control-label pull-left">
                        End Date
                    </label>
                </div>
            </div>
        </div>

        <div class="row show-grid">
            <div class="col-xs-3"></div>
            <div class="col-xs-6" id="report_parameters_info"></div>
            <div class="col-xs-3"></div>
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
        $(document).off("change","#id_office");
        $(document).off("change","#id_department");
        $(document).off("change","#employee_responsible");
        $(document).off("change","#id_category");
        $(document).off("change","#id_class");
        $(document).off("change","#id_type");
        $(document).off("change","#id_name");
        $(document).off("click","#button_action_report");

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
                            id_department:id_department
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
            $("#id_name").val("");
            var id_class=$('#id_class').val();
            if(id_class>0)
            {
                $('#type_container').show();
                $('#name_container').hide();
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
                $('#name_container').hide();
            }
        });
        $(document).on("change","#id_type",function()
        {
            $("#id_name").val("");
            var id_type=$('#id_type').val();
            if(id_type>0)
            {
                $('#name_container').show();
                $.ajax(
                    {
                        url: base_url+"common_controller/get_dropdown_with_select",
                        type: 'POST',
                        datatype: "JSON",
                        data:
                        {
                            html_container_id:'#id_name',
                            table:'<?php echo $CI->config->item('table_setup_file_name'); ?>',
                            table_column:'id_type',
                            table_column_value:id_type
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
                $('#name_container').hide();
            }
        });
    });
</script>
