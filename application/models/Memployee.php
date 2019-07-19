<?php

class Memployee extends CI_Model
{	
	// creds
	private $headers = array();

	// servers
	private $urls = array(
		"people" => "https://covi.int2.real.com/people",
		"events" => "https://cv-event.int2.real.com/events?sinceModDate=",
		"eventsPoll" => "https://cv-event.int2.real.com/event/status?since="
		);

	// constructor
	public function __construct()
	{
		parent::__construct();
		$this->load->model('msettings');
		$this->headers = array(
			'AUTHORIZATION:'.$this->msettings->directory(),
			'X-RPC-AUTHORIZATION:'.$this->msettings->credentials()
		);

		date_default_timezone_set('Asia/Kuala_Lumpur');
	}

	// register new people manually
	public function create($inputs)
	{
		if($this->mongo_db->insert('employees', $inputs))
		{
			$this->session->set_flashdata('info', 'New Employee Added!');
		}
		redirect('employee');
	}

	// get all people records(local)
	public function all()
	{
		return $this->mongo_db->get('employees');
	}

	// get single data from employees table
	public function getData($id)
	{
		return $this->mongo_db->where('_id', new \MongoId($id))->get('employees');
	}

	// edit employee data
	public function update($_id, $inputs)
	{
		$this->mongo_db->set($inputs)->where('_id', new \MongoId($_id));
		$status = $this->mongo_db->update('employees');
		if($status)
		{
			$this->session->set_flashdata('info', 'Employee '. $inputs['emp_name'].' information updated!' );
		}
		redirect('employee');
	}

	// delete employee
	public function delete_emp($_id)
	{
		$status = $this->mongo_db->where('_id', new \MongoId($_id))->delete('employees');
		redirect('employee');
	}

	// compare records from local to cloud data
	public function tallyData()
	{
		$count = count($this->cloudDataPeople());
		// get the last count of record data from cloud
		$last_count = $this->mongo_db->order_by(array('_id'=>FALSE))->limit(1)->get('registered_no');
		
		$new_count = empty($last_count) ? 0 : $last_count[0]["cloud_count"];
		// fresh
		if($new_count == 0)
		{
			echo $count;
			return 0;
		}
		// check if record is updated to cloud
		if($count > $new_count)
		{
			// there's a unsave data from cloud
			$json =  json_encode($count - $new_count);
			echo $json;
			// return index (where to start)
			return $count - $json;
		}
	}

	// get people data via cloud
	public function cloudDataPeople()
	{
		$result = $this->curler($this->urls["people"], $this->headers);
		return $result["people"];
	}

	// get events data via cloud
	public function cloudDataEvents($time)
	{
		$result = $this->curler($this->urls["events"].$time, $this->headers);
		return (!empty($result)) ? $result["events"] : null;
	}

	// polling events
	public function cloudDataEventsPoll($time)
	{
		$result = $this->curler($this->urls["eventsPoll"].$time, $this->headers);
		return $result["lastModDate"];
	}

	// curl request over cloud
	public function curler($url, $headers=array())
	{
		$this->load->library('xmlrpc');
		$this->load->library('xmlrpcs');
		
		// set_time_limit(0);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    $data = curl_exec($ch);

	    if(curl_errno($ch))
	    {
	    	$info = curl_getinfo($ch);
			if($info["http_code"] == 0)
			{
				echo round(microtime(true) * 1000);
			}
	    	// print "Error" .curl_error($ch);
	    	// print "Error no Internet Connection";
	    	// $data = curl_exec($ch);
	    }
	    else
	    {
	    	$transaction = json_decode($data, TRUE);
	    	curl_close($ch);
	    	return $transaction;
	    }
	}

	// get registered people from facial recognition
	public function updateRecord()
	{
		$index = $this->tallyData();
		$cloud = $this->cloudDataPeople();
		$cloud_count = count($cloud);
		$inputs = array();
		
		// update old records
		if($index)
		{
			// single data
			if(count($inputs) == 1)
			{
				$inputs = array(
					'emp_name' => $cloud[$index]["name"],
		    		'position' => "N/A",
		    		'date_registed' => date('m/d/Y h:i:s', $cloud[$index]["rootPersonAddDate"] / 1000),
		    		'personId' => $cloud[$index]["personId"],
		    		'fr' => TRUE
				);
				$this->mongo_db->insert('employees', $inputs);
			}
			// bulk data
			else
			{
				// gather inputs
				for ($i=$index; $i < $cloud_count; $i++)
				{
					$inputs[] = array(
							'emp_name' => $cloud[$i]["name"],
		    				'position' => "N/A",
		    				'date_registed' => date('m/d/Y h:i:s', $cloud[$i]["rootPersonAddDate"] / 1000),
		    				'personId' => $cloud[$i]["personId"],
		    				'fr' => TRUE
					);
				}
				$this->mongo_db->batch_insert('employees', $inputs);
			}
		}
		// no records get all
		else
		{
			// gather inputs
			foreach ($cloud as $key => $value) {

	    		$inputs[] = array(
	    				'emp_name' => $value["name"],
	    				'position' => "N/A",
	    				'date_registed' => date('m/d/Y h:i:s', $value["rootPersonAddDate"] / 1000),
	    				'personId' => $value["personId"],
	    				'fr' => TRUE
	    		);
	    	}

	    	// insert to database
	    	if(count($cloud) != 1)
	    	{
	    		$this->mongo_db->batch_insert('employees', $inputs);
	    	}
	    	else
	    	{
	    		$this->mongo_db->insert('employees', $inputs);	
	    	}
		}

		$input["cloud_count"] = $cloud_count;
		$input["date_updated"] =  date('m/d/Y h:i:s');
		$this->mongo_db->insert('registered_no',$input);
		redirect('employee');
	}
}