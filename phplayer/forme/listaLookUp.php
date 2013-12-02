<?php
/************************************************************/
/*
/*      KLASA ZA PRIKAZ I KREACIJU SVIH LOOKUPOVA
/*		SQL SE IZVRSAVA U formesqlkontroler.php
/*		OVDE KOPIRAJ BLOKOVE U SWITCHU I MIJENJAJ
/*
/************************************************************/


class listaLookUp
{
	var $query ="";
	var $dbTabela = "";
	var $sLookUp   = "";
	var $sOpstina ="";
	var $con="";
	
	function listaLookUp ($f_conn, $f_sql, $f_tabela, $f_opstina)
	{
		
		$this->dbTabela 			= $f_tabela;	
		$this->query    			= $f_sql;
		$this->con      			= $f_conn;
		$this->sOpstina				= $f_opstina;
		
	}

	
	function napraviLookUp ()
	{
	
	
			$rs = $this->con->prepare($this->query);	
		
			if($rs->execute())
			{
	
				switch ($this->dbTabela)
				{
					case "opstine":
						$this->sLookUp =        			"<select  id='cmbOpstine1' name='cmbOpstine'>";
						
						while ($row = $rs->fetch(PDO::FETCH_NUM))// fetch(PDO::FETCH_ASSOC);$row['sifra'],$row['naziv']
						{
							if ($this->sOpstina==$row[0])
							{
								$this->sLookUp = $this->sLookUp. "<option value='{$row[0]}'  selected='selected'>{$row[1]}</option>";
							}
							else
							{
								$this->sLookUp = $this->sLookUp. "<option  value='{$row[0]}'>{$row[1]}</option>";
							}
						}
						$this->sLookUp = $this->sLookUp.     "</select>";				

					break;
				}

			
			}
			else
			{
				echo "Greska sql-a u listi formi.";
			}
			
		

			return $this->sLookUp;
			
	}
}
?>