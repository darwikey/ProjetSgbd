<?php

include_once('Database.php');

class Statistique
{
	static function getPage()
	{
		$r = '<form action="index.php?page=statistique" method="post">
		<p>Afficher : 
		<select name="choix">
		<option value="matchs">matchs</option>
		<option value="feuille_matchs">feuille de matchs</option>
		<option value="joueurs_inscrits">joueurs inscrits</option>
		<option value="equipes_inscrites">équipes inscrites</option>
		</select>
		
		à la date (AAAA-MM-JJ) : 
		<input type="text" name="date" />
		<input type="submit" value="Rechercher" />
		</p></form>';
		
		
		if(isset($_POST['choix']))
		{
			$date = $_POST['date'];
			
			if ($_POST['choix'] == 'matchs')
			{
				$r = $r . Statistique::getMatchs($date);
			}
			else if ($_POST['choix'] == 'feuille_matchs')
			{
				$r = $r . Statistique::getFeuilleMatchs($date);
			}
			else if ($_POST['choix'] == 'joueurs_inscrits')
			{
				$r = $r . Statistique::getJoueursInscrits($date);
			}
			else if ($_POST['choix'] == 'equipes_inscrites')
			{
				$r = $r . Statistique::getEquipesInscrites($date);
			}
		}
		
		return $r;
	}


	static function getMatchs($date)
	{
		$r = '';
		$q = Database::query('Select ID_Rencontre From Rencontre Where Date_Match = \'' . $date . '\'');
		
		
		while ($data = $q->fetch())
		{
			$r = $r . '<h1>Rencontre ' . $data['ID_Rencontre'] . ' : </h1><p>' 
			. Match::getInfoMatch($data['ID_Rencontre']) . '</p>';
		}
		
		return $r;
	}
	
	
	static function getFeuilleMatchs($date)
	{
		$r = '';
		$q = Database::query('Select ID_Rencontre From Rencontre Where Date_Match = \'' . $date . '\'');
		
		
		while ($data = $q->fetch())
		{
			$r = $r . '<h1>Rencontre ' . $data['ID_Rencontre'] . ' : </h1><p>' 
			. Match::getMoreInfoMatch($data['ID_Rencontre']) . '</p>';
		}
		
		return $r;
	}
}

?>