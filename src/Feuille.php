<?php

include_once('Database.php');

class Feuille
{
  static function getFeuilleMatch($id_rencontre)
  {
    $r = '<ul>';
		
    $q1 = Database::query('
		Select c.Nom as Nom_Club, e.Categorie, m.Nom, m.Prenom, r0.Points, r0.Fautes, 

		r0.Points = (Select max(Points) 
			From Rencontrer r
			Where r.ID_Rencontre = r0.ID_Rencontre
			and r.ID_Equipe = r0.ID_Equipe
			) as MeilleurJoueur,

		r0.Fautes = (Select max(Fautes) 
			From Rencontrer r
			Where r.ID_Rencontre = r0.ID_Rencontre
			and r.ID_Equipe = r0.ID_Equipe
			) as PireJoueur 
								
		From (
              (
               (
                (Rencontrer r0 inner join Equipe e
                 On e.ID_Equipe = r0.ID_Equipe) 
                inner join Club c            
                On e.ID_Club = c.ID_Club) 
               inner join Membre m
               On r0.ID_Membre = m.ID_Membre) 
              inner join Joueur j
              On m.ID_Membre = j.ID_Membre)

		Where r0.ID_Rencontre = ' . $id_rencontre . '

		Order by Nom_Club, Points DESC, Fautes ASC');
		
	$nom_club = "";
		
	// Pour chaque joueur de la rencontre
	while ($data1 = $q1->fetch())
	{
		// On affiche le nom du club pour chaque club
		if ($nom_club != $data1['Nom_Club'])
		{
			$nom_club = $data1['Nom_Club'];
			$r = $r . '</ul><h2>Club ' . $nom_club . ' (équipe ' . $data1['Categorie'] . ')</h2><ul>';
		}
		
		$r2 = $data1['Nom'] . ' ' . $data1['Prenom']
		. ' - Point : ' . $data1['Points'] 
		. ' - Fautes : ' . $data1['Fautes'];
		
		if ($data1['PireJoueur'])
		{
			$r2 = '<font color="red"> ' . $r2 . '</font>';	
		}
		else if ($data1['MeilleurJoueur'])
		{
			$r2 = '<font color="green"> ' . $r2 . '</font>';	
		}
		
		$r = $r . '<li>' . $r2 . '</li>';
	}
	
    return $r;
  }
}