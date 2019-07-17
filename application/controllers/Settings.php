<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller
{
	function __construct()
	{
		parent:: __construct();
		$this->load->model('msettings');
	}

	public function index()
	{
		$data['data'] = $this->msettings->getSettings();
		$this->load->view('template/header');
		$this->load->view('settings', $data);
		$this->load->view('template/footer');
	}

	public function update()
	{
		$this->msettings->updateSettings();
		redirect('settings');
	}
}