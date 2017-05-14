<?php

class Search{
	
	private $dbc;
	
	// Constructor.
	// params:
	// $dbc_in - database handler given from higher layer
	public function __construct($dbc_in=null){
		$this->dbc=$dbc_in;
	}
	
	// Search events by category id.
	// params:
	// $cat_id - category identifier given by user
	public function event_by_cat($cat_id){
		$x=false;
		if($this->dbc){
			$x=$this->dbc->grab_data('dbs_events',array($cat_id),array('cat_id'));
		}
		return $x;
	}
	
}

?>