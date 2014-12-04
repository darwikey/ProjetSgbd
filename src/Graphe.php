<?php
//type mime de l'image
header('Content-type: image/png');
include_once('Database.php');
//Init Database
Database::init();
	
$idJoueur = intval($_GET['joueur']);
$annee = intval($_GET['annee']);

$q1 = Database::query('Select Month(Date_Match) AS mois,
Sum(r.Points) as PointsMois,
Sum(r.Fautes) as FautesMois,
sum((Select sum(r1.Points)
	From Rencontrer r1
    Where r1.ID_Rencontre = r.ID_Rencontre
    and r1.ID_Equipe = r.ID_Equipe)
    >
    (Select sum(r1.Points)
	From Rencontrer r1
    Where r1.ID_Rencontre = r.ID_Rencontre)/2) as Gagne,
    
count(r.ID_Rencontre) as NombreMatch

From Joueur j, Rencontrer r, Rencontre a
Where j.ID_Membre =' . $idJoueur .
' and j.ID_Membre = r.ID_Membre
and r.ID_Rencontre = a.ID_Rencontre
And Year(Date_Match) =' . $annee . 
' Group by mois 
Order by mois ASC');

$max = 0;
$elements=array();

while($data = $q1->fetch())
{
	$perdu = $data['NombreMatch'] - $data['Gagne'];
	$max = max($max, $data['PointsMois'], $data['FautesMois'], $data['Gagne'], $perdu);
	
	$elements[$data['mois']] = array($data['PointsMois'], $data['FautesMois'], $data['Gagne'], $perdu);	
}
$q1->closeCursor();

//Mettre les mois en Francais dans un tableau
$moisFr=array('Janvier','Fevrier','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Decembre');



//Chemin vers le police à utiliser

//Adapter la largeur de l'image par rapport au nombre de ligne et nombre de mois
$largeur=1000;
$hauteur=400;
$absis=120;
$font_file = './arial.ttf';
$courbe=imagecreate($largeur, $hauteur);

//Les autre couleurs utils
$ligne=imagecolorallocate($courbe, 220, 220, 220);
$fond=imagecolorallocate($courbe, 250, 250, 250);
$noir=imagecolorallocate($courbe, 0, 0, 0);
$blanc=imagecolorallocate($courbe, 255, 255, 255);
$couleur = array(imagecolorallocate($courbe, 255, 0, 0), imagecolorallocate($courbe, 0, 0, 255), imagecolorallocate($courbe, 0, 255, 0), imagecolorallocate($courbe, 255, 0, 255));

//Colorer le fond
imagefilledrectangle($courbe,0 , 0, $largeur, $hauteur, $fond);
//Tracer l'abscisse et l'ordonnée
imageline($courbe, 50, $hauteur-$absis, $largeur-10,$hauteur-$absis, $noir);
imageline($courbe, 50,$hauteur-$absis,50,20, $noir);


$nbOrdonne=10;
//Calculer les échelles suivants les abscisses et ordonnées
$echelleX=($largeur-30)/12;
$echelleY=($hauteur-$absis-20)/$nbOrdonne;
$i=0;
$py=$max/$nbOrdonne;
$pasY=$absis;
//Tracer les grides
while($pasY<($hauteur-19))
{
	imagestring($courbe, 2,10 , $hauteur-$pasY-6, round($i), $noir);
	imageline($courbe, 50, $hauteur-$pasY+1, $largeur-20,$hauteur-$pasY+1, $ligne);
	$pasY+=$echelleY;
	$i+=$py;
}


$pasX=60;
for($mois = 0; $mois < 12; $mois++)
{
	//Ecrire le mois en Français en abscisse
	imagestring($courbe, 2, $pasX, $hauteur-$absis+32 , $moisFr[$mois], $noir);

	if (isset($elements[$mois]))
	{
		$idElement = 0;
		foreach ($elements[$mois] as $donnee)
		{
			//Calculer la hauteur de la rectangle
			$y=($hauteur) -($donnee * ($echelleY/$py))-$absis;

			//Dessiner le rectangle
			imagefilledrectangle($courbe, $pasX-10, $hauteur-$absis, $pasX+10, $y, $couleur[$idElement]);
			//Ecrire la valeur en verticale
			imagefttext($courbe, 10, 270, $pasX-3, $y+5, $blanc, $font_file, $donnee);
			
			$pasX += $echelleX / count($elements[$mois]);
			$idElement++;
		}
	}
	else
	{
		$pasX+=$echelleX;;
	}
}

//La legende
$legende = array('Points', 'Fautes', 'Matchs gagnees', 'Match perdus');
$pasX=50;
$Y=$hauteur-$absis+70;
$index = 0;
foreach ($legende as $libelle)
{	
	//Le nom du poduit avec sa couleur
	imagestring($courbe, 2, $pasX+25, $Y , $libelle, $couleur[$index]);
	//Un petit rectangle 
	imagefilledrectangle($courbe,$pasX , $Y, $pasX+20, $Y+12, $couleur[$index]);
	$pasX+=140;
	$index++;
}

imagepng($courbe);
imagedestroy($courbe);

?>
