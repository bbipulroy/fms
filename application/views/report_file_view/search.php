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

                <div style="<?php if(!($item['id_name']>0)){echo 'display:none';} ?>" class="row show-grid" id="name_container">
                    <div class="col-xs-6">
                        <label for="id_name" class="control-label pull-right">
                            <?php echo $CI->lang->line('LABEL_FILE_NAME');?>
                        </label>
                    </div>
                    <div class="col-xs-6">
                        <select name="item[id_name]" id="id_name" class="form-control system_report_empty">
                            <option value=""><?php echo $this->lang->line('SELECT');?></option>
                            <?php
                            foreach($names as $name)
                            {?>
                                <option value="<?php echo $name['value']?>" <?php if($name['value']==$item['id_name']){echo "selected";}?>><?php echo $name['text'];?></option>
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
                            <option value="list_files">List Files Only Wise</option>
                            <option value="list_with_files_info">List with Files Information Wise</option>
                            <option value="list_file_items">List Files Item Wise</option>
                        </select>
                    </div>
                    <div class="col-xs-6">
                        <label for="report_name" class="control-label pull-left">
                            <span style="color:#FF0000">*</span>
                            <?php echo 'Report Type'; ?>
                        </label>
                    </div>
                </div>
                <div style="" class="row show-grid">
                    <div class="col-xs-6">
                        <select name="item[id_company]" id="id_company" class="form-control system_report_empty" tabindex="-1">
                            <option value=""><?php echo $this->lang->line('SELECT');?></option>
                            <?php
                            foreach($companies as $company)
                            {?>
                                <option value="<?php echo $company['value']?>" <?php if($company['value']==$item['id_company']){ echo 'selected';}?>><?php echo $company['text'];?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-6">
                        <label for="id_company" class="control-label pull-left">
                            <?php echo $CI->lang->line('LABEL_COMPANY_NAME'); ?>
                        </label>
                    </div>
                </div>

                <div style="" class="row show-grid">
                    <div class="col-xs-6">
                        <select name="item[id_department]" id="id_department" class="form-control system_report_empty" tabindex="-1">
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
                    <div class="col-xs-6">
                        <label for="id_department" class="control-label pull-left">
                            <?php echo $CI->lang->line('LABEL_DEPARTMENT'); ?>
                        </label>
                    </div>
                </div>

                <div style="<?php if(!($item['employee_id']>0)){echo 'display: none';} ?>" class="row show-grid" id="employee_id_container">
                    <div class="col-xs-6">
                        <select name="item[employee_id]" id="employee_id" class="form-control system_report_empty" tabindex="-1">
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
                    <div class="col-xs-6">
                        <label for="employee_id" class="control-label pull-left">
                            <?php echo $CI->lang->line('LABEL_RESPONSIBLE_EMPLOYEE'); ?>
                    </div>
                </div>
            </div>
        </div>

        <div style="" class="row show-grid">
            <div class="col-xs-3">
                <label class="control-label pull-right">
                    File Opening Date
                </label>
            </div>
            <div class="col-xs-6">
                <div class="col-xs-6">
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon2">
                            <label for="date_from_start_file">From:</label>
                        </span>
                        <input name="item[date_from_start_file]" type="text" id="date_from_start_file" class="form-control datepicker system_report_empty" value="<?php echo $item['date_from_start_file'] ?>" placeholder="File Opening From Date">
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon2">
                            <label for="date_to_start_file">To:</label>
                        </span>
                        <input name="item[date_to_start_file]" type="text" id="date_to_start_file" class="form-control datepicker system_report_empty" value="<?php echo $item['date_to_start_file'] ?>" placeholder="File Opening To Date">
                    </div>
                </div>
            </div>
            <div class="col-xs-3"></div>
        </div>

        <div style="" class="row show-grid">
            <div class="col-xs-3">
                <label class="control-label pull-right">
                    Page Entry Date
                </label>
            </div>
            <div class="col-xs-6">
                <div class="col-xs-6">
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon2">
                            <label for="date_from_start_page">From:</label>
                        </span>
                        <input name="item[date_from_start_page]" type="text" id="date_from_start_page" class="form-control datepicker" value="<?php echo $item['date_from_start_page'] ?>" placeholder="Page Entry From Date">
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon2">
                            <label for="date_to_start_page">To:</label>
                        </span>
                        <input name="item[date_to_start_page]" type="text" id="date_to_start_page" class="form-control datepicker" value="<?php echo $item['date_to_start_page'] ?>" placeholder="Page Entry To Date">
                    </div>
                </div>
            </div>
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
        $(document).off("change","#id_company");
        $(document).off("change","#id_department");
        $(document).off("change","#employee_id");
        $(document).off("change","#id_category");
        $(document).off("change","#id_sub_category");
        $(document).off("change","#id_class");
        $(document).off("change","#id_type");
        $(document).off("change","#id_name");
        $(document).off("click","#button_action_report");
        $(document).off("click", ".pop_up");
        $(document).off("change", ".system_report_empty");

        $(".datepicker").datepicker({dateFormat : display_date_format});
        $(document).on("change",".system_report_empty",function(e)
        {
            $('#system_report_container').html('');
        });
        $(document).on("change","#id_company,#id_department",function()
        {
            $("#employee_id").val("");
            var id_department=$('#id_department').val();
            var id_company=$('#id_company').val();
            if(id_company>0 || id_department>0)
            {
                $('#employee_id_container').show();
                $.ajax(
                    {
                        url: "<?php echo site_url('common_controller/get_employees_by_company_department'); ?>",
                        type: 'POST',
                        datatype: "JSON",
                        data:
                        {
                            html_container_id:'#employee_id',
                            id_department:id_department,
                            id_company:id_company
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
                $('#employee_id_container').hide();
            }
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
        $(document).on("change","#id_type",function()
        {
            $("#id_name").val("");
            var id_type=$('#id_type').val();
            if(id_type>0)
            {
                $('#name_container').show();
                $.ajax(
                    {
                        url: '<?php echo site_url('common_controller/get_names_by_type_id'); ?>',
                        type: 'POST',
                        datatype: "JSON",
                        data:
                        {
                            html_container_id:'#id_name',
                            id_type:id_type
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
        $(document).on("click", ".pop_up", function(event)
        {
            var left=((($(window).width()-450)/2)+$(window).scrollLeft());
            var top=((($(window).height()-550)/2)+$(window).scrollTop());
            $("#popup_window").jqxWindow({width: 1200,height:550,position:{x:left,y:top}}); //to change position always
            //$("#popup_window").jqxWindow({position:{x:left,y:top}});
            var row=$(this).attr('data-item-no');
            var id=$("#system_jqx_container").jqxGrid('getrowdata',row).id;
            $.ajax(
                {
                    url: "<?php echo site_url($CI->controller_url.'/index/details') ?>",
                    type: 'POST',
                    datatype: "JSON",
                    data:
                    {
                        html_container_id:'#popup_content',
                        id:id,
                        date_from_start_page: $('#date_from_start_page').val(),
                        date_to_start_page: $('#date_to_start_page').val()
                    },
                    success: function (data, status)
                    {

                    },
                    error: function (xhr, desc, err)
                    {
                        console.log("error");
                    }
                });
            $("#popup_window").jqxWindow('open');
        });
    });
</script>
