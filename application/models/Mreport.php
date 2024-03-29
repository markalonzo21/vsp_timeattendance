<?php

class Mreport extends CI_Model
{
	
	public function logs($inputs)
	{
		$this->mongo_db->insert('time_logs', $inputs);
	}

	public function all()
	{
		date_default_timezone_set('Asia/Kuala_Lumpur');
		return $this->mongo_db->order_by(array('date_recognized.time' => FALSE))->where(array("date_recognized.date" => date('m/d/Y')))->get('time_logs');
	}

	public function distinct_all()
	{
		// check attendance
		$names = $this->mongo_db->distinct("time_logs", "emp_name");

		// harvest time logs
		for($i = 0; $i < count($names); $i++)
		{
			$data["time_ins"][] = $this->mongo_db->where(array('emp_name' => $names[$i]))->limit(1)->select(array("date_recognized", "emp_name"), array('_id'))->get('time_logs');

			$data["time_outs"][] = $this->mongo_db->where(array('emp_name' => $names[$i]))->order_by(array('date_recognized' => FALSE))->limit(1)->select(array('date_recognized'), array('_id'))->get('time_logs');	
		}
		$data["names"] = $names;
		return $data;
	}

	public function distinct_range($dates)
	{
		$dateRange = explode(" - ", $dates);
		if($dateRange[0] == $dateRange[1])
		{
			$names = $this->mongo_db->where(array('date_recognized.date' => $dateRange[0]))->distinct("time_logs", "emp_name");
			// harvest time logs
			for($i = 0; $i < count($names); $i++)
			{
				$data["time_ins"][] = $this->mongo_db->where(array('emp_name' => $names[$i], 'date_recognized.date' => $dateRange[0]))
					->limit(1)->select(array("date_recognized","emp_name"), array('_id'))->get('time_logs');
				$data["time_outs"][] = $this->mongo_db->where(array('emp_name' => $names[$i], 'date_recognized.date' => $dateRange[0]))
					->order_by(array('date_recognized' => FALSE))->limit(1)->select(array('date_recognized'), array('_id'))->get('time_logs');	
			}
			$data["names"] = $names;
			return $data;
		}
		else
		{
			// get all names between the dates
			$names = $this->mongo_db->where_between("date_recognized.date", $dateRange[0], $dateRange[1])->distinct("time_logs", "emp_name");
			// get all logs within the dates and names
			$diff = (strtotime($dateRange[1]) - strtotime($dateRange[0]))/86400;
			for($i = 0; $i < count($names); $i++)
			{
				// harvest time logs
				for($x = 0; $x <= $diff; $x++)
				{
					$millis = strtotime("+".$x." day", strtotime($dateRange[0]));
					$index = date('m/d/Y', $millis);

					$data["time_ins"][] = $this->mongo_db->where(array('emp_name' => $names[$i],
					'date_recognized.date' => $index))
					->limit(1)
					->select(array('date_recognized', 'emp_name'), array('_id'))
					->get('time_logs');

					$data["time_outs"][] = $this->mongo_db->where(array('emp_name' => $names[$i],
					'date_recognized.date' => $index))
					->order_by(array("date_recognized" => FALSE))
					->limit(1)
					->select(array('date_recognized.time'), array('_id'))
					->get('time_logs');
				}
			}
			$data["names"] = $names;
			return $data;
		}
	}

	public function getReport($date)
	{
		// Check if date range are same value
		$dateRange = explode(" - ", $date);
		if($dateRange[0] == $dateRange[1])
		{
			return $this->mongo_db->where(array("date_recognized.date" => $dateRange[0]))->get("time_logs");
		}
		else
		{
			return $this->mongo_db->where_between("date_recognized.date", $dateRange[0], $dateRange[1])->get("time_logs");
		}
	}

	public function getAllDate()
	{
		$data[0] = $this->mongo_db->select(array("date_recognized.date"), array("_id"))->limit(1)->get("time_logs");
		$data[1] = $this->mongo_db->order_by(array("date_recognized.date" => FALSE))
		->select(array("date_recognized.date"), array("_id"))->limit(1)->get("time_logs");
		return $data;
	}

	public function distinct_dates()
	{
		$dates = $this->mongo_db->distinct("time_logs", "date_recognized.date");
		sort($dates);
		return $dates;
	}

	public function reportByDate($date)
	{
		return $this->mongo_db->where(array("date_recognized.date" => $date))->get("time_logs");
	}
}