<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$CI= & get_instance();
$action_data=array();
if($CI->is_add || $CI->is_edit || $CI->is_delete)
{
    $action_data['action_edit']=site_url($CI->controller_url.'/index/edit');
}
if($CI->is_view)
{
    $action_data['action_details']=site_url($CI->controller_url.'/index/details');
}
$action_data['action_refresh']=site_url($CI->controller_url.'/index/list');
$CI->load->view('action_buttons',$action_data);
?>

<div class="row widget">
    <div class="widget-header">
        <div class="title">
            <?php echo $title; ?>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="col-xs-12" id="system_jqx_container">

    </div>
</div>
<div class="clearfix"></div>
<script type="text/javascript">
    $(document).ready(function()
    {
        var url="<?php echo site_url($CI->controller_url.'/index/get_items');?>";
        var source=
        {
            dataType:"json",
            dataFields:[
                { name: 'id', type: 'int' },
                { name: 'name', type: 'string' },
                { name: 'class_name', type: 'string' },
                { name: 'category_name', type: 'string' },
                { name: 'type_name', type: 'string' },
                { name: 'number_of_file', type: 'string' },
                { name: 'date_start', type: 'string' }
            ],
            id: 'id',
            url: url
        };

        var dataAdapter=new $.jqx.dataAdapter(source);
        // create jqxgrid.
        $("#system_jqx_container").jqxGrid(
            {
                width: '100%',
                source: dataAdapter,
                pageable: true,
                filterable: true,
                sortable: true,
                showfilterrow: true,
                columnsresize: true,
                pagesize:50,
                pagesizeoptions: ['20', '50', '100', '200','300','500'],
                selectionmode: 'singlerow',
                altrows: true,
                autoheight: true,
                columns: [
                    { text: '<?php echo $CI->lang->line('LABEL_FILE_NAME'); ?>', dataField: 'name',width: '300'},
                    { text: '<?php echo $CI->lang->line('LABEL_FILE_CATEGORY'); ?>', dataField: 'category_name',filtertype: 'list'},
                    { text: '<?php echo $CI->lang->line('LABEL_FILE_CLASS'); ?>', dataField: 'class_name',filtertype: 'list'},
                    { text: '<?php echo $CI->lang->line('LABEL_FILE_TYPE'); ?>', dataField: 'type_name',filtertype: 'list'},
                    { text: 'Number of Page', dataField: 'number_of_file',filtertype: 'int',cellsAlign: 'right', width: '80'},
                    { text: 'Opening Date', dataField: 'date_start',filtertype: 'list',width:'150'}
                ]
            });
    });
</script>
