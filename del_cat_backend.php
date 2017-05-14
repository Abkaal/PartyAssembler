<?php

require_once("startup.php");
include_once("includes/Category.php");

print '<div style="margin: 0 auto;">';
if(isset($_POST['submit'])){
	$cid=intval(request_var('cat',0));
	$ncid=intval(request_var('newcat',0));
	if(!class_exists('Event')) include('includes/Event.php');
	$cat=new Category($cid,$dbc);
	$y=($ncid)?Event::update_cats($cid,$ncid):false;
	if($y){
		$x=$cat->delete();
		unset($cat); // equivalent of "delete" - in PHP we do not delete objects explictly;
		if($x) print '<h4>Selected category successfuly deleted!</h4>'; 
		else print '<h4>Something has gone wrong... please check your input.</h4>';
	}
	else print '<h4>Could not assign a new category to events. You cannot delete a category if any event is assigned to it.</h4>';
	print '<a href="del_cat.php">Go to the previous page</a>';
}
else{
	$cats=$dbc->grab_data('dbs_categories');
	if($cats){
		$opts_c='<option value="0">-----</option>';
		foreach($cats as $c){
			$opts_c.='<option value="'.$c['cat_id'].'">'.$c['cat_name'].'</option>';
		}
		$opts_cn=$opts_c;
		print '<h3>Delete a category</h3>';
		print '<form id="add" class="center" action="del_cat.php" method="post" accept-charset="UTF-8">';
		print '<label for="cat">Select category to be deleted:</label>';
		print '<select id="cat" name="cat">';
		print $opts_c;
		print '</select><br/><br/>';
		print '<label for="newcat">Select new category for its events:</label>';
		print '<select id="newcat" name="newcat">';
		print $opts_cn;
		print '</select><br/><br/>';
		print '<input type="hidden" name="submit" value="submit">';
		print '<input type="submit" name="send" value="Send">';
		print '</form>';
	}
	else print 'ERROR - no category created yet.';
}
print '</div>';
$db=null;
?>