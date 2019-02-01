<?php

class ZpIP2Nation
	{

	public $IP;
	public $ISOCode;
	public $CountryName;
	public $Private;

	public $Conn;
	public $Error;

	public function __construct(&$Conn)
		{
		$this->IP = '';
		$this->ISOCode = '';
		$this->CountryName = '';
		$this->Private = true;

		$this->Conn = $Conn;
		$this->Error = false;
		}

	public function Get($IP)
		{
		$this->IP = $IP;
		$strSQL  = "SELECT ip2nationCountries.country AS countryname, ip2nation.country AS isocode ";
		$strSQL .= "FROM ip2nationCountries, ip2nation ";
		$strSQL .= "WHERE (ip2nation.ip < INET_ATON('" . $this->IP . "')) ";
		$strSQL .= "AND (ip2nationCountries.code = ip2nation.country) ";
		$strSQL .= "ORDER BY ip2nation.ip DESC LIMIT 0, 1 ";
		if ($resRS = mysqli_query($this->Conn, $strSQL))
			{
			if (mysqli_num_rows($resRS) == 1)
				{
				$arrRS = mysqli_fetch_assoc($resRS);
				$this->ISOCode = strtoupper($arrRS["isocode"]);
				$this->CountryName = $arrRS["countryname"];
				$this->Private = (is_numeric($this->ISOCode)) ? true : false;
				$this->Error = false;
				}
			else
				{
				$this->ISOCode = '';
				$this->CountryName = '';
				$this->Private = true;
				$this->Error = true;
				}
			mysqli_free_result($resRS);
			}
		else
			{
			$this->ISOCode = '';
			$this->CountryName = '';
			$this->Private = true;
			$this->Error = true;
			}
		}

	}

# EOF
