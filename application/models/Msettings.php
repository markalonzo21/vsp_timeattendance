<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MSettings extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();

	}

	public function updateSettings()
	{
		$data = array(
			'directory' => $this->input->post('directory'),
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password')
		);
		
		// update values
		if($this->_id())
		{
			$this->mongo_db->where('_id', new \MongoId($this->_id()))->set($data);
			$status = $this->mongo_db->update('settings');
			if($status)
			{
				$this->session->set_flashdata('info', 'Updated!');
			}
			// return TRUE;
		}
		else
		{
			// set default values
			$this->mongo_db->insert('settings', $data);
			// return TRUE;
		}
	}

	public function getSettings()
	{
		if($this->mongo_db->get('settings'))
		{
			return $this->mongo_db->get('settings');
		}
		else
		{
			return FALSE;
		}
	}

	public function _id()
	{
		$result = $this->mongo_db->select(array('_id'))->limit(1)->get('settings');
		if($result)
		{
			return $result[0]['_id'];	
		}
	}

	public function directory()
	{
		$result = $this->mongo_db->select(array('directory'), array('_id'))->get('settings');
		if($result)
		{
			return $result[0]['directory'];	
		}
	}

	public function credentials()
	{
		$result = $this->mongo_db->select(array('password','username'), array('_id'))->get('settings');
		if($result)
		{
			$password = $result[0]['password'];
			$username = $result[0]['username'];
			return $username.":".$password;
		}
	}

}