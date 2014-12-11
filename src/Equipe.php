<?php

include_once('Database.php');

class Equipe 
{
  static function whichInformation()
  {
    $r = '<form action="index.php?page=equipe" method="post">
            <p> Que voulez-vous voir ?
             <select name="choix">
              <option value="Classement">Classement</option>
              <option value="Equipe">Liste équipe</option>
             </select>
             <input type="submit" value="Suivant">
            </p>';

    if(isset($_POST['choix']) and $_POST['choix'] == 'Equipe')
      {
        $r = $r . Equipe::getEquipeListe();
      }

    else
      {
        $r = $r . '
               <p> Choisissez une catégorie :
               <select name="categorie">
               <option value="Senior"> Senior </option>
               <option value="Junior"> Junior </option>
               <option value="Cadet"> Cadet </option>
               <option value="Minime"> Minime </option>
               <option value="Benjamin"> Benjamin </option>
               <option value="Poussin"> Poussin </option>
               <option value="Baby"> Baby </option>
               </select> 
               <input type="submit" value="Suivant"> </p>';

        $r = $r . Equipe::getClassement();
      }
    

    return $r . '</form>';
  }
  
  static function getClassement()
  {
	if (! isset($_POST['categorie']))
	{
		return;
	}

	$r = '';
    $q = Database::query('
			SELECT c.Nom,
            SUM(e.Points > t.Total/2) AS gagne,
			SUM(e.Points = t.Total/2) AS egual,
			SUM(e.Points < t.Total/2) AS perdu
			
			FROM ((SELECT ID_Rencontre, e1.*,
				   SUM(r1.Points) AS Points
				   FROM Equipe e1, Rencontrer r1
				   WHERE e1.ID_Equipe = r1.ID_Equipe
				   GROUP BY r1.ID_Rencontre, e1.ID_Equipe) e 
                
                   INNER JOIN (SELECT ID_Rencontre,
              	   			   SUM(r1.Points) as Total
			            	   FROM Rencontrer r1
				               GROUP BY r1.ID_Rencontre) t
                   ON e.ID_Rencontre = t.ID_Rencontre)
 
               INNER JOIN Club c
               ON e.ID_Club = c.ID_Club
			  
            WHERE e.Categorie = \'' . $_POST['categorie'] . '\'

			GROUP BY e.ID_Equipe
			ORDER BY gagne DESC, egual DESC, perdu DESC');

    $r = $r . '<h1> CLASSEMENT '. $_POST['categorie'] . '</h1>
                     <table>
                      <tr>
                       <td> Club </td>
                       <td> Gagne </td>
                       <td> Perdu </td>
                       <td> Egalité </td>
                      </tr>';

    while($data = $q->fetch())
      {
        $r = $r . '<tr>
                          <td>' . $data['Nom'] . '</td>
                          <td>' . $data['gagne'] . '</td>
                          <td>' . $data['perdu'] . '</td>
                          <td>' . $data['egual'] . '</td>
                         </tr>';
      }
          
    $r = $r . '</table>';

    $q->closeCursor();

    return $r;
  }

  static function getEquipeListe()
  {
	$r = '';
    $q = Database::query('
			Select c.Nom, e.Categorie,
			SUM(e.Points > t.Total/2) as gagne,
			SUM(e.Points = t.Total/2) as egual,
			SUM(e.Points < t.Total/2) as perdu
			
			From
				(Select ID_Rencontre, e1.*,
				SUM(r1.Points) as Points
				From Equipe e1, Rencontrer r1
				Where e1.ID_Equipe = r1.ID_Equipe
				Group by r1.ID_Rencontre, e1.ID_Equipe) e,

				(Select ID_Rencontre,
				SUM(r1.Points) as Total
				From Rencontrer r1
				Group by r1.ID_Rencontre) t,
				
				Club c

			Where e.ID_Rencontre = t.ID_Rencontre
			and e.ID_Club = c.ID_Club
			Group by e.ID_Equipe
			Order by c.Nom, gagne DESC, egual DESC, perdu DESC');
        
    $data = $q->fetch();
    $nom_club = $data['Nom'];

    $r = $r . "<h1> '$nom_club' </h1> <table>
                      <tr> 
                       <td> Categorie </td>
                       <td> Gagne </td>
                       <td> Perdu </td>
                       <td> Egalité </td> 
                      </tr>";
    do
      {
        if($nom_club != $data['Nom'])
          {
            $nom_club = $data['Nom'];

            $r = $r . "</table> <h1> '$nom_club' </h1> <table>
                      <tr> 
                       <td> Categorie </td>
                       <td> Gagne </td>
                       <td> Perdu </td>
                       <td> Egalité </td> 
                      </tr>";
          }

        $r = $r . '<tr> 
                    <td>' . $data['Categorie'] . '</td>
                    <td>' . $data['gagne'] . '</td>
                    <td>' . $data['perdu'] . '</td>
                    <td>' . $data['egual'] . '</td>
                   </tr>';

      } while($data = $q->fetch());
        
        
    $q->closeCursor();
		
    return $r;
  }

  // renvoie un tableau avec [match gagné, match perdu, match nul]
  static function getStatMatch($idEquipe)
  {
    $q = Database::query('Select SUM(a.Points > t.Total/2) as gagne, 
			SUM(a.Points = t.Total/2) as egual, 
			SUM(a.Points < t.Total/2) as perdu
			From
				(Select ID_Rencontre, 
				SUM(r.Points) as Points 
				From Equipe e, Rencontrer r
				Where r.ID_Equipe = ' . $idEquipe .'
				and e.ID_Equipe = r.ID_Equipe
				Group by r.ID_Rencontre) a, 

				(Select ID_Rencontre, 
				SUM(r1.Points) as Total
				From Rencontrer r1
				Group by r1.ID_Rencontre) t

			Where a.ID_Rencontre = t.ID_Rencontre');
			
    $data = $q->fetch();
		
    return array($data['gagne'], $data['egual'], $data['perdu']);
  }
}
?>