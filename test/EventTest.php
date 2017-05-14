<?php
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase{
	
	protected $ev;
	protected $dbc;
	
	public function setUp(){
		if(!class_exists('Event')){
			include_once('../includes/Event.php');
		}
		if(!class_exists('Database')){
			include_once('../includes/Database.php');
		}
		$this->dbc=$this->createMock(Database::class);
		$this->ev=new Category(0,$this->dbc);
	}
	
	public function testEnrollPositive(){
		$this->dbc->method('insert_data')->willReturn(true); // successful insert;
		$this->ev->setDB(this->dbc);
		$x=$this->ev->edit('test');
		$this->assertEquals($x,true); // row count neglected;
	}
	
	public function testEnrollNegative(){
		$this->dbc->method('insert_data')->willReturn(false);
		$this->ev->setDB(this->dbc);
		x=$this->ev->edit('test');
		$this->assertEquals($x,false);
	}
	
	public function testAddCatPositive(){
		$this->dbc->method('update_data')->willReturn(true);
		$this->ev->setDB(this->dbc);
		$x=$this->ev->delete();
		$this->assertEquals($x,true);
	}
	
	public function testAddCatNegative(){
		$this->dbc->method('update_data')->willReturn(true);
		$this->ev->setDB(this->dbc);
		$x=$this->ev->delete();
		$this->assertEquals($x,true);
	}
	
}

?>