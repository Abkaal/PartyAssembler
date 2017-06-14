<?php

include_once("Validator.php");

class Event{
	
	private $id;
	private $name;
	private $time;
	private $cat; // object!!!
	private $owner; // object!!!
	private $dbc;
	
	// Constructor
	// params:
	// $id - identifier obtained from the db
	public function __construct($id_in=0,$dbc_in=null){
		// TODO
		if($id_in>0) $this->id=$id_in;
		else $this->id=0;
		$this->dbc=$dbc_in;
		$this->cat=null;
		$this->owner=null;
	}
	
	// Add new user to the db.
	// params:
	// $name - user name
	// $ip - user ip
	// $email - user e-mail
	// $day, $month, $year - date given by a user
	public static function add($name=null,$ip=null,$owner=null,$day=null,$month=null,$year=null){
		$s=Validator::validate_date($day,$month,$year);
		if($name && $owner && $s){
			$fields='event_name,$event_owner,$event_date';
			$values="$name,$owner,$s";
			$x=$dbc->insert_data('dbs_events',$fields,$values);
		} else $x=false;
		return $x;
	}
	
	// Enroll for an event
	// params:
	// $user_id - identifier of the user to be enrolled
	public function get_enrolled($user_id){
		if($this->id>0 && $user_id>0){
			$fields='user_id,event_id';
			$values="$user_id,".$this->id;
			$x=$this->dbc->insert_data('dbs_enrollments',$fields,$values);
		}
		else $x=false;
		return $x;
	}
}

?>