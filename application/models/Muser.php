<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Muser extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function authenticate( $username, $password )
	{
		$this->mongo_db->where(array('username' => $username,
			'password' => $password));
		$query = $this->mongo_db->get('users');
		return $query;
	}
}