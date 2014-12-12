<?php

include_once('Database.php');


class Joueur
{
  static function getList()
  {
    $r = '';

    /*
      Cette requête retourne uniquement les infos des joueurs ayant joués dans la saison courante
      Une solution serait de transformer INNER JOIN Rencontrer rr en LEFT OUTER JOIN rr de même sur re
      Il resterait le problème de l'utilisation de YEAR(re.Date_match) alors que le contenu pour être null
    */
    $q = Database::query('SELECT c.Nom AS Nom_Club, 
                                 m.Date_Entree, m.Nom, m.Prenom, 
                                 j.Adresse, j.Date_Naissance, j.ID_Membre, j.Num_Licence,
			                     AVG(rr.Points) AS MoyennePoints,
			                     STD(rr.Points) AS EcartTypePoints,
			                     AVG(rr.Fautes) AS MoyenneFautes,
			                     STD(rr.Fautes) AS EcartTypeFautes

			              FROM (((Membre m 
                                  INNER JOIN Joueur j
                                  ON m.ID_Membre = j.ID_Membre) 
                                 INNER JOIN Rencontrer rr
                                 ON rr.ID_Membre = m.ID_Membre)
                                INNER JOIN Club c
                                ON c.ID_Club = m.ID_Club)
                               INNER JOIN Rencontre re
                               ON re.ID_Rencontre = rr.ID_Rencontre

                          WHERE YEAR(re.Date_match) = YEAR(NOW())
                          GROUP BY c.Nom, j.ID_Membre');

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
          .'Date d\'entrée dans le club ' . $data['Nom_Club'] . ' : ' . $data['Date_Entree'] . '<br/>'
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