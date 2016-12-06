<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class External_login extends CI_Controller
{
	public function index()
	{

	}
    public function login($auth_code)
    {
        $db_login=$this->load->database('armalik_login',TRUE);
        $db_login->from($this->config->item('table_other_sites_visit'));
        $db_login->where('auth_key',$auth_code);
        $db_login->where('status',$this->config->item('system_status_active'));
        $info=$db_login->get()->row_array();
        if($info)
        {
            $db_login->where('id',$info['id']);
            $db_login->set('status', $this->config->item('system_status_inactive'));
            $db_login->update($this->config->item('table_other_sites_visit'));

            $this->session->set_userdata("user_id", $info['user_id']);

        }
        redirect(site_url());

    }
}
