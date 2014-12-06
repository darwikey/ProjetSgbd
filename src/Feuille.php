<?php

include_once('Database.php');

class Feuille
{
  static function getFeuilleMatch($id_rencontre)
  {
    $r = '';
		
    $q1 = Database::query('Select Distinct r.ID_Equipe, c.Nom, e.Categorie
		From Rencontrer r, Equipe e, Club c
		Where ID_Rencontre = ' .  $id_rencontre
    . ' and e.ID_Equipe = r.ID_Equipe
		and e.ID_Club = c.ID_Club');
		
    while ($data1 = $q1->fetch())
      {
        $r = $r . '<h2>Club ' . $data1['Nom'] . ' (équipe ' . $data1['Categorie'] . ')</h2><ul>';
		
        $q2 = Database::query('Select m.Nom, m.Prenom, r.Points, r.Fautes, 
			r.Points = (Select max(Points) 
						From Rencontrer
						Where ID_Rencontre = ' .  $id_rencontre
        . ' and ID_Equipe = ' . $data1['ID_Equipe'] 
        . ') as MeilleurJoueur,
			r.Fautes = (Select max(Fautes) 
						From Rencontrer
						Where ID_Rencontre = ' .  $id_rencontre
        . ' and ID_Equipe = ' . $data1['ID_Equipe']
        . ') as PireJoueur 
			From Rencontrer r, Membre m, Joueur j
			Where r.ID_Rencontre = ' .  $id_rencontre
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