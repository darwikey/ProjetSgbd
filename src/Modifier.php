<?php

include_once('Database.php');

class Modifier 
{
  static function getPage()
  {
	$r = '';
    $r = $r . '<form action="index.php?page=modifier" method="post">
               <p> Que voulez-vous modifier ?
                <select name="choix">
                 <option value="Membre">Membre</option>
                </select>

                <input type="submit" value="Suivant">
               </p> </form>';

    if(isset($_POST['choix']))
      {
        if($_POST['choix'] == 'Membre')
          {
            $r = $r . Modifier::modifyMembreByClub();
          }
      }

    return $r . '</form>';
  }

  static function modifyMembreByClub()
  {
    $r = '';

    $club = Database::query("Select Nom, ID_Club from Club");

    $r = $r . '<form action="index.php?page=modifierMembre" method="post">
               <p> Dans quel club ?
                <select name="club">';
      
      while($data = $club->fetch())
        {
          $nom_club = $data['Nom'];
          $id_club  = $data['ID_Club'];
          
          $r = $r . "<option value=\"" . $id_club . "\">$nom_club</option>";
        }
    
      $r = $r . '</select> 
               <input type="submit" value="Suivant"> </p> </form>';

      return $r;
  }

  static function modifyMembre()
  {
    $r = '';

    if(isset($_POST['club']))
      {
        $choosen_club = $_POST['club'];
    
        $liste_joueur = Database::query("Select m.Nom, m.Prenom, m.ID_Membre 
                                       From Membre m, Club c 
                                       Where c.ID_Club = '$choosen_club'
                                       And   c.ID_Club = m.ID_Club");

        $r = $r . '<form action="index.php?page=modifierMembreInformation&club='.$choosen_club.'" method="post">
                   <p> Quel joueur ?
                    <select name="joueur">';
        
          while($data = $liste_joueur->fetch())
            {
              $nom_joueur     = $data['Nom'];
              $prenom_joueur  = $data['Prenom'];
              $id_membre      = $data['ID_Membre'];
        
              $r = $r . '<option value="'.$id_membre.'">' . $id_membre . ' ' . $nom_joueur . ' ' . $prenom_joueur . '</option>';
            }

          $r = $r . '<input type="submit" value="Suivant"> </form>';
      }

    return $r;
  }

  static function modifyMembreInformation()
  {
    $r = '';

    if(isset($_POST['joueur']))
      {
        $choosen_one = $_POST['joueur'];

        $info_joueur = Database::query('SELECT r.Activite, m.*, j.Date_Naissance, j.Adresse,

                                               (SELECT COUNT(*) 
                                                FROM Entraineur e1
                                                WHERE e1.ID_Membre = \''.$choosen_one.'\') AS entraine,

                                               (SELECT COUNT(*)
                                                FROM Joueur j1
                                                WHERE j1.ID_Membre = \''.$choosen_one.'\') AS joue,

                                               (SELECT COUNT(*)
                                                FROM Responsable r1
                                                WHERE r1.ID_Membre = \''.$choosen_one.'\') AS gere


                                        FROM (Membre m 
                                              INNER JOIN Joueur j
                                              ON j.ID_Membre = m.ID_Membre)
                                             LEFT OUTER JOIN Responsable r
                                             ON r.ID_Membre = \''.$choosen_one.'\'

                                        WHERE m.ID_Membre = \''.$choosen_one.'\'');

        $data           = $info_joueur->fetch();
        $nom_joueur     = $data['Nom'];
        $prenom_joueur  = $data['Prenom'];
        $date_naissance = $data['Date_Naissance'];
        $adresse        = $data['Adresse'];
        $date_entree    = $data['Date_Entree'];

        $r = $r . '<form action="index.php?page=modifierMembreInformation" method="post">
               <p> Entrez le nom :
                <input type="text" name="nom" value="'.$nom_joueur.'" />
               </p>

               <p> Entrez le prenom :
                <input type="text" name="prenom" value="'.$prenom_joueur.'"/>
               </p>

               <p> Entrez la date de naissance (AAAA-MM-JJ) :
                <input type="text" name="naissance" value="'.$date_naissance.'" />
               </p>

               <p> Entrez l\'adresse (pas obligatoire) :
                <input type="text" name="adresse" value="'.$adresse.'"/>
               </p>
                 
               <p> Entrez la date d\'entree (AAAA-MM-JJ) :
                <input type="text" name="entree" value="'.$date_entree.'"/>
               </p>

               <p> Club :
                <select name="club">';

        $l = '';
        
        $club = Database::query("Select Nom, ID_Club from Club");

        while($info_club = $club->fetch())
          {
            $nom_club = $info_club['Nom'];
            $id_club  = $info_club['ID_Club'];
                
            if($id_club == $_GET['club'])
              {
                $l = "<option value=\"" . $id_club . "\">$nom_club</option>" . $l;
              }

            else
              {
                $l = $l . "<option value=\"" . $id_club . "\">$nom_club</option>";
              }
          }

        $r = $r . $l;

        $r = $r . "</select> </p>";

        $r = $r . '<p> Activité : <br/>
                <input type="checkbox" name="activite[]" value="Entraineur" ';
                    
          if($data['entraine'] > 0)
            {
              $r = $r . 'checked="true"';
            }

          $r = $r . ' >
                 Entraineur <br/>
                <input type="checkbox" name="activite[]" value="Joueur" ';

          if($data['joue'] > 0)
            {
              $r = $r . 'checked="true"';
            }
          
          $r = $r . ' >
                 Joueur <br/>                
                <input type="checkbox" name="activite[]" value="Responsable" '; 
            
          if($data['gere'] > 0)
            {
              $r = $r . 'checked="true"';
            }
        
          $r = $r . '>
                 Responsable <br/>
               </p>';
          
          $r = $r . '<p>
                    <input type="submit" value="Enregistrer" name"Change">
                   </p>';
          
          if(isset($_POST['Change']))
            {
              if(isValidDate($_POST['naissance']) and isValidDate($_POST['entree']))
                {
                  if($_POST['nom'] != '' and
                  $_POST['prenom'] != '' and
                  isset($_POST['activite']))
                    {
                      $nom = $_POST['nom'];
                      $prenom = $_POST['prenom'];
                      $entree = $_POST['entree'];
                      $naissance = $_POST['naissance'];
                      $adresse = $_POST['adresse'];

                      $sql = "UPDATE Membre m, Joueur j SET m.Nom='$nom', m.Prenom='$prenom', m.Date_Entree='$entree', j.Date_naissance='$naissance', j.Adresse='$adresse' where m.ID_Membre='$choosen_one' and j.ID_Membre='$choosen_one'";
                      
                      Database::query($sql);
                      
                      if(in_array("Entraineur", $_POST['activite']) and ($data['entraine'] == 0))
                        {
                          $sql = "INSERT INTO Entraineur(ID_Membre) VALUES ('$choosen_one')";
                          Database::query($sql);
                        }
                      
                      if((!in_array("Entraineur", $_POST['activite'])) and ($data['entraine'] > 0))
                        {
                          $sql = "DELETE FROM Entraineur where ID_Membre = " . $choosen_one;
                          Database::query($sql);
                        }
                      
                      if(in_array("Joueur", $_POST['activite']) and ($data['joue'] == 0))
                        {
                          if($_POST['adresse'] == '')
                            {
                              $adresse = NULL;
                            }
                          
                          else
                            {
                              $adresse   = $_POST['adresse'];
                            }
                          
                          $sql = "INSERT INTO Joueur(Num_Licence, ID_Membre, Date_Naissance, Adresse) VALUES ('','$choosen_one','$naissance','$adresse')";
                          Database::query($sql);
                        }
                      
                      if((!in_array("Joueur", $_POST['activite'])) and ($data['joue'] > 0))
                        {
                          $sql = "DELETE FROM Joueur where ID_Membre = " . $id_membre;
                          Database::query($sql);
                        }
                      
                      $r = "Membre modifié avec succés.\n";
                    }
                  
                  else
                    {
                      $r = "Informations manquantes.\n";
                    }
                }
              
              else
                {
                  $r = "Date(s) invalide(s).\n";
                }
            }
      }
    
    return $r . '</form>';
  }
}

?>