<?php
require_once("zmconfig.php");
$id = $_REQUEST[id] ?? "";
$refresh = $_REQUEST[refresh] ?? 120;
$fps = $_REQUEST[fps] ?? 20;
$quality = $_REQUEST[quality] ?? 100; //quality in percent
$alturl = "unavailable.png"; //alternative picture, will be shown if stream is not available

if ($id == "") die("Invalid Camera ID");
?>
<html>
<head>
<meta http-equiv="refresh" content="<?php echo $refresh; ?>" />
<style>
body {
	background-color: black;
}
img {
	position: fixed;
	margin: 0;
	padding: 0;
	top: 0;
	left: 0;
	display: block;
	width: 100%;
	height: 100%;
	object-fit: contain;
	max-width: 100%;
	max-height: 100%;
}
</style>
</head>
<body>
	<img src="<?php echo $server; ?>/cgi-bin/nph-zms?scale=<?php echo $quality; ?>&mode=jpeg&maxfps=<?php echo $fps; ?>&monitor=<?php echo $id; ?>&user=<?php echo $zmuser; ?>&pass=<?php echo $zmpass; ?>"
	onerror="this.src='<?php echo "\"".$alturl."\""; ?>'"/>
</body>
</html>