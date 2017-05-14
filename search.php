<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Party Assembler</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<link rel="alternate stylesheet" type="text/css" media="screen" title="light-theme" href="style2.css" />
	<link rel="alternate stylesheet" type="text/css" media="screen" title="dark-theme" href="style3.css" />
	<meta name="Description" content="Party Assembler" />
	<script src="styleswitch.js" type="text/javascript"></script>
</head>
<body>
<div class="wrapper">
	<div class="top">
		<div class="logo"><!--no content, only picture--></div>
		<div class="menu">
			<div class="non_act"><a href="index.php" title="Main Page">Main Page</a></div>
			<div class="active"><a href="search.php" title="Search">Search</a></div>
			<div class="non_act"><a href="manage.php" title="ACP">Admin Control Panel</a></div>
			<div class="non_act"><a href="contact.php" title="Contact">Contact</a></div>
		</div>
	</div>
	<div class="gallery center">
		What do you want to search for?<br/><br/>
			<a href="search_events.php">Events</a><br/>
			<a href="search_users.php">Users</a><br/>
	</div>
	<div class="foot center">Choose site theme:
		<form id="switchform">
			<select name="switchcontrol" size="1" onChange="chooseStyle(this.options[this.selectedIndex].value, 60)">
				<option value="none" selected="selected">Standard</option>
				<option value="light-theme">Light</option>
				<option value="dark-theme">Dark</option>
			</select>
		</form>
		Created by <a href="mailto:adam.klaczynski@student.put.poznan.pl">Adam Kłaczyński</a>, <a href="mailto:kacper.kurzeja@student.put.poznan.pl">Kacper Jacek Kurzeja</a> and <a href="mailto:wojciech.zebrowski@student.put.poznan.pl">Wojciech Żebrowski</a><br/>
		Tested on Vivaldi 1.8. It is recommended to use that browser when visiting this site.<br/>
	</div>
</div>
</body>
</html>