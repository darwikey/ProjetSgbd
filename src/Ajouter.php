<?php

include_once('Database.php');

class Ajouter
{
  static function getPage()
  {
    $r = '<form action="index.php?page=ajouter" method="post">
               <p> Que voulez-vous ajouter ?
                <select name="choix">
                 <option value="Membre">Membre</option>
                 <option value="Club">Club</option>
                 <option value="Match">Match</option>
                 <option value="Equipe">Equipe</option>
                </select>

                <input type="submit" value="Suivant">
               </p>
              </form>';

        
    if(isset($_POST['choix']))
      {
        if($_POST['choix'] == 'Membre')
          {
            $r = $r . Ajouter::addMembre();
          }

        else if($_POST['choix'] == 'Club')
          {
            $r = $r . Ajouter::addClub();
          }

        else if($_POST['choix'] == 'Match')
          {
            $r = $r . Ajouter::addMatch();
          }

        else if($_POST['choix'] == 'Equipe')
          {
            $r = $r . Ajouter::addEquipe();
          }
      }

    return $r;
  }

  /*
    Ajout d'un membre
   */

  static function addMembre()
  {
    $q = Database::query('Select Nom From Club');

    $r = '<form action="index.php?page=ajouterMembre" method="post">
               <p> Entrez le nom :
                <input type="text" name="nom" />
               </p>

               <p> Entrez le prenom :
                <input type="text" name="prenom" />
               </p>

               <p> Entrez la date de naissance (AAAA-MM-JJ) :
                <input type="text" name="naissance" />
               </p>

               <p> Entrez l\'adresse (pas obligatoire) :
                <input type="text" name="adresse" />
               </p>
                 
               <p> Entrez la date d\'entree (AAAA-MM-JJ) :
                <input type="text" name="entree" />
               </p>

               <p> Club :
                <select name="club">';
        
      while($data = $q->fetch())
        {
          $r = $r . '<option value="' . $data['Nom'];
          $r = $r . '">' . $data['Nom'] . '</option>';
        }

      $r = $r . '</select> </p>';
      
      $r = $r . '<p> Activité : <br>
                <input type="checkbox" name="activite[]" value="Entraineur">
                 Entraineur <br>
                <input type="checkbox" name="activite[]" value="Joueur">
                 Joueur <br>                
                <input type="checkbox" name="activite[]" value="Responsable">
                 Responsable <br>
               </p>

               <p> Entrez le poste (choisir aucun si pas responsable) :
                <select name="role">
                 <option value="President">President</option>
                 <option value="Tresorier">Tresorier</option>
                 <option value="Secretaire">Secretaire</option>
                 <option value="Aucun">Aucun</option>
                </select>
               </p>

               <p>
                <input type="submit" value="Enregistrer">
               </p>

              </form>';        
      
      return $r;
  }

  static function verifyMembre()
  {
    if(Ajouter::isValidDate($_POST['naissance']) and 
    Ajouter::isValidDate($_POST['entree']))
      {
        if($_POST['nom'] != '' and
        $_POST['prenom'] != '' and
        isset($_POST['activite']))
          {
            $q = Database::query('Select ID_Club From Club Where Nom = \'' . $_POST['club'] . '\'');
            
            $data = $q->fetch();

            $id_club = $data['ID_Club'];
            $nom     = strip_tags($_POST['nom']);
            $prenom  = strip_tags($_POST['prenom']);
            $entree  = $_POST['entree'];

            $sql = "INSERT INTO Membre(ID_Membre, ID_Club, Nom, Prenom, Date_Entree) VALUES ('','$id_club', '$nom', '$prenom', '$entree')";
            Database::query($sql);

            $id_membre = Database::lastId();

            if(in_array("Entraineur", $_POST['activite']))
              {
                $sql = "INSERT INTO Entraineur(ID_Membre) VALUES ('$id_membre')";
                Database::query($sql);
              }
              
            if(in_array("Joueur", $_POST['activite']))
              {
                $naissance = $_POST['naissance'];

                if($_POST['adresse'] == '')
                  {
                    $adresse = NULL;
                  }

                else
                  {
                    $adresse   = $_POST['adresse'];
                  }

                $sql = "INSERT INTO Joueur(Num_Licence, ID_Membre, Date_Naissance, Adresse) VALUES ('','$id_membre','$naissance','$adresse')";
                Database::query($sql);
              }
                        
            if(in_array("Responsable", $_POST['activite']))
              {
                $q = Database::query('Select Activite From Responsable r, Membre m Where r.ID_Membre = m.ID_Membre and m.ID_Club = ' . $id_club . ' and Activite = \'' . $_POST['role'] . '\'');

                $data = $q->fetch();

                if($_POST['role'] != 'Aucun' and isset($data['Activite']) != 1)
                  {
                    $role = $_POST['role']; 
                        
                    $sql = "INSERT INTO Responsable(ID_Membre, Activite) VALUES ('$id_membre','$role')";
                        
                    Database::query($sql);
                  }

                else
                  {
                    $sql = "DELETE FROM Entraineur where ID_Membre = " . $id_membre; 
                    Database::query($sql);
                        
                    $sql = "DELETE FROM Joueur where ID_Membre = " . $id_membre; 
                    Database::query($sql);
                        
                    $sql = "DELETE FROM Membre where ID_Membre = " . $id_membre; 
                    Database::query($sql);
                        
                    return "Information manquante ou poste déjà occupé.";
                  }
              }

            return "Membre enregistre avec succes.\n";
          }

        else 
          {
            return "Informations manquantes.\n";
          }
      }

    else
      {
        return "Mauvais format de date.\n";
      }
  }

  /*
    Ajout d'un club
  */

  static function addClub()
  {
    $q = Database::query('Select m.ID_Membre, m.Nom, m.Prenom 
                          From Membre m
                          Where not exists (Select * from Responsable r where m.ID_Membre = r.ID_Membre)');

    $r = $r . '<form action="index.php?page=ajouterClub" method="post">
               <p> Entrez le nom : 
               <input type="text" name="nom" /> </p>
               <p> Entrez la ville :
               <input type="text" name="ville" /> </p>
               <p> Choisissez un président : 
               <select name="president">';

      while($data = $q->fetch())
        {
          $r = $r . '<option value="' . $data['ID_Membre'] . '_' . $data['Nom'] . '_' . $data['Prenom'] ;
          $r = $r . '">' . $data['ID_Membre'] . ' ' . $data['Nom'] . ' ' . $data['Prenom'] . '</option>';          
        }
      
      $r = $r . '</p> <p> <input type="submit" value="Enregistrer" /> </p>';
      
      return $r;
  }

  static function verifyClub()
  {
    if(isset($_POST['nom']) and isset($_POST['ville']))
      {
        $nom = $_POST['nom'];
        $ville = $_POST['ville'];
        $info_president = explode('_', $_POST['president']);

        $sql = "INSERT INTO Club(ID_Club, Nom, Ville) VALUES ('','$nom','$ville')";
        Database::query($sql);
        
        $id_club = Database::lastId();

        $date = getdate();
        $date_formatee = $date['year'] . '-' . $date['mon'] . '-' . $date['mday'];

        $sql = "UPDATE Membre SET ID_Club='$id_club', Date_Entree='$date_formatee' WHERE ID_Membre='$info_president[0]'";
        Database::query($sql);

        $sql = "INSERT INTO Responsable(ID_Membre, Activite) VALUES ('$info_president[0]', 'President')";
        Database::query($sql);

        return "Club enregistré avec succés.\n";
      }

    else
      {
        return "Informations manquantes.\n";
      }
  }

  /*
    Ajout d'une équipe
  */

  static function addEquipe()
  {
    $q = Database::query('Select Nom, ID_Club From Club');

    $r = $r . '<form action="index.php?page=ajouterEquipe" method="post">
               <p> Choisissez le club : 
               <select name="club">';

    while($data = $q->fetch())
      {
        $r = $r . '<option value="' . $data['ID_Club'] . '_' . $data['Nom'];
        $r = $r . '">' . $data['ID_Club'] . ' ' . $data['Nom'] . '</option>';
      }
    
    $r = $r . '</select> </p>';

    $r = $r . '<p> Choisissez une catégorie :
               <select name="categorie">
               <option value="Senior"> Senior </option>
               <option value="Junior"> Junior </option>
               <option value="Cadet"> Cadet </option>
               <option value="Minime"> Minime </option>
               <option value="Benjamin"> Benjamin </option>
               <option value="Poussin"> Poussin </option>
               <option value="Baby"> Baby </option>
               </select> </p>';

    $r = $r . '<p> <input type="submit" value="Enregistrer" /> </p>';

    return $r;
  }

  static function verifyEquipe()
  {
    $categorie = $_POST['categorie'];
    $info_club = explode('_', $_POST['club']);

    $sql = "INSERT INTO Equipe(ID_Equipe, Categorie, ID_Club) VALUES ('', '$categorie', '$info_club[0]')";
    Database::query($sql);

    return "Equipe ajoutée avec succés.\n";
  }

  static function isValidDate($date)
  {
    if(preg_match("#[0-9]{4}-[0-9]{2}-[0-9]{2}#", $date))
      {
        $cut = explode('-', $date);
                
        return checkdate($cut[1], $cut[2], $cut[0]);
      }
        
    return false;
  }
}

?>