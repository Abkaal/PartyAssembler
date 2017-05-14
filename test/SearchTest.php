<?php
use PHPUnit\Framework\TestCase;

class SearchTest extends TestCase{
	
	protected $se; // search engine;
	protected $dbc;
	
	public function setUp(){
		if(!class_exists('Search')){
			include_once('../includes/Search.php');
		}
		if(!class_exists('Database')){
			include_once('../includes/Database.php');
		}
		$this->dbc=$this->createMock(Database::class);
		$this->se=new Search($this->dbc);
	}
	
	public function testEventByCatPositive(){
		$this->dbc->method('grab_data')->willReturn(array('testkey'=>'testvalue')); // not-empty array - something found;
		$this->se->setDB(this->dbc);
		$x=$this->se->event_by_cat(1);
		$this->assertEquals($x,true); // row count neglected;
	}
	
	public function testEventByCatNegative(){
		$this->dbc->method('grab_data')->willReturn(false);
		$this->se->setDB(this->dbc);
		x=$this->se->event_by_cat(null);
		$this->assertEquals($x,false);
	}
	
	public function testEventByCatNotFound(){
		$this->dbc->method('grab_data')->willReturn(array()); // empty array - nothing found;
		$this->se->setDB(this->dbc);
		x=$this->se->event_by_cat(0);
		$this->assertEquals($x,true);
	}

}

?>