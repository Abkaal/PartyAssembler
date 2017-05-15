<?php
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase{
	
	protected $ev;
	protected $dbc;
	
	public function setUp(){
		if(!class_exists('Event')){
			include_once('src/includes/Event.php');
		}
		if(!class_exists('Database')){
			include_once('src/includes/Database.php');
		}
		$this->dbc=$this->createMock(Database::class);
		$this->ev=new Event(10,$this->dbc);
	}
	
	public function testEnrollPositive(){
		$this->dbc->method('insert_data')->willReturn(true); // successful insert;
		$this->ev->setDB($this->dbc);
		$x=$this->ev->edit('test');
		$this->assertEquals($x,true); // row count neglected;
	}
	
	public function testEnrollNegative(){
		$this->dbc->method('insert_data')->willReturn(false);
		$this->ev->setDB($this->dbc);
		$x=$this->ev->edit('test');
		$this->assertEquals($x,false);
	}
	
	public function testAddCatPositive(){
		$this->dbc->method('update_data')->willReturn(true);
		$this->ev->setDB($this->dbc);
		$x=$this->ev->add_cat(13);
		$this->assertEquals($x,true);
	}
	
	public function testAddCatNegative(){
		$this->dbc->method('update_data')->willReturn(false);
		$this->ev->setDB($this->dbc);
		$x=$this->ev->add_cat(13);
		$this->assertEquals($x,false);
	}
	
	public function testDelCatPositive(){
		$this->dbc->method('remove_data')->willReturn(true);
		$this->ev->setDB($this->dbc);
		$x=$this->ev->del_cat();
		$this->assertEquals($x,true);
	}
	
	public function testDelCatNegative(){
		$this->dbc->method('remove_data')->willReturn(false);
		$this->ev->setDB($this->dbc);
		$x=$this->ev->del_cat();
		$this->assertEquals($x,false);
	}
	
}

?>