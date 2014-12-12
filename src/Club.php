<?php

include_once('Database.php');


class Club 
{
  static function getList()
  {
    // Recupere les informations sur les clubs, leur nombre d'équipes et de joueurs
    $q = Database::query('SELECT c.Nom, c.Ville, c.ID_Club,
				
                                 (SELECT COUNT(*) 
   		                          FROM Equipe e
				                  WHERE c.ID_Club = e.ID_Club) AS NombreEquipe,
				
                                 (SELECT COUNT(*) 
				                  FROM Joueur j, Membre m
				                  WHERE c.ID_Club = m.ID_Club
				                  AND m.ID_Membre = j.ID_Membre) AS NombreJoueur
			
                           FROM Club c');
    $r = '';
		
    while ($data = $q->fetch())
      {
		
        $r = $r . '<p><h2>Club '.$data['Nom'].':</h2>';

        $r = $r . '<ul><li>Ville : '.$data['Ville'].'</li>';
			
        $r = $r . '<li>Reponsables : '.Club::getResponsables($data['ID_Club']).'</li>';
			
        $r = $r . '<li>Nombre d\'équipes : '.$data['NombreEquipe'].'</li>';

        $r = $r . '<li>Nombre de joueur : '.$data['NombreJoueur'].'</li>';
			
        $r = $r . '</ul></p>';
      }

    $q->closeCursor();
		
    return $r;
  }
	
  static function getResponsables($idClub)
  {
    $r = '<ul>';
    
    // Recherche des responsables
    $q = Database::query('SELECT *
                          FROM Membre m, Responsable r 
                          WHERE m.ID_Club = ' . $idClub . ' 
                          AND m.ID_Membre = r.ID_Membre');

    while ($data = $q->fetch())
      {
        $r = $r.'<li>'.$data['Activite'].' : '.$data['Nom'].'  '.$data['Prenom'].'  (prise de fonction : '.$data['Date_Entree'].')</li>';
      }

    $q->closeCursor();
		
    return $r . '</ul>';
  }
}

?>