<?php

class ZpRecordset
	{
	public $Conn;
	public $Data;
	public $Records;
	public $Error;

	public function __construct(&$resConn, $strSQL)
		{
		$this->Error = true;
		$this->Conn = $resConn;
		$this->Records = 0;
		if ($strSQL != '')
			{
			if ($resRS = mysqli_query($this->Conn, $strSQL))
				{
				$this->Records = mysqli_num_rows($resRS);
				if ($this->Records > 0)
					{
					while ($arrRS = mysqli_fetch_assoc($resRS)) { $this->Data[] = $arrRS; }
					$this->Error = false;
					}
				mysqli_free_result($resRS);
				}
			}
		}

	}

# EOF