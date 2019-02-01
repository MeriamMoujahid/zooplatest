<?php


class ZpFileUploader
	{

	public $Uploads;
	public $UploadedFile;
	public $MimeType;
	public $TempFolder;
	public $TempPath;
	public $MaxFileSize;
	public $AllowedTypes;

	public $Error;
	public $ErrorDescription;

	public function __construct()
		{
		$this->Uploads = array();
		$this->UploadedFile = null;
		$this->MimeType = '';
		$this->TempFolder = "";
		$this->TempPath = "";
		$this->MaxFileSize = 0;
		$this->AllowedTypes = array('image/jpeg', 'image/png', 'image/gif');

		$this->Error = false;
		$this->ErrorDescription = "OK";

		$this->EnumerateUploads();
		}

	public function EnumerateUploads()
		{
		foreach ($_FILES as $objFile)
			{
			if (is_uploaded_file($objFile['tmp_name']))
				{
				$this->Uploads[] = $objFile["tmp_name"];
				}
			}
		}

	public function AcquireFile($FieldName)
		{
		$this->UploadedFile = $_FILES[$FieldName];
		$this->MimeType = $this->UploadedFile["type"];
		if ($this->TempPath == "")
			{
			$this->TempPath = $this->TempFolder . $this->UploadedFile["name"];
			}
		if (!is_uploaded_file($this->UploadedFile["tmp_name"]))
			{
			$this->Error = true;
			$this->ErrorDescription = "no valid file found";
			}
		elseif (($this->MaxFileSize > 0) && ($this->UploadedFile["size"] > $this->MaxFileSize))
			{
			$this->Error = true;
			$this->ErrorDescription = "file is larger than " . $this->MaxFileSize . " bytes";
			}
		elseif (!in_array($this->MimeType, $this->AllowedTypes))
			{
			print_r($this->AllowedTypes);
			$this->Error = true;
			$this->ErrorDescription = "file type " . $this->UploadedFile["type"] . " is not permitted";
			}
		elseif (file_exists($this->TempPath))
			{
			$this->Error = true;
			$this->ErrorDescription = "file already exists in temporary processing path";
			}
		elseif (!move_uploaded_file($this->UploadedFile["tmp_name"], $this->TempPath))
			{
			$this->Error = true;
			$this->ErrorDescription = "error while moving to temporary processing path";			
			}
		else
			{
			$arrImageSpecs = getimagesize($this->TempPath);
			}
		}

	public function SaveFile($SavePath)
		{
		if (is_file($this->TempPath))
			{
			copy($this->TempPath, $SavePath);
			}
		else
			{
			$this->Error = true;
			$this->ErrorDescription = "no file in temporary processing slot";
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
