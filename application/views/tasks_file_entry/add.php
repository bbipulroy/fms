<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$CI = & get_instance();
$action_data=array();
$action_data['action_refresh']=site_url($CI->controller_url);
$action_data['action_save']='#save_form';
$action_data['action_save_new']='#save_form';
//$action_data['action_clear']='#save_form';
$CI->load->view('action_buttons',$action_data);
?>
<form class="form_valid" id="save_form" action="<?php echo site_url($CI->controller_url.'/index/save');?>" method="post">
    <input type="hidden" name="id" value="<?php echo $items['id']; ?>">
    <input type="hidden" id="system_save_new_status" name="system_save_new_status" value="0">
    <div class="row widget">
        <div class="widget-header">
            <div class="title">
                <?php echo $title; ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="row show-grid">
            <div class="col-xs-4">
                <label for="date_entry_text" class="control-label pull-right">
                    Entry Date
                    <span style="color:#FF0000">*</span>
                </label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <input type="text" name="items[date_entry_text]" id="date_entry_text" class="form-control datepicker" value="<?php echo $items['date_entry_text'] ?>"/>
            </div>
        </div>

        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label for="id_file_type_1" class="control-label pull-right">
                    <?php echo $CI->lang->line('LABEL_FILE_TYPE_1');?>
                    <span style="color:#FF0000">*</span>
                </label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <select id="id_file_type_1" name="items[id_file_type_1]" class="form-control" tabindex="-1">
                    <option value=""><?php echo $this->lang->line('SELECT');?></option>
                    <?php
                    foreach($file_type_1s as $file_type_1)
                    {?>
                        <option value="<?php echo $file_type_1['value']?>" <?php if($file_type_1['value']==$items['id_file_type_1']){ echo 'selected';}?>><?php echo $file_type_1['text'];?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>

        <div style="<?php if(!($items['id_file_type_2']>0)){echo 'display:none';} ?>" class="row show-grid" id="id_file_type_2_container">
            <div class="col-xs-4">
                <label for="id_file_type_2" class="control-label pull-right">
                    <?php echo $CI->lang->line('LABEL_FILE_TYPE_2');?>
                    <span style="color:#FF0000">*</span></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <select id="id_file_type_2" name="items[id_file_type_2]" class="form-control" tabindex="-1">
                    <option value=""><?php echo $this->lang->line('SELECT');?></option>
                    <?php
                    foreach($file_type_2s as $file_type_2)
                    {?>
                        <option value="<?php echo $file_type_2['value']?>" <?php if($file_type_2['value']==$items['id_file_type_2']){ echo 'selected';}?>><?php echo $file_type_2['text'];?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>

        <div style="<?php if(!($items['id_file_type_3']>0)){echo 'display:none';} ?>" class="row show-grid" id="id_file_type_3_container">
            <div class="col-xs-4">
                <label for="id_file_type_3" class="control-label pull-right">
                    <?php echo $CI->lang->line('LABEL_FILE_TYPE_3');?>
                    <span style="color:#FF0000">*</span>
                </label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <select id="id_file_type_3" name="items[id_file_type_3]" class="form-control">
                    <option value=""><?php echo $this->lang->line('SELECT');?></option>
                    <?php
                    foreach($file_type_3s as $file_type_3)
                    {?>
                        <option value="<?php echo $file_type_3['value']?>" <?php if($file_type_3['value']==$items['id_file_type_3']){echo "selected";}?>><?php echo $file_type_3['text'];?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>

        <div style="<?php if(!($items['id_file_type_4']>0)){echo 'display:none';} ?>" class="row show-grid" id="id_file_type_4_container">
            <div class="col-xs-4">
                <label for="id_file_type_4" class="control-label pull-right">
                    <?php echo $CI->lang->line('LABEL_FILE_TYPE_4');?>
                    <span style="color:#FF0000">*</span>
                </label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <select id="id_file_type_4" name="items[id_file_type_4]" class="form-control">
                    <option value=""><?php echo $this->lang->line('SELECT');?></option>
                    <?php
                    foreach($file_type_4s as $file_type_4)
                    {?>
                        <option value="<?php echo $file_type_4['value']?>" <?php if($file_type_4['value']==$items['id_file_type_4']){echo "selected";}?>><?php echo $file_type_4['text'];?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>

        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label for="id_hc_location" class="control-label pull-right">
                    Hardcopy Location
                    <span style="color:#FF0000">*</span>
                </label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <select id="id_hc_location" name="items[id_hc_location]" class="form-control" tabindex="-1">
                    <option value=""><?php echo $this->lang->line('SELECT');?></option>
                    <?php
                    foreach($hc_locations as $hc_location)
                    {?>
                        <option value="<?php echo $hc_location['value']?>"><?php echo $hc_location['text'];?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>


        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label for="remarks" class="control-label pull-right">
                    Remarks
                    <span style="color:#FF0000">*</span>
                </label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <textarea name="items[remarks]" id="remarks" class="form-control"><?php echo $items['remarks'] ?></textarea>
            </div>
        </div>

        <div id="files_container">
            <div style="overflow-x: auto;" class="row show-grid">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="min-width: 250px;">File/Picture</th>
                            <th style="min-width: 50px;">UPLOAD</th>
                        </tr>
                    </thead>
                    <tbody>
                    <!-- php codes -->
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row show-grid">
            <div class="col-xs-4">

            </div>
            <div class="col-xs-4">
                <button type="button" class="btn btn-warning system_button_add" data-current-id="0">
                    <?php echo $CI->lang->line('LABEL_ADD_MORE'); ?>
                </button>
                <button id="camera" type="button" class="btn btn-warning">
                    Camera
                </button>
                <button id="take-photo" type="button" class="btn btn-warning">
                    Take Photo
                </button>
                <button id="camera-close" type="button" class="btn btn-warning">
                    Camera Off
                </button>
            </div>
            <div class="col-xs-4">

            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</form>
<div id="system_content_add" style="display: none;">
    <table>
        <tbody>
            <tr>
                <td>
                    <div class="preview_container_file">
                    </div>
                </td>
                <td>
                    <input type="file" class="browse_button_new file_new"><br>
                    <button type="button" class="btn btn-danger system_button_delete file_new"><?php echo $CI->lang->line('DELETE'); ?></button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="row show-grid">
    <div class="col-xs-12">
        <video id="video" width="1000" height="600" controls autoplay></video>
    </div>
</div>
<script type="text/javascript">
    var camera_stream;
    function camera_on()
    {
        $('video').show();
        if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia)
        {
            navigator.mediaDevices.getUserMedia(
            {
                video:true
            })
            .then(function(stream)
            {
                camera_stream=stream;
                video.src=window.URL.createObjectURL(stream);
                video.play();
            });
        }
    }
    jQuery(document).ready(function()
    {
        $('video').hide();
        var camera=$('#camera');
        var take_photo=$('#take-photo');
        camera.data('check',false);
        camera.data('counter',0);
        take_photo.hide();

        var files_container=$('#files_container tbody');
        $(".datepicker").datepicker({dateFormat : display_date_format});
        $('#date_entry_text').data('predefined_date',$('#date_entry_text').val());

        var form_obj=$('#save_form');
        form_obj.data('form_data_append',true);
        form_obj.data('file_camera',"");
        form_obj.data('file_drag_drop',"");

        $(document).on("change","#id_file_type_1",function()
        {
            $("#id_file_type_2").val("");
            $("#id_file_type_3").val("");
            $("#id_file_type_4").val("");
            var id_file_type_1=$('#id_file_type_1').val();
            if(id_file_type_1>0)
            {
                $('#id_file_type_2_container').show();
                $('#id_file_type_3_container').hide();
                $('#id_file_type_4_container').hide();
                $.ajax(
                {
                    url: "<?php echo site_url($CI->controller_url.'/index/get_drop_down'); ?>",
                    type: 'POST',
                    datatype: "JSON",
                    data:
                    {
                        html_container_id:'#id_file_type_2',
                        table:'<?php echo $CI->config->item('table_setup_file_type_2'); ?>',
                        table_column:'id_file_type_2',
                        table_column_check:'id_file_type_1',
                        table_column_value:id_file_type_1
                    },
                    success: function (data, status)
                    {

                    },
                    error: function (xhr, desc, err)
                    {
                        console.log("error");
                    }
                });
            }
            else
            {
                $('#id_file_type_2_container').hide();
                $('#id_file_type_3_container').hide();
                $('#id_file_type_4_container').hide();
            }
        });
        $(document).on("change","#id_file_type_2",function()
        {
            $("#id_file_type_3").val("");
            $("#id_file_type_4").val("");
            var id_file_type_2=$('#id_file_type_2').val();
            if(id_file_type_2>0)
            {
                $('#id_file_type_3_container').show();
                $('#id_file_type_4_container').hide();
                $.ajax(
                    {
                        //url: base_url+"common_controller/get_dropdown_with_select",
                        url: "<?php echo site_url($CI->controller_url.'/index/get_drop_down'); ?>",
                        type: 'POST',
                        datatype: "JSON",
                        data:
                        {
                            html_container_id:'#id_file_type_3',
                            table:'<?php echo $CI->config->item('table_setup_file_type_3'); ?>',
                            table_column: 'id_file_type_3',
                            table_column_check:'id_file_type_2',
                            table_column_value:id_file_type_2
                        },
                        success: function (data, status)
                        {

                        },
                        error: function (xhr, desc, err)
                        {
                            console.log("error");
                        }
                    });
            }
            else
            {
                $('#id_file_type_3_container').hide();
                $('#id_file_type_4_container').hide();
            }
        });
        $(document).on("change","#id_file_type_3",function()
        {
            $("#id_file_type_4").val("");
            var id_file_type_3=$('#id_file_type_3').val();
            if(id_file_type_3>0)
            {
                $('#id_file_type_4_container').show();
                $.ajax(
                    {
                        //url: base_url+"common_controller/get_dropdown_with_select",
                        url: "<?php echo site_url($CI->controller_url.'/index/get_drop_down'); ?>",
                        type: 'POST',
                        datatype: "JSON",
                        data:
                        {
                            html_container_id:'#id_file_type_4',
                            table:'<?php echo $CI->config->item('table_setup_file_type_4'); ?>',
                            table_column:'id_file_type_4',
                            table_column_check:'id_file_type_3',
                            table_column_value:id_file_type_3
                        },
                        success: function (data, status)
                        {

                        },
                        error: function (xhr, desc, err)
                        {
                            console.log("error");
                        }
                    });
            }
            else
            {
                $('#id_file_type_4_container').hide();
            }
        });
        $(document).on("change","#id_file_type_4",function()
        {
            var id_file_type_4=$('#id_file_type_4').val();
            $('input[name="id"]').val(id_file_type_4);
            if(id_file_type_4>0)
            {
                $.ajax(
                    {
                        url: base_url+"<?php echo $CI->controller_url.'/index/edit/'; ?>"+id_file_type_4,
                        type: 'POST',
                        datatype: "JSON",
                        data:
                        {
                            html_container_id:'#files_container tbody'
                        },
                        success: function (data, status)
                        {
                            if(data.status==false)
                            {
                                if(data.status==false)
                                {
                                    $('#id_file_type_4').val("");
                                }
                            }
                        },
                        error: function (xhr, desc, err)
                        {
                            console.log("error");
                        }
                    });
            }
            else
            {
                files_container.empty();
                set_current_id("0");
                $('#save_form').data('file_camera',"");
                $('#id_hc_location').val("");
                $('#date_entry_text').val($('#date_entry_text').data('predefined_date'));
                $('#remarks').val("");
            }
        });
        $(document).on("click", ".system_button_add", function(event)
        {
            var current_id=get_current_id()+1;
            set_current_id(current_id);
            var content_id='#system_content_add table tbody';

            $(content_id+' .browse_button_new').attr('data-preview-container','#preview_container_file_'+current_id);
            $(content_id+' .browse_button_new').attr('name','file_'+current_id);
            $(content_id+' .browse_button_new').attr('id','file_'+current_id);
            $(content_id+' .file_new').attr('data-current-id',current_id);
            $(content_id+' .preview_container_file').attr('id','preview_container_file_'+current_id);
            
            var html=$(content_id).html();
            files_container.append(html);

            $(content_id+' .browse_button_new').removeAttr('name');
            $(content_id+' .browse_button_new').removeAttr('data-preview-container');
            $(content_id+' .browse_button_new').removeAttr('id');
            $(content_id+' .file_new').removeAttr('data-current-id');
            $(content_id+' .preview_container_file').removeAttr('id');
            
            set_filestyle('#file_'+current_id);
        });
        $(document).on("click", ".system_button_delete", function(event)
        {
            $(this).closest('tr').remove();
        });
        $(document).on('click','#camera',function()
        {
            if(camera.data('check'))
            {
                camera_off();
                camera.data('check',false);
                take_photo.hide();
            }
            else
            {
                take_photo.show();
                camera.data('check',true);
                if(camera.data('no_need_to_on'))
                {
                    camera_on_false();
                }
                else
                {
                    camera_on();
                    camera.data('no_need_to_on',true);
                }
            }
        });
        $(document).on('click','#take-photo',function()
        {
            var canvas=document.createElement("canvas");
            canvas.width=video.videoWidth;
            canvas.height=video.videoHeight;
            canvas.getContext('2d').drawImage(video,0,0,canvas.width,canvas.height);
            var image_data=canvas.toDataURL();
            alert(image_data);
        });
        $(document).on('click','#camera-close',function()
        {
            camera_off();
            take_photo.hide();
            camera_stream.stop();
            camera.data('no_need_to_on',false);
        });
        function camera_off()
        {
            $('video').hide();
            video.pause();
        }
        function camera_on_false()
        {
            $('video').show();
            video.play();
        }
        function get_current_id()
        {
            return parseInt($('.system_button_add').attr('data-current-id'));
        }
        function set_current_id(id)
        {
            $('.system_button_add').attr('data-current-id',id);
        }
        function set_filestyle(where)
        {
            $(where).filestyle({input: false,icon: false,buttonText: "Upload",buttonName: "btn-primary"});
        }
    });
</script>
