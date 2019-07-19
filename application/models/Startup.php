<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Startup extends CI_Model
{
	function __construct()
	{
		parent:: __construct();

		$this->checkIfAdminPresent();
		$this->defaultSettings();
	}

	private function createAdmin()
	{
		$inputs = array(
			'username' => 'admin',
			'password' => 'admin'
		);
		$this->mongo_db->insert('users', $inputs);
	}

	private function checkIfAdminPresent()
	{
		if(!empty($this->mongo_db->get('users')))
		{
			return TRUE;
		}
		else
		{
			$this->createAdmin();
		}
	}

	private function defaultSettings()
	{
		if($this->mongo_db->get('settings'))
		{
			return TRUE;
		}
		else
		{
			$inputs = array(
			'directory' => 'test',
			'username' => 'thevaluesystems',
			'password' => 'fastb00t'
			);

			$this->mongo_db->insert('settings', $inputs);
		}
	}
}