<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;


 final class ValidatorTest extends TestCase
 {  
 
//1	
	public function testIsEmailPositive(): void
    {
        $this->assertEquals( true,Validator::validate_email('user@example.com'));
    }
//2		
	public function testIsEmailNegative(): void
    {
        $this->assertEquals(false, Validator::validate_email('userexample.com'));
    }
//3
	public function testIsEmailNegative2(): void
    {
        $this->assertEquals(true, Validator::validate_email('user@examplecom'));
    }
//4	
	public function testDateNegative(): void
    {
        $this->assertEquals(false,Validator::validate_date(35,55,100));
    }
	
//5
	public function testDatePositive(): void
	{
       	$s=Validator::validate_date(12,12,1994);
		$this->assertEquals($s,"STR_TO_DATE('12,12,1994','%d,%m,%Y')"); // as the validator returns string for DB;
	}
//6
	public function testIsDoublePasswordPositive(): void
	{
        $this->assertEquals(true, Validator::validate_pass("haslo","haslo"));
    }
//7
	public function testIsDoublePasswordNegative(): void
	{
        $this->assertEquals(false, Validator::validate_pass("haslo","pass"));
    }
	

}
