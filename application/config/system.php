<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['system_site_short_name']='fms';
$config['offline_controllers']=array('home','sys_site_offline');//active controller when site is offline
$config['external_controllers']=array('home');//user can use them without login
$config['system_max_actions']=7;
$config['system_fms_max_actions']=4;

//dbs
$config['system_db_login']='shaiful_arm_login';
$config['system_db_fms']='arm_fms';

$config['system_status_active']='Active';
$config['system_status_inactive']='In-Active';
$config['system_status_delete']='Deleted';

$config['system_image_base_url']='http://localhost/fms/';
$config['system_folder_upload']='files';
$config['system_folder_upload_delete']='deleted';

$config['system_digital_file_image']='image';
$config['system_digital_file_word']='word';
$config['system_digital_file_book']='book';
$config['system_digital_file_slide_show']='slide_show';
$config['system_digital_file_excel']='excel';
