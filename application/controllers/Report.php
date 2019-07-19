<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class Report extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('memployee');
		$this->load->model('mreport');

		if(!$this->session->userdata('_id')){
			header('Location: '.site_url('login'));
			$this->session->set_flashdata('error','You Must Logged in first');
		}
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
		set_time_limit(0);
		clearstatcache();
		if($timestamp == 'undefined')
		{
			$timestamp = round(microtime(true) * 1000);
		}
		$data = $this->memployee->cloudDataEventsPoll($timestamp);
		$this->events($data);
		echo $data;
	}

	//live feed from cloud data
	public function events($timestamp)
	{
		date_default_timezone_set('Asia/Kuala_Lumpur');
		$data = $this->memployee->cloudDataEvents($timestamp);
		if($data != null)
		{
			$inputs = array();
			for($i=0; $i < count($data); $i++)
			{
				if($data[$i]["idClass"] == "noconcern" || $data[$i]["idClass"] == "concern")
				{
					$inputs = array(
						'emp_name' => $data[$i]["name"],
						'date_recognized' => array(
							'date' => date('m/d/Y'),
							'time' => date('H:i:s')
						),
						'idClass' => $data[$i]["idClass"],
						'source' => $data[$i]["sourceId"],
						'device' => 'Web'
					);
					$this->mreport->logs($inputs);
				}
			}
		}
	}

	// Template Report
	public function generateReport($date=null)
	{
		if(isset($date))
		{
			$range_date = base64_decode($date);
			$dateRange = explode(" - ", $range_date);
			$diff = (strtotime($dateRange[1]) - strtotime($dateRange[0]))/86400;
			$start_date = $dateRange[0];
		}
		else
		{
			$dates = $this->mreport->getAllDate();
			$start_date = $dates[0][0]["date_recognized"]["date"];
			$end_date = $dates[1][0]["date_recognized"]["date"];
			$diff = (strtotime($end_date) - strtotime($start_date))/86400;
			$range_date = $start_date." - ".$end_date;
		}
			$data = $this->mreport->getReport($range_date);
			$distinct_data = $this->mreport->distinct_range($range_date);
			
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('template.xlsx');
		// /////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		
		for($i = 0; $i <= $diff; $i++)
		{
			$date = strtotime("+".$i." day", strtotime($start_date));
			$title = date('m-d-Y', $date);
			${"worksheet$i"} = clone $spreadsheet->getSheetByName('Sheet1');
			${"worksheet$i"}->setTitle($title);
			$spreadsheet->addSheet(${"worksheet$i"});
			$spreadsheet->setActiveSheetIndexByName($title);

			$new_title = date('d/m/Y', strtotime($title));
			// TIME LOGS START HERE
			$col = 6;
			for($x = 0; $x < count($data); $x++)
			{
				// var_dump($new_title);
				if($data[$x]['date_recognized']["date"] == $new_title)
				{
					// name
					$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(3, $col, $data[$x]['emp_name']);
					// date
					$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(8, $col, date('m/d/Y', strtotime($data[$x]['date_recognized']["date"]) ));
					// time
					$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(6, $col, date('H:i:s', strtotime($data[$x]['date_recognized']["time"]) ));
					// idclass
					$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(11, $col, $data[$x]['idClass']);
					// source
					$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(13, $col, ( array_key_exists('source', $data[$x]) ) ? $data[$x]['source'] : "N/A" );
			        $col++;
				}
	        }
	        //  TIME LOGS ENDS HERE

	        // DAILY TIME IN AND OUT START HERE
	        $dailies_col = 6;

	        for($y = 0; $y < count($distinct_data["time_ins"]); $y++)
	        {
	        	for($z = 0; $z < count($distinct_data["names"]); $z++)
	        	{
	        		if(!empty($distinct_data["time_ins"][$y]))
	        		{
	        			if($distinct_data["time_ins"][$y][0]["date_recognized"]["date"] == $new_title)
		        		{
		   					if($distinct_data["time_ins"][$y][0]["emp_name"] == $distinct_data["names"][$z])
		   					{
		   						$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(15, $dailies_col, $distinct_data["time_ins"][$y][0]["emp_name"]);
		   						$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(19, $dailies_col, date('H:i:s', strtotime($distinct_data["time_ins"][$y][0]['date_recognized']["time"])) );
					        	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(22, $dailies_col, date('H:i:s', strtotime($distinct_data["time_outs"][$y][0]['date_recognized']["time"])) );
					        	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(26, $dailies_col, number_format(((strtotime($distinct_data["time_outs"][$y][0]['date_recognized']["time"]) - strtotime($distinct_data["time_ins"][$y][0]['date_recognized']["time"]))/3600), 2)  );
				        		$dailies_col++;
		   					}   			
		        		}
	        		}
	        		
	        	}
	        }
	        // DAILY TIME IN AND OUT ENDS HERE
		}

		$hiddenSheet = $spreadsheet->getSheetByName('Sheet1');
		$hiddenSheet->setSheetState(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::SHEETSTATE_VERYHIDDEN);

        // create xls file
        $writer = new Xls($spreadsheet);
        // filename
        $filename = 'time_attendance_'.date('m/d/Y').'.xls';
        // headers
        header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		ob_end_clean();
		// force download xls file
		return $writer->save('php://output');
	}

	public function testing()
	{
		$this->load->model('msettings');
		
		var_dump($this->memployee->tallyData());
		// var_dump($this->msettings->getSettings());
		// $data = $this->mreport->getAllDate();
		// var_dump($data[0][0]["date_recognized"]["date"]);
		// $distinct_data = $this->mreport->distinct_range("07/04/2019 - 07/05/2019");
		// var_dump($distinct_data["time_ins"]);
	}
}