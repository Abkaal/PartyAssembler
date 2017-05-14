<?php

require_once("startup.php");
include_once("includes/Category.php");

print '<div style="margin: 0 auto;">';
if(isset($_POST['submit'])){
	$name=request_var('name','');
	$x=Category::add($name);
	if($x) print '<h4>New category created successfuly!</h4>'; 
	else print '<h4>Something has gone wrong... please check your input.</h4>';
	print '<a href="add_cat.php">Go to the previous page</a>';
}
else{
	print '<h3>Add new category</h3>';
	print '<form id="add" class="center" action="add_cat.php" method="post" accept-charset="UTF-8">';
	print '<label for="name">Category name:</label>';
	print '<input type="text" id="name" name="name" size="255" style="width:80%;"/> <br/><br/>';
	print '<input type="hidden" name="submit" value="submit">';
	print '<input type="submit" name="send" value="Send">';
	print '</form>';
}
print '</div>';
$db=null;
?>