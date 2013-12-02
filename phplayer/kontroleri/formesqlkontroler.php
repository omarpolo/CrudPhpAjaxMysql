<?php

/************************************************************/
/*
/*      FAJL ZA IZVRSENJE SVIH SQL NAREDBI SVIH FORMI
/*		OVDE KOPIRAJ BLOKOVE U SWITCHU I MIJENJAJ
/*		
/*
/************************************************************/

include '../def/db_connect.php';
include '../def/definicije.php';


//$sTabela = $_GET['tabela'];
$bEditAddDelete    = $_GET['bEditAddDelete'];

	
$sTabela = "";
if (isset($_GET['tabela'] )) {
	$TT=$_GET['tabela'];	
	$sTabela = constant($TT);
}


switch ($sTabela)
{
	case "kontakti":
		try{
				$query="";
				switch ($bEditAddDelete)
				{
					case 0:
							$query = "update 
									kontakti 
								set 
									username = :username, 
									fullname = :fullname, 
									email = :email, 
									password = :password,
									opstina = :opstina,
									aktivan = :aktivan
								where
									id = :id";
							break;
					case 1:
							$query = "insert into 
								kontakti 
									(username,fullname,email,password,opstina,aktivan)
								values
									(:username,:fullname,:email,:password,:opstina,:aktivan)
									";
							break;
					case 2:
							$query = "delete from 
								kontakti 
									where id in (".$_POST['idskriveni'].")";
							break;
					
				}
		
				$stmt = $conn->prepare($query);
				
				if ($bEditAddDelete !=2)
				{			
					$stmt->bindParam(':username', $_POST['username']);
					$stmt->bindParam(':fullname', $_POST['fullname']);
					$stmt->bindParam(':email', $_POST['email']);
					$stmt->bindParam(':password', $_POST['password']);
					$stmt->bindParam(':opstina',  $_POST['cmbOpstine']);
					$stmt->bindParam(':aktivan',  $_POST['aktivan']);					
				}				
				if ($bEditAddDelete != 1)
				{
					$stmt->bindParam(':id', $_POST['idskriveni']);
				}

				if($stmt->execute()){
					echo "User was updated.";
				}else{
					echo "Unable to update user.";
				}
			/*####################################################*/		
			/*
			- isporbaj preko browsera ali sve promjeni u $_GET
			http://localhost/bicom/webjs/kontaktAjaxPhp/phplayer/kontroleri/formesqlkontroler.php?tabela=tabela1&idskriveni=4&bAdd=0
			&username=okokok&fullname=okokok&email=okoko&passwor=okokok
			*/
		
		}

		catch(PDOException $exception){
			echo "Error: " . $exception->getMessage();
		}
	break;
}
?>