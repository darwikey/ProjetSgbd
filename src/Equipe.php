<?php

include_once('Database.php');

class Equipe 
{
	static function getList()
	{
		$q = Database::query('
			Select e.Categorie, c.Nom, c.Ville, e.ID_Equipe,
			sum(e.Points > t.Points/2) as gagne, 
			sum(e.Points = t.Points/2) as egual, 
			sum(e.Points < t.Points/2) as perdu
			
			From
				(Select ID_Rencontre, e1.*,
				sum(r1.Points) as Points 
				From Equipe e1, Rencontrer r1
				Where e1.ID_Equipe = r1.ID_Equipe
				Group by r1.ID_Rencontre, e1.ID_Equipe) e, 

				(Select ID_Rencontre, 
				sum(r1.Points) as Points
				From Rencontrer r1
				Group by r1.ID_Rencontre) t,
				
				Club c

			Where e.ID_Rencontre = t.ID_Rencontre
			and e.ID_Club = c.ID_Club
			Group by e.ID_Equipe
			Order by gagne DESC, egual DESC, perdu DESC');
		$r = '';
		
		while ($data = $q->fetch())
		{
			$r = $r . '<p> <h2> Equipe :</h2><ul>'
			.'<li>Categorie : ' . $data['Categorie'] . '</li>'
			.'<li>Club : ' . $data['Nom'] . ' (' . $data['Ville'] . ')</li>'
			.'<li> ' . $data['gagne'] . ' matchs gagnés</li>'
			.'<li> ' . $data['egual'] . ' matchs ex aequos</li>'
			.'<li> ' . $data['perdu'] . ' matchs perdus</li>'
			.'</ul></p>';

		}

		$q->closeCursor();
		
		return $r;
	}

	// renvoie un tableau avec [match gagné, match perdu, match null]
	static function getStatMatch($idEquipe)
	{
		$q = Database::query('Select sum(a.Points > t.Points/2) as gagne, 
			sum(a.Points = t.Points/2) as egual, 
			sum(a.Points < t.Points/2) as perdu
			From
				(Select ID_Rencontre, 
				sum(r.Points) as Points 
				From Equipe e, Rencontrer r
				Where r.ID_Equipe = ' . $idEquipe .'
				and e.ID_Equipe = r.ID_Equipe
				Group by r.ID_Rencontre) a, 

				(Select ID_Rencontre, 
				sum(r1.Points) as Points
				From Rencontrer r1
				Group by r1.ID_Rencontre) t

			Where a.ID_Rencontre = t.ID_Rencontre');
			
		$data = $q->fetch();
		
		return array($data['gagne'], $data['egual'], $data['perdu']);
	}
}
?>