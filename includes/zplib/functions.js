

//	RESOURCE.FUNCTIONS.JS
//
//	Author:		Andy Towler
//	Created:	1999
//	Revised:	1 March 2008
//	Copyright:	1999-2008 Andy Towler, All Rights Reserved


//	STRING FUNCTIONS


function zpGetFront(strMain, strSearch)
	{
	var intPos = strMain.indexOf(strSearch);
	if (intPos == -1) { return null }
	return strMain.substring(0, intPos)
	}


function zpGetEnd(strMain, strSearch)
	{
	var intPos = strMain.indexOf(strSearch);
	if (intPos == -1) { return null }
	return strMain.substring(intPos + strSearch.length, strMain.length)
	}


function zpInsertString(strMain, strSearch, strInsert)
	{
	var strFront = zpGetFront(strMain, strSearch);
	var strEnd = zpGetEnd(strMain, strSearch);
	if (strFront != null && strEnd != null) { return strFront + strInsert + strSearch + strEnd }
	return null
	}


function zpDeleteString(strMain, strDelete)
	{
	return zpReplaceString(strMain, strDelete, "")
	}


function zpReplaceString(strMain, strSearch, strReplace)
	{
	var strFront = zpGetFront(strMain, strSearch);
	var strEnd = zpGetEnd(strMain, strSearch);
	if (strFront != null && strEnd != null) { return strFront + strReplace + strEnd }
	return null
	}


function zpAllowChars(strValue, strChars, blnCaseSense)
	{
	strResult = "";
	if (strValue.length > 0)
		{
		if (blnCaseSense)
			{
			for (var i = 0; i < strValue.length; i++)
				{
				strChar = strValue.substr(i, 1);
				if (strChars.indexOf(strChar) > -1) { strResult += strChar; }
				}
			}
		else
			{
			strChars = strChars.toUpperCase();
			for (var i = 0; i < strValue.length; i++)
				{
				strChar = strValue.substr(i, 1);
				if (strChars.indexOf(strChar.toUpperCase()) > -1) { strResult += strChar; }
				}
			}
		}
	return strResult;
	}


function zpDenyChars(strValue, strChars, blnCaseSense)
	{
	strResult = "";
	if (strValue.length > 0)
		{
		if (blnCaseSense)
			{
			for (var i = 0; i < strValue.length; i++)
				{
				strChar = strValue.substr(i, 1);
				if (strChars.indexOf(strChar) == -1) { strResult += strChar; }
				}
			}
		else
			{
			strChars = strChars.toUpperCase();
			for (var i = 0; i < strValue.length; i++)
				{
				strChar = strValue.substr(i, 1);
				if (strChars.indexOf(strChar.toUpperCase()) == -1) { strResult += strChar; }
				}
			}
		}
	return strResult;
	}


//	DATE FUNCTIONS


function zpGetDate(lngOffset)
	{
	// returns a date in the form yyyymmdd, lngOffset days away from today
	var dtmToday = new Date();
	var lngTodayOffset = dtmToday.getTime();
	var dtmTemp = new Date(lngTodayOffset + (lngOffset * 24 * 60 * 60 * 1000));
	var intYear = dtmTemp.getYear();
	var intMonth = dtmTemp.getMonth() + 1;
	var intDay = dtmTemp.getDate();
	var strYear = intYear.toString();
	var strMonth = intMonth.toString();
	var strDay = intDay.toString();
	if (strYear.length == 2) { if (intYear > 50) { strYear = "19" + strYear } else { strYear = "20" + strYear } }
	if (strMonth.length == 1) { strMonth = "0" + strMonth }
	if (strDay.length == 1) { strDay = "0" + strDay }
	return (strYear + strMonth + strDay)
	}


function zpDateDiff(strDate1, strDate2)
	{
	// takes 2 dates in the form yyyymmdd and returns the number of days difference
	var dtmTemp1 = new Date(strDate1.substring(0,4), parseInt(strDate1.substring(4,6))-1, strDate1.substring(6,8));
	var dtmTemp2 = new Date(strDate2.substring(0,4), parseInt(strDate2.substring(4,6))-1, strDate2.substring(6,8));
	var lngOffset1 = dtmTemp1.getTime();
	var lngOffset2 = dtmTemp2.getTime();
	return Math.round((lngOffset2 - lngOffset1) / 1000 / 60 / 60 / 24)
	}


//	MISC FUNCTIONS


function zpNumeric(val)
	{
	return (parseFloat(val, 10) == (val * 1));
	}


function zpMakeArray(lngElements) { this.length = lngElements }


function zpMakeImageArray(lngElements, lngWidth, lngHeight)
	{
	this.length = lngElements;
	for (var lngLoop = 1; lngLoop <= lngElements; lngLoop++) { this[lngLoop] = new Image(lngWidth, lngHeight) }
	return this
	}


function zpToHex(intDec)
	{
	if (intDec > 255) { return null }
	var strHexChars = "0123456789abcdef";
	var intLow = intDec % 16;
	var intHigh = (intDec - intLow) / 16;
	return "" + hexchars.charAt(intHigh) + hexchars.charAt(intLow)
	}


function dw(t) { document.write(t) }


function zpSure(strPrompt)
	{
	if (strPrompt.length < 1) { strPrompt = "Are you sure?" }
	return confirm(strPrompt)
	}


function zpReallySure() { return confirm("Are you REALLY sure?") }


function zpDaysInYear(intYear)
	{
	if ((intYear / 4) == parseInt(intYear / 4))
		{
		if ((intYear / 100) == parseInt(intYear / 100))
			{
			if ((intYear / 400) == parseInt(intYear / 400)) { return 366 }
			else
				{
				return 365
				}
			}
		else
			{
			return 366
			}
		}
	else
		{
		return 365
		}
	}


function zpDaysInMonth(intMonth, intYear)
	{
	switch(intMonth)
		{
		case 1, 3, 5, 7, 8, 10, 12:
			return 31;
			break
		case 4, 6, 9, 11:
			return 30;
			break
		case 2:
			if (zpDaysInYear(intYear)==366) { return 29 } else { return 28 };
			break
		}
	return 0
	}


function zpMakeWindow(strUrl, strChrome)
	{
	var objWindow = window.open(strUrl, "", strChrome);
	if (navigator.appVersion.charAt(0) == "2" && navigator.appName == "Netscape") { objWindow = window.open(strUrl, "", strChrome) }
	}


function zpMakeImagePopup(strURL, intWidth, intHeight, blnCentered)
	{
	strChrome = "width=" + intWidth + ",height=" + intHeight;
	zpMakeWindow(strURL, strChrome);
	}


function zpGetScreenWidth() { return screen.availWidth }


function zpGetScreenHeight() { return screen.availHeight }


function zpGetWindowWidth()
	{
	// cross-browser window width getter, added 2007-07-08
	var intW = 0;
	if( typeof( window.innerWidth ) == 'number' )
		{
		//Non-IE
		intW = window.innerWidth;
		} 
	else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) 
		{
		//IE 6+ in 'standards compliant mode'
		intW = document.documentElement.clientWidth;
		} 
	else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) 
		{
		//IE 4 compatible
		intW = document.body.clientWidth;
		}
	return intW;
	}


function zpValidEmail(emailStr)
	{
	var emailPat =/^(.+)@(.+)$/											// check user@domain pattern
	var specialChars = "\\(\\)<>@,;:\\\\\\\"\\.\\[\\]"					// check banned special chars
	var validChars = "\[^\\s" + specialChars + "\]"						// check banned normal chars
	var quotedUser = "(\"[^\"]*\")"										// check if username quoted
	var ipDomainPat =/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/	// check ip format
	var atom = validChars + '+'											// series of non special chars
	var word = "(" + atom + "|" + quotedUser + ")"						// a word
	var userPat = new RegExp("^" + word + "(\\." + word + ")*$")		// structure of username
	var domainPat = new RegExp("^" + atom + "(\\." + atom +")*$")		// structure of domain
	var matchArray = emailStr.match(emailPat)
	if (matchArray == null) { return false }
	var user = matchArray[1];
	var domain = matchArray[2];
	if (user.match(userPat) == null) { return false }
	var IPArray = domain.match(ipDomainPat)
	if (IPArray != null)
		{
		for (var i = 1; i <= 4; i++) { if (IPArray[i] > 255) { return false } }
		return true
		}
	var domainArray = domain.match(domainPat);
	if (domainArray == null) { return false }
	var atomPat = new RegExp(atom,"g");
	var domArr = domain.match(atomPat);
	var len = domArr.length;
	// test for length of final part of domain - now need to allow up to 6 chars (.museum)
	if (domArr[domArr.length - 1].length < 2 || domArr[domArr.length - 1].length > 6) { return false }
	if (len < 2) { return false }
	return true;
	}
