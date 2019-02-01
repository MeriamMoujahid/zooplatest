<?php


#	CLASS_URL.PHP
#
#	Author:		Andy Towler
#	Created:	6 June 2004
#	Revised:	9 March 2006
#	Copyright:	2004-2006 Andy Towler, All Rights Reserved


class ZpURL
	{

	public $URL;
	public $Protocol;
	public $Server;
	public $PagePath;
	public $PageName;
	public $QueryString;
	public $FileSystemPath;
	public $FileSystemRoot;

	public function __construct()
		{
		# first try to get the page path ( /folder/folder/page.php )
		if (!isset($_SERVER["REQUEST_URI"]))
			{
			# we're getting it from SCRIPT_NAME (IIS)
			$this->PagePath = $_SERVER["SCRIPT_NAME"];
			}
		else
			{
			# we're getting it from REQUEST_URI (BadBlue)
			$this->PagePath = $_SERVER["REQUEST_URI"];
			# this will also contain the querystring which must be stripped if present
			if (!(strpos($this->PagePath, "?") === false))
				{
				$this->PagePath = substr($this->PagePath, 0, strpos($this->PagePath, "?"));
				}
			}
		# now get the server protocol if we can
		if (!isset($_SERVER["SERVER_PROTOCOL"]))
			{
			# we can't get it from the server variables so assume http
			$this->Protocol = "http";
			}
		else
			{
			# check for https
			if (!(strpos($_SERVER["SERVER_PROTOCOL"], "HTTPS") === false))
				{
				$this->Protocol = "https";
				}
			else
				{
				$this->Protocol = "http";
				}
			}
		# now get the server name
		$this->Server = $_SERVER["HTTP_HOST"];
		# now build the full url
		$this->URL = $this->Protocol . "://" . $this->Server . $this->PagePath;
		# now extract the page name
		# start with the page path
		$this->PageName = $this->PagePath;
		# remove everything before the last slash
		$pos = strpos($this->PageName, "/");
		if (!($pos === false))
			{
			$this->PageName = substr($this->PageName, strrpos($this->PageName, "/") + 1);
			}
		# now get the query string
		if (!isset($_SERVER["QUERY_STRING"]))
			{
			$this->QueryString = "";
			}
		else
			{
			$this->QueryString = $_SERVER["QUERY_STRING"];
			}
		# now get the filesystem path & root
		if (!$this->FileSystemPath = @$_SERVER["ORIG_PATH_TRANSLATED"])
			{
			$this->FileSystemPath = @$_SERVER["PATH_TRANSLATED"];
			}
		$this->FileSystemPath = str_replace(chr(92) . chr(92), "/", $this->FileSystemPath);
		$this->FileSystemRoot = str_replace($this->PagePath, "", $this->FileSystemPath);
		$this->FileSystemRoot = str_replace("/", chr(92), $this->FileSystemRoot);
		$this->FileSystemPath = str_replace("/", chr(92), $this->FileSystemPath);
		}

	}

# EOF
