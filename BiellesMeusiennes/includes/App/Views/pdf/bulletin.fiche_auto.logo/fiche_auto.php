<?php
header('Content-type: text/html; charset=utf-8');
?>

<body style="width:793px;height:1122px; margin:auto; border:1px rgb(0, 127, 255) solid; font-size:50px; color: rgb(85, 114, 182); font-family:ar julian;">

	<div class="logo">
	<!--Je n'es pas trouver le logo-->
		<center><img style="margin:auto; width:60%; height:25%; margin-top:30px;" src="logo_retro_meuse.png"/></center>
	</div>
	
		<div class="fiche" style="margin-left:25px; line-height:100px;">
		
			<div class="marque">
				<p><b>Marque:</b>   <? $data['marque'];?>   </p>
			</div>
			
			<div class="modele">
				<p><b>Modèle:</b>  <? $data['model'];?>    </p>
			</div>
			
			<div class="type">
				<p><b>Type:</b>  <? $data['type'];?>    </p>
			</div>
			
			<div class="annee">
				<p><b>Année:</b>   <? $data['date_circu'];?>   </p>
			</div>
			
			<div class="club">
				<p><b>Club:</b>   <? $data['club'];?>   </p>
			</div>
			
		</div>



</body>