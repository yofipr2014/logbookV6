<?php
if (session_id() == ""){
    session_start();
}
include "./art_config.php"; 
include "./art_functions.php"; 

global $verification_code;

function get_verification_string() {
    if(!isset($_SESSION['captcha_code'])) {
        return false;
    }
    return $_SESSION['captcha_code'];
}

art_create_verification_code();	
	
$verification_code = get_verification_string();
if($verification_code === false) { return false; }

header('Content-type: image/jpeg');
$font_size = 12;
$char_width = imagefontwidth($font_size);
$char_height = imagefontheight($font_size);
$string_width = 50;
$string_height = 1 * $char_height;
$padding = 5;  
$img_width = $string_width + $padding * 2;
$img_height = $string_height + $padding * 2; 	
$img = @imagecreatetruecolor($img_width, $img_height)
 	     or die("imagecreatetruecolor failed");

$alternate_color = true;
if($alternate_color === false || rand(0, 1) == 0){
    $background_color = imagecolorallocate($img, 15, 15, 15);
	 	$text_color = imagecolorallocate($img, 238, 238, 238);
	 	$bg_text_color = imagecolorallocate($img, 95, 95, 95);
} else {
	 	$background_color = imagecolorallocate($img, 238, 238, 238);
	 	$text_color = imagecolorallocate($img, 15, 15, 15);
	 	$bg_text_color = imagecolorallocate($img, 191, 191, 191);
}

imagefill($img ,0, 0, $background_color);
$bg_pattern_enabled = true;
if($bg_pattern_enabled === true){
    $bg_str_font_size = 2;
		$bg_char_width = imagefontwidth($bg_str_font_size);
    $bg_char_height = imagefontheight($bg_str_font_size);
	 	for($x = rand(-2, 2); $x < $img_width; $x += $bg_char_width + 1){
	 	    for($y = rand(-2, 2); $y <  $img_height; $y += $bg_char_height + 1){
	 			    imagestring($img, $bg_str_font_size, $x, $y, art_random_char(), $bg_text_color);
        }
    }
}

$x = $padding + rand(-2, 2);
$y = $padding + rand(-2, 2);
for($i = 0; $i < strlen($verification_code); $i++){
    imagestring($img, $font_size, $x, 
	  $y  + rand(-2, 2), substr($verification_code, $i, 1), $text_color);
	  $x += $char_width;
}

$line_color = imagecolorallocate($img, 254, 254, 254);
imagejpeg($img);
imagedestroy($img);
?>
