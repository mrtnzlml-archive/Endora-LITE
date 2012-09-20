<?php
header('Content-type: text/css');
require_once('../../../../wp-load.php'); /* get_option(); */
$reklama = get_option('endora_reklama');
?>
#reklama-wplugin {
	color: <?php echo $reklama['barva1']; ?> !important;
	background-color: <?php if($reklama['transparent']==1) echo 'transparent'; else echo $reklama['barva3']; ?> !important;
	font-size: <?php echo $reklama['velikost']; ?>px !important;
	text-align: <?php echo $reklama['zarovnani']; ?> !important;
	font-family: <?php echo $reklama['pismo']; ?> !important;
}

#reklama-wplugin a {
	color: <?php echo $reklama['barva2']; ?> !important;
}

.poznamka {
	color: #888888;
	width: 250px;
}