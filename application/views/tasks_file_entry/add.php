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

        <div style="" class="row show-grid">
            <div class="col-xs-4">
                <label for="id_category" class="control-label pull-right">
                    <?php echo $CI->lang->line('LABEL_FILE_CATEGORY');?>
                    <span style="color:#FF0000">*</span>
                </label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <select id="id_category" name="items[id_category]" class="form-control" tabindex="-1">
                    <option value=""><?php echo $this->lang->line('SELECT');?></option>
                    <?php
                    foreach($categories as $category)
                    {?>
                        <option value="<?php echo $category['value']?>" <?php if($category['value']==$items['id_category']){ echo 'selected';}?>><?php echo $category['text'];?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>

        <div style="<?php if(!($items['id_class']>0)){echo 'display:none';} ?>" class="row show-grid" id="class_container">
            <div class="col-xs-4">
                <label for="id_class" class="control-label pull-right">
                    <?php echo $CI->lang->line('LABEL_FILE_CLASS');?>
                    <span style="color:#FF0000">*</span></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <select id="id_class" name="items[id_class]" class="form-control" tabindex="-1">
                    <option value=""><?php echo $this->lang->line('SELECT');?></option>
                    <?php
                    foreach($classes as $class)
                    {?>
                        <option value="<?php echo $class['value']?>" <?php if($class['value']==$items['id_class']){ echo 'selected';}?>><?php echo $class['text'];?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>

        <div style="<?php if(!($items['id_type']>0)){echo 'display:none';} ?>" class="row show-grid" id="type_container">
            <div class="col-xs-4">
                <label for="id_type" class="control-label pull-right">
                    <?php echo $CI->lang->line('LABEL_FILE_TYPE');?>
                    <span style="color:#FF0000">*</span>
                </label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <select id="id_type" name="items[id_type]" class="form-control">
                    <option value=""><?php echo $this->lang->line('SELECT');?></option>
                    <?php
                    foreach($types as $type)
                    {?>
                        <option value="<?php echo $type['value']?>" <?php if($type['value']==$items['id_type']){echo "selected";}?>><?php echo $type['text'];?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>

        <div style="<?php if(!($items['id_name']>0)){echo 'display:none';} ?>" class="row show-grid" id="name_container">
            <div class="col-xs-4">
                <label for="id_name" class="control-label pull-right">
                    <?php echo $CI->lang->line('LABEL_FILE_NAME');?>
                    <span style="color:#FF0000">*</span>
                </label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <select id="id_name" name="items[id_name]" class="form-control">
                    <option value=""><?php echo $this->lang->line('SELECT');?></option>
                    <?php
                    foreach($names as $name)
                    {?>
                        <option value="<?php echo $name['value']?>" <?php if($name['value']==$items['id_name']){echo "selected";}?>><?php echo $name['text'];?></option>
                    <?php
                    }
                    ?>
                </select>
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
        turn_off_triggers();
        $('video').hide();
        var camera=$('#camera');
        var take_photo=$('#take-photo');
        camera.data('check',false);
        camera.data('counter',0);
        take_photo.hide();

        var files_container=$('#files_container tbody');
        var form_obj=$('#save_form');
        form_obj.data('form_data_append',true);
        form_obj.data('file_camera',"");
        form_obj.data('file_drag_drop',"");

        $(document).on("change","#id_category",function()
        {
            $("#id_class").val("");
            $("#id_type").val("");
            $("#id_name").val("");
            var id_category=$('#id_category').val();
            if(id_category>0)
            {
                $('#class_container').show();
                $('#type_container').hide();
                $('#name_container').hide();
                $.ajax(
                {
                    url: "<?php echo site_url($CI->controller_url.'/index/get_drop_down'); ?>",
                    type: 'POST',
                    datatype: "JSON",
                    data:
                    {
                        html_container_id:'#id_class',
                        file_type:'class',
                        id:id_category
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
                $('#class_container').hide();
                $('#type_container').hide();
                $('#name_container').hide();
            }
        });
        $(document).on("change","#id_class",function()
        {
            $("#id_type").val("");
            $("#id_name").val("");
            var id_class=$('#id_class').val();
            if(id_class>0)
            {
                $('#type_container').show();
                $('#name_container').hide();
                $.ajax(
                    {
                        url: "<?php echo site_url($CI->controller_url.'/index/get_drop_down'); ?>",
                        type: 'POST',
                        datatype: "JSON",
                        data:
                        {
                            html_container_id:'#id_type',
                            file_type:'type',
                            id:id_class
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
                $('#type_container').hide();
                $('#name_container').hide();
            }
        });
        $(document).on("change","#id_type",function()
        {
            $("#id_name").val("");
            var id_type=$('#id_type').val();
            if(id_type>0)
            {
                $('#name_container').show();
                $.ajax(
                    {
                        url: "<?php echo site_url($CI->controller_url.'/index/get_drop_down'); ?>",
                        type: 'POST',
                        datatype: "JSON",
                        data:
                        {
                            html_container_id:'#id_name',
                            file_type:'name',
                            id:id_type
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
                $('#name_container').hide();
            }
        });
        $(document).on("change","#id_name",function()
        {
            var id_name=$('#id_name').val();
            $('input[name="id"]').val(id_name);
            if(id_name>0)
            {
                $.ajax(
                    {
                        url: base_url+"<?php echo $CI->controller_url.'/index/edit/'; ?>"+id_name,
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
                                    $('#id_name').val("");
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
