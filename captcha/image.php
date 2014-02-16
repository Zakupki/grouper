<?php

if ($isrc = imagecreate(100, 30)) {
	
	session_start();
	
	$str = (isset($_SESSION['ADR_CAPTCHA']))?$_SESSION['ADR_CAPTCHA']:'56ty';
	
	$dir="captcha";
	
	//$fonts[]='MODERNCI.TTF';
	//$fonts[]='NGRANIT.TTF';
	//$fonts[]='PLAYBILL.TTF';
	//$fonts[]='PRN75__C.TTF';
	$fonts[]='A101HLVN.TTF';
	
	sscanf('3F3F3E', '%2x%2x%2x', $red, $green, $blue);
	imagecolorallocate($isrc, $red, $green, $blue);
	sscanf('999999', '%2x%2x%2x', $red, $green, $blue);
	$tcolor = imagecolorallocate($isrc, $red, $green, $blue);
	
	for($i=0; $i<strlen($str); ++$i){
		$font=mt_rand(0,count((array)$fonts)-1);
		imagettftext($isrc,  mt_rand(18,19), -20+2*mt_rand(0, 20), 3+$i*24, 23, $tcolor, "{$_SERVER['DOCUMENT_ROOT']}/$dir/{$fonts[$font]}", substr($str, $i, 1));
		//imagettftext($isrc,  18, 0, 2+$i*20, 22, $tcolor, "{$_SERVER['DOCUMENT_ROOT']}/$dir/{$fonts[$font]}", substr($str, $i, 1));
	}
	header("Content-type: image/png");
	imagepng($isrc);
	imagedestroy($isrc);
}

?>
