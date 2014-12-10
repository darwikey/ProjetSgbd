<?php

include_once('Database.php');


class Club 
{
	static function getList()
	{
		$q1 = Database::query('Select c.Nom, c.Ville, c.ID_Club,
				(Select count(*) 
				From Equipe e
				Where c.ID_Club = e.ID_Club) as NombreEquipe,
				(Select count(*) 
				From Joueur j, Membre m
				Where c.ID_Club = m.ID_Club
				and m.ID_Membre = j.ID_Membre) as NombreJoueur
			From Club c');
		$r = '';
		
		while ($data1 = $q1->fetch())
		{
		
			$r = $r . '<p> <h2> Club ' . $data1['Nom'] .':</h2><ul>'
			.'<li>Ville : ' . $data1['Ville'] . '</li>';
			
			// recherche des responsables
			$r = $r . '<li>Reponsables : ' . Club::getResponsables($data1['ID_Club']) . '</li>';
			
			$r = $r . '<li>Nombre d\'équipes : ' . $data1['NombreEquipe'] . '</li>'
			. '<li>Nombre de joueur : ' . $data1['NombreJoueur'] . '</li>';
			
			$r = $r . '</ul></p>';
		}

		$q1->closeCursor();
		
		return $r;
	}
	
	static function getResponsables($idClub)
	{
		$r = '<ul>';
		$q = Database::query('Select * From Membre m, Responsable r Where m.ID_Club = ' . $idClub . ' and m.ID_Membre = r.ID_Membre');

		while ($data = $q->fetch())
		{
			$r = $r . '<li>' . $data['Activite'] .' : ' . $data['Nom'] . '  ' . $data['Prenom'] . '  (prise de fonction : ' . $data['Date_Entree'] . ')</li>';
		}
		$q->closeCursor();
		
		return $r . '</ul>';
	}
}

?>