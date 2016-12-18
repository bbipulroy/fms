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

        <div class="row show-grid">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <input type="checkbox" name="permission_all" id="permission_all" child-class="category">
                        <a class="external" data-toggle="collapse" href="#permission_all_body">
                            All Permission
                        </a>
                    </h4>
                </div>
                <div id="permission_all_body" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="panel-group" id="category">
                            <?php
                            $CI->categories();
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
    jQuery(document).ready(function()
    {
        var permission_all_id='#permission_all';
        var permission_all_child='.permission_all_child';
        var permission_all_child_panel='#permission_all_body';
        var form_reset_id='#button_action_clear';

        $(document).on('reset','form',function(e)
        {
            var obj=$(form_reset_id);
            var check=obj.data('check');
            if(check==undefined || check==false)
            {
                obj.data('check',true);
                obj.data('page_data',$(permission_all_child_panel).html());
                reset_next();
            }
            else
            {
                e.preventDefault();
                var page=$(permission_all_child_panel);
                page.empty();
                page.html(obj.data('page_data'));
                reset_next();
            }
        });
        $(document).on('click','input[type="checkbox"]',function()
        {
            var this_id='#'+$(this).attr('id');
            var parent_id='#'+$(this).attr('parent-id');
            var child_class='.'+$(this).attr('child-class');
            var child_panel_id='#'+$(this).attr('name');
            var this_classes=$(this).attr('class');
            if(this_classes==undefined)
            {
                var this_class='';
                var main_class='';
            }
            else
            {
                this_classes=this_classes.split(' ');
                var this_class='.'+this_classes[0];
                var main_class='.'+this_classes[1];
            }
            if($(this).is(':checked'))
            {
                var check=true;
            }
            else
            {
                var check=false;
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
                    if(this_class=='.category')
                    {
                        check_category(child_panel_id,child_class);
                    }
                    else if(this_class=='.class')
                    {
                        check_class(child_panel_id,child_class,main_class,parent_id);
                    }
                    else if(this_class=='.type')
                    {
                        check_type(child_panel_id,child_class,main_class,parent_id);
                    }
                    else if(this_class=='.name')
                    {
                        check_name(main_class,parent_id,$(this).next().text());
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
        function check_name(main_class,parent_id)
        {
            if(check_all_item(main_class)===true)
            {
                var parent_text=$(parent_id).next().text();
                parent_text=$.trim(parent_text);
                var sure=confirm('You select all FILE NAME under FILE TYPE '+parent_text+'.\nYou can select that FILE TYPE for future coming NEW FILE NAME auto selected.\nClick Ok or Cancel.');
                if(!sure)
                {
                    return;
                }
                var child_panel_id_new='#'+$(parent_id).attr('name');
                var child_class_new='.'+$(parent_id).attr('child-class');
                var parent_id_new='#'+$(parent_id).attr('parent-id');
                var main_class_new=$(parent_id).attr('class');
                main_class_new=main_class_new.split(' ');
                main_class_new='.'+main_class_new[1];
                check_type(child_panel_id_new,child_class_new,main_class_new,parent_id_new,parent_id);
            }
            else
            {
                $(parent_id).prop('checked',false);
            }
        }
        function check_type(child_panel_id,child_class,main_class,parent_id,to_check)
        {
            if(to_check!=undefined)
            {
                $(to_check).prop('checked',true);
            }
            $(child_panel_id).removeClass('in');
            $(child_class).prop('checked',false);
            if(check_all_item(main_class)===true)
            {
                var parent_text=$(parent_id).next().text();
                parent_text=$.trim(parent_text);
                var sure=confirm('You select all FILE TYPE under FILE CLASS '+parent_text+'.\nYou can select that FILE CLASS for future coming NEW FILE TYPE auto selected.\nClick Ok or Cancel.');
                if(!sure)
                {
                    return;
                }
                var child_panel_id_new='#'+$(parent_id).attr('name');
                var child_class_new='.'+$(parent_id).attr('child-class');
                var parent_id_new='#'+$(parent_id).attr('parent-id');
                var main_class_new=$(parent_id).attr('class');
                main_class_new=main_class_new.split(' ');
                main_class_new='.'+main_class_new[1];
                check_class(child_panel_id_new,child_class_new,main_class_new,parent_id_new,parent_id);
            }
            else
            {
                $(parent_id).prop('checked',false);
            }
        }
        function check_class(child_panel_id,child_class,main_class,parent_id,to_check)
        {
            if(to_check!=undefined)
            {
                $(to_check).prop('checked',true);
            }
            $(child_panel_id).removeClass('in');
            $(child_class).prop('checked',false);
            if(check_all_item(main_class)===true)
            {
                var parent_text=$(parent_id).next().text();
                parent_text=$.trim(parent_text);
                var sure=confirm('You select all FILE CLASS under FILE CATEGORY '+parent_text+'.\nYou can select that FILE CATEGORY for future coming NEW FILE CLASS auto selected.\nClick Ok or Cancel.');
                if(!sure)
                {
                    return;
                }
                var child_class_new='.'+$(parent_id).attr('child-class');
                var child_panel_id_new='#'+$(parent_id).attr('name');
                check_category(child_panel_id_new,child_class_new,parent_id);
            }
            else
            {
                $(parent_id).prop('checked',false);
            }
        }
        function check_category(child_panel_id,child_class,to_check)
        {
            if(to_check!=undefined)
            {
                $(to_check).prop('checked',true);
            }
            $(child_panel_id).removeClass('in');
            $(child_class).prop('checked',false);
            if(check_all_item('.category')===true)
            {
                var sure=confirm('You select all FILE CATEGORY under All Permission.\nYou can select All Permission for future coming NEW FILE CATEGORY auto selected.\nClick Ok or Cancel.');
                if(!sure)
                {
                    return;
                }
                check_permission_all();
            }
        }
        function check_all_item(obj)
        {
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
            $(permission_all_child_panel).removeClass('in');
            $(permission_all_child_panel).hide();
            $(permission_all_child).prop('checked',false);
        }
        function uncheck_permission_all()
        {
            $(permission_all_child_panel).addClass('in');
            $(permission_all_child_panel).show();
        }
        function reset_next()
        {
            <?php
                if($CI->selected_process_check==false)
                {
                    if($CI->selected_array=='permission_all')
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
    });
    <?php
    if($js_prevent=='')
    {
        echo 'window.location.href="'.$pre_system_page_url.'/prevent";';
    }
    ?>
</script>
