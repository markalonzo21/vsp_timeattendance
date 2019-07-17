<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller
{
	function __construct()
	{
		parent:: __construct();
	}

	public function index()
	{
		$this->load->view('template/header');
		$this->load->view('settings');
		$this->load->view('template/footer');
	}
}