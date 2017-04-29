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
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column" checked value="category_name"><?php echo $CI->lang->line('LABEL_FILE_CATEGORY'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column" checked value="sub_category_name"><?php echo $CI->lang->line('LABEL_FILE_SUB_CATEGORY'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column" checked value="class_name"><?php echo $CI->lang->line('LABEL_FILE_CLASS'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column" checked value="type_name"><?php echo $CI->lang->line('LABEL_FILE_TYPE'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column" checked value="item_name"><?php echo $CI->lang->line('LABEL_FILE_ITEM'); ?></label>
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
        var url="<?php echo site_url($CI->controller_url.'/index/get_items_list_file_items'); ?>";
        var source =
        {
            dataType:"json",
            dataFields:[
                { name: 'id', type: 'int' },
                { name: 'item_name', type: 'string' },
                { name: 'category_name', type: 'string' },
                { name: 'sub_category_name', type: 'string' },
                { name: 'class_name', type: 'string' },
                { name: 'type_name', type: 'string' }
            ],
            id: 'id',
            url: url,
            type: 'POST',
            data:{<?php echo $ajax_post; ?>}
        };
        var cellsrenderer=function(row,column,value,defaultHtml,columnSettings,record)
        {
            var element=$(defaultHtml);
            if(value=='' || value=='Not Assigned')
            {
                element.css({'background-color': 'red','margin': '0px','width': '100%', 'height': '100%',padding:'5px'});
                if(column=='item_name')
                {
                    element.css({'background-color': 'red','color':'red','margin': '0px','width': '100%', 'height': '100%',padding:'5px'});
                }
            }
            return element[0].outerHTML;
        };
        var dataAdapter=new $.jqx.dataAdapter(source);
        $("#system_jqx_container").jqxGrid(
            {
                width: '100%',
                autoheight: true,
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
                //showaggregates: true,
                rowsheight: 35,
                columns:[
                    { text: '<?php echo $CI->lang->line('LABEL_FILE_CATEGORY'); ?>', dataField: 'category_name',width:240,filtertype:'list'},
                    { text: '<?php echo $CI->lang->line('LABEL_FILE_SUB_CATEGORY'); ?>', dataField: 'sub_category_name',width:240,filtertype:'list',cellsrenderer:cellsrenderer},
                    { text: '<?php echo $CI->lang->line('LABEL_FILE_CLASS'); ?>', dataField: 'class_name',width:240,filtertype:'list',cellsrenderer:cellsrenderer},
                    { text: '<?php echo $CI->lang->line('LABEL_FILE_TYPE'); ?>', dataField: 'type_name',width:240,filtertype:'list',cellsrenderer:cellsrenderer},
                    { text: '<?php echo $CI->lang->line('LABEL_FILE_ITEM'); ?>', dataField: 'item_name',width:'300',cellsrenderer:cellsrenderer}
                ]
            });
    });
</script>
