<?php
//error_reporting (E_ALL ^ E_NOTICE); // iskljuci notice
/*#####################################################################################################################################*/
define("tabela1", "kontakti");	



/*#####################################################################################################################################*/
/*#############################################               FUNKCIJE                  ###############################################*/
/*#####################################################################################################################################*/
		
		
function RetFieldValue ($cTip, $mKon, $cTblName, $cFieldName, $cFilter)
{
	// poziv: $NazivOpstine=RetFieldValue ('string', $this->con, 'opstine', 'naziv', 'sifra='.$this->sOpstina.'');
	$retPolje="";
	$strComm = "select " . $cFieldName . " from " . $cTblName . " where " . $cFilter . "";
	echo $strComm ;
	$rs = $mKon->prepare($strComm);
	if($rs->execute())
	{
		
		$total_rows = $rs->rowCount();
		if ($total_rows != 0)
		{
			$row = $rs->fetch(PDO::FETCH_NUM);
			$retPolje = $row[0];
			
		}
		else
		{
			switch ($cTip)
			{
				case "int":
					$retPolje =0;
				break;
				
				case "string":
					$retPolje = "nema trazene vrijednosti";
				break;
				
				case "double":
					$retPolje =0;
				break;
			}
		
		}
	}
	else
	{
		echo "Greska sql-a u povratnoj funkciji.";
	}
	
	return $retPolje;
}		
		
?>