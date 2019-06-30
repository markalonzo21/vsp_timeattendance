<?php

class Mreport extends CI_Model
{
	
	public function logs($inputs)
	{
		$this->mongo_db->insert('time_logs', $inputs);
	}

	public function all()
	{
		return $this->mongo_db->order_by(array('date_recognized' => FALSE))->get('time_logs');
	}

	public function distinct_all()
	{
		$names = $this->mongo_db->distinct("time_logs", "emp_name");
		// $data["time_ins"] = array();
		// $data["time_outs"] = array();

		for($i = 0; $i < count($names); $i++)
		{
			$data["time_ins"][] = $this->mongo_db->where(array('emp_name' => $names[$i]))->limit(1)->select(array('date_recognized'), array('_id'))->get('time_logs');
			$data["time_outs"][] = $this->mongo_db->where(array('emp_name' => $names[$i]))->order_by(array('date_recognized' => FALSE))->limit(1)->select(array('date_recognized'), array('_id'))->get('time_logs');	
		}
		$data["names"] = $names;
		// var_dump($data["time_ins"][0][]['date_recognized']);
		return $data;
	}
}