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
}