<?php


# database functions


function zpSQLServerConnString($strServer, $strUsername, $strPassword, $strDB)
	{
	$strTemp = "";
	$strTemp .= "Provider=SQLOLEDB;";
	$strTemp .= "Data Source=" . $strServer . ";";
	$strTemp .= "User ID=" . $strUsername . ";";
	$strTemp .= "Password=" . $strPassword . ";";
	$strTemp .= "Initial Catalog=" . $strDB;
	return $strTemp;
	}


function zpConnectMySQL($strHost, $strUsername, $strPassword, $strDatabase)
	{
	if ($resConn = @mysqli_connect($strHost, $strUsername, $strPassword, $strDatabase))
		{
		return $resConn;
		}
	else
		{
		return false;
		}
	}


# date and time functions


function zpThisYear($lngOffset)
	{
	$arrDate = getdate(time() + ($lngOffset * 24 * 60 * 60));
	$year = strval($arrDate["year"]);
	return $year;
	}


function zpThisMonth($lngOffset)
	{
	$arrDate = getdate(time() + ($lngOffset * 24 * 60 * 60));
	$month = strval($arrDate["mon"]);
	if (strlen($month) == 1) { $month = "0" . $month; }
	return $month;
	}


function zpThisDay($lngOffset)
	{
	$arrDate = getdate(time() + ($lngOffset * 24 * 60 * 60));
	$day = strval($arrDate["mday"]);
	if (strlen($day) == 1) { $day = "0" . $day; }
	return $day;
	}


function zpThisDayName($lngOffset)
	{
	$arrDate = getdate(time() + ($lngOffset * 24 * 60 * 60));
	$weekday = strval($arrDate["weekday"]);
	return $weekday;
	}


function zpThisDate($lngOffset)
	{
	return zpThisYear($lngOffset) . zpThisMonth($lngOffset) . zpThisDay($lngOffset);
	}


function zpSlashDate($strDate, $blnShowFullYear)
	{
	$strTemp = substr($strDate,6) . "/" . substr($strDate,4,2) . "/";
	if ($blnShowFullYear)
		{
		$strTemp .= substr($strDate,0,4);
		}
	else
		{
		$strTemp .= substr($strDate,2,2);
		}
	return $strTemp;
	}


function zpThisHour($lngOffset)
	{
	$arrDate = getdate(time() + ($lngOffset * 24 * 60 * 60));
	$hour = strval($arrDate["hours"]);
	if (strlen($hour) == 1) { $hour = "0" . $hour; }
	return $hour;
	}


function zpThisMinute($lngOffset)
	{
	$arrDate = getdate(time() + ($lngOffset * 24 * 60 * 60));
	$minute = strval($arrDate["minutes"]);
	if (strlen($minute) == 1) { $minute = "0" . $minute; }
	return $minute;
	}


function zpThisSecond($lngOffset)
	{
	$arrDate = getdate(time() + ($lngOffset * 24 * 60 * 60));
	$second = strval($arrDate["seconds"]);
	if (strlen($second) == 1) 
		{ 
		$second = "0" . $second; 
		}
	return $second;
	}


function zpThisTime($lngOffset)
	{
	return zpThisHour($lngOffset) . zpThisMinute($lngOffset) . zpThisSecond($lngOffset);
	}


function zpColonTime($strTime, $blnShowSeconds)
	{
	$strTemp = substr($strTime,0,2) . ":" . substr($strTime,2,2);
	if ($blnShowSeconds) 
		{ 
		$strTemp .= ":" . substr($strTime,4); 
		}
	return $strTemp;
	}


function zpTimeDiff($strDate1, $strTime1, $strDate2, $strTime2)
	{
	if ($strDate1 == "00000000") { $strDate1 = "00000101"; }
	if ($strDate2 == "00000000") { $strDate2 = "00000101"; }
	$intTimeStamp1 = strtotime(substr($strDate1,0,4) . "-" . substr($strDate1,4,2) . "-" . substr($strDate1,6,2) . " " . substr($strTime1,0,2) . ":" . substr($strTime1,2,2) . ":" . substr($strTime1,4,2));
	$intTimeStamp2 = strtotime(substr($strDate2,0,4) . "-" . substr($strDate2,4,2) . "-" . substr($strDate2,6,2) . " " . substr($strTime2,0,2) . ":" . substr($strTime2,2,2) . ":" . substr($strTime2,4,2));
	$intDiff = round($intTimeStamp1 - $intTimeStamp2, 0);
	return $intDiff;
	}

function zpDateDiff($strDate1, $strDate2)
	{
	return round(zpTimeDiff($strDate1, '000001', $strDate2, '000001') / 60 / 60 / 24, 0);
	}

function zpFormatSeconds($intSeconds)
	{
	$intHours = floor($intSeconds / 3600);
	$intSeconds = $intSeconds - ($intHours * 3600);
	$intMinutes = floor($intSeconds / 60);
	$intSeconds = $intSeconds - ($intMinutes * 60);
	if (strlen($intMinutes) == 1) { $intMinutes = "0" . $intMinutes; }
	if (strlen($intSeconds) == 1) { $intSeconds = "0" . $intSeconds; }
	return "" . $intHours . ":" . $intMinutes . ":" . $intSeconds;
	}


function zpFormatSecondsHMS($intSeconds)
	{
	$intHours = floor($intSeconds / 3600);
	$intSeconds = $intSeconds - ($intHours * 3600);
	$intMinutes = floor($intSeconds / 60);
	$intSeconds = $intSeconds - ($intMinutes * 60);
	if (strlen($intMinutes) == 1) { $intMinutes = "0" . $intMinutes; }
	if (strlen($intSeconds) == 1) { $intSeconds = "0" . $intSeconds; }
	return "" . $intHours . "h " . $intMinutes . "m " . $intSeconds . "s";
	}


function zpDaysInYear($intYear)
	{
	$intYear = settype($intYear,"integer");
	if (($intYear / 4) == (floor($intYear / 4)))
		{
		if (($intYear / 100) == (floor($intyear / 100)))
			{
			if (($intYear / 400) == (floor($intyear / 400))) { $intDays = 366; } else { $intDays = 365; }
			}
		else
			{
			$intDays = 366;
			}
		}
	else
		{
		$intDays = 365;
		}
	return $intDays;
	}


function zpDaysInMonth($intMonth, $intYear)
	{
	settype($intMonth,"integer");
	switch ($intMonth)
		{
		case 1:
			$intDays = 31; break;
		case 2:
			if (zpDaysInYear(settype($intYear,"integer")) == 366) { $intDays = 29; } else { $intDays = 28; }
			break;
		case 3:
			$intDays = 31; break;
		case 4:
			$intDays = 30; break;
		case 5:
			$intDays = 31; break;
		case 6:
			$intDays = 30; break;
		case 7:
			$intDays = 31; break;
		case 8:
			$intDays = 31; break;
		case 9:
			$intDays = 30; break;
		case 10:
			$intDays = 31; break;
		case 11:
			$intDays = 30; break;
		case 12:
			$intDays = 31; break;
		}
	return $intDays;
	}

function zpMonthName($intMonth, $intTruncate)
	{
	settype($intMonth, "integer");
	switch($intMonth)
		{
		case 1 : $strMonth = "January"; break;
		case 2 : $strMonth = "February"; break;
		case 3 : $strMonth = "March"; break;
		case 4 : $strMonth = "April"; break;
		case 5 : $strMonth = "May"; break;
		case 6 : $strMonth = "June"; break;
		case 7 : $strMonth = "July"; break;
		case 8 : $strMonth = "August"; break;
		case 9 : $strMonth = "September"; break;
		case 10 : $strMonth = "October"; break;
		case 11 : $strMonth = "November"; break;
		case 12 : $strMonth = "December"; break;
		}
	if ($intTruncate > 0)
		{
		$strMonth = substr($strMonth, 0, $intTruncate);
		}
	return $strMonth;
	}


function zpGetStarSign($date) # YYYYMMDD
	{
	$date = strtotime(substr($date, 0, 4) . '-' . substr($date, 4, 2) . '-' . substr($date, 6, 2));

	$zodiac[356] = "capricorn";
	$zodiac[326] = "sagittarius";
	$zodiac[296] = "scorpio";
	$zodiac[266] = "libra";
	$zodiac[235] = "virgo";
	$zodiac[203] = "leo";
	$zodiac[172] = "cancer";
	$zodiac[140] = "gemini";
	$zodiac[111] = "taurus";
	$zodiac[78]  = "aries";
	$zodiac[51]  = "pisces";
	$zodiac[20]  = "aquarius";
	$zodiac[0]   = "capricorn";
	$dayOfTheYear = date("z",$date);
	$isLeapYear = date("L",$date);
	if ($isLeapYear && ($dayOfTheYear > 59)) $dayOfTheYear = $dayOfTheYear - 1;
	foreach($zodiac as $day => $sign) if ($dayOfTheYear > $day) break;
	return $sign;
	}


function zpGetStarSignIcon($sign)
	{
	$icon = '';
	switch ($sign)
		{
		case 'aries' : $icon = '&#9800'; break;
		case 'taurus' : $icon = '&#9801'; break;
		case 'gemini' : $icon = '&#9802'; break;
		case 'cancer' : $icon = '&#9803'; break;
		case 'leo' : $icon = '&#9804'; break;
		case 'virgo' : $icon = '&#9805'; break;
		case 'libra' : $icon = '&#9806'; break;
		case 'scorpio' : $icon = '&#9807'; break;
		case 'sagittarius' : $icon = '&#9808'; break;
		case 'capricorn' : $icon = '&#9809'; break;
		case 'aquarius' : $icon = '&#9810'; break;
		case 'pisces' : $icon = '&#9811'; break;
		}
	return $icon;
	}


# domain and site functions


function zpOnLiveSite($strDomain)
	{
	$strTemp = $strDomain;
	if (strpos($strTemp, "www.") == 0) { $strTemp = substr($strTemp, 4); }
	if (is_integer(strpos($_SERVER["HTTP_HOST"], $strTemp))) { return True; } else { return False; }
	}


function zpGetPageName()
	{
	$page = $_SERVER["SCRIPT_NAME"];
	$pos = strpos($page,"/");
	if (!($pos === false)) { $page = substr($page,strrpos($page,"/") + 1); }
	$pos = strpos($page,"?");
	if (!($pos === false)) { $page = substr($page, 0, $pos); }
	return $page;
	}


# miscellaneous functions


function zpTruncate(&$string, $length)
	{
	if (strlen($string) > $length)
		{
		$string = substr($string, 0, $length);
		}
	}


function zpGetOrPostVar($strName)
	{
	$strResult = @$_POST[$strName];
	if (is_null($strResult)) { $strResult = @$_GET[$strName]; }
	if (is_null($strResult)) { $strResult = @$_GET["amp;" . $strName]; }
	$strResult = str_replace("\'", "'", $strResult);
	return $strResult;
	}


function zpPostVar($strName)
	{
	$strResult = @$_POST[$strName];
	$strResult = str_replace("\'", "'", $strResult);
	return $strResult;
	}


function zpGetVar($strName)
	{
	$strResult = @$_GET[$strName];
	if (is_null($strResult)) { $strResult = @$_GET["amp;" . $strName]; }
	$strResult = str_replace("\'", "'", $strResult);
	return $strResult;
	}


function zpSessionVar($strName)
	{
	$strResult = @$_SESSION[$strName];
	return $strResult;
	}


function zpServerVar($strName)
	{
	$strResult = @$_SERVER[$strName];
	return $strResult;
	}


function zpValidEmail($strAddress)
	{
	# must be at least a@bb.cc
	if (strlen($strAddress) < 6) { return false; }
	# must have at least 1 @
	if (!is_numeric(strpos($strAddress, "@"))) { return false; }
	# must have at least 1 .
	if (!is_numeric(strpos($strAddress, "."))) { return false; }
	# must have no more than 6 chars after the last .
	if (strlen($strAddress) - strrpos($strAddress,".") > 7) { return false; }
	# must have at least 2 chars after the last .
	if (strlen($strAddress) - strrpos($strAddress,".") < 3) { return false; }
	# must have no underscore after the @
	if (strpos($strAddress,"_")) { if (strrpos($strAddress,"_") > strrpos($strAddress,"@")) { return false; } }
	# must have only 1 @
	$arrTemp = explode("@",$strAddress);
	if (count($arrTemp) > 2) { return false; }
	# check each char for validity
	for ($i = 0; $i< strlen($strAddress); $i++)
		{
		$blnGood = false;
		if (is_numeric(substr($strAddress, $i, 1))) { $blnGood = true; }
		if ((ord(strtoupper(substr($strAddress, $i, 1))) >= 65) && (ord(strtoupper(substr($strAddress, $i, 1))) <= 90)) { $blnGood = true; }
		if (substr($strAddress, $i, 1) == "_") { $blnGood = true; }
		if (substr($strAddress, $i, 1) == ".") { $blnGood = true; }
		if (substr($strAddress, $i, 1) == "@") { $blnGood = true; }
		if (substr($strAddress, $i, 1) == "-") { $blnGood = true; }
		if (substr($strAddress, $i, 1) == "+") { $blnGood = true; }
		if (!$blnGood) { return false; }
		}
	return true;
	}


function zpReadTextFile($strPath)
	{
	if (file_exists($strPath))
		{
		$arrFile = file($strPath);
		$strFile = implode("",$arrFile);
		return $strFile;
		}
	else
		{
		return "";
		}
	}


function zpWAMP()
	{
	if (!$strFilePath = @$_SERVER["ORIG_PATH_TRANSLATED"]) 
		{ 
		if (!$strFilePath = @$_SERVER["PATH_TRANSLATED"])
			{
			$strFilePath = @$_SERVER["SCRIPT_FILENAME"];
			}
		}
	if (strlen($strFilePath) >= 2)
		{
		if (!(strpos(strtolower($strFilePath), 'wamp') === false))
			{
			return true;
			}
		else
			{
			return false;
			}
		}
	else
		{
		return(false);
		}
	}


function zpCurrentDriveLetter()
	{
	if (!$strFilePath = @$_SERVER["ORIG_PATH_TRANSLATED"]) 
		{ 
		if (!$strFilePath = @$_SERVER["PATH_TRANSLATED"])
			{
			$strFilePath = @$_SERVER["SCRIPT_FILENAME"];
			}
		}
	if (strlen($strFilePath) >= 2)
		{
		return(strtolower(substr($strFilePath, 0, 1)));
		}
	else
		{
		return("");
		}
	}


function zpDbFolderPath($strDomainName)
	{
	$strDbFolderPath = "";
	if (zpOnLiveSite($strDomainName))
		{
		$strDbFolderPath = "d:\\domains\\" . substr($strDomainName, 4) . "\\db\\";
		}
	elseif (zpWAMP())
		{
		$strDbFolderPath = zpCurrentDriveLetter() . ":/wamp/wwwdb/";
		}
	else
		{
		if (is_dir("c:\inetpub\\wwwdb\\")) { $strDbFolderPath = "c:\\inetpub\\wwwdb\\"; }
		elseif (is_dir("c:\\inetpub\\db\\")) { $strDbFolderPath = "c:\\inetpub\\db\\"; }
		else { $strDbFolderPath = ""; }
		}
	return $strDbFolderPath;
	}


function zpAllowChars($strValue, $strChars, $blnCaseSense)
	{
	$strResult = "";
	if ($blnCaseSense)
		{
		for ($i = 0; $i < strlen($strValue); $i++)
			{
			$strChar = substr($strValue, $i, 1);
			if (is_numeric(strpos($strChars, $strChar))) { $strResult .= $strChar; }
			}
		}
	else
		{
		$strChars = strtoupper($strChars);
		for ($i = 0; $i < strlen($strValue); $i++)
			{
			$strChar = substr($strValue, $i, 1);
			if (is_numeric(strpos($strChars, strtoupper($strChar)))) { $strResult .= $strChar; }
			}
		}
	return $strResult;
	}


function zpDenyChars($strValue, $strChars, $blnCaseSense)
	{
	$strResult = "";
	if ($blnCaseSense)
		{
		for ($i = 0; $i < strlen($strValue); $i++)
			{
			$strChar = substr($strValue, $i, 1);
			if (!is_numeric(strpos($strChars, $strChar))) { $strResult .= $strChar; }
			}
		}
	else
		{
		$strChars = strtoupper($strChars);
		for ($i = 0; $i < strlen($strValue); $i++)
			{
			$strChar = substr($strValue, $i, 1);
			if (!is_numeric(strpos($strChars, strtoupper($strChar)))) { $strResult .= $strChar; }
			}
		}
	return $strResult;
	}


function zpGuid()
	{
	return md5(uniqid(rand(), 1));
	}


function zpObfuscateString($strText)
	{
	$strNew = "";
	for ($i = 0; $i < strlen($strText); $i++)
		{
		$strNew .= "&#" . ord(substr($strText, $i, 1)) . ";";
		}
	return $strNew;
	}


function zpHTML2RGB($color)
	{
	if ($color[0] == '#') { $color = substr($color, 1); }
	if (strlen($color) == 6) { list($r, $g, $b) = array($color[0].$color[1], $color[2].$color[3], $color[4].$color[5]); }
	elseif (strlen($color) == 3) { list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]); }
	else { return false; }
	$r = hexdec($r); $g = hexdec($g); $b = hexdec($b);
	return array($r, $g, $b);
	}


function zpRGB2HTML($r, $g=-1, $b=-1)
	{
	if (is_array($r) && sizeof($r) == 3) { list($r, $g, $b) = $r; }
	$r = intval($r); 
	$g = intval($g);
	$b = intval($b);
	$r = dechex($r<0?0:($r>255?255:$r));
	$g = dechex($g<0?0:($g>255?255:$g));
	$b = dechex($b<0?0:($b>255?255:$b));
	$color = (strlen($r) < 2?'0':'').$r;
	$color .= (strlen($g) < 2?'0':'').$g;
	$color .= (strlen($b) < 2?'0':'').$b;
	return '#'.$color;
	}


?>
