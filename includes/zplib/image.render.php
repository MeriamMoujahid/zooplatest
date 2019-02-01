<?php
require_once "functions.php";


# get image url, watermark url, decide if we're watermarking 

$strImageURL = zpGetVar("i");
$strWatermarkURL = 'images/watermark.copyright.png';
$blnWatermark = false;
if (zpGetVar('wm') != 'false') { $blnWatermark = true; }


# get image size

$arrImageSize = GetImageSize($strImageURL);
$intImageW = $arrImageSize[0];
$intImageH = $arrImageSize[1];

# create objects

$imgMain = imagecreatefromjpeg($strImageURL);
if ($blnWatermark)
	{
	$arrWatermarkSize = getimagesize($strWatermarkURL);
	$intWatermarkW = $arrWatermarkSize[0];
	$intWatermarkH = $arrWatermarkSize[1];
	$imgWatermark = imagecreatefrompng($strWatermarkURL);
	$intWatermarkX = ($intImageW / 2) - ($intWatermarkW / 2);
	$intWatermarkY = ($intImageH / 2) - ($intWatermarkH / 2);
	imagecopymerge($imgMain, $imgWatermark, $intWatermarkX, $intWatermarkY, 0, 0, $intWatermarkW, $intWatermarkH, 30);  
	}

# render image 

header('content-type: image/jpeg');  
imagejpeg($imgMain, NULL, 100);
imagedestroy($imgMain);
imagedestroy($imgWatermark);
?>