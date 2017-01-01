<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$CI = & get_instance();
$action_data=array();
$action_data['action_back']=site_url($CI->controller_url);
$action_data["action_refresh"]=site_url($CI->controller_url.'/index/get_file_permission_list/'.$item_id);
$CI->load->view("action_buttons",$action_data);
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
    $(document).ready(function ()
    {
        var url = "<?php echo site_url($CI->controller_url.'/index/get_file_permission_list/'.$item_id); ?>";

        // prepare the data
        var source =
        {
            dataType: "json",
            dataFields: [
                { name: 'id', type: 'int' },
                { name: 'name', type: 'string' },
                { name: 'ft1_name', type: 'string' },
                { name: 'ft2_name', type: 'string' },
                { name: 'ft3_name', type: 'string' }
            ],
            id: 'id',
            url: url
        };

        var dataAdapter = new $.jqx.dataAdapter(source);
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
                    { text: '<?php echo $CI->lang->line('LABEL_FILE_TYPE_4'); ?>', dataField: 'name'},
                    { text: '<?php echo $CI->lang->line('LABEL_FILE_TYPE_3'); ?>', dataField: 'ft3_name',filtertype: 'list',width:'200'},
                    { text: '<?php echo $CI->lang->line('LABEL_FILE_TYPE_2'); ?>', dataField: 'ft2_name',filtertype: 'list',width:'200'},
                    { text: '<?php echo $CI->lang->line('LABEL_FILE_TYPE_1'); ?>', dataField: 'ft1_name',filtertype: 'list',width:'200'}
                ]
            });
    });
</script>
