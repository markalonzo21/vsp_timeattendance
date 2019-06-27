<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('memployee');
	}

	public function index()
	{
		$data["result"] = $this->memployee->all();
		$data["people"] = $this->memployee->tallyData();
		$this->load->view('template/header');
		$this->load->view('employees',$data);
		$this->load->view('template/footer');
	}

	public function updateRecords()
	{
		$this->memployee->updateRecord();
	}

	public function trackRecord()
	{
		$this->memployee->tallyData();
	}

	public function register()
	{
		date_default_timezone_set('Asia/Kuala_Lumpur');

		$inputs = array('emp_name' => $this->input->post('emp_name'),
						'position' => $this->input->post('emp_pos'),
						'date_registed' => date('m/d/Y h:i:s', time()),
						'fr' => FALSE
		);
		$this->memployee->create($inputs);
	}

	public function edit($_id)
	{
		$data["result"] = $this->memployee->getData($_id);

		$this->load->view('template/header');
		$this->load->view('edit', $data);
		$this->load->view('template/footer');
	}

	public function update($_id)
	{
		$inputs = array('emp_name' => $this->input->post('emp_name'),
						'position' => $this->input->post('emp_pos')
		);
		$this->memployee->update($_id, $inputs);
	}

	public function delete($_id)
	{
		$this->memployee->delete_emp($_id);
	}
}