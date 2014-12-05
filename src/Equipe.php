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
            </p>
          </form>';

    if($_POST['choix'] == 'Equipe')
      {
        $r = $r . Equipe::getEquipeListe();
      }

    else
      {
        $r = $r . '<form action="index.php?page=equipe" method="post">
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
    

    return $r;
  }
  
  static function getClassement()
  {
    $q = Database::query('
			Select c.Nom,
            sum(e.Points > t.Points/2) as gagne,
			sum(e.Points = t.Points/2) as egual,
			sum(e.Points < t.Points/2) as perdu
			
			From
				(Select ID_Rencontre, e1.*,
				sum(r1.Points) as Points
				From Equipe e1, Rencontrer r1
				Where e1.ID_Equipe = r1.ID_Equipe
				Group by r1.ID_Rencontre, e1.ID_Equipe) e,

				(Select ID_Rencontre,
				sum(r1.Points) as Points
				From Rencontrer r1
				Group by r1.ID_Rencontre) t,
				
				Club c

			Where e.ID_Rencontre = t.ID_Rencontre
			and e.ID_Club = c.ID_Club
            and e.Categorie = \'' . $_POST['categorie'] . '\'
			Group by e.ID_Equipe
			Order by gagne DESC, egual DESC, perdu DESC');

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
    $q = Database::query('
			Select c.Nom, e.Categorie,
			sum(e.Points > t.Points/2) as gagne,
			sum(e.Points = t.Points/2) as egual,
			sum(e.Points < t.Points/2) as perdu
			
			From
				(Select ID_Rencontre, e1.*,
				sum(r1.Points) as Points
				From Equipe e1, Rencontrer r1
				Where e1.ID_Equipe = r1.ID_Equipe
				Group by r1.ID_Rencontre, e1.ID_Equipe) e,

				(Select ID_Rencontre,
				sum(r1.Points) as Points
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
    $q = Database::query('Select sum(a.Points > t.Points/2) as gagne, 
			sum(a.Points = t.Points/2) as egual, 
			sum(a.Points < t.Points/2) as perdu
			From
				(Select ID_Rencontre, 
				sum(r.Points) as Points 
				From Equipe e, Rencontrer r
				Where r.ID_Equipe = ' . $idEquipe .'
				and e.ID_Equipe = r.ID_Equipe
				Group by r.ID_Rencontre) a, 

				(Select ID_Rencontre, 
				sum(r1.Points) as Points
				From Rencontrer r1
				Group by r1.ID_Rencontre) t

			Where a.ID_Rencontre = t.ID_Rencontre');
			
    $data = $q->fetch();
		
    return array($data['gagne'], $data['egual'], $data['perdu']);
  }
}
?>