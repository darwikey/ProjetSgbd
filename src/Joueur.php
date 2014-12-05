<?php

include_once('Database.php');


class Joueur
{
  static function getList()
  {
    $q = Database::query('Select c.Nom as Nom_Club, j.ID_Membre, j.Num_Licence, m.Date_Entree, m.Nom, m.Prenom, j.Adresse, j.Date_Naissance,
			avg(r.Points) as MoyennePoints,
			std(r.Points) as EcartTypePoints,
			avg(r.Fautes) as MoyenneFautes,
			std(r.Fautes) as EcartTypeFautes

			From Membre m, Joueur j, Rencontrer r, Rencontre a, Club c
			Where m.ID_Membre = j.ID_Membre
			and r.ID_Membre = m.ID_Membre
			and a.ID_Rencontre = r.ID_Rencontre
			and Year(a.Date_match) = Year(Now())
            and c.ID_Club = m.ID_Club
			Group by c.Nom, j.ID_Membre');

    $data = $q->fetch();
    $nom_club = $data['Nom_Club'];
    $r = $r . '<h1>' . $nom_club . '</h1><p><ul>';          

 
    do
      {
        if($nom_club != $data['Nom_Club'])
          {
            $nom_club = $data['Nom_Club'];
            $r = $r . '</ul></p><h1>' . $nom_club . '</h1><p><ul>';          
          }

        // Informations joueur
        $r = $r . '<li> <strong>' . $data['Nom'] . ' ' . $data['Prenom'] . '</strong> <br/>'
          .'Date d\'entrée dans le club ' . $data['NomClub'] . ' : ' . $data['Date_Entree'] . '<br/>'
          .'Numéro de licence : ' . $data['Num_Licence'] . '<br/>'
          .'Adresse : ' . $data['Adresse'] . '<br/>'
          .'Date de naissance : ' . $data['Date_Naissance'] . '<br/>'
			
          // Statistiques
          .'Moyenne des points cette saison : ' . number_format($data['MoyennePoints'], 2) 
                                                . ' (écart type : ' . number_format($data['EcartTypePoints'], 2) . ')<br/>'
          .'Moyenne des fautes cette saison : ' . number_format($data['MoyenneFautes'], 2) 
                                                . ' (écart type : ' . number_format($data['EcartTypeFautes'], 2) . ')<br/>'
          .'Graphique : <a href="javascript:popup(\'Graphe.php?joueur=' . $data['ID_Membre'] . '&annee=2014\')"> cliquez ici</a></li>';
      } while ($data = $q->fetch());

    $r = $r .'</ul></p>';

    $q->closeCursor();
		
    return $r;
  }  
}

?>