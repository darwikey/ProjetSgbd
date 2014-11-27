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
	
	static function getMoreInfoMatch($idRencontre)
	{
		$r = '';
		
		$q1 = Database::query('Select Distinct r.ID_Equipe, c.Nom, e.Categorie
		From Rencontrer r, Equipe e, Club c
		Where ID_Rencontre = ' .  $idRencontre
		. ' and e.ID_Equipe = r.ID_Equipe
		and e.ID_Club = c.ID_Club');
		
		while ($data1 = $q1->fetch())
		{
			$r = $r . '<h2>Club ' . $data1['Nom'] . ' (équipe ' . $data1['Categorie'] . ')</h2><ul>';
		
			$q2 = Database::query('Select m.Nom, m.Prenom, r.Points, r.Fautes, 
			r.Points = (Select max(Points) 
						From Rencontrer
						Where ID_Rencontre = ' .  $idRencontre
						. ' and ID_Equipe = ' . $data1['ID_Equipe'] 
						. ') as MeilleurJoueur,
			r.Fautes = (Select max(Fautes) 
						From Rencontrer
						Where ID_Rencontre = ' .  $idRencontre
						. ' and ID_Equipe = ' . $data1['ID_Equipe']
						. ') as PireJoueur 
			From Rencontrer r, Membre m, Joueur j
			Where r.ID_Rencontre = ' .  $idRencontre
			. ' and r.ID_Equipe = ' . $data1['ID_Equipe']
			. ' and r.ID_Membre = m.ID_Membre
			and m.ID_Membre = j.ID_Membre
			Order by r.Points DESC, r.Fautes');
			
			
			while ($data2 = $q2->fetch())
			{
				$r2 = $data2['Nom'] . ' ' . $data2['Prenom']
				. ' - Point : ' . $data2['Points'] 
				. ' - Fautes : ' . $data2['Fautes'];
			
				if ($data2['PireJoueur'])
				{
					$r2 = '<font color="red"> ' . $r2 . '</font>';	
				}
				else if ($data2['MeilleurJoueur'])
				{
					$r2 = '<font color="green"> ' . $r2 . '</font>';	
				}
			
				$r = $r . '<li>' . $r2 . '</li>';
			}
			
			$r = $r . '</ul>';
		}
		
		return $r;
	}
}

?>