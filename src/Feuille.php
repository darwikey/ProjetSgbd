<?php

include_once('Database.php');

class Feuille
{
  static function getFeuilleMatch($id_rencontre)
  {
    $r = '<ul>';
		
    $q1 = Database::query('
		Select c.Nom as Nom_Club,
		e0.Categorie,
		m.Nom,
		m.Prenom,
		r0.Points,
		r0.Fautes, 
		r0.Points = (Select max(Points) 
			From Rencontrer r
			Where r.ID_Rencontre = r0.ID_Rencontre
			and ID_Equipe = r0.ID_Equipe
			) as MeilleurJoueur,
		r0.Fautes = (Select max(Fautes) 
			From Rencontrer r
			Where r.ID_Rencontre = r0.ID_Rencontre
			and ID_Equipe = r0.ID_Equipe
			) as PireJoueur 
								

		From Rencontrer r0, Equipe e0, Club c, Membre m, Joueur j
		Where ID_Rencontre = ' . $id_rencontre . '
		and e0.ID_Equipe = r0.ID_Equipe
		and e0.ID_Club = c.ID_Club
		and r0.ID_Membre = m.ID_Membre
		and m.ID_Membre = j.ID_Membre

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