<?php

include_once('Database.php');

class Consultation
{
	static function getPage()
	{
		$r = '<form action="index.php?page=consultation" method="post">
		<p>Afficher : 
		<select name="choix">
		<option value="joueurs_inscrits">Joueurs Inscrits</option>
		<option value="meilleurs_joueurs">Meilleurs Joueurs</option>
		</select>
		
		à la date (AAAA-MM-JJ) : 
		<input type="text" name="date" />
		<input type="submit" value="Rechercher" />
		</p></form>';
		
		
		if(isset($_POST['choix']))
		{
			$date = $_POST['date'];
			
			if ($_POST['choix'] == 'joueurs_inscrits')
			{
				$r = $r . Consultation::getJoueursInscrits($date);
			}
			else if ($_POST['choix'] == 'meilleurs_joueurs')
			{
				$r = $r . Consultation::getMeilleursJoueurs($date);
			}
		}
		
		return $r;
	}
	
	// retourne la liste de tous les joueurs inscrit à une date donnée
	static function getJoueursInscrits($date)
	{
		$r = '<ul>';
		$q = Database::query('Select * 
		From Membre m, Joueur j 
		Where j.ID_Membre = m.ID_Membre
		and m.Date_Entree <= \'' . $date . '\'');
		
		
		while ($data = $q->fetch())
		{
			$r = $r . '<li>' . $data['Nom'] . ' ' . $data['Prenom'] . '</li>';
		}
		
		return $r . '</ul>';
	}
	
	// retourne le classement de tous les joueurs ayant joués un match à une date donnée
	// ils sont triés par le nombre de points marqués
	static function getMeilleursJoueurs($date)
	{
		$r = '';
		$q1 = Database::query('Select Distinct Categorie From Equipe');
		
		while ($data1 = $q1->fetch())
		{
			$r = $r . '<h1>Catégorie ' . $data1['Categorie'] . '</h1>';
			
			$q2 = Database::query('Select m.Nom, m.Prenom,
				sum(r.Points) as MoyennePoints
				
				From Membre m, Joueur j, Rencontrer r, Rencontre a, Equipe e
				Where m.ID_Membre = j.ID_Membre
				and r.ID_Membre = m.ID_Membre
				and a.ID_Rencontre = r.ID_Rencontre
				and a.Date_Match = "' . $date
				.'" and e.Categorie = "' . $data1['Categorie']
				.'" and e.ID_Equipe = r.ID_Equipe
				Group by j.ID_Membre
				Order by MoyennePoints DESC');
			
			while ($data2 = $q2->fetch())
			{
				$r = $r . '<li>' . $data2['Nom'] . ' ' . $data2['Prenom'] . ' - Points marqués : ' . (int)$data2['MoyennePoints'] . '</li>';
			}
		}
		
		return $r;
	}
}

?>