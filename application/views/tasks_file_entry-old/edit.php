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

        </div>

    </div>
    <div class="clearfix"></div>
</form>

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
        $(document).off("change", "#id_category");
        $(document).on("change","#id_category",function()
        {
            $("#id_class").val("");
            $("#id_type").val("");
            $("#id_name").val("");
            $("#files_container").html('');
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
        $(document).off("change", "#id_class");
        $(document).on("change","#id_class",function()
        {
            $("#id_type").val("");
            $("#id_name").val("");
            $("#files_container").html('');
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
        $(document).off("change", "#id_type");
        $(document).on("change","#id_type",function()
        {
            $("#id_name").val("");
            $("#files_container").html('');
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
        $(document).off("change", "#id_name");
        $(document).on("change","#id_name",function()
        {
            $("#files_container").html('');
            var id_name=$('#id_name').val();
            $('input[name="id"]').val(id_name);
            if(id_name>0)
            {
                $.ajax(
                    {
                        url: "<?php echo site_url($CI->controller_url.'/index/details/'); ?>"+'/'+id_name,
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
    });
</script>
<div id="upload-complete-info"></div>
