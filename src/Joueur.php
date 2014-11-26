<?php

include_once('Database.php');


class Joueur
{
	static function getList()
	{
		$q = Database::query('Select * from Membre m, Joueur j where m.ID_Membre = j.ID_Membre');
		$r = '';
		
		while ($data = $q->fetch())
		{
		
			$r = $r . '<p> <h2> Joueur ' . $data['ID_Membre'] .':</h2><ul>'
			.'<li>Numéro de licence : ' . $data['Num_Licence'] . '</li>'
			.'<li>Date d\'entrée dans le club : ' . $data['Date_Entree'] . '</li>'
			.'<li>Nom : ' . $data['Nom'] . '</li>'
			.'<li>Prénom : ' . $data['Prenom'] . '</li>'
			.'<li>Adresse : ' . $data['Adresse'] . '</li>'
			.'<li>Date de naissance : ' . $data['Date_Naissance'] . '</li>'
			. '</ul></p>';

		}

		$q->closeCursor();
		
		return $r;
	}
}

?>