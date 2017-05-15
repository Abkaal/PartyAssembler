<?php
use PHPUnit\Framework\TestCase;

class SearchTest extends TestCase{
	
	protected $se; // search engine;
	protected $dbc;
	
	public function setUp(){
		if(!class_exists('Search')){
			include_once('src/includes/Search.php');
		}
		if(!class_exists('Database')){
			include_once('src/includes/Database.php');
		}
		$this->dbc=$this->createMock(Database::class);
		$this->se=new Search($this->dbc);
	}
	
	public function testEventByCatPositive(){
		$this->dbc->method('grab_data')->willReturn(array('testkey'=>'testvalue')); // not-empty array - something found;
		$this->se->setDB($this->dbc);
		$x=$this->se->event_by_cat(1);
		$this->assertCount(1,$x);
	}
	
	public function testEventByCatNegative(){
		$this->dbc->method('grab_data')->willReturn(false);
		$this->se->setDB($this->dbc);
		$x=$this->se->event_by_cat(null);
		$this->assertEquals($x,false);
	}

	public function testEventByCatNotFound(){
		$this->dbc->method('grab_data')->willReturn(array()); // empty array - nothing found;
		$this->se->setDB($this->dbc);
		$x=$this->se->event_by_cat(0);
		$this->assertCount(0,$x);
	}

}

?>