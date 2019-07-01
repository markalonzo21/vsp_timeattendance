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

	public function generateReport()
	{
		$data = $this->mreport->all();
		// $spreadsheet = new Spreadsheet();
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('template.xlsx');
		$col = 6;
		for($i = 0; $i < count($data); $i++)
		{
			$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(3, $col, $data[$i]['emp_name']);
			$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(8, $col, date('m/d/Y', strtotime($data[$i]['date_recognized']["date"]) ));
			$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(6, $col, date('H:i:s A', strtotime($data[$i]['date_recognized']["time"]) ));
			$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(11, $col, $data[$i]['idClass']);
			$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(13, $col, ( array_key_exists('source', $data[$i]) ) ? $data[$i]['source'] : "N/A" );
	        $col++;
        }

        $data = $this->mreport->distinct_all();
        // $name_col = 6;
        // for ($i=0; $i < count($names); $i++) { 
        // 	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(15, $name_col, $names[$i]);
        // }
        $column_array = array_chunk($data["names"], 1);
        // $column_array_in = array_chunk($data["time_ins"], 1);
        // $column_array_out = array_chunk($data["time_outs"], 1);
        $dailies_col = 6;
        $spreadsheet->getActiveSheet()->fromArray($column_array, NULL, 'O6');
        for ($i=0; $i < count($column_array); $i++) {
        	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(19, $dailies_col, date('H:i:s A', strtotime($data["time_ins"][$i][0]['date_recognized']["time"])) );
        	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(22, $dailies_col, date('H:i:s A', strtotime($data["time_outs"][$i][0]['date_recognized']["time"])) );
        	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(26, $dailies_col, (strtotime($data["time_outs"][$i][0]['date_recognized']["time"]) - strtotime($data["time_ins"][$i][0]['date_recognized']["time"]))/3600 );
        	$dailies_col++;
        }
        $writer = new Xls($spreadsheet);

        $filename = 'time_attendance_'.date('m/d/Y').'.xls';

        header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		ob_end_clean();

		$writer->save('php://output');
	}

	public function rangeReport()
	{
		if(isset($_POST["dateRange"])){
			$dates = explode(' - ', $_POST["dateRange"]);
			// echo $dates[0].' and '.$dates[1];
			$this->mreport->generateReportByRange($dates);
		}
		else
		{
			echo 'no data';
		}
	}

	public function testing()
	{
		$this->mreport->distinct_all();
		// var_dump((strtotime('10:12:49 AM') - strtotime('03:19:43 AM'))/3600);
		// $this->mreport->all();
		// (date('h:i:s', strtotime($data["time_outs"][$i][0]['date_recognized'])) - date('h:i:s', strtotime($data["time_ins"][$i][0]['date_recognized'])))
	}
}