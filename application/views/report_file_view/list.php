<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$CI= & get_instance();
$action_data=array();
if(isset($CI->permissions['action4'])&&($CI->permissions['action4']==1))
{
    $action_data["action_print"]='print';
}
if(isset($CI->permissions['action5'])&&($CI->permissions['action5']==1))
{
    $action_data["action_download"]='download';
}
$CI->load->view("action_buttons",$action_data);
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
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column" checked value="employee_name">Responsible Employee</label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column" checked value="date_start">Opening Date</label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column" checked value="category_name"><?php echo $CI->lang->line('LABEL_FILE_CATEGORY'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column" checked value="class_name"><?php echo $CI->lang->line('LABEL_FILE_CLASS'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column" checked value="type_name"><?php echo $CI->lang->line('LABEL_FILE_TYPE'); ?></label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column" checked value="office_name">Office</label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column" checked value="department_name">Department</label>
                <label class="checkbox-inline"><input type="checkbox" class="system_jqx_column" value="details_button">Details</label>
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
        $(document).off("click", ".pop_up");
        $(document).on("click", ".pop_up", function(event)
        {
            var left=((($(window).width()-550)/2)+$(window).scrollLeft());
            var top=((($(window).height()-550)/2)+$(window).scrollTop());
            $("#popup_window").jqxWindow({width: 1200,height:550,position:{x:left,y:top}}); //to change position always
            //$("#popup_window").jqxWindow({position:{x:left,y:top}});
            var row=$(this).attr('data-item-no');
            var id=$("#system_jqx_container").jqxGrid('getrowdata',row).id;
            $.ajax(
            {
                url: "<?php echo site_url($CI->controller_url.'/index/details_popup') ?>",
                type: 'POST',
                datatype: "JSON",
                data:
                {
                    html_container_id:'#popup_content',
                    id:id,
                    date_from_start_page: $('#date_from_start_page').val(),
                    date_to_start_page: $('#date_to_start_page').val()
                },
                success: function (data, status)
                {

                },
                error: function (xhr, desc, err)
                {
                    console.log("error");
                }
            });
            $("#popup_window").jqxWindow('open');
        });
        var url="<?php echo site_url($CI->controller_url.'/index/get_items'); ?>";
        var source =
        {
            dataType:"json",
            dataFields:[
                {name: 'id', type: 'int'},
                {name: 'name', type: 'string'},
                {name: 'date_start', type: 'string'},
                {name: 'type_name', type: 'string'},
                {name: 'class_name', type: 'string'},
                {name: 'category_name', type: 'string'},
                {name: 'employee_name', type: 'string'},
                {name: 'department_name', type: 'string'},
                {name: 'office_name', type: 'string'},
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
            showstatusbar: true,
            rowsheight: 45,
            columns:[
                { text: '<?php echo $CI->lang->line('LABEL_FILE_NAME'); ?>', dataField: 'name',width:'300',pinned:true,rendered: tooltiprenderer},
                { text: 'Responsible Employee', dataField: 'employee_name',width:'150',pinned:true,rendered: tooltiprenderer},
                { text: 'Opening Date', dataField: 'date_start',width:'100',pinned:true,rendered: tooltiprenderer},
                { text: '<?php echo $CI->lang->line('LABEL_FILE_CATEGORY'); ?>', dataField: 'category_name',pinned:true,rendered: tooltiprenderer,filtertype:'list'},
                { text: '<?php echo $CI->lang->line('LABEL_FILE_CLASS'); ?>', dataField: 'class_name',pinned:true,rendered: tooltiprenderer,filtertype:'list'},
                { text: '<?php echo $CI->lang->line('LABEL_FILE_TYPE'); ?>', dataField: 'type_name',pinned:true,rendered: tooltiprenderer,filtertype:'list'},
                { text: 'Office', dataField: 'office_name',pinned:false,rendered: tooltiprenderer,filtertype:'list'},
                { text: 'Department', dataField: 'department_name',pinned:true,rendered: tooltiprenderer,filtertype:'list'},
                { text: 'Details', dataField: 'details_button',cellsrenderer:cellsrenderer}
            ]
        });
    });
</script>
