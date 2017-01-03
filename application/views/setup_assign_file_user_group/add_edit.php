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
                        <input type="checkbox" child-class="<?php echo $CI->permission_all_child; ?>">
                        <a class="external" data-toggle="collapse" href="#<?php echo $CI->permission_all_body; ?>">
                            All Permission
                        </a>
                    </h4>
                </div>
                <div id="<?php echo $CI->permission_all_body; ?>" class="panel-collapse collapse">
                    <div class="panel-body">
                        <?php
                            $CI->categories();
                        ?>
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
        $('.panel-collapse').collapse("show");
        $(document).on('click','input[type="checkbox"]',function()
        {
            var obj=$(this);
            var child_class=obj.attr('child-class');
            var this_class=obj.attr('class');
            if(this_class!=undefined)
            {
                this_class=this_class.split(' ');
                this_class=this_class[0];
            }

            if(obj.is(':checked'))
            {
                check=true;
            }
            else
            {
                check=false;
            }

            if(check)
            {
                if(this_class=='category' || this_class=='class')
                {
                    check_all_level_child(child_class);
                }
                else
                {
                    if(child_class!=undefined)
                    {
                        $('.'+child_class).prop('checked',true);
                    }
                }
            }
        });
        function check_all_level_child(html_class)
        {
            if(html_class!=undefined)
            {
                $('.'+html_class).each(function(index,element)
                {
                    $(element).prop('checked',true);
                    check_all_level_child($(element).attr('child-class'));
                });
            }
        }
    });
</script>
