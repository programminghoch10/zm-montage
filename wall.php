<?php
require_once("zmconfig.php");
$ids = $_REQUEST[ids] ?? "";
$refresh = $_REQUEST[refresh] ?? 120;
$imgtimeout = $_REQUEST[imgtimeout] ?? 2.5;
$quality = $_REQUEST[quality] ?? 50; //quality in percent
$fps = $_REQUEST[fps] ?? 5;
$noerror = $_REQUEST[noerror] ?? 1; //will remove stream instead of showing alturl, will still show alturl if there is no stream available
$alturl = "unavailable.png"; //alternative picture, will be shown if stream is not available

if ($id == "") die("Invalid Camera ID");
$ids = $ids."-";
$idarray = explode("-", $ids);
?>
<html>
<head>
<meta http-equiv="refresh" content="<?php echo $refresh; ?>" />
<style>
body {
	background-color: black;
	margin: 0;
}
.video {
	margin: 0;
	width: 100%;
	height: 100%;
}
.table {
	position: relative;
	display: grid;
	height: 100%;
	width: 100%;
	grid-template-rows: repeat(1, 1fr);
	grid-auto-flow: column;
    grid-gap: 0px;
}
img {
	margin: 0;
	padding: 0;
	width: 100%;
	height: 100%;
	object-fit: contain;
}
</style>
<script>
var camcount = <?php 
	$camcount = 0;
	foreach ($idarray as $id) {
		if ($id == "") continue;
		$camcount++;
	}
	echo $camcount;
?>;
var camfailcount = 0;
function getel(el) {return document.getElementById(el);}
function checkgrid() {
	console.log("camcount: " + camcount + "  camfailcount: " + camfailcount);
	var table = document.getElementById("table");
	if (table.childElementCount == 1) {
		var cols = document.getElementsByClassName('table');
		for(i = 0; i < cols.length; i++) {
			cols[i].style.gridTemplateRows = 'auto';
		}
		if (getel("altimage") != null) getel("altimage").parentNode.removeChild(getel("altimage"));
	}
	if (table.childElementCount == 0) {
		if (<?php echo($noerror);?> == 0 | camcount == camfailcount) {
			var image = new Image();
			image.src = <?php echo "\"".$alturl."\"";?>;
			image.id = "altimage";
			table.appendChild(image);
			console.log("all streams unavailable, defaulting to alternative URL"<?php if ($noerror==1) echo " + "."\", disregarding noerror\""?>);
		}
	}
	if (table.childElementCount > 1) {
		var cols = document.getElementsByClassName('table');
		for(i = 0; i < cols.length; i++) {
			cols[i].style.gridTemplateRows = 'repeat('+(parseInt(Math.sqrt(table.childElementCount)))+', 1fr)';
		}
		if (getel("altimage") != null) getel("altimage").parentNode.removeChild(getel("altimage"));
	}
	return;
}

function loadimage(id, url) {
	var el = getel("table");
	var alturl = <?php echo "\"".$alturl."\"";?>;
	var timer;
	function cleartimer() {
		if (timer) {                
            clearTimeout(timer);
            timer = null;
        }
	}
	function loadfail() {
		if (timer == null) return;
		cleartimer();
		camfailcount++;
		var table = document.getElementById("table");
		if (<?php echo($noerror);?> == 0) {
			var image = new Image();
			image.id = "altimage" + id;
			image.src = <?php echo "\"".$alturl."\"";?>;
			table.appendChild(image);
		}
		checkgrid();
	};
	var img = new Image();
	img.id = "image" + id;
	img.onerror = img.onabort = loadfail;
    img.onload = function() {
		console.log("loaded");
		cleartimer();
        el.appendChild(img);
		checkgrid();
    };
    img.src = url;
	timer = setTimeout(loadfail, <?php echo($imgtimeout * 1000);?>);
    return(img);
}
document.addEventListener("DOMContentLoaded", function(event) {
	<?php 
	foreach ($idarray as $id) {
		if ($id == "") continue;
	?>
	loadimage(<?php echo($id);?>, <?php echo $server; ?> + "/cgi-bin/nph-zms?scale=" + <?php echo $quality; ?> + "&mode=jpeg&maxfps=" + <?php echo $fps; ?> + "&monitor=" + <?php echo $id; ?> + "&user=" + <?php echo $zmuser; ?> + "&pass=" + <?php echo $zmpass; ?>);
	<?php
	}
	?>
	checkgrid();
});
</script>
</head>
<body>
	<div class=table id=table>
	</div>
</body>
</html>