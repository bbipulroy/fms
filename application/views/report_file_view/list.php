<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$CI= & get_instance();
$action_data=array();
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
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column" value="date_start">Opening Date</label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column" checked value="hardcopy_location"><?php echo $CI->lang->line('LABEL_HC_LOCATION'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column" checked value="category_name"><?php echo $CI->lang->line('LABEL_FILE_CATEGORY'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column" checked value="class_name"><?php echo $CI->lang->line('LABEL_FILE_CLASS'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column" checked value="type_name"><?php echo $CI->lang->line('LABEL_FILE_TYPE'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column" value="office_name"><?php echo $CI->lang->line('LABEL_OFFICE'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column" value="department_name"><?php echo $CI->lang->line('LABEL_DEPARTMENT'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column" value="ordering"><?php echo $CI->lang->line('LABEL_ORDER'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column" checked value="details_button"><?php echo $CI->lang->line('ACTION_DETAILS'); ?></label>
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
        var url="<?php echo site_url($CI->controller_url.'/index/get_items'); ?>";
        var source =
        {
            dataType:"json",
            dataFields:[
                {name: 'id', type: 'int'},
                {name: 'name', type: 'string'},
                {name: 'date_start', type: 'string'},
                {name: 'hardcopy_location', type: 'string'},
                {name: 'type_name', type: 'string'},
                {name: 'class_name', type: 'string'},
                {name: 'category_name', type: 'string'},
                {name: 'employee_name', type: 'string'},
                {name: 'department_name', type: 'string'},
                {name: 'office_name', type: 'string'},
                {name: 'ordering', type: 'string'},
                {name: 'details_button', type: 'string'}
            ],
            id: 'id',
            url: url,
            type: 'POST',
            data:{<?php echo $ajax_post; ?>}
        };
        var cellsrenderer=function(row,column,value,defaultHtml,columnSettings,record)
        {
            var element=$(defaultHtml);
            element.css({'margin': '0px','width': '100%', 'height': '100%',padding:'5px'});
            if(column=='details_button')
            {
                element.html('<div><button class="btn btn-primary pop_up" data-item-no="'+row+'">Details</button></div>');
            }
            return element[0].outerHTML;
        };
        var tooltiprenderer = function (element) {
            $(element).jqxTooltip({position: 'mouse', content: $(element).text() });
        };

        var dataAdapter=new $.jqx.dataAdapter(source);
        $("#system_jqx_container").jqxGrid(
        {
            width: '100%',
            height:'350px',
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
            showaggregates: true,
            rowsheight: 45,
            columns:[
                { text: '<?php echo $CI->lang->line('LABEL_FILE_NAME'); ?>', dataField: 'name',width:'300',pinned:true,rendered: tooltiprenderer},
                { text: '<?php echo $CI->lang->line('LABEL_RESPONSIBLE_EMPLOYEE'); ?>', dataField: 'employee_name',width:'200',rendered: tooltiprenderer},
                { text: 'Opening Date', dataField: 'date_start',width:'100',rendered: tooltiprenderer,hidden:true},
                { text: '<?php echo $CI->lang->line('LABEL_HC_LOCATION'); ?>', dataField: 'hardcopy_location',width:'200',rendered: tooltiprenderer,filtertype:'list'},
                { text: '<?php echo $CI->lang->line('LABEL_FILE_CATEGORY'); ?>', dataField: 'category_name',width:'200',rendered: tooltiprenderer,filtertype:'list'},
                { text: '<?php echo $CI->lang->line('LABEL_FILE_CLASS'); ?>', dataField: 'class_name',width:'200',rendered: tooltiprenderer,filtertype:'list'},
                { text: '<?php echo $CI->lang->line('LABEL_FILE_TYPE'); ?>', dataField: 'type_name',width:'200',rendered: tooltiprenderer,filtertype:'list'},
                { text: '<?php echo $CI->lang->line('LABEL_OFFICE'); ?>', dataField: 'office_name',width:'200',rendered: tooltiprenderer,filtertype:'list',hidden:true},
                { text: '<?php echo $CI->lang->line('LABEL_DEPARTMENT'); ?>', dataField: 'department_name',width:'200',rendered: tooltiprenderer,filtertype:'list',hidden:true},
                { text: '<?php echo $CI->lang->line('LABEL_ORDER'); ?>', dataField: 'ordering',width:'60',rendered: tooltiprenderer,hidden:true},
                { text: '<?php echo $CI->lang->line('ACTION_DETAILS'); ?>', dataField: 'details_button',width:'85',cellsrenderer:cellsrenderer}
            ]
        });
    });
</script>
