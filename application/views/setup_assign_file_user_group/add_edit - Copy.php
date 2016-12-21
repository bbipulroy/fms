<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$CI = & get_instance();
$action_data=array();
$action_data['action_back']=site_url($CI->controller_url);
$action_data['action_save']='#save_form';
$action_data['action_clear']='#save_form';
$CI->load->view('action_buttons',$action_data);
?>
<form class="form_valid" id="save_form" action="<?php echo site_url($CI->controller_url.'/index/save');?>" method="post">
    <input type="hidden" id="id" name="id" value="<?php echo $item_id; ?>">
    <input type="hidden" id="system_save_new_status" name="system_save_new_status" value="0">

    <div class="row widget">
        <div class="widget-header">
            <div class="title">
                <?php echo $title; ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <div id="main_panel" class="row show-grid">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <input type="checkbox" name="<?php echo $CI->permission_all; ?>" id="<?php echo $CI->permission_all; ?>" child-class="<?php echo $CI->config->item('system_file_type_1'); ?>">
                        <a class="external" data-toggle="collapse" href="#<?php echo $CI->permission_all_body; ?>">
                            All Permission
                        </a>
                    </h4>
                </div>
                <div id="<?php echo $CI->permission_all_body; ?>" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="panel-group" id="<?php echo $CI->config->item('system_file_type_1'); ?>">
                            <?php
                                $CI->file_type_1s();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="clearfix"></div>
</form>

<script type="text/javascript">
    <?php
        if($js_prevent=='')
        {
            echo 'window.location.href="'.$pre_system_page_url.'/prevent";';
        }
    ?>
    jQuery(document).ready(function()
    {
        var file_type_1='<?php echo $CI->lang->line('LABEL_FILE_TYPE_1'); ?>'.toUpperCase();
        var file_type_2='<?php echo $CI->lang->line('LABEL_FILE_TYPE_2'); ?>'.toUpperCase();
        var file_type_3='<?php echo $CI->lang->line('LABEL_FILE_TYPE_3'); ?>'.toUpperCase();
        var file_type_4='<?php echo $CI->lang->line('LABEL_FILE_TYPE_4'); ?>'.toUpperCase();

        var permission_all_id='#<?php echo $CI->permission_all; ?>';
        var permission_all_child='.<?php echo $CI->permission_all_child; ?>';
        var permission_all_child_panel='#<?php echo $CI->permission_all_body; ?>';
        var form_reset_id='#button_action_clear';
        var check_all_item_but_one=false;

        var this_id;
        var this_id_text;
        var this_class;
        var main_class;
        var parent_id;
        var child_class;
        var child_panel_id;
        var check;

        $(document).on('reset','form',function(e)
        {
            var obj=$(form_reset_id);
            var check=obj.data('check');
            var page=$('#main_panel');
            if(check==undefined || check==false)
            {
                obj.data('check',true);
                obj.data('page_data',page.html());
                reset_next();
            }
            else
            {
                e.preventDefault();
                page.empty();
                page.html(obj.data('page_data'));
                reset_next();
            }
        });
        $(document).on('click','input[type="checkbox"]',function()
        {
            this_id='#'+$(this).attr('id');
            get_information();
            if($(this).is(':checked'))
            {
                check=true;
            }
            else
            {
                check=false;
            }
            if(this_id==permission_all_id)
            {
                if(check)
                {
                    check_permission_all();
                }
                else
                {
                    uncheck_permission_all();
                }
            }
            else
            {
                if(check)
                {
                    uncheck_permission_all_single();
                    if(this_class=='.<?php echo $CI->config->item('system_file_type_1'); ?>')
                    {
                        check_file_type_1();
                    }
                    else if(this_class=='.<?php echo $CI->config->item('system_file_type_2'); ?>')
                    {
                        check_file_type_2();
                    }
                    else if(this_class=='.<?php echo $CI->config->item('system_file_type_3'); ?>')
                    {
                        check_file_type_3();
                    }
                    else if(this_class=='.<?php echo $CI->config->item('system_file_type_4'); ?>')
                    {
                        check_file_type_4();
                    }
                }
                else
                {
                    $(child_panel_id).collapse("show");
                }
            }
        });
        $('form').trigger('reset');
        $('form').trigger('reset');
        function check_file_type_4()
        {
            if(check_all_item(main_class)===true)
            {
                var parent_text=$(parent_id).next().text();
                parent_text=$.trim(parent_text);
                var sure=confirm('You select all '+file_type_4+' under '+file_type_3+' '+parent_text+'.\nYou can select that '+file_type_3+' for future coming NEW '+file_type_4+' auto selected.\nClick Ok or Cancel.');
                if(!sure)
                {
                    if(check_all_item_but_one)
                    {
                        $(parent_id).prop('checked',false);
                        check_all_item_but_one=false;
                    }
                    return;
                }
                get_information(parent_id);
                check_file_type_3(true);
            }
            else
            {
                $(parent_id).prop('checked',false);
                parent_id='#'+$(parent_id).attr('parent-id');
                $(parent_id).prop('checked',false);
                parent_id='#'+$(parent_id).attr('parent-id');
                $(parent_id).prop('checked',false);
            }
        }
        function check_file_type_3(to_check)
        {
            same_element_false_work();
            if(to_check==true)
            {
                $(this_id).prop('checked',true);
            }
            $(child_panel_id).removeClass('in');
            $(child_class).prop('checked',false);
            $('.'+this_id_text+'_all').prop('checked',false);
            if(check_all_item(main_class)===true)
            {
                var parent_text=$(parent_id).next().text();
                parent_text=$.trim(parent_text);
                var sure=confirm('You select all '+file_type_3+' under '+file_type_2+' '+parent_text+'.\nYou can select that '+file_type_2+' for future coming NEW '+file_type_3+' auto selected.\nClick Ok or Cancel.');
                if(!sure)
                {
                    if(check_all_item_but_one)
                    {
                        $(parent_id).prop('checked',false);
                        check_all_item_but_one=false;
                    }
                    return;
                }
                get_information(parent_id);
                check_file_type_2(true);
            }
            else
            {
                $(parent_id).prop('checked',false);
                parent_id='#'+$(parent_id).attr('parent-id');
                $(parent_id).prop('checked',false);
            }
        }
        function check_file_type_2(to_check)
        {
            same_element_false_work();
            if(to_check==true)
            {
                $(this_id).prop('checked',true);
            }
            $(child_panel_id).removeClass('in');
            $(child_class).prop('checked',false);
            $('.'+this_id_text+'_all').prop('checked',false);
            if(check_all_item(main_class)===true)
            {
                var parent_text=$(parent_id).next().text();
                parent_text=$.trim(parent_text);
                var sure=confirm('You select all '+file_type_2+' under '+file_type_1+' '+parent_text+'.\nYou can select that '+file_type_1+' for future coming NEW '+file_type_2+' auto selected.\nClick Ok or Cancel.');
                if(!sure)
                {
                    if(check_all_item_but_one)
                    {
                        $(parent_id).prop('checked',false);
                        check_all_item_but_one=false;
                    }
                    return;
                }
                get_information(parent_id);
                check_file_type_1(true);
            }
            else
            {
                $(parent_id).prop('checked',false);
            }
        }
        function check_file_type_1(to_check)
        {
            if(to_check==true)
            {
                $(this_id).prop('checked',true);
            }
            $(child_panel_id).removeClass('in');
            $(child_class).prop('checked',false);
            $('.'+this_id_text+'_all').prop('checked',false);
            if(check_all_item('.<?php echo $CI->config->item('system_file_type_1'); ?>')===true)
            {
                var sure=confirm('You select all '+file_type_1+' under All Permission.\nYou can select All Permission for future coming NEW '+file_type_1+' auto selected.\nClick Ok or Cancel.');
                if(!sure)
                {
                    return;
                }
                check_permission_all();
            }
        }
        function check_all_item(obj)
        {
            if($(obj).length==1)
            {
                check_all_item_but_one=true;
            }
            var check=true;
            $(obj).each(function(index,element)
            {
                if($(element).is(':checked'))
                {
                    check=check && true;
                }
                else
                {
                    check=check && false;
                }
            });
            return check;
        }
        function check_permission_all()
        {
            $(permission_all_id).prop('checked',true);
            $(permission_all_child_panel).collapse("hide");
            $(permission_all_child).prop('checked',false);
        }
        function uncheck_permission_all()
        {
            $(permission_all_child_panel).collapse("show");
        }
        function uncheck_permission_all_single()
        {
            $(permission_all_id).prop('checked',false);
        }
        function reset_next()
        {
            <?php
                if($CI->selected_process_check==false)
                {
                    if($CI->selected_array==$CI->permission_all)
                    {
                        ?>
                        check_permission_all();
                        <?php
                    }
                }
                else
                {
                    foreach($CI->selected_array as $selected)
                    {
                        echo '$("#'.$CI->selected_array_all[$selected].'").prop("checked",true);';
                    }
                }
            ?>
        }
        function get_information(html_id)
        {
            if(html_id!=undefined)
            {
                this_id=html_id;
            }
            this_id_text=$(this_id).attr('id');
            parent_id='#'+$(this_id).attr('parent-id');
            child_class='.'+$(this_id).attr('child-class');
            child_panel_id='#'+$(this_id).attr('name');
            var this_classes=$(this_id).attr('class');
            if(this_classes==undefined)
            {
                this_class='';
                main_class='';
            }
            else
            {
                this_classes=this_classes.split(' ');
                this_class='.'+this_classes[0];
                main_class='.'+this_classes[1];
            }
        }
        function same_element_false_work()
        {
            var obj=$(main_class);
            var suppose_length=obj.length;
            for(var i=0;i<suppose_length;++i)
            {
                obj.eq(i).removeClass(this_id_text+'_all');
            }
        }
    });
</script>
