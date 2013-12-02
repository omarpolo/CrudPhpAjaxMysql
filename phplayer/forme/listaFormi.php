<?php
/************************************************************/
/*
/*      KLASA ZA PRIKAZ I KREACIJU SVIH FORMI
/*		SQL SE IZVRSAVA U formesqlkontroler.php
/*		OVDE KOPIRAJ BLOKOVE U SWITCHU I MIJENJAJ
/*
/************************************************************/

include 'listaLookUp.php';

class listaFormi
{
	var $query ="";
	var $dbTabela = "";
	var $bEditAddDelete= 0;
	var $sForma   = "";
	var $con="";
	var $sqlLookUp="";
	var $sLookUpTabela="";
	
	function listaFormi ($f_conn, $f_sql, $f_tabela, $f_bEditAddDelete)
	{
		
		$this->dbTabela 			= $f_tabela;	
		$this->query    			= $f_sql;
		$this->con      			= $f_conn;
		$this->bEditAddDelete		= $f_bEditAddDelete;
	}

	
	function napraviFormu ()
	{
		
		/*echo "Vrijednost je : " . $this->bEditAddDelete. " (Edit-0, Add-1, Delete-2) <br>";*/

		
	
			$stmt = $this->con->prepare($this->query);	
		
			if($stmt->execute()){
	
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
			
		
				switch ($this->dbTabela)
					{
					case "kontakti":

						$aktivan=0;
						if ($this->bEditAddDelete==0)
						{						
							
							$id = $row['id'];
							$fullname = $row['fullname'];
							$email = $row['email'];
							$username = $row['username'];
							$password = $row['password'];
							$city=$row['opstina'];
							$aktivan=$row['aktivan'];
							
						}
						if ($this->bEditAddDelete==1)
						{
							$city="";						
						}						
						
						// ------------- kreiraj LookUp opstine ------------------------------------------
						$this->sLookUpTabela="opstine";
						$this->sqlLookUp="select sifra, naziv from $this->sLookUpTabela";						
						$clsLookUp = new listaLookUp ($this->con, $this->sqlLookUp, $this->sLookUpTabela, $city);
						$sLookUpForma = $clsLookUp->napraviLookUp();
						//---------------------------------------------------------------------------------
						
						// ---------------- EDIT  - ADD forma ----------------------------------								
						
						if ($this->bEditAddDelete==0)
						{
							$this->sForma = "<form id='UpdateForm' action='#' method='post' border='0'>";						
						}
						else
						{
							$this->sForma = "<form id='AddForm' action='#' method='post' border='0'>";
						}
						
						$this->sForma = $this->sForma. "<table>";
						$this->sForma = $this->sForma. "<tr>";
						$this->sForma = $this->sForma. "<td>Full name</td>";
						
						if ($this->bEditAddDelete==0)
						{						
							$this->sForma = $this->sForma. "<td><input type='text' name='fullname' value='".$fullname."' required /></td>";
						}
						else
						{
							$this->sForma = $this->sForma. "<td><input type='text' name='fullname' required /></td>";					
						}
	
						$this->sForma = $this->sForma. "</tr>";
						$this->sForma = $this->sForma. "<tr>";
						$this->sForma = $this->sForma. "<td>Email</td>";
							
						if ($this->bEditAddDelete==0)
						{							
							$this->sForma = $this->sForma. "<td><input type='text' name='email' value='".$email."' required /></td>";
						}
						else
						{
							$this->sForma = $this->sForma. "<td><input type='text' name='email' required /></td>";					
						}
	
						$this->sForma = $this->sForma. "</tr>";
						$this->sForma = $this->sForma. "<tr>";
						$this->sForma = $this->sForma. "<td>Username</td>";
	
						if ($this->bEditAddDelete==0)
						{							
							$this->sForma = $this->sForma. "<td><input type='text' name='username' value='".$username."' required /></td>";
						}
						else
						{
							$this->sForma = $this->sForma. "<td><input type='text' name='username' required /></td>";					
						}
	
						$this->sForma = $this->sForma. "</tr>";
						$this->sForma = $this->sForma. "<tr>";
						$this->sForma = $this->sForma. "<td>Password</td>";
	
						if ($this->bEditAddDelete==0)
						{							
							$this->sForma = $this->sForma. "<td><input type='password' name='password' value='".$password."' required /></td>";
						}
						else
						{
							$this->sForma = $this->sForma. "<td><input type='password' name='password' required /></td>";					
						}
						$this->sForma = $this->sForma. "</tr>";
						$this->sForma = $this->sForma. "<tr>";	
						$this->sForma = $this->sForma. "<td>City</td>";
						$this->sForma = $this->sForma. "<td>".$sLookUpForma."</td>";
						$this->sForma = $this->sForma. "</tr>";

	
						$this->sForma = $this->sForma. "<tr>";				
						
						$this->sForma = $this->sForma. "<td></td>";
						$bOptAktivan ="";
						
						$bOptAktivan =				  "<input name='aktivan' type='radio' value='1' >Aktivan";						
						$bOptAktivan = $bOptAktivan . "<input name='aktivan' type='radio' value='0' checked='checked'>Neaktivan";						

						if ($aktivan==1)
						{
							$bOptAktivan =				  "<input name='aktivan' type='radio' value='1' checked='checked'>Aktivan";
							$bOptAktivan = $bOptAktivan . "<input name='aktivan' type='radio' value='0' >Neaktivan";
						}

						$this->sForma = $this->sForma. "<td>". $bOptAktivan ."</td>";
						$this->sForma = $this->sForma. "</tr>";
						
						$this->sForma = $this->sForma. "<tr >";	
						$this->sForma = $this->sForma. "<td>";  
						if ($this->bEditAddDelete==0)
						{						
							$this->sForma = $this->sForma. "<input type='hidden' id='idskriveni' name='idskriveni' value='" . $id . "' />";              
						}
						
						$this->sForma = $this->sForma. "<input type='submit' value='Update' class='customDugme'  />";
						$this->sForma = $this->sForma. "</td>";
						/*$this->sForma = $this->sForma. "<td><div class='customDugme' align='right'><a href='#' id='close'>Close</a></div></td>";*/
						$this->sForma = $this->sForma. "<td><input type='button' class='customDugme' id='close' value='Close'></td>";
						$this->sForma = $this->sForma. "</tr>";
						$this->sForma = $this->sForma. "</table>";
						$this->sForma = $this->sForma. "</form>";	
												
					break;
				}

			
			}
			else
			{
				echo "Greska sql-a u listi formi.";
			}
			
		

		return $this->sForma;
			
	}
}
?>