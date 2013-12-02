<html>
<head></head>
<body>

<div id="zona"></div>
<script type = "text/javascript" src = "js/jquery-1.7.1.min.js"></script> 
<script type = "text/javascript">
$(function() {
	
	opa();
	
	//getdata( 1,'','Kontakti' );
});

/*function getdata( nBrojstranice, sUslov , sTabela ){                     
	
	 alert (" stranica " + nBrojstranice +" uslov "+ sUslov  +" tabela "+ sTabela );
	 var stranicaURL = '/phplayer/rezultat.php?imetabele='+ sTabela +'&uslov=' + sUslov + '&page=' + nBrojstranice + '';   
  
	 
	$('#ZonaPrikazivanja').html('<p><img src="images/preloader.gif" /></p>');      
	$('#ZonaPrikazivanja').load( stranicaURL ).hide().fadeIn('slow');

}  */   

function opa()
{
//alert ("halio");
	//var stranicaURL = 'proba.php';   
	 
	//$('#ZonaPrikazivanja').html('<p><img src="images/preloader.gif" /></p>');      
	//$('#ZonaPrikazivanja').load( stranicaURL ).hide().fadeIn('slow');
	//$('#ZonaPrikazivanja').load( stranicaURL )
	document.getElementById("zona").innerHTML ="mamu li ti jebem";
	//$("#ZonaPrikazivanja").innerHTML ="pa jebiga";
} 
</script>





</body>
</html>
