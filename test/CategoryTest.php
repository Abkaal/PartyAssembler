<?php
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase{
	
	protected $cat;
	protected $dbc;
	
	public function setUp(){
		if(!class_exists('Category')){
			include_once('src/includes/Category.php');
		}
		if(!class_exists('Database')){
			include_once('src/includes/Database.php');
		}
		$this->dbc=$this->createMock(Database::class);
		$this->cat=new Category(10,$this->dbc);
	}
	
	public function testHasAttribute(){
        $this->assertClassHasAttribute('id', Category::class);
		$this->assertClassHasAttribute('name', Category::class);
		$this->assertClassHasAttribute('dbc', Category::class);
    }
	
	public function testEditPositive(){
		$this->dbc->method('update_data')->willReturn(true); // successful update;
		$this->cat->setDB($this->dbc);
		$x=$this->cat->edit('test');
		$this->assertEquals($x,true); // row count neglected;
	}
	
	public function testEditNegative(){
		$this->dbc->method('update_data')->willReturn(false);
		$this->cat->setDB($this->dbc);
		$x=$this->cat->edit('test');
		$this->assertEquals($x,false);
	}
	
	public function testDeletePositive(){
		$this->dbc->method('remove_data')->willReturn(true);
		$this->cat->setDB($this->dbc);
		$x=$this->cat->delete();
		$this->assertEquals($x,true);
	}
	
	public function testDeleteNegative(){
		$this->dbc->method('remove_data')->willReturn(false);
		$this->cat->setDB($this->dbc);
		$x=$this->cat->delete();
		$this->assertEquals($x,false);
	}
	
}

?>