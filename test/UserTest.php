<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{  

	protected $u;
	
	public function setUp(){
		$this->u=new User(5,false);
	}
	
	public function testHasAttribute(): void
    {
        $this->assertClassHasAttribute('id', User::class);
		$this->assertClassHasAttribute('name', User::class);
		$this->assertClassHasAttribute('ip', User::class);
		$this->assertClassHasAttribute('email', User::class);
		$this->assertClassHasAttribute('level', User::class);
		$this->assertClassHasAttribute('table_name', User::class);
    }

	public function testIsCorrectDataType(): void
    {
		$id = $this->u->getID();
		$this->assertTrue(gettype($id)=='int');
	}
	
	public function testIsIDCorrect(): void
	{
		$id = $this->u->getID();
		$this->assertEquals(5,$id);
	}
	
	public function testIsCorrectName(): void
    {
		$name = $this->u->getName();
		$this->assertEquals(null,$name); // not implemented yet;
	}

}