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
        $r = $r . '<p> <h2>' . $data['Date_match'] . ':</h2><ul>'
          . Match::getInfoMatch($data['Date_match'])
          . '</ul></p>';
      }

    $q->closeCursor();
		
    return $r;
  }
	
  static function getInfoMatch($dateMatch)
  {
    $r = '';
    $e1 = '';
    $e2 = '';

    $q = Database::query('Select c.Nom, e.Categorie, sum(rr.Points) as SumPoints, sum(rr.Fautes) as SumFautes
		From Rencontre re, Rencontrer rr, Equipe e, Club c
		Where re.Date_match = \'' .  $dateMatch . '\'
        and e.ID_Equipe = rr.ID_Equipe
        and re.ID_Rencontre = rr.ID_Rencontre
		and e.ID_Club = c.ID_Club
		Group by e.ID_Equipe
		Order by rr.ID_Rencontre');

    $nb_equipes = 0;

    while ($data = $q->fetch())
      {
        $noms[]       = $data['Nom'];
        $categories[] = $data['Categorie'];
        $fautes[]     = $data['SumFautes'];
        $scores[]     = $data['SumPoints'];

        $nb_equipes++;
      }

    for(int i = 0; i < $nb_equipes; i = i + 2)
      {
        $e1 = $e1 . $noms[i] . '(' . $categories[i] . ')';
        $e2 = $e2 . $noms[i + 1] . '(' . $categories[i + 1] . ')';

        if($scores[i] > $scores[i + 1]) { $e1 = '<b>' . $e1 . '</b>';}
        else                            { $e2 = '<b>' . $e2 . '</b>';}

        $r = $r . '<li>' . $e1 . ' - ' . $e2 . ' : ' . $scores[i] . ' - ' . $scores[i + 1] . '</li>';
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