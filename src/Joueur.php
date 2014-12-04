<?php

include_once('Database.php');


class Joueur
{
	static function getList()
	{
		$q = Database::query('Select j.ID_Membre, j.Num_Licence, m.Date_Entree, m.Nom, m.Prenom, j.Adresse, j.Date_Naissance, c.Nom as NomClub,
			avg(r.Points) as MoyennePoints,
			std(r.Points) as EcartTypePoints,
			avg(r.Fautes) as MoyenneFautes,
			std(r.Fautes) as EcartTypeFautes

			From Membre m, Joueur j, Rencontrer r, Rencontre a, Club c
			Where m.ID_Membre = j.ID_Membre
			and r.ID_Membre = m.ID_Membre
			and a.ID_Rencontre = r.ID_Rencontre
			and c.ID_Club = m.ID_Club
			and Year(a.Date_match) = Year(Now())
			Group by j.ID_Membre');
		$r = '';
		
		while ($data = $q->fetch())
		{
			// Informations joueur
			$r = $r . '<p> <h2> Joueur ' . $data['ID_Membre'] .':</h2><ul>'
			.'<li>Numéro de licence : ' . $data['Num_Licence'] . '</li>'
			.'<li>Date d\'entrée dans le club ' . $data['NomClub'] . ' : ' . $data['Date_Entree'] . '</li>'
			.'<li>Nom : ' . $data['Nom'] . '</li>'
			.'<li>Prénom : ' . $data['Prenom'] . '</li>'
			.'<li>Adresse : ' . $data['Adresse'] . '</li>'
			.'<li>Date de naissance : ' . $data['Date_Naissance'] . '</li>'
			
			// Statistiques
			.'<li>Moyenne des points cette saison : ' . number_format($data['MoyennePoints'], 2) 
			. ' (écart type : ' . number_format($data['EcartTypePoints'], 2) . ')</li>'
			.'<li>Moyenne des fautes cette saison : ' . number_format($data['MoyenneFautes'], 2) 
			. ' (écart type : ' . number_format($data['EcartTypeFautes'], 2) . ')</li>'
			.'<li>Graphique : <a href="javascript:popup(\'Graphe.php?joueur=' . $data['ID_Membre'] . '&annee=2014\')"> cliquez ici</a></li>'
			
			.'</ul></p>';

		}

		$q->closeCursor();
		
		return $r;
	}
}

?>