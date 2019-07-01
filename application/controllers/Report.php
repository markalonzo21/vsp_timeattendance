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
						'source' => $data[$i]["sourceId"]
					);
					$this->mreport->logs($inputs);
				}
			}
		}
	}

	// Template Report
	public function generateReport()
	{
		$data = $this->mreport->all();
		// $spreadsheet = new Spreadsheet();
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('template.xlsx');
		
		// TIME LOGS START HERE
		$col = 6;
		for($i = 0; $i < count($data); $i++)
		{
			// name
			$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(3, $col, $data[$i]['emp_name']);
			// date
			$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(8, $col, date('m/d/Y', strtotime($data[$i]['date_recognized']["date"]) ));
			// time
			$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(6, $col, date('H:i:s A', strtotime($data[$i]['date_recognized']["time"]) ));
			// idclass
			$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(11, $col, $data[$i]['idClass']);
			// source
			$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(13, $col, ( array_key_exists('source', $data[$i]) ) ? $data[$i]['source'] : "N/A" );
	        $col++;
        }
        //  TIME LOGS ENDS HERE

        // DAILY TIME IN AND OUT START HERE
        $data = $this->mreport->distinct_all();
        $column_array = array_chunk($data["names"], 1);
        $dailies_col = 6;
        $spreadsheet->getActiveSheet()->fromArray($column_array, NULL, 'O6');
        for ($i=0; $i < count($column_array); $i++) {
        	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(19, $dailies_col, date('H:i:s A', strtotime($data["time_ins"][$i][0]['date_recognized']["time"])) );
        	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(22, $dailies_col, date('H:i:s A', strtotime($data["time_outs"][$i][0]['date_recognized']["time"])) );
        	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(26, $dailies_col, (strtotime($data["time_outs"][$i][0]['date_recognized']["time"]) - strtotime($data["time_ins"][$i][0]['date_recognized']["time"]))/3600 );
        	$dailies_col++;
        }
        // DAILY TIME IN AND OUT ENDS HERE

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
		$writer->save('php://output');
	}

	// public function rangeReport()
	// {
	// 	if(isset($_POST["dateRange"]))
	// 	{
	// 		$dates = explode(' - ', $_POST["dateRange"]);
	// 		$data = $this->mreport->generateReportByRange($dates);

	// 		if($data)
	// 		{
	// 			$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('template.xlsx');
		
	// 			// TIME LOGS START HERE
	// 			$col = 6;
	// 			for($i = 0; $i < count($data); $i++)
	// 			{
	// 				// name
	// 				$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(3, $col, $data[$i]['emp_name']);
	// 				// date
	// 				$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(8, $col, date('m/d/Y', strtotime($data[$i]['date_recognized']["date"]) ));
	// 				// time
	// 				$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(6, $col, date('H:i:s A', strtotime($data[$i]['date_recognized']["time"]) ));
	// 				// idclass
	// 				$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(11, $col, $data[$i]['idClass']);
	// 				// source
	// 				$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(13, $col, ( array_key_exists('source', $data[$i]) ) ? $data[$i]['source'] : "N/A" );
	// 		        $col++;
	// 	        }
	// 	        //  TIME LOGS ENDS HERE

	// 	        // DAILY TIME IN AND OUT START HERE
	// 	        $data = $this->mreport->distinct_all();
	// 	        $column_array = array_chunk($data["names"], 1);
	// 	        $dailies_col = 6;
	// 	        $spreadsheet->getActiveSheet()->fromArray($column_array, NULL, 'O6');
	// 	        for ($i=0; $i < count($column_array); $i++) {
	// 	        	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(19, $dailies_col, date('H:i:s A', strtotime($data["time_ins"][$i][0]['date_recognized']["time"])) );
	// 	        	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(22, $dailies_col, date('H:i:s A', strtotime($data["time_outs"][$i][0]['date_recognized']["time"])) );
	// 	        	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(26, $dailies_col, (strtotime($data["time_outs"][$i][0]['date_recognized']["time"]) - strtotime($data["time_ins"][$i][0]['date_recognized']["time"]))/3600 );
	// 	        	$dailies_col++;
	// 	        }
	// 	        // DAILY TIME IN AND OUT ENDS HERE

	// 	        // create xls file
	// 	        $writer = new Xls($spreadsheet);
	// 	        // filename
	// 	        $filename = 'time_attendance_'.date('m/d/Y').'.xls';
	// 	        // headers
	// 	        header('Content-Type: application/vnd.ms-excel');
	// 			header('Content-Disposition: attachment;filename="'.$filename.'"');
	// 			header('Cache-Control: max-age=0');

	// 			ob_end_clean();
	// 			// force download xls file
	// 			$writer->save('php://output');

	// 		}
	// 		else
	// 		{
	// 			echo 'no data';
	// 		}

	// 	}
	// 	else
	// 	{
	// 		echo 'no data';
	// 	}
	// }

	public function testing()
	{
		$dates = array('06/30/2019','07/01/2019');
		$data = $this->mreport->generateReportByRange($dates);
		var_dump($data);
		// $this->mreport->distinct_all();
		// var_dump((strtotime('10:12:49 AM') - strtotime('03:19:43 AM'))/3600);
		// $this->mreport->all();
		// (date('h:i:s', strtotime($data["time_outs"][$i][0]['date_recognized'])) - date('h:i:s', strtotime($data["time_ins"][$i][0]['date_recognized'])))
	}
}