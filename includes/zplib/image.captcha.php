<?php
session_start();
require_once 'functions.php';


class CaptchaSecurityImages 
	{
	# From: http://www.white-hat-web-design.co.uk/articles/php-captcha.php
	var $font = 'fonts/monofont.ttf';

	function generateCode($characters) 
		{
		/* list all possible characters, similar looking characters and vowels have been removed */
		$possible = '23456789bcdfghjkmnpqrstvwxyzBCDFGHJKMNPQRSTVWXYZ';
		$code = '';
		$i = 0;
		while ($i < $characters) 
			{ 
			$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
			$i++;
			}
		return $code;
		}

	function CaptchaSecurityImages($width='120',$height='40',$characters='6', $backgroundHTMLColor='ffffff', $textHTMLColor='142864', $noiseHTMLColor='6478b4') 
		{
		$backgroundRGBColor = zpHTML2RGB($backgroundHTMLColor);
		$textRGBColor = zpHTML2RGB($textHTMLColor);
		$noiseRGBColor = zpHTML2RGB($noiseHTMLColor);

		$code = $this->generateCode($characters);
		/* font size will be 75% of the image height */
		$font_size = $height * 0.75;
		$image = @imagecreate($width, $height) or die('Cannot initialize new GD image stream');
		/* set the colours */
		$background_color = imagecolorallocate($image, $backgroundRGBColor[0], $backgroundRGBColor[1], $backgroundRGBColor[2]);
		$text_color = imagecolorallocate($image, $textRGBColor[0], $textRGBColor[1], $textRGBColor[2]);
		$noise_color = imagecolorallocate($image, $noiseRGBColor[0], $noiseRGBColor[1], $noiseRGBColor[2]);
		/* generate random dots in background */
		for( $i=0; $i<($width*$height)/3; $i++ ) 
			{
			imagefilledellipse($image, mt_rand(0,$width), mt_rand(0,$height), 1, 1, $noise_color);
			}
		/* generate random lines in background */
		for( $i=0; $i<($width*$height)/150; $i++ ) 
			{
			imageline($image, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $noise_color);
			}
		/* create textbox and add text */
		$textbox = imagettfbbox($font_size, 0, $this->font, $code) or die('Error in imagettfbbox function');
		$x = ($width - $textbox[4])/2;
		$y = ($height - $textbox[5])/2;
		imagettftext($image, $font_size, 0, $x, $y, $text_color, $this->font , $code) or die('Error in imagettftext function');
		/* output captcha image to browser */
		header('Content-Type: image/jpeg');
		imagejpeg($image);
		imagedestroy($image);
		$_SESSION['zigpress_captcha'] = $code;
		}

	}

$width = isset($_GET['w']) ? $_GET['w'] : '120';
$height = isset($_GET['h']) ? $_GET['h'] : '40';
$characters = isset($_GET['c']) && $_GET['c'] > 1 ? $_GET['c'] : '6';
$textColor = isset($_GET['fc']) ? $_GET['fc'] : '142864';
$noiseColor = isset($_GET['bc']) ? $_GET['bc'] : '6478b4';

$captcha = new CaptchaSecurityImages($width,$height,$characters, '#fff', $textColor, $noiseColor);

?>