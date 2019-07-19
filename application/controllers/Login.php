<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Login extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('muser');
	}

	public function index()
	{
		$this->load->view('template/header');
		$this->load->view('login');
		$this->load->view('template/footer');
	}

	public function authenticate()
	{
		if($this->input->post('username'))
		{
			if($data = $this->muser->authenticate($this->input->post('username'), $this->input->post('password')))
			{
				$sess =  array( "username" => $data[0]["username"], "_id" => $data[0]["_id"]);
				$this->session->set_userdata($sess);
				if($this->session->userdata("_id"))
				{
					redirect('report');
				}
			}
			else
			{
				$this->session->set_flashdata('error', 'Invalid username or password');
				redirect('login');
			}
		}
		else
		{
			$this->session->set_flashdata('error', 'Invalid username or password');
			$this->index();
		}
	}

	public function signout()
	{
		$this->session->unset_userdata(array('username', '_id'));
		$this->session->set_flashdata('info', 'Thanks for Stopping by! :)');
		redirect('login');
	}
}