<?php


class ZpPagingRecordset
	{
	public $Data;
	public $Page;
	public $Records;
	public $Pages;
	public $PageSize;
	public $Error;
	public $SQL;

	public $FirstTip;
	public $PreviousTip;
	public $NextTip;
	public $LastTip;

	private $Conn;
	private $Offset;
	private $ControlHTML;

	public function __construct(&$conn, $intPageSize = 10)
		{
		$this->Conn = $conn;
		$this->PageSize = $intPageSize;

		$this->Error = true;
		$this->Offset = 0;
		$this->Records = 0;
		$this->Page = 0;
		$this->Pages = 0;
		$this->SQL = '';
		$this->ControlHTML = '';

		$this->FirstTip = 'first page';
		$this->PreviousTip = 'previous page';
		$this->NextTip = 'next page';
		$this->LastTip = 'last page';
		$this->Of = 'of';
		}

	public function GetData($sql, $intPage = 1)
		{
		$this->SQL = $sql;
		$this->Page = $intPage;

		if ($this->SQL != '')
			{
			if ($resRS = mysqli_query($this->Conn, $this->SQL))
				{
				$this->Records = mysqli_num_rows($resRS);
				$this->Pages = ceil($this->Records / $this->PageSize);
				if ($this->Page > $this->Pages) { $this->Page = $this->Pages; }
				if ($this->Page < 1) { $this->Page = 1; }
				$this->Offset = ($this->Page - 1) * $this->PageSize;
				mysqli_free_result($resRS);
				}
			if ($this->Records > 0)
				{
				$this->SQL .= " LIMIT " . $this->Offset . ", " . $this->PageSize . " ";
				if ($resRS = mysqli_query($this->Conn, $this->SQL))
					{
					while ($arrRS = mysqli_fetch_assoc($resRS)) { $this->Data[] = $arrRS; }
					$this->Error = false;
					mysqli_free_result($resRS);
					}
				}
			}
		}

	public function Controls($strURL, $strQS = '')
		{
		$this->ControlHTML = '';
		if (strlen($strQS) >= 1) { if (substr($strQS, 0, 1) != "&") { $strQS = "&amp;" . $strQS; } }
		if ($this->Page > 1)
			{
			$this->ControlHTML .= '<a href="' . $strURL . '?intCurPage=1' . $strQS . '" title="' . $this->FirstTip . '"><img src="zplib/icons/resultset_first.png" alt="' . $this->FirstTip . '" /></a>';
			$this->ControlHTML .= '<a href="' . $strURL . '?intCurPage=' . ($this->Page - 1) . $strQS . '" title="' . $this->PreviousTip . '"><img src="zplib/icons/resultset_previous.png" alt="' . $this->PreviousTip . '" /></a>';
			}
		else
			{
			$this->ControlHTML .= '<img src="zplib/icons/resultset_first_disabled.png" alt="" />';
			$this->ControlHTML .= '<img src="zplib/icons/resultset_previous_disabled.png" alt="" />';
			}
		$this->ControlHTML .= '&nbsp;' . max($this->Page, 1) . ' ' . $this->Of . ' ' . max($this->Pages, 1) . '&nbsp;';
		if ($this->Page < $this->Pages)
			{
			$this->ControlHTML .= '<a href="' . $strURL . '?intCurPage=' . ($this->Page + 1) . $strQS . '" title="' . $this->NextTip . '"><img src="zplib/icons/resultset_next.png" alt="' . $this->NextTip . '" /></a>';
			$this->ControlHTML .= '<a href="' . $strURL . '?intCurPage=' . $this->Pages . $strQS . '" title="' . $this->LastTip . '"><img src="zplib/icons/resultset_last.png" alt="' . $this->LastTip . '" /></a>';
			}
		else
			{
			$this->ControlHTML .= '<img src="zplib/icons/resultset_next_disabled.png" alt="" />';
			$this->ControlHTML .= '<img src="zplib/icons/resultset_last_disabled.png" alt="" />';
			}
		return $this->ControlHTML;
		}

		public function AltControls($url, $qs) {
			$totalrecords = $this->Records;
			$recordsperpage = $this->PageSize;
			$currentpage = $this->Page;
			$content = '';
			$paged = ($totalrecords > $recordsperpage);
			if ($paged) {
				$totalpages = ($paged) ? (int) (($totalrecords / $recordsperpage) + 1) : 1;
				$content .= '<div class="pagingwrap"><div class="paging"> ';
				$content .= (($currentpage > 1) ? '<a class="pagingfirst" href="' . $url . '?intCurPage=1&' . $qs . '"></a> ' : '<div class="pagingfirst"></div> ');
				$content .= (($currentpage > 1) ? '<a class="pagingleft" href="' . $url . '?intCurPage=' . ($currentpage - 1) . '&' . $qs . '"></a> ' : '<div class="pagingleft"></div> ');
				for ($p = 1; $p <= $totalpages; $p++) {
					if ($p == $currentpage) {
						$content .= '<div class="number thispage">' . $p . '</div> ';
					} else {
						$content .= '<a class="number" href="' . $url . '?intCurPage=' . $p . '&' . $qs . '">' . $p . '</a> ';
					}
				}
				$content .= (($currentpage < $totalpages) ? '<a class="pagingright" href="' . $url . '?intCurPage=' . (1 + $currentpage) . '&' . $qs . '"></a> ' : '<div class="pagingright"></div> ');
				$content .= (($currentpage < $totalpages) ? '<a class="paginglast" href="' . $url . '?intCurPage=' . $totalpages . '&' . $qs . '"></a> ' : '<div class="paginglast"></div> ');
				$content .= '</div></div><!--/pagingwrap--> ';
			}
			return $content;
		}

		public function CompactControls($url, $qs) {
			$totalrecords = $this->Records;
			$recordsperpage = $this->PageSize;
			$currentpage = $this->Page;
			$content = '';
			$paged = ($totalrecords > $recordsperpage);
			if ($paged) {
				$totalpages = ($paged) ? (int) (($totalrecords / $recordsperpage) + 1) : 1;
				$content .= '<div class="pagingwrap"><div class="paging"> ';
				$content .= (($currentpage > 1) ? '<a title="First page" class="pagingfirst" href="' . $url . '?intCurPage=1&' . $qs . '"></a> ' : '<div class="pagingfirst"></div> ');
				$content .= (($currentpage > 1) ? '<a title="Previous page" class="pagingleft" href="' . $url . '?intCurPage=' . ($currentpage - 1) . '&' . $qs . '"></a> ' : '<div class="pagingleft"></div> ');
				$content .= '<div class="number">' . max($this->Page, 1) . ' ' . $this->Of . ' ' . max($this->Pages, 1) . '</div> ';
				$content .= (($currentpage < $totalpages) ? '<a title="Next page" class="pagingright" href="' . $url . '?intCurPage=' . (1 + $currentpage) . '&' . $qs . '"></a> ' : '<div class="pagingright"></div> ');
				$content .= (($currentpage < $totalpages) ? '<a title="Last page" class="paginglast" href="' . $url . '?intCurPage=' . $totalpages . '&' . $qs . '"></a> ' : '<div class="paginglast"></div> ');
				$content .= '</div></div><!--/pagingwrap--> ';
			}
			return $content;
		}

	}

# EOF
