<?php

include_once('Database.php');


class Match 
{
	static function getList()
	{
		$q = Database::query('Select * From Rencontre');
		$r = '';
		
		while ($data = $q->fetch())
		{
		
			$r = $r . '<p> <h2> Match ' . $data['ID_Rencontre'] .':</h2><ul>'
			. '<li>Date : ' . $data['Date_match'] . '</li>'
			. Match::getInfoMatch($data['ID_Rencontre'])
			. '</ul></p>';

		}

		$q->closeCursor();
		
		return $r;
	}
	
	static function getInfoMatch($idRencontre)
	{
		$r = '';
		$q = Database::query('Select c.Nom, e.Categorie, sum(r.Points) as SumPoints, sum(r.Fautes) as SumFautes 
		From Rencontrer r, Equipe e, Club c
		Where ID_Rencontre = ' .  $idRencontre
		. ' and e.ID_Equipe = r.ID_Equipe
		and e.ID_Club = c.ID_Club
		Group by e.ID_Equipe
		Order by SumPoints DESC');
		
		$win = true;
		$score = 0;
		while ($data = $q->fetch())
		{
			$r = $r . '<li>Club ' . $data['Nom'] . ' (équipe ' . $data['Categorie'] 
			. ') - Score : ' . $data['SumPoints'] 
			. ' - Fautes : ' . $data['SumFautes'] . '</li>';
			
			// On formate le texte en gras pour l'équipe gagnante ou ex aequo
			if ($win OR ($score == $data['SumPoints']))
			{
				$r = '<b>' . $r . '</b>';
			}
			$win = false;
			$score = $data['SumPoints'];
		}
		
		return $r;
	}
}

?>