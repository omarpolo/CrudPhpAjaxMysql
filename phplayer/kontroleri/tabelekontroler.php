<!-- include style -->

<?php

/************************************************************/
/*
/*      KONTROLER ZA PRIKAZ SVIH JEDNOSTAVNIH TABELA
/*		ON SE NEMA POTREBE MIJENJATI, SVE PROMJENE TREBA 
/*		RADITI U listaTabela.php I tabelesqlkontroler.php
/*
/************************************************************/


//error_reporting (E_ALL ^ E_NOTICE); // iskljuci notice

include '../def/db_connect.php';
include '../def/definicije.php';
include 'paginacijaTabele.php';
include 'tabelesqlkontroler.php';
include '../forme/listaTabela.php';


// nazivi tabela su definirani u defnicije.php
$sTabela = "";
if (isset($_GET['tabela'] )) {
	$TT=$_GET['tabela'];	
	$sTabela = constant($TT);
}


$sPolje="";

// vrijednost iz txtSearcha
$uslov="";
if (isset($_GET['uslov'])) {
		$uslov = $_GET['uslov'];

}


// formiranje sqlupita u tabelesqlkontroler.php
$kreiranje = new listUpita ($sTabela,$uslov, $sPolje);
$sql=$kreiranje->napraviUpit();




try {
	// paginacija u paginacijaTabele.php
	$pager = new Paginacija_Stranica( $conn, $sql, 3, 4, null, $sTabela, $uslov );
	
	$rs = $pager->Paginacija(); 
	
	$brojredova =0;
	if (!empty($rs))
	{
		$brojredova = $rs->rowCount();
	}
	else
	{
		echo "";
	}
	
	if($brojredova >= 1 ){     
		//ovde ide display tabela iz listaTabela.php
		echo "<div id='zona-tabele' style=' min-width: 350px; min-height: 150px;'>";
			$clsTabela= new listaTabela ($rs, $sTabela);		
			echo $sTabela = $clsTabela -> napraviTabelu();
		echo "</div>";
		
		// prikazi paginaciju
		echo "<div id='zona-navigacije' class='page-nav'>";			
			echo $pager->prikaziNavigaciju();
		echo "</div><br>";
		
	}else{
	
		echo "No records found!";
	}


	
}
catch(PDOException $exception)
{
	//echo "Error: " . $exception->getMessage();
	echo "Excepcija";
}
?>