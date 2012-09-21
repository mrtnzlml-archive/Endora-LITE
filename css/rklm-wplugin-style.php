<?php
header('Content-type: text/css');
require_once('../../../../wp-load.php'); /* get_option(); */
$rklm = get_option('endora_rklm');
?>
#rklm-wplugin {
	color: <?php echo $rklm['barva1']; ?> !important;
	background-color: <?php if($rklm['transparent']==1) echo 'transparent'; else echo $rklm['barva3']; ?> !important;
	font-size: <?php echo $rklm['velikost']; ?>px !important;
	text-align: <?php echo $rklm['zarovnani']; ?> !important;
	font-family: <?php echo $rklm['pismo']; ?> !important;
}

#rklm-wplugin a {
	color: <?php echo $rklm['barva2']; ?> !important;
}