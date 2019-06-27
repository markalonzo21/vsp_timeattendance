<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Home extends CI_Controller
{

	public function __construct(){
		parent:: __construct();

		if(!$this->session->userdata('_id')){
			header('Location: '.site_url('login'));
			$this->session->set_flashdata('error','You Must Logged in first');
		}
	}

	public function index()
	{
		$this->load->view('template/header');
		$this->load->view('home');
		$this->load->view('template/footer');
	}
	
}