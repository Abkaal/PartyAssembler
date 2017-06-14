<?php

class Search{
	
	private $dbc;
	
	// Constructor.
	// params:
	// $dbc_in - database handler given from higher layer
	public function __construct($dbc_in=null){
		$this->dbc=$dbc_in;
	}
	
	// Search events by organizer id (user id).
	// params:
	// $name - event name given by user
	public function event_by_name($name){
		$x=false;
		if($this->dbc){
			$x=$this->dbc->grab_data('dbs_events',array($name),array('event_name'),'event_id,event_name');
		}
		return $x;
	}
	
	// Search events by organizer id (user id).
	// params:
	// $user_id - organizer identifier given by user
	public function event_by_org($user_id){
		$x=false;
		if($this->dbc){
			$x=$this->dbc->grab_data('dbs_events',array($user_id),array('event_owner'),'event_id,event_name');
		}
		return $x;
	}
	
	// Search events by category id.
	// params:
	// $cat_id - category identifier given by user
	public function event_by_cat($cat_id){
		$x=false;
		if($this->dbc){
			$x=$this->dbc->grab_data('dbs_events',array($cat_id),array('cat_id'),'event_id,event_name');
		}
		return $x;
	}
	
	// Search events by their name, organizer id (user id) AND category id.
	// params:
	// $name - event name given by user
	// $user_id - organizer identifier given by user
	// $cat_id - category identifier given by user
	public function event_mix($name,$user_id,$cat_id){
		$x=false;
		if($this->dbc){
			$vals=array_diff(array($name,$user_id,$cat_id),array(null)); // remove nulls from array;
			$keys=array_intersect_key(array('event_name','event_owner','cat_id'),$vals); // remove all entries with keys removed above;
			$x=$this->dbc->grab_data('dbs_events',$vals,$keys,'event_id,event_name');
		}
		return $x;
	}
	
}

?>