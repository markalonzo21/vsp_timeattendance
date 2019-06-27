<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('memployee');
		$this->load->model('mreport');
	}

	public function index()
	{
		$data["result"] = $this->mreport->all();
		$this->load->view('template/header');
		$this->load->view('reports',$data);
		$this->load->view('template/footer');
	}

	public function displayData()
	{
		$data = json_encode($this->mreport->all());

		echo $data;
	}

	//live feed from cloud data
	public function pollEvent($timestamp)
	{
		if($timestamp == 'undefined')
		{
			$timestamp = round(microtime(true) * 1000);
		}
		// $current_time = round(microtime(true) * 1000);
		$data = $this->memployee->cloudDataEventsPoll($timestamp);
		echo $data;
	}

	//live feed from cloud data
	public function events($timestamp)
	{
		$data = $this->memployee->cloudDataEvents($timestamp);
		// $output = ($data != null) ? $data[0]["idClass"] : "unknown";
		// echo $output;
		if($data != null)
		{
			$inputs = array();
			for($i=0; $i < count($data); $i++)
			{
				if($data[$i]["idClass"] == "noconcern" || $data[$i]["idClass"] == "concern")
				{
					$inputs = array(
						'emp_name' => $data[$i]["name"],
						'date_recognized' => date('m/d/Y h:i:s'),
						'idClass' => $data[$i]["idClass"]
					);
					$this->mreport->logs($inputs);
				}
			}
		}	
	}
}