<?php

include_once('Database.php');


class Match 
{
  static function whichInformation()
  {
    $r = '<form action="index.php?page=match" method="post">
           <p> Entrez la date au format (AAAA-MM-JJ) :
            <input type="text" name="date">
            <input type="submit" value="Suivant">
           </p>
          </form>';

    if(isset($_POST['date']))
      {
        if(Database::isValidDate($_POST['date']))
          {
            $r = $r . Match::getMatchAtDate();
          }

        else
          {
            $r = $r . "Date invalide.\n";
          }
      }
    
    else
      {
        $r = $r . Match::getMatch();
      }

    return $r;
  }

  static function getMatch()
	{
      $q = Database::query('Select Distinct r.ID_Equipe, c.Nom, e.Categorie, re.Date_match,
                              sum(r.Points) as points, 
                              sum(r.Fautes) as fautes 
		                      
                              From Rencontre re, Rencontrer r, Equipe e, Club c
		   
                              Where e.ID_Equipe = r.ID_Equipe
                              and re.ID_Rencontre = r.ID_Rencontre
		                      and e.ID_Club = c.ID_Club
                              
                              Group by e.ID_Equipe, r.ID_Rencontre
                              Order by re.Date_match, re.ID_Rencontre, points DESC');

        $data = $q->fetch();
        $date_match = $data['Date_match'];
		$r = '<p><h1>' .  $data['Date_match'] . '</h1> <ul>';

        $preums = 1;
		
        do
		{
          if($date_match != $data['Date_match'])
            {
              $date_match = $data['Date_match'];
              $r = $r . '</ul></p> <h1>' .  $data['Date_match'] . '</h1> <ul>';
            }

          if($preums)
            {
              $r = $r . '<li>' . $data['Nom'] . ' Score : ' . $data['points'] . ' Fautes : ' . $data['fautes'];
              $preums = 0;
            }

          else
            {
              $r = $r . ' - ' . $data['Nom'] . ' Score : ' . $data['points'] . ' Fautes : ' . $data['fautes'] . '</li>';
              $preums = 1;
            }

		} while ($data = $q->fetch());

        $r = $r . '</ul> </p>';

		$q->closeCursor();
		
		return $r;
	}

  static function getMatchAtDate()
    {
      $q = Database::query('Select Distinct r.ID_Equipe, c.Nom, e.Categorie, re.Date_match,
                              sum(r.Points) as points,
                              sum(r.Fautes) as fautes
		                      
                              From Rencontre re, Rencontrer r, Equipe e, Club c
		   
                              Where e.ID_Equipe = r.ID_Equipe
                              and re.ID_Rencontre = r.ID_Rencontre
                              and e.ID_Club = c.ID_Club
                              and re.Date_match = \'' . $_POST['date'] . '\'
                              
                              Group by e.ID_Equipe, r.ID_Rencontre
                              Order by re.Date_match, re.ID_Rencontre, points DESC');

        $data = $q->fetch();
        $r = '<p><h1>' .  $data['Date_match'] . '</h1> <ul>';

        $preums = 1;
		
        do
        {
          if($preums)
            {
              $r = $r . '<li>' . $data['Nom'] . ' Score : ' . $data['points'] . ' Fautes : ' . $data['fautes'];
              $preums = 0;
            }

          else
            {
              $r = $r . ' - ' . $data['Nom'] . ' Score : ' . $data['points'] . ' Fautes : ' . $data['fautes'] . '</li>';
              $preums = 1;
            }

        } while ($data = $q->fetch());

        $r = $r . '</ul> </p>';

        $q->closeCursor();
		
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