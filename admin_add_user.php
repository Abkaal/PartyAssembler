<?php

require("startup.php");
include_once("Validator.php");

print '<div style="margin: 0 auto;">';
if(isset($_POST['submit'])){
	$table_name='dbs_users';
	$fields='user_name,user_email,user_password,user_ip';
	$num=intval(request_var('num',0));
	$nick=request_var('nick','');
	$email=request_var('email','');
	$pass=request_var('pass','');
	$rpass=request_var('rpass','');
	$x=Validator::validate_email($email);
	if($x){
	//$x=$dbc->insert_data('dbs_users',$fields,$values);
	//if($x) print '<h4>New line added successfully!</h4>';
		$x=Validator::validate_pass($pass,$rpass);
		if($x){
			$s=md5($pass);
			$ip=((!empty($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR']!=$_SERVER['REMOTE_ADDR'])?$_SERVER['HTTP_X_FORWARDED_FOR']:$_SERVER['REMOTE_ADDR']);
			$values="'$nick','$email','$s','$ip'";
			$x=$dbc->insert_data($table_name,$fields,$values);
		}
		else print "The passwords you provided does not match.<br/>";
	}
	else print "The e-mail address you provided is not valid.<br/>";
	if($x) print '<h4>New user added successfully.</h4>';
	else print '<h4>Something has gone wrong... please check your input.</h4>';
	print '<a href="register.php">Go to the previous page</a>';
}
else{
	print '<h3>Add new user</h3>';
	print '<form id="add" class="center" action="register.php" method="post" accept-charset="UTF-8">';
	print '<label for="nick">Nick/login:</label>';
	print '<input type="text" id="nick" name="nick" size="255" style="width:80%;"/> <br/><br/>';
	print '<label for="email">E-mail:</label>';
	print '<input type="text" id="email" name="email" size="100" style="width:80%;"/> <br/><br/>';
	print '<label for="pass">Password:</label>';
	print '<input type="password" id="pass" name="pass" size="40" style="width:80%;"/> <br/><br/>';
	print '<label for="rpass">Repeat password:</label>';
	print '<input type="password" id="rpass" name="rpass" size="40" style="width:80%;"/> <br/><br/>';
	print '<input type="hidden" name="submit" value="submit">';
	print '<input type="submit" name="send" value="Send">';
	print '</form>';
}
print '</div>';
$db=null;
?>