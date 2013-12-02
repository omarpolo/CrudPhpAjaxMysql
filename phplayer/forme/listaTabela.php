<?php
/************************************************************/
/*
/*      KLASA ZA PRIKAZ I KREACIJU SVIH TABELA
/*		SQL SE IZVRSAVA U tabelesqlkontroler.php I
/*				paginacijaTabele.php
/*		OVDE KOPIRAJ BLOKOVE U SWITCHU I MIJENJAJ
/*
/************************************************************/
class listaTabela 
{
	var $rs;
	var $dbTabela = "";
	var $sTabela  = "";
	var $sForma   = "";
	
	function listaTabela ($f_rs, $f_tabela)
	{
		
		$this->dbTabela= $f_tabela;	
		$this->rs=$f_rs;
	}

	function napraviTabelu ()
	{	
		
		switch ($this->dbTabela)
		{
			case "kontakti":
			
				// ---------------- tabela ----------------------------------
				$this->sTabela =    				 "<table  id='my-tbl' class='sortable'>";
				$this->sTabela = 	$this->sTabela.  "<tr>";
				$this->sTabela = 	$this->sTabela.  "<th><input type='checkbox' class='selectallcheck'/></th>";
				$this->sTabela = 	$this->sTabela.  "<th>ID</th>";
				$this->sTabela = 	$this->sTabela.  "<th>Username</th>";
				$this->sTabela = 	$this->sTabela.  "<th>Full Name</th>";
				$this->sTabela = 	$this->sTabela.  "<th></th>";
				$this->sTabela = 	$this->sTabela.  "</tr>";
				
				
				while ($row = $this->rs->fetch(PDO::FETCH_NUM)){
					$this->sTabela = 	$this->sTabela.  "<tr class='data-tr' align='center'>";
					$this->sTabela = 	$this->sTabela.  "<td><input type='checkbox' name='tblcheck' class='tblcheck' value='{$row[0]}'/></td>";
					$this->sTabela = 	$this->sTabela.  "<td>{$row[0]}</td>";
					$this->sTabela = 	$this->sTabela.  "<td>{$row[1]}</td>";
					$this->sTabela = 	$this->sTabela.  "<td>{$row[2]}</td>";
					$this->sTabela = 	$this->sTabela.  "<td style='text-align:right;'>";
					$this->sTabela = 	$this->sTabela.  "<div id='' class='IdRed'>{$row[0]}</div>";
					$this->sTabela = 	$this->sTabela.  "<div id='' class='btnEdit customDugme'>Edit</div>";
					$this->sTabela = 	$this->sTabela.  "<div id='' class='btnDelete customDugme'>Delete</div>";
					$this->sTabela = 	$this->sTabela.  "</td>";
					$this->sTabela = 	$this->sTabela.  "</tr>";
				}      
				
				$this->sTabela = 	$this->sTabela.  "</table>";
			break;
		}
		//echo $this->sTabela;

		return $this->sTabela;

	}
	
	
}
?>