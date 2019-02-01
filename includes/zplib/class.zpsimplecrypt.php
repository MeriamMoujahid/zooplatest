<?php

class ZpSimpleCrypt 
	{

	private $scramble1;     // 1st string of ASCII characters
	private $scramble2;     // 2nd string of ASCII characters

	public $Errors;        // array of error messages
	public $adj;           // 1st adjustment value (optional)
	public $mod;           // 2nd adjustment value (optional)

	public $sourcelen = 16; // to disguise the length of small strings

	public function __construct()
		{
		$this->Errors = array();
		// Each of these two strings must contain the same characters, but in a different order.
		// Use only printable characters from the ASCII table.
		// Do not use single quote, double quote or backslash as these have special meanings in PHP. ALSO REMOVED ? < > and the space character
		// Each character can only appear once in each string.
		$this->scramble1 = '!#$%&()*+,-./0123456789:;=@ABCDEFGHIJKLMNOPQRSTUVWXYZ[]^_`abcdefghijklmnopqrstuvwxyz{|}~';
		$this->scramble2 = 'TcS%p@6Ze|r:lGK/uCy.[2&iQ!#$~(;Lt-R}Ma,NvW+]okIOzUPdFV=mDYq1{3`h5w_794s8BgJx)Hnb*0Xf^jAE';
		if (strlen($this->scramble1) != strlen($this->scramble2)) 
			{
			trigger_error('** SCRAMBLE1 is not same length as SCRAMBLE2 **', E_USER_ERROR);
			}
		$this->adj = 1.75;  // this value is added to the rolling fudgefactors
		$this->mod = 3;     // if divisible by this the adjustment is made negative
		}

	public function Decrypt ($key, $source)
		{
		$this->Errors = array();
		// convert $key into a sequence of numbers
		$fudgefactor = $this->_convertKey($key);
		if ($this->Errors) return;
		if (empty($source)) 
			{
			$this->Errors[] = 'No value has been supplied for decryption';
			return;
			}
		$target = null;
		$factor2 = 0;
		for ($i = 0; $i < strlen($source); $i++) 
			{
			// extract a (multibyte) character from $source
			if (function_exists('mb_substr')) 
				{
				$char2 = mb_substr($source, $i, 1);
				} 
			else 
				{
				$char2 = substr($source, $i, 1);
				}
			// identify its position in $scramble2
			$num2 = strpos($this->scramble2, $char2);
			if ($num2 === false) 
				{
				$this->Errors[] = "Source string contains an invalid character ($char2)";
				return;
				}
			// get an adjustment value using $fudgefactor
			$adj     = $this->_applyFudgeFactor($fudgefactor);
			$factor1 = $factor2 + $adj;                 // accumulate in $factor1
			$num1    = $num2 - round($factor1);         // generate offset for $scramble1
			$num1    = $this->_checkRange($num1);       // check range
			$factor2 = $factor1 + $num2;                // accumulate in $factor2
			// extract (multibyte) character from $scramble1
			if (function_exists('mb_substr')) 
				{
				$char1 = mb_substr($this->scramble1, $num1, 1);
				} 
			else 
				{
				$char1 = substr($this->scramble1, $num1, 1);
				}
			// append to $target string
			$target .= $char1;
			}
		$target = base64_decode($target);
		return rtrim($target);
		}

	public function Encrypt ($key, $source)
		{
		$this->Errors = array();
		// convert $key into a sequence of numbers
		$fudgefactor = $this->_convertKey($key);
		if ($this->Errors) return;
		if (empty($source)) 
			{
			$this->Errors[] = 'No value has been supplied for encryption';
			return;
			}
		// pad $source with spaces up to $sourcelen
		$source = str_pad($source, $this->sourcelen);
		$source = base64_encode($source); // gets around non-ascii chars
		$target = null;
		$factor2 = 0;
		for ($i = 0; $i < strlen($source); $i++) 
			{
			// extract a (multibyte) character from $source
			if (function_exists('mb_substr')) 
				{
				$char1 = mb_substr($source, $i, 1);
				} 
			else 
				{
				$char1 = substr($source, $i, 1);
				}
			// identify its position in $scramble1
			$num1 = strpos($this->scramble1, $char1);
			if ($num1 === false) 
				{
				$this->Errors[] = "Source string contains an invalid character ($char1)";
				return;
				}
			// get an adjustment value using $fudgefactor
			$adj     = $this->_applyFudgeFactor($fudgefactor);
			$factor1 = $factor2 + $adj;             // accumulate in $factor1
			$num2    = round($factor1) + $num1;     // generate offset for $scramble2
			$num2    = $this->_checkRange($num2);   // check range
			$factor2 = $factor1 + $num2;            // accumulate in $factor2
			// extract (multibyte) character from $scramble2
			if (function_exists('mb_substr')) 
				{
				$char2 = mb_substr($this->scramble2, $num2, 1);
				} 
			else 
				{
				$char2 = substr($this->scramble2, $num2, 1);
				}
			// append to $target string
			$target .= $char2;
			}
		return $target;
		}

	public function GetAdjustment ()
		{
		return $this->adj;
		}

	public function GetModulus ()
		{
		return $this->mod;
		}

	public function SetAdjustment ($adj)
		{
		$this->adj = (float)$adj;
		}

	public function SetModulus ($mod)
		{
		$this->mod = (int)abs($mod);    // must be a positive whole number
		}

	private function _applyFudgeFactor (&$fudgefactor)
		{
		// return an adjustment value  based on the contents of $fudgefactor
		// NOTE: $fudgefactor is passed by reference so that it can be modified
		$fudge = array_shift($fudgefactor);     // extract 1st number from array
		$fudge = $fudge + $this->adj;           // add in adjustment value
		$fudgefactor[] = $fudge;                // put it back at end of array
		if (!empty($this->mod)) 
			{					                // if modifier has been supplied
			if ($fudge % $this->mod == 0) 
				{							    // if it is divisible by modifier
				$fudge = $fudge * -1;           // make it negative
				}
			}
		return $fudge;
		}

	private function _checkRange ($num)
		{
		// check that $num points to an entry in $this->scramble1
		$num = round($num);         // round up to nearest whole number
		$limit = strlen($this->scramble1);
		while ($num >= $limit) 
			{
			$num = $num - $limit;   // value too high, so reduce it
			}
		while ($num < 0) 
			{
			$num = $num + $limit;   // value too low, so increase it
			}
		return $num;
		}

	private function _convertKey ($key)
		{
		// convert $key into an array of numbers
		if (empty($key)) 
			{
			$this->Errors[] = 'No value has been supplied for the encryption key';
			return;
			}
		$array[] = strlen($key);    // first entry in array is length of $key
		$tot = 0;
		for ($i = 0; $i < strlen($key); $i++) 
			{
			// extract a (multibyte) character from $key
			if (function_exists('mb_substr')) 
				{
				$char = mb_substr($key, $i, 1);
				} 
			else 
				{
				$char = substr($key, $i, 1);
				}
			// identify its position in $scramble1
			$num = strpos($this->scramble1, $char);
			if ($num === false) 
				{
				$this->Errors[] = "Key contains an invalid character ($char)";
				return;
				}
			$array[] = $num;        // store in output array
			$tot = $tot + $num;     // accumulate total for later
			}
		$array[] = $tot;            // insert total as last entry in array
		return $array;
		}

	}

# EOF
