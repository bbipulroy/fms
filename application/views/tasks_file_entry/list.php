<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$CI=& get_instance();
$action_buttons=array();
if(isset($CI->permissions['action1']) && ($CI->permissions['action1']==1))
{
    $action_buttons[]=array(
        'label'=>$CI->lang->line("ACTION_NEW"),
        'href'=>site_url($CI->controller_url.'/index/add')
    );
}
if(isset($CI->permissions['action2']) && ($CI->permissions['action2']==1))
{
    $action_buttons[]=array(
        'type'=>'button',
        'label'=>$CI->lang->line("ACTION_EDIT"),
        'class'=>'button_jqx_action',
        'data-action-link'=>site_url($CI->controller_url.'/index/edit')
    );
}
$action_buttons[]=array(
    'type'=>'button',
    'label'=>$CI->lang->line("ACTION_DETAILS"),
    'class'=>'button_jqx_action',
    'data-action-link'=>site_url($CI->controller_url.'/index/details')
);
if(isset($CI->permissions['action4']) && ($CI->permissions['action4']==1))
{
    $action_buttons[]=array(
        'type'=>'button',
        'label'=>$CI->lang->line("ACTION_PRINT"),
        'class'=>'button_action_download',
        'data-title'=>"Print",
        'data-print'=>true
    );
}
if(isset($CI->permissions['action5']) && ($CI->permissions['action5']==1))
{
    $action_buttons[]=array(
        'type'=>'button',
        'label'=>$CI->lang->line("ACTION_DOWNLOAD"),
        'class'=>'button_action_download',
        'data-title'=>"Download"
    );
}
$action_buttons[]=array(
    'label'=>$CI->lang->line("ACTION_REFRESH"),
    'href'=>site_url($CI->controller_url.'/index/list')

);
$CI->load->view('action_buttons',array('action_buttons'=>$action_buttons));
?>
<div class="row widget">
    <div class="widget-header">
        <div class="title">
            <?php echo $title; ?>
        </div>
        <div class="clearfix"></div>
    </div>
    <?php
    if(isset($CI->permissions['action6']) && ($CI->permissions['action6']==1))
    {
        ?>
        <div class="col-xs-12" style="margin-bottom: 20px;">
            <div class="col-xs-12" style="margin-bottom: 20px;">
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column" checked value="name"><?php echo $CI->lang->line('LABEL_FILE_NAME'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column" checked value="employee_name"><?php echo $CI->lang->line('LABEL_RESPONSIBLE_EMPLOYEE'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column" checked value="date_start">Opening Date</label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column" value="status_file"><?php echo $CI->lang->line('LABEL_FILE_STATUS'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column" checked value="number_of_page">Number of Page</label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column" checked value="hardcopy_location"><?php echo $CI->lang->line('LABEL_HC_LOCATION'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column" checked value="category_name"><?php echo $CI->lang->line('LABEL_FILE_CATEGORY'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column" checked value="sub_category_name"><?php echo $CI->lang->line('LABEL_FILE_SUB_CATEGORY'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column" checked value="class_name"><?php echo $CI->lang->line('LABEL_FILE_CLASS'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column" checked value="type_name"><?php echo $CI->lang->line('LABEL_FILE_TYPE'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column" checked value="company_name"><?php echo $CI->lang->line('LABEL_COMPANY_NAME'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column" checked value="department_name"><?php echo $CI->lang->line('LABEL_DEPARTMENT'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column" checked value="ordering"><?php echo $CI->lang->line('LABEL_ORDER'); ?></label>
            </div>
        </div>
    <?php
    }
    ?>
    <div class="col-xs-12" id="system_jqx_container">

    </div>
</div>
<div class="clearfix"></div>
<script type="text/javascript">
    $(document).ready(function()
    {
        var url="<?php echo site_url($CI->controller_url.'/index/get_items');?>";
        var source =
        {
            dataType: "json",
            dataFields: [
                { name: 'id', type: 'int' },
                { name: 'name', type: 'string' },
                { name: 'category_name', type: 'string' },
                { name: 'sub_category_name', type: 'string' },
                { name: 'class_name', type: 'string' },
                { name: 'type_name', type: 'string' },
                { name: 'ordering', type: 'int' },
                { name: 'date_start', type: 'string' },
                { name: 'status_file', type: 'string' },
                { name: 'number_of_page', type: 'int' },
                { name: 'hardcopy_location', type: 'string' },
                { name: 'company_name', type: 'string' },
                { name: 'department_name', type: 'string' },
                { name: 'employee_name', type: 'string' }
            ],
            id: 'id',
            url: url
        };
        var tooltiprenderer = function (element) {
            $(element).jqxTooltip({position: 'mouse', content: $(element).text() });
        };

        var dataAdapter = new $.jqx.dataAdapter(source);
        // create jqxgrid.
        $("#system_jqx_container").jqxGrid(
            {
                width: '100%',
                //height:'350px',
                source: dataAdapter,
                columnsresize: true,
                columnsreorder: true,
                pageable: true,
                filterable: true,
                sortable: true,
                showfilterrow: true,
                pagesize:50,
                pagesizeoptions: ['20', '50', '100', '200','300','500'],
                selectionmode: 'singlerow',
                altrows: true,
                enabletooltips: true,
                autoheight: true,
                columns:[
                    { text: '<?php echo $CI->lang->line('LABEL_FILE_NAME'); ?>', dataField: 'name',width:'300',pinned:true,rendered: tooltiprenderer},
                    { text: '<?php echo $CI->lang->line('LABEL_RESPONSIBLE_EMPLOYEE'); ?>', dataField: 'employee_name',width:'200',pinned:false,rendered: tooltiprenderer},
                    { text: 'Opening Date', dataField: 'date_start',width:'100',pinned:false,rendered: tooltiprenderer},
                    { text: '<?php echo $CI->lang->line('LABEL_FILE_STATUS'); ?>', dataField: 'status_file',width:'100',rendered: tooltiprenderer,hidden:true,filtertype:'list'},
                    { text: 'Number of Page', dataField: 'number_of_page',width:'60',pinned:false,rendered: tooltiprenderer},
                    { text: '<?php echo $CI->lang->line('LABEL_HC_LOCATION'); ?>', dataField: 'hardcopy_location',width:200,pinned:false,rendered: tooltiprenderer,filtertype:'list'},
                    { text: '<?php echo $CI->lang->line('LABEL_FILE_CATEGORY'); ?>', dataField: 'category_name',width:200,pinned:false,rendered: tooltiprenderer,filtertype:'list'},
                    { text: '<?php echo $CI->lang->line('LABEL_FILE_SUB_CATEGORY'); ?>', dataField: 'sub_category_name',width:200,pinned:false,rendered: tooltiprenderer,filtertype:'list'},
                    { text: '<?php echo $CI->lang->line('LABEL_FILE_CLASS'); ?>', dataField: 'class_name',width:200,pinned:false,rendered: tooltiprenderer,filtertype:'list'},
                    { text: '<?php echo $CI->lang->line('LABEL_FILE_TYPE'); ?>', dataField: 'type_name',width:200,pinned:false,rendered: tooltiprenderer,filtertype:'list'},
                    { text: '<?php echo $CI->lang->line('LABEL_COMPANY_NAME'); ?>', dataField: 'company_name',width:200,pinned:false,rendered: tooltiprenderer,filtertype:'list'},
                    { text: '<?php echo $CI->lang->line('LABEL_DEPARTMENT'); ?>', dataField: 'department_name',width:200,pinned:false,rendered: tooltiprenderer,filtertype:'list'},
                    { text: '<?php echo $CI->lang->line('LABEL_ORDER'); ?>', dataField: 'ordering',width:60,pinned:false,rendered: tooltiprenderer}
                ]
            });
    });
</script>
