<?php

require_once("startup.php");
include_once("includes/Category.php");

print '<div style="margin: 0 auto;">';
if(isset($_POST['submit'])){
	$cid=intval(request_var('cat',0));
	$name=request_var('name','');
	$cat=new Category($cid,$dbc);
	$x=$cat->edit($name);
	if($x) print '<h4>Selected category successfuly altered!</h4>'; 
	else print '<h4>Something has gone wrong... please check your input.</h4>';
	print '<a href="edit_cat.php">Go to the previous page</a>';
}
else{
	$cats=$dbc->grab_data('dbs_categories');
	if($cats){
		$opts_c='<option value="0">-----</option>';
		foreach($cats as $c){
			$opts_c.='<option value="'.$c['cat_id'].'">'.$c['cat_name'].'</option>';
		}
		print '<h3>Edit a category</h3>';
		print '<form id="add" class="center" action="edit_cat.php" method="post" accept-charset="UTF-8">';
		print '<label for="cat">Select category:</label>';
		print '<select id="cat" name="cat">';
		print $opts_c;
		print '</select><br/><br/>';
		print '<label for="name">New category name:</label>';
		print '<input type="text" id="name" name="name" size="255" style="width:80%;"/> <br/><br/>';
		print '<input type="hidden" name="submit" value="submit">';
		print '<input type="submit" name="send" value="Send">';
		print '</form>';
	}
	else print 'ERROR - no category created yet.';
}
print '</div>';
$db=null;
?>