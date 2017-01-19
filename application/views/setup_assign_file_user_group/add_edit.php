<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$CI= & get_instance();
$action_data=array();
$action_data['action_back']=site_url($CI->controller_url);
if($action=='edit')
{
    $action_data['action_save']='#save_form';
    $action_data['action_clear']='#save_form';
}
$CI->load->view('action_buttons',$action_data);

if($action=='edit')
{
    ?>
    <form class="form_valid" id="save_form" action="<?php echo site_url($CI->controller_url.'/index/save');?>" method="post">
        <input type="hidden" id="id" name="id" value="<?php echo $item_id; ?>">
    <?php
}
?>
    <div class="row widget">
        <div class="widget-header">
            <div class="title">
                <?php echo $title; ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="row show-grid">
            <table class="table">
                <thead>
                    <tr>
                        <th>File Category</th>
                        <th>File Class</th>
                        <th>File Type</th>
                        <th>
                            <?php
                            if($action=='edit')
                            {
                                ?>
                                <input id="name" type="checkbox" data-id="" data-type="name">
                                <?php
                            }
                            ?>
                            <label for="name">File Name</label>
                        </th>
                        <th>
                            <?php
                            if($action=='edit')
                            {
                                ?>
                                <input id="action1" type="checkbox" data-id="" data-type="action1">
                                <?php
                            }
                            ?>
                            <label for="action1">Add</label>
                        </th>
                        <th>
                            <?php
                            if($action=='edit')
                            {
                                ?>
                                <input id="action2" type="checkbox" data-id="" data-type="action2">
                                <?php
                            }
                            ?>
                            <label for="action2">Edit</label>
                        </th>
                        <th>
                            <?php
                            if($action=='edit')
                            {
                                ?>
                                <input id="action3" type="checkbox" data-id="" data-type="action3">
                                <?php
                            }
                            ?>
                            <label for="action3">Delete</label>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $check_array=array();
                        foreach($CI->all_files as $file)
                        {
                            $CI->table_cells($file,$check_array,$action);
                        }
                        if(!isset($check_array['category']))
                        {
                            $check_array['category']=array();
                            $check_array['class']=array();
                            $check_array['type']=array();
                            echo '<tr style="text-align: center;font-size: 18px;"><td colspan="7">No data to display.</td></tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
    <div class="clearfix"></div>
<?php
    if($action=='edit')
    {
        echo '</form>';
    }
?>
<script>
    jQuery(document).ready(function()
    {
        <?php
        $CI->javascript_code_gen($check_array['category'],'category');
        $CI->javascript_code_gen($check_array['class'],'class');
        $CI->javascript_code_gen($check_array['type'],'type');
        if($action=='edit')
        {
            ?>
            $(document).on('change','input[type="checkbox"]',function()
            {
                var obj=$(this);
                var child_type="."+obj.attr("data-type");
                if(obj.attr("data-id")!="")
                {
                    child_type+="_"+obj.attr("data-id");
                }
                if(obj.is(':checked'))
                {
                    $(child_type).prop('checked',true);
                }
                else
                {
                    $(child_type).prop('checked',false);
                }
            });
            <?php
        }
        ?>
    });
</script>
