<?php

include_once('Database.php');

class Equipe 
{
	static function getList()
	{
		$q = Database::query('Select * from Equipe e,Club c where e.ID_Club = c.ID');
		$r = '';
		
		while ($data = $q->fetch())
		{
		
			$r = $r . '<p> <h2> Equipe ' . $data['ID'] .':</h2>'
			.'<ul> <li>Categorie : ' . $data['Categorie'] . '</li>'
			.'<li>Club : ' . $data['Nom'] . ' (' . $data['Ville'] . ')</li>'
			.'</ul></p>';

		}

		$q->closeCursor();
		
		return $r;
	}
}

?>