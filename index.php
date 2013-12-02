<html>
<head>
<link rel="stylesheet" type="text/css" href="styles/style.css" />
<script type = "text/javascript" src = "js/sorttable.js"></script> 
</head>

<body style="">


<div class="zona-site-centar">
    <div class="zona-header">
      <h1>CRUD PHP AJAX MYSQL</h1>
    </div>
    <br>
    <div class="zona-body">
        <div id="zona-kontrola" >

              <div class="customZonaKontrola" style="padding:4px 5px" > 
              		<div  class='btnDodavanje customDugme'>Dodavanje</div>     
                      <img src="images/Search.png" width="19" height="19" align="texttop" >
                      <input type="text" id="SearchLS" style="font-size:12px;" />
              </div>

          
        </div>
        <!-- ################ zona prikaza ################################################################################### --> 	
        
        <div id='zona-prikaza'>	
              <div style=" min-width: 350px; min-height: 50px;">
                <div id='preloader' style="margin:auto; width:18%;" ><img src='images/preloader.gif' /></div>
            </div>   
	           
        </div>     
        
         <div id='operacijainfo' style="font-style:oblique; font:bold; color:#333333">
           <div align="center">Operacija je uspjesno izvrsena.</div>
         </div>
        <div class="formBox" id='zona-prikaza-edit'>    
        </div>
        <!-- ################################################################################################################# --> 	

    </div>
    
            

       	 
    <br>
    <div class="zona-footer"><h4>FOOTER</h4></div>
</div>

<script type = "text/javascript" src = "js/dragable-content.js"></script>

	
<strong></strong>

<script type = "text/javascript" src = "js/jquery-1.7.1.min.js"></script> 
<script type = "text/javascript" src = "js/jquery-1.9.1.min.js"></script> 

<script type = "text/javascript">

var cImeTbl='tabela1';
var cPublicBrojStrane=0;
//var stranicaForma ='phplayer/forme/addFormaTBL.php';
$(function() {
	$('#preloader').show();
	$('#operacijainfo').hide(); 
	//############### inicijalizacija prvog sitea ##########################################################################
	getdata( 1,"",cImeTbl);
	//######################################################################################################################	

});



//################ txtSerach keyup ##################################################################################### 		
var $txtSearch = document.getElementById("SearchLS")
$txtSearch.addEventListener("keyup", function(event) {					
					//funkcija();
					$('#preloader').show();
					var sUslov = $txtSearch.value;		
					getdata( 1,  sUslov , cImeTbl );
					
			}, true);
//######################################################################################################################



//################ btnEdit click ####################################################################################### 		
$(document).on('click', '.btnEdit', function(){ 	
	var red_id = $(this).closest('td').find('.IdRed').text();
	console.log(red_id);
	$('#preloader').show();
	getEditdata( red_id,  cImeTbl, 0 );	
});	
//######################################################################################################################				




//################ btnDodavanje click ################################################################################## 		
$(document).on('click', '.btnDodavanje', function(){ 	
	$('#preloader').show();
	getAdddata( cImeTbl, 1 );	
});	
//######################################################################################################################	




//################ btnDelete click ##################################################################################### 		
$(document).on('click', '.btnDelete', function() {
	if(confirm('Are you sure?')){
		colectCheckboxove(); //alert (strCheckovi);
		
		var red_id =  $(this).closest('td').find('.IdRed').text();
		if (strCheckovi.length > 0){red_id = strCheckovi; /*alert (strCheckovi);*/}
		var bEditAddDelete=2;
		$('#loaderImage').show();
		$.post('phplayer/kontroleri/formesqlkontroler.php?tabela='+ cImeTbl +'&bEditAddDelete=' + bEditAddDelete + '', { idskriveni: red_id })
			.done(function(data) {
					var sUslov = "";		
					getAdddata (cImeTbl, 1);
					getdata( 1,  sUslov , cImeTbl );
			});
		
	 }
	
});
//######################################################################################################################




//################ Close link forma #################################################################################### 		
$(document).on('click', '#close', function(){ 	
	$('#zona-prikaza-edit').fadeOut("fast");
});	
//######################################################################################################################



//################ UpdateForm submit ################################################################################### 		
$(document).on('submit', '#UpdateForm', function() {
	var red_id = document.getElementById("idskriveni").value;
	var bEditAddDelete=0;
	$('#loaderImage').show();
	$.post('phplayer/kontroleri/formesqlkontroler.php?tabela='+ cImeTbl +'&bEditAddDelete=' + bEditAddDelete + '', $('#UpdateForm').serialize())
		.done(function(data) {
			var sUslov = $txtSearch.value;	
			getdata( cPublicBrojStrane,sUslov,cImeTbl);
			operacijainfo();
		});

	return false;
	
});
//######################################################################################################################




//################### AddForm submit ################################################################################### 		
$(document).on('submit', '#AddForm', function() {
	
	var bEditAddDelete=1;
	$('#loaderImage').show();
	$.post('phplayer/kontroleri/formesqlkontroler.php?tabela='+ cImeTbl +'&bEditAddDelete=' + bEditAddDelete + '', $('#AddForm').serialize())
		.done(function(data) {
			var sUslov = "";	
			getdata( 1,  sUslov , cImeTbl );
			getAdddata (cImeTbl, 1);
			operacijainfo();
		});

	return false;
	
});
//######################################################################################################################


//####################### Fade in-out info funkcija ####################################################################
function operacijainfo()
{

$('#operacijainfo').fadeIn("fast");
setTimeout(function()
				{ 
					$('#operacijainfo').fadeOut("slow"); 
					},1500);
}
//######################################################################################################################

//####################### Kolektuj checkboxove #########################################################################
// ------------- verzija bez jQuery
var strCheckovi="";
function colectCheckboxove()
{
	strCheckovi="";
	
	/*     
	var cks = document.getElementsByTagName('input');
	for (i = 0; i < cks.length; i++)
	 {
	 	if(cks[i].type == 'checkbox') {
		  if (cks[i].checked){
			strCheckovi = strCheckovi + cks[i].value + ',';
			
		  }
		}
	 }
	strCheckovi = strCheckovi.substring (0, strCheckovi.length-1);
	*/
	  

// ---------- verzija sa jQuery

	strCheckovi = $('input:checked').map(function() {
		return this.value;
	}).get();

}
//#########################################################################################################################	




//####################### Pokazi Edit formu ############################################################################
function getEditdata (sRedId, sTabela, bEditAddDelete)
{
	var stranicaEditUrl = 'phplayer/kontroleri/formekontroler.php?tabela='+ sTabela +'&RedId='+ sRedId +'&bEditAddDelete='+ bEditAddDelete +'';
	setTimeout(function()
				{ prikaziEditzone (stranicaEditUrl);
					$('#preloader').hide(); 
					},500);
	
}
function prikaziEditzone (stranicaEditUrl)
{
	$('#zona-prikaza-edit').load(stranicaEditUrl);	
	$('#zona-prikaza-edit').fadeIn("fast");	

}
//#########################################################################################################################	



//####################### Pokazi Add formu ################################################################################
function getAdddata (sTabela, bEditAddDelete)
{  
	var stranicaEditUrl = 'phplayer/kontroleri/formekontroler.php?tabela='+ sTabela +'&bEditAddDelete='+ bEditAddDelete +'';
	setTimeout(function()
				{ prikaziAddzone (stranicaEditUrl);
					$('#preloader').hide(); 
					},500);				
	
}
function prikaziAddzone (stranicaEditUrl)
{
	$('#zona-prikaza-edit').load(stranicaEditUrl);		
	$('#zona-prikaza-edit').fadeIn("fast");

}
//#########################################################################################################################



//############################# pocetna procedura tabele ##################################################################
function getdata( nBrojstranice,  sUslov , sTabela){                     
	
	var stranicaURL = 'phplayer/kontroleri/tabelekontroler.php?tabela=' + sTabela + '&uslov=' + sUslov + '&page=' + nBrojstranice + '';   
    		 
	setTimeout(function()
				{ prikazizone (stranicaURL);
					$('#preloader').hide(); 
					tblsort ();		
					},500);
					
}     
function prikazizone (stranicaURL)
{
	$('#zona-prikaza').load(stranicaURL);		

}
//#########################################################################################################################



//############################# napravi tabelu sortabilnom  ###############################################################
function tblsort ()
{

	setTimeout (
		function ()
		{
			var newTableObject = document.getElementById('my-tbl');
			sorttable.makeSortable(newTableObject);
		},500
	);	

}
//#########################################################################################################################


//############################# load stranice iz paginacije ###############################################################
function ulodajStranu (nBrojStrane)
{// ovu poziva paginacija 
	
	$('#preloader').show();
	cPublicBrojStrane=nBrojStrane;
	getdata(nBrojStrane,"",cImeTbl, 1);
}
//#########################################################################################################################

</script>



</body>
</html>
