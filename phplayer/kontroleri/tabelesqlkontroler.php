<?php
/************************************************************/
/*
/*      KLASA ZA PRIKAZ I KREACIJU SVIH SQL ZA TABELE
/*		SQL SE IZVRSAVA ZATIM IDE PAGINACIJA 
/*				paginacijaTabele.php PA
/*		PRIKAZ TABELE IZ listaTahela.php
/*		OVDE KOPIRAJ BLOKOVE U SWITCHU I MIJENJAJ
/*
/************************************************************/

class listUpita 
{
	var $dbTabela 	= "";
	var $sUslov 	= "";
	var $sPolje 	= "";
	var $sSqlString = "";

	
	function listUpita ($f_tabela,$f_uslov, $f_polje)
	{
		
		$this->dbTabela = $f_tabela;	
		$this->sUslov	= $f_uslov;
		$this->sPolje	= $f_polje;		
	}

	function napraviUpit ()
	{	
		
		switch ($this->dbTabela)
		{
			case "kontakti":
				$sUslov=$this->sUslov;
				if ($sUslov==="")
				{$sUslov="";}
				else
				{
					$sPolje = $this->sPolje;
					if ($sPolje===""){$sPolje="fullname";}
					$sUslov = " Where $sPolje like '%".$sUslov."%' ";
				}

				$sSQL="select * from kontakti $sUslov ORDER BY id DESC";
				
				$this->sSqlString =$sSQL;
			break;
		}

		return $this->sSqlString;

	}
	

}
?>