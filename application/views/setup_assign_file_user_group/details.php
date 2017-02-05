<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$CI= & get_instance();
$action_data=array();
$action_data['action_back']=site_url($CI->controller_url);
$action_data['action_save']='#save_form';
$action_data['action_clear']='#save_form';
$CI->load->view('action_buttons',$action_data);
?>
    <div class="row widget">
        <div class="widget-header">
            <div class="title">
                <?php echo $title; ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="row show-grid">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>File Category</th>
                        <th>File Class</th>
                        <th>File Type</th>
                        <th>File Name</th>
                            <?php
                            for($index=0;$index<$CI->config->item('system_fms_max_actions');$index++)
                            {
                                ?>
                                <th><?php echo $CI->lang->line('LABEL_ACTION'.$index); ?></th>
                                <?php
                            }
                            ?>
                    </tr>
                </thead>
                <tbody>
                <?php
                $check_array=array();
                foreach($all_files as $file)
                {
                    $is_first_category=false;
                    $is_first_class=false;
                    $is_first_type=false;
                    if(isset($check_array['category'][$file['category_id']]))
                    {
                        $check_array['category'][$file['category_id']]+=1;
                    }
                    else
                    {
                        $is_first_category='_first';
                        $check_array['category'][$file['category_id']]=1;
                    }
                    if(isset($check_array['class'][$file['class_id']]))
                    {
                        $check_array['class'][$file['class_id']]+=1;
                    }
                    else
                    {
                        $is_first_class='_first';
                        $check_array['class'][$file['class_id']]=1;
                    }
                    if(isset($check_array['type'][$file['type_id']]))
                    {
                        $check_array['type'][$file['type_id']]+=1;
                    }
                    else
                    {
                        $is_first_type='_first';
                        $check_array['type'][$file['type_id']]=1;
                    }

                    for($i=0;$i<$CI->config->item('system_fms_max_actions');$i++)
                    {
                        $temp_variable_name='action'.$i;
                        if($file[$temp_variable_name]==1)
                        {
                            $$temp_variable_name='ok';
                        }
                        else
                        {
                            $$temp_variable_name='remove';
                        }
                    }
                    ?>
                    <tr>
                        <td class="category-<?php echo $file['category_id'].$is_first_category; ?>">
                            <?php echo $file['category_name']; ?>
                        </td>
                        <td class="class-<?php echo $file['class_id'].$is_first_class; ?>">
                            <?php echo $file['class_name']; ?>
                        </td>
                        <td class="type-<?php echo $file['type_id'].$is_first_type; ?>">
                            <?php  echo $file['type_name']; ?>
                        </td>
                        <td>
                            <?php echo $file['name_name']; ?>
                        </td>
                        <?php
                        for($i=0;$i<$CI->config->item('system_fms_max_actions');$i++)
                        {
                            $temp_variable_name='action'.$i;
                            ?>
                            <td>
                                <span class="glyphicon glyphicon-<?php echo $$temp_variable_name; ?>" aria-hidden="true"></span>
                            </td>
                            <?php
                        }
                        ?>
                    </tr>
                    <?php
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
<script>
    jQuery(document).ready(function()
    {
        <?php
        foreach($check_array as $index=>$value)
        {
            foreach($value as $id=>$rowspan)
            {
                echo '$(".'.$index.'-'.$id.'").remove();';
                echo '$(".'.$index.'-'.$id.'_first").attr("rowspan","'.$rowspan.'");';
            }
        }
        ?>
    });
</script>
