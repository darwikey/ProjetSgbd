<!DOCTYPE html>
<html>
<head>
	<link type="text/css" rel="stylesheet" href="style.css" />
	<meta charset="utf-8" />
	<title>Basket manager</title>
</head>

<body>
<div id="conteneur">
<div id="top" style="text-align: center"><a href="index.php"><img src="img/top.png"></a></div><br>
<div style="text-align: center"><p class="menu_horz_1">
<a href="index.php?page=club">Clubs</a> | <a href="index.php?page=equipe">Équipes</a> | <a href="index.php?page=joueur">Joueurs</a>
 | <a href="index.php?page=match">Matchs</a> | <a href="index.php?page=statistique">Statistiques</a> | <a href="index.php?page=ajouter">Ajouter</a> 
 </p></div>

<?php 

include_once('Page.php');

main();

?>

</div>
</body>
</html>