<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller
{
	public function index()
	{
        $this->load->dbforge();
        $tables=$this->db->list_tables();
        foreach($tables as $table)
        {
            if ($this->db->field_exists('id', $table))
            {
                echo 'Y - ';
                $fields = array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'auto_increment' => TRUE
                ),
                );
                if($this->dbforge->modify_column($table, $fields))
                {
                    echo 'Y ';
                }
                else
                {
                    echo 'N ';
                }
            }
            else
            {
                echo 'N -N ';
            }
            echo $table.'<br>';
        }
	}
}
