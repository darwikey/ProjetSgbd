<?php

include_once('Database.php');


class Club 
{
	static function getList()
	{
		$q1 = Database::query('Select * From Club');
		$r = '';
		
		while ($data1 = $q1->fetch())
		{
		
			$r = $r . '<p> <h2> Club ' . $data1['Nom'] .':</h2><ul>'
			.'<li>Ville : ' . $data1['Ville'] . '</li>';
			
			// recherche des responsables
			$r = $r . '<li>Reponsables : ' . Club::getResponsables($data1['ID_Club']) . '</li>';
			
			$r = $r . '<li>Nomre d\'équipes : ' . Club::getNombreEquipes($data1['ID_Club']) . '</li>';
			
			$r = $r . '</ul></p>';
		}

		$q1->closeCursor();
		
		return $r;
	}
	
	static function getResponsables($idClub)
	{
		$r = '<ul>';
		$q = Database::query('Select * From Membre m, Responsable r Where r.ID_Club = ' . $idClub . ' and m.ID_Membre = r.ID_Membre');

		while ($data = $q->fetch())
		{
			$r = $r . '<li>' . $data['Role'] .' : ' . $data['Nom'] . '  ' . $data['Prenom'] . '  (prise de fonction : ' . $data['Date_Entree'] . ')</li>';
		}
		$q->closeCursor();
		
		return $r . '</ul>';
	}
	
	static function getNombreEquipes($idClub)
	{
		return Database::query('Select count(*) From Equipe Where ID_Club = ' . $idClub)->fetchColumn();;
	}
	
	static function getNombreMatchsGagnes($idClub)
	{
		$r = '';
		//TODO
		$q = Database::query('Select * From Membre m, Responsable r Where r.ID_Club = ' . $idClub);

		
		$q->closeCursor();
		
		return $r;
	}
}

?>