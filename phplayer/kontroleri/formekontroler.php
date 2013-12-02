<!-- include style -->

<?php

/************************************************************/
/*
/*      KONTROLER ZA PRIKAZ SVIH FORMI
/*		ON SE NEMA POTREBE MIJENJATI, SVE PROMJENE TREBA 
/*		RADITI U listaFormi.php I formesqlkontroler.php
/*
/************************************************************/

//error_reporting (E_ALL ^ E_NOTICE); // iskljuci notice

include '../def/db_connect.php';
include '../def/definicije.php';
include '../forme/listaFormi.php';


//nazivi tabela su definirani u defnicije.php
$sTabela = "";
if (isset($_GET['tabela'] )) {
	$TT=$_GET['tabela'];	
	$sTabela = constant($TT);
}

// broj reda id
$sIdRed = "";
if (isset($_GET['RedId'] )) {
	$sIdRed = $_GET['RedId'];
}

// da li je dodavanje
$bEditAddDelete=0;
if (isset($_GET['bEditAddDelete'] )) {
	//echo "moduldodavanja " . $_GET['bEditAddDelete'] ."<br>";
	$bEditAddDelete = $_GET['bEditAddDelete'];
	if ($bEditAddDelete==0)
	{$bEditAddDelete=0;}
	else
	{$bEditAddDelete=1;}
}

if ($bEditAddDelete==0)
{$sql = "select * from $sTabela where id=$sIdRed";}
else
{$sql = "select * from $sTabela";}




try {
	// dovuci formu iz listaFormi.php
	$clsRes = new listaFormi ($conn, $sql, $sTabela, $bEditAddDelete);
	
	// prikazi formu
	echo "<div id='zona-formi' class='page-forme'>";			
			echo $forma = $clsRes->napraviFormu();
	echo "</div><br>";
	
}
catch(PDOException $exception)
{
	//echo "Error: " . $exception->getMessage();
	echo "Excepcija";
}
?>