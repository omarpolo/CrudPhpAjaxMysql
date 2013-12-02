<?php

// ------------------------------------------------------------------------

class Paginacija_Stranica {
	//inicijalizacija nonstatic varijabli
	var $php_self;
	var $rows_per_page = 10; //broj po stranici
	var $total_rows = 0; //total rovova
	var $links_per_page = 5; //broj linkova po stranici
	var $append = ""; //Paremeters to append to pagination links
	var $sql = "";
	var $debug = false;
	var $conn = false;
	var $page = 1; //broj stranice koji su dobiti preko servera
	var $max_pages = 0;
	var $offset = 0;
	var $sTabela=""; // ime tabele
	var $sUslov="";
	//punim main funkcijom iz javnog poziva nonstatic variable u klasi
	function Paginacija_Stranica($connection, $sql, $rows_per_page , $links_per_page, $append = "", $sFTabela, $sFUslov) 
	{
		$this->conn = $connection;
		$this->sql = $sql;
		$this->rows_per_page = (int)$rows_per_page;
		if (intval($links_per_page ) > 0) {
			$this->links_per_page = (int)$links_per_page;
		} else {
			$this->links_per_page = 5;
		}
		$this->append = $append;
		$this->php_self = htmlspecialchars($_SERVER['PHP_SELF'] );
		if (isset($_GET['page'] )) {
			$this->page = intval($_GET['page'] );
		}
		$this->sTabela = $sFTabela;
		$this->sUslov = $sFUslov;
	}
	


	//sada radim paginaciju
	function Paginacija() {
		//Check for valid mysql connection
		
		
		//Find total number of rows
		$all_rs = $this->conn->prepare( $this->sql );
		$all_rs->execute();
		
		if (! $all_rs) {
			if ($this->debug)
				echo "SQL query failed. Check your query.<br /><br />Error Returned: " . mysql_error();
			return false;
		}
		$this->total_rows = $all_rs->rowCount();
		
		//Return FALSE if no rows found
		if ($this->total_rows == 0) {
			if ($this->debug)
				echo "Query returned zero rows.";
			return FALSE;
		}
		
		//Max number of pages
		$this->max_pages = ceil($this->total_rows / $this->rows_per_page );
		if ($this->links_per_page > $this->max_pages) {
			$this->links_per_page = $this->max_pages;
		}
		
		//ako je broj stranice veci od uk broja ili manji od 0
		if ($this->page > $this->max_pages || $this->page <= 0) {
			$this->page = 1;
		}
		
		//Calculate Offset
		$this->offset = $this->rows_per_page * ($this->page - 1);
		
		//Fetch the required result set
		$query = $this->sql . " LIMIT {$this->offset}, {$this->rows_per_page}";
		$rs = $this->conn->prepare( $query );
		$rs->execute();
		
		if (! $rs) {
			if ($this->debug)
				echo "Pagination query failed. Check your query.<br /><br />Error Returned: " . mysql_error();
			return false;
		}
		return $rs;
	}
	
	/**
	 * Display the link to the first page
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to 'First'
	 * @return string
	 */
	function renderFirst($tag = 'First') {
		if ($this->total_rows == 0)
			return FALSE;
		
		if ($this->page == 1) {
			return "$tag ";
		} else {
			//return '<a href="' . $this->php_self . '?page=1&' . $this->append . '">' . $tag . '</a> ';
            //default to one (1)
            return " <a href='javascript:void(0);' OnClick='ulodajStranu(1)'>$tag</a> ";
		}
	}
	
	/**
	 * Display the link to the last page
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to 'Last'
	 * @return string
	 */
	function renderLast($tag = 'Last') {
		if ($this->total_rows == 0)
			return FALSE;
		
		if ($this->page == $this->max_pages) {
			return $tag;
		} else {
			//return ' <a href="' . $this->php_self . '?page=' . $this->max_pages . '&' . $this->append . '">' . $tag . '</a>';
            $nBrojstranice = $this->max_pages;
			$sTbl= $nBrojstranice ."," . $this->sUslov . ",'Kontakti'";
            return " <a href='javascript:void(0);' OnClick='ulodajStranu($nBrojstranice)' title='Last Page'>$tag</a> ";
		}
	}
	/**
	 * Display the next link
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to '>>'
	 * @return string
	 */
	function renderNext($tag = '&gt;&gt;') {
		if ($this->total_rows == 0)
			return FALSE;
		
		if ($this->page < $this->max_pages) {
			//return '<a href="' . $this->php_self . '?page=' . ($this->page + 1) . '&' . $this->append . '" title=\'next to\'>' . $tag . '</a>';
            $nBrojstranice = $this->page + 1;
            return " <a href='javascript:void(0);' OnClick='ulodajStranu($nBrojstranice)' title='Next Page'>$tag</a> ";
		} else {
			return $tag;
		}
	}
	
	/**
	 * Display the previous link
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to '<<'
	 * @return string
	 */
	function renderPrev($tag = '&lt;&lt;') {
		if ($this->total_rows == 0)
			return FALSE;
		
		if ($this->page > 1) {
			//return ' <a href="' . $this->php_self . '?page=' . ($this->page - 1) . '&' . $this->append . '">' . $tag . '</a>';
            $nBrojstranice = $this->page - 1;
            return " <a href='javascript:void(0);' OnClick='ulodajStranu($nBrojstranice)' title='Previous Page'>$tag</a> ";
		} else {
			return " $tag ";
		}
	}
	
	/**
	 * Display the page links
	 *
	 * @access public
	 * @return string
	 */
	function renderNav($prefix = '<span class="page_link">', $suffix = '</span>') {
		if ($this->total_rows == 0)
			return FALSE;
		
		$batch = ceil($this->page / $this->links_per_page );
		$end = $batch * $this->links_per_page;
		if ($end == $this->page) {
		//$end = $end + $this->links_per_page - 1;
		//$end = $end + ceil($this->links_per_page/2);
		}
		if ($end > $this->max_pages) {
			$end = $this->max_pages;
		}
		$start = $end - $this->links_per_page + 1;
		$links = '';
		
		for($i = $start; $i <= $end; $i ++) {
			if ($i == $this->page) {
				$links .= $prefix . " $i " . $suffix;                                       
			} else {
				//$links .= ' ' . $prefix . '<a href="' . $this->php_self . '?page=' . $i . '&' . $this->append . '">' . $i . '</a>' . $suffix . ' ';
                //$pageno = $this->page + 1;
                $links .= " <a href='javascript:void(0);' OnClick='ulodajStranu($i)' title='Another page'>$i</a> ";
			}
		}
		
		return $links;
	}
	
	/**
	 * Display full pagination navigation
	 *
	 * @access public
	 * @return string
	 */
	function prikaziNavigaciju() {
        //echo $this->renderFirst() . " " . $this->renderPrev();
        
		return $this->renderFirst() . '&nbsp;' . $this->renderPrev() . '&nbsp;' . $this->renderNav() . '&nbsp;' . $this->renderNext() . '&nbsp;' . $this->renderLast();
	}
	
	/**
	 * Set debug mode
	 *
	 * @access public
	 * @param bool $debug Set to TRUE to enable debug messages
	 * @return void
	 */
	function setDebug($debug) {
		$this->debug = $debug;
	}
}
?>
