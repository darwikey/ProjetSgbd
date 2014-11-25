<!DOCTYPE html>
<html>
<head>
	<link type="text/css" rel="stylesheet" href="style.css" />
	<meta charset="utf-8" />
	<title>Basket manager</title>
</head>

<body>
<div id="conteneur">
<div id="top"><img src="img/top.png"></div><br>
<p class="menu_horz_1"> <a href="index.php?page=club">Clubs</a> | <a href="index.php?page=equipe">Équipes</a> | <a href="index.php?page=joueur">Joueurs</a>
 | <a href="index.php?page=match">Matchs</a> | <a href="index.php?page=statistique">Statistique</a> </p>

<?php 

include_once('Page.php');

main();

?>

</div>
</body>
</html>