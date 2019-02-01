<?php


class ZpImageUploader
	{

	public $Uploads;
	public $UploadedImage;
	public $TempFolder;
	public $TempPath;
	public $TempWidth;
	public $TempHeight;
	public $MaxFileSize;
	public $AllowedTypes;

	public $Error;
	public $ErrorDescription;
	public $UploadErrors;

	public function __construct()
		{
		$this->Uploads = array();
		$this->UploadedImage = null;
		$this->TempFolder = "";
		$this->TempPath = "";
		$this->TempWidth = 0;
		$this->TempHeight = 0;
		$this->MaxFileSize = 0;
		$this->AllowedTypes = array('image/jpeg', 'image/pjpeg', 'image/jpg', 'image/png', 'image/gif');

		$this->Error = false;
		$this->ErrorDescription = "OK";
		$this->UploadErrors = array(
			1 => 'File size exceeds server-defined limit',
			2 => 'File size exceeds browser-defined limit',
			3 => 'Partial upload',
			4 => 'No file uploaded',
			6 => 'Temporary folder missing',
			7 => 'Disk write failed',
			8 => 'Upload prevented by extension',
			);

		$this->EnumerateUploads();
		}

	public function EnumerateUploads()
		{
		foreach ($_FILES as $objFile)
			{
			if ($objFile['error'] != 0)
				{
				$this->Error = true;
				$this->ErrorDescription = $this->UploadErrors[$objFile['error']];
				}
			elseif (is_uploaded_file($objFile['tmp_name']))
				{
				$this->Uploads[] = $objFile["tmp_name"];
				}
			else
				{
				$this->Error = true;
				$this->ErrorDescription = 'Unspecified upload error';
				}
			}
		}

	public function AcquireImage($FieldName)
		{
		$this->UploadedImage = $_FILES[$FieldName];
		if ($this->TempPath == "")
			{
			$this->TempPath = $this->TempFolder . $this->UploadedImage["name"];
			}
		if (!is_uploaded_file($this->UploadedImage["tmp_name"]))
			{
			$this->Error = true;
			$this->ErrorDescription = "No valid file found";
			}
		elseif (($this->MaxFileSize > 0) && ($this->UploadedImage["size"] > $this->MaxFileSize))
			{
			$this->Error = true;
			$this->ErrorDescription = "File is larger than " . $this->MaxFileSize . " bytes";
			}
		elseif (!in_array($this->UploadedImage["type"], $this->AllowedTypes))
			{
			print_r($this->AllowedTypes);
			$this->Error = true;
			$this->ErrorDescription = "File type " . $this->UploadedImage["type"] . " is not permitted";
			}
		elseif (file_exists($this->TempPath))
			{
			$this->Error = true;
			$this->ErrorDescription = "File already exists in temporary processing path";
			}
		elseif (!move_uploaded_file($this->UploadedImage["tmp_name"], $this->TempPath))
			{
			$this->Error = true;
			$this->ErrorDescription = "Error while moving to temporary processing path";			
			}
		else
			{
			$arrImageSpecs = getimagesize($this->TempPath);
			$this->TempWidth = $arrImageSpecs[0];
			$this->TempHeight = $arrImageSpecs[1];
			}
		}

	public function SaveImage($SavePath, $MaxWidth, $MaxHeight, $Watermark = false)
		{
		if (is_file($this->TempPath))
			{
			if ( ($this->TempWidth <= $MaxWidth) && ($this->TempHeight <= $MaxHeight) )
				{
				copy($this->TempPath, $SavePath);
				}
			else
				{
				$dblWidthRatio = ($this->TempWidth / $MaxWidth);
				$dblHeightRatio = ($this->TempHeight / $MaxHeight);
				if($dblWidthRatio >=$dblHeightRatio) 
					{
					$dblRatio = $dblWidthRatio;
					}
				else
					{
					$dblRatio = $dblHeightRatio;
					}
				$intSaveWidth = (int)(($this->TempWidth / $dblRatio) + 0);
				$intSaveHeight = (int)(($this->TempHeight / $dblRatio) + 0);

				$strExtension = strtolower(substr($SavePath, strrpos($SavePath, '.')));
				switch ($strExtension)
					{
					case '.jpg' :
						$imgTemp = ImageCreateFromJPEG($this->TempPath);
						$imgSave = ImageCreateTrueColor($intSaveWidth,$intSaveHeight);
						ImageCopyResampled($imgSave, $imgTemp, 0, 0, 0, 0, ($intSaveWidth - 0), ($intSaveHeight - 0), $this->TempWidth, $this->TempHeight);
						ImageJPEG($imgSave, $SavePath, 100);
						break;
					case '.gif' :
						$imgTemp = ImageCreateFromGIF($this->TempPath);
						$imgSave = ImageCreateTrueColor($intSaveWidth,$intSaveHeight);
						ImageCopyResampled($imgSave, $imgTemp, 0, 0, 0, 0, ($intSaveWidth - 0), ($intSaveHeight - 0), $this->TempWidth, $this->TempHeight);
						ImageGIF($imgSave, $SavePath);
						break;
					case '.png' :
						$imgTemp = ImageCreateFromPNG($this->TempPath);
						$imgSave = ImageCreateTrueColor($intSaveWidth,$intSaveHeight);
						ImageCopyResampled($imgSave, $imgTemp, 0, 0, 0, 0, ($intSaveWidth - 0), ($intSaveHeight - 0), $this->TempWidth, $this->TempHeight);
						ImagePNG($imgSave, $SavePath);
						break;
					}
				ImageDestroy($imgTemp);
				ImageDestroy($imgSave);
				}
			}
		else
			{
			$this->Error = true;
			$this->ErrorDescription = "No file in temporary processing slot";
			}
		}

	public function ClearTempPath()
		{
		if (is_file($this->TempPath))
			{
			unlink($this->TempPath);
			}
		}

	}

# EOF
