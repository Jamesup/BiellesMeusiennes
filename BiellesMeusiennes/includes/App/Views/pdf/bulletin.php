<?php
header('Content-type: text/html; charset=utf-8');
?>
		
<body style="width:90%; height:700px; margin:auto; border:1px rgb(0, 127, 255) solid; font-size:14px; font-family:open sans, sans-serif;">

<center><img style=" width:20%; height:14%; margin-top:30px; margin-left:25px; margin-top:5px;" src="logo_retro_meuse2.png"/></center>
	<center><h1 style="color: rgb(53, 122, 183);"><b>Bulletin pour retirer votre plaque de rallye</b></h1>
		<h2 style="color: rgb(53, 122, 183);"><b>A DEPOSER A L'ACCUEIL, MERCI</b></h2></center>
	  
		

           <div class="bulletin" style="margin-right:5%;margin-left:5%;">		
				 
							<!--IDENTITE-->		
	
			<div class="identite">				
				
				<div class="prenom"style="float:left;width:45%;">
					<p><b>Prénom:</b> <? $data['lastname'];?> </p>
				</div>

				<div class="nom"style="float:left;width:45%;">
					<p><b>Nom:</b> <? $data['firstname'];?> </p>
				</div>
			</div>				
			
							<!--VILLE-->	
			
			<div class="ville">
				<div class="postal" style="float:left;width:35%;">
					<p><b>Code postal:</b>  <? $data['cp'];?> </p>
				</div>
			
				<div class="ville"style="float:left;width:55%;">
					<p><b>Ville:</b> <? $data['city'];?> </p>
				</div>
			</div>
							<!--PAYS-->		
	
				<div class="pays" style="float:left;width:90%;">
					<p><b>Pays:</b> <? $data['country'];?></p>
				</div>
				</br>
						<!--NEWSLETTER-->
						
				<div class="newsletter" style="margin-left:5%; font-size:14px;">
					<div class="email" style="float:left;width:90%;">
						<p>Recevez-vous nos emails d'informations sur nos activités?  <input type="checkbox"style="margin-left:10%"> OUI</input>  <input type="checkbox"> NON</input> </p>
					</div>
				
					<div class="message"style="float:left;width:90%;">
						<p>Si NON, souhaitez-vous recevoir nos messages? <input type="checkbox"style="margin-left:17%"> OUI</input>  <input type="checkbox"> NON</input> </p>
					</div>
				</div>
				
						<!--MAIL-->
				<div class="mail" style="float:left; width:90%;">
					<p><b>Mail:</b> <? $data['email'];?>  </p>
				</div>	
				
						<!--CLUB-->
				<div class="club" style="float:left; width:90%;">
					<p><b>Je suis membre du club:</b><? $data['club'];?>  </p>
				</div>
				<div class="mailclub" style="float:left; width:90%;">
					<p><b>Son adresse email:</b> _____________@___________     </p>
				</div>
				
						<!--VEHICULE-->
				<div class="vehicule" style="float:left; width:90%;">
					<p><b>Mon vehicule:</b>   <input type="checkbox"style="margin-left:15%"> Auto</input>  <input type="checkbox"> Moto</input> <input type="checkbox"style=""> Utilitaire</input>  <input type="checkbox"> Militaire</input></p>
				</div>
				<div class="marque" style="float:left; width:90%;">
					<p style="float:left; width:15%;"><b>Marque: <? $data['marque'];?></b>   </p> <p style="float:left; width:15%;"><b>Modèle: <? $data['model'];?></b>   </p> <p style="float:left; width:15%;"><b>Type: <? $data['type'];?></b>   </p> <p style="float:left; width:15%;"><b>Année: <? $data['date_circu'];?></b>   </p>  <p style="float:left; width:15%;"><b>Immatriculation: <? $data['immat'];?></b>   </p> 
				</div>
			
        </div> 
       
</body>