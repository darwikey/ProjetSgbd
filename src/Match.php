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
    $q = Database::query('SELECT DISTINCT rr.ID_Equipe, c.Nom, e.Categorie, re.Date_match, re.ID_Rencontre,
                                          SUM(rr.Points) AS points, 
                                          SUM(rr.Fautes) AS fautes 
		                      
                          FROM ((Club c
                                 INNER JOIN Equipe e
                                 ON e.ID_Club = c.ID_Club) 
                                INNER JOIN Rencontrer rr
                                ON e.ID_Equipe = rr.ID_Equipe)
                               INNER JOIN Rencontre re
                               ON re.ID_Rencontre = rr.ID_Rencontre

                          GROUP BY e.ID_Equipe, rr.ID_Rencontre
                          ORDER BY re.Date_match, re.ID_Rencontre, points DESC');

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
            $r = $r . ' - ' . $data['Nom'] . ' Score : ' . $data['points'] . ' Fautes : ' . $data['fautes']
              . ' - <a href="javascript:popup(\'index.php?page=feuille&rencontre=' . $data['ID_Rencontre'] . '\')">Feuille de Match</a> </li>';
            $preums = 1;
          }

      } while ($data = $q->fetch());

    $r = $r . '</ul> </p>';

    $q->closeCursor();
		
    return $r;
  }

  static function getMatchAtDate()
  {
    $q = Database::query('Select Distinct r.ID_Equipe, c.Nom, e.Categorie, re.Date_match, re.ID_Rencontre,
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
            $r = $r . ' - ' . $data['Nom'] . ' Score : ' . $data['points'] . ' Fautes : ' . $data['fautes']
           . ' - <a href="javascript:popup(\'index.php?page=feuille&rencontre=' . $data['ID_Rencontre'] . '\')">Feuille de Match</a> </li>';
            $preums = 1;
          }

      } while ($data = $q->fetch());

    $r = $r . '</ul> </p>';

    $q->closeCursor();
		
    return $r;
  }
}

?>