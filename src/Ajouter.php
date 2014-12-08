<?php

include_once('Database.php');

class Ajouter
{
  static function getPage()
  {
	$r = '';
    $r = $r . '<form action="index.php?page=ajouter" method="post">
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
            $r = $r . Ajouter::addMatchDate();
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
      
      $r = $r . '<p> Activité : <br/>
                <input type="checkbox" name="activite[]" value="Entraineur">
                 Entraineur <br/>
                <input type="checkbox" name="activite[]" value="Joueur">
                 Joueur <br/>                
                <input type="checkbox" name="activite[]" value="Responsable">
                 Responsable <br/>
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
    if(Database::isValidDate($_POST['naissance']) and 
    Database::isValidDate($_POST['entree']))
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

    $r = '<form action="index.php?page=ajouterClub" method="post">
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

    $r = '<form action="index.php?page=ajouterEquipe" method="post">
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

  // Ajout d'un match

  static function addMatchDate()
  {
    $r = '<form action="index.php?page=ajouterMatchJoueur" method="post">
                <p> Entrez une date pour le match (AAAA-MM-JJ) : 
                 <input type="text" name="date" />
                </p>';

    $q = Database::query("Select c.Nom, e.Categorie, e.ID_Equipe from Club c, Equipe e where c.ID_Club = e.ID_Club");
    
    $r = $r . '<p> Club hôte :
                <select name="locaux">';

   $result = $q->fetchAll();
      
    foreach($result as $data)
      {
        $r = $r . '<option value="'. $data['Nom'].'_'.$data['Categorie'].'_'.$data['ID_Equipe'].'">'. $data['Nom'].' - '.$data['Categorie'] . '</option>';
      }
    
    $r = $r . '</select>';
    
    $r = $r . '</p> <p> Club visiteur :
                     <select name="visiteurs">';

    
        
    foreach($result as $data)
      { 
        $r = $r . '<option value="'. $data['Nom'].'_'.$data['Categorie'].'_'.$data['ID_Equipe'].'">'. $data['Nom'].' - '.$data['Categorie'] . '</option>';
      } 
    
    $r = $r . '</select>';
    
    $r = $r . '</p> <p> <input type="submit" value="Suivant" /> </p>';            
    
    return $r;
  }
  
  static function addMatchPlayer()
  {
	$r = '';
    if(isset($_POST['date']) and Database::isValidDate($_POST['date']))
      {        
        $locaux    = explode('_', $_POST['locaux']);
        $visiteurs = explode('_', $_POST['visiteurs']);
        $date      = $_POST['date'];

        if(($locaux[0] != $visiteurs[0]) and ($locaux[1] == $visiteurs[1]))
          {
            $q = Database::query('Select distinct m.ID_Membre, m.Nom, m.Prenom, j.Num_Licence, c.Nom as NomClub 
                                  From Membre m, Joueur j, Club c

                                  Where c.Nom in (\''.$locaux[0].'\',\''.$visiteurs[0].'\')
                                  and c.ID_Club = m.ID_Club
                                  and m.ID_Membre = j.ID_Membre
                                  and m.ID_Membre not in (Select m.ID_Membre
                                                          From Rencontre re, Rencontrer rr, Membre m
                                                          where re.Date_match = \''.$date.'\'
                                                          and re.ID_Rencontre = rr.ID_rencontre
                                                          and rr.ID_Membre = m.ID_Membre)

                                  Order by c.Nom');

            if($data = $q->fetch())
              {
                $nom_club = $data['NomClub'];
                
                $r = $r . '<form action="index.php?page=enregistrerMatch&id_hote='.$locaux[2].'&id_visiteur='.$visiteurs[2].'&date='.$date.'" method="post">
                       <p> Selection des joueurs de ' . $nom_club . ' : <br/>';

                do
                  {
                    $r = $r . '<input type="checkbox" name="joueurs_1[]" value="'.$data['ID_Membre'].'">'
                      . $data['Num_Licence'] . ' ' . $data['Nom'] . ' ' . $data['Prenom'] .'</input> <br/>';
                    
                  }while($data = $q->fetch() and $nom_club == $data['NomClub']);

                $nom_club = $data['NomClub'];

                if($data)
                  {
                    $r = $r . '</p> <p> Selection des joueurs de ' . $nom_club . ' : <br/>';
                    
                    do
                      {
                        $r = $r . '<input type="checkbox" name="joueurs_2[]" value="'.$data['ID_Membre'].'">'
                          . $data['Num_Licence'] . ' ' . $data['Nom'] . ' ' . $data['Prenom'] .'</input> <br/>';
                        
                      }while($data = $q->fetch() and $nom_club == $data['NomClub']);
                    
                    $r = $r . '<input type="submit" value="Suivant">';
                  }

                else
                  {
                    return "Pas de joueurs disponibles pour une des équipes.\n";
                  }
              }
            
            else
              {
                return "Pas de joueurs disponibles pour les deux équipes.\n";
              }
          }
        
        else
          {
            $r = "Problème selection équipe.\n";
          }
      }
    
    else if(isset($_POST['date']))
      {
        $r = "Date invalide ou manquante.\n";
      }
    
    return $r;
  }
  
  static function verifyMatch()
  {
    $id_hote = $_GET['id_hote'];
    $id_visiteur = $_GET['id_visiteur'];

    $date = $_GET['date'];

    if(isset($_POST['joueurs_1']) and isset($_POST['joueurs_2']))
      {
        $sql = "INSERT INTO Rencontre(ID_Rencontre, Date_match) VALUES (' ', '$date')";
        
        Database::query($sql);
        
        $id_rencontre = Database::lastId();

        $joueur_hote = $_POST['joueurs_1'];

        foreach($joueur_hote as $joueur)
          {
            $points = rand(0,50);
            $fautes = rand(0,5);

            $sql = "INSERT INTO Rencontrer(ID_Membre, ID_Rencontre, ID_Equipe, Points, Fautes) VALUES ('$joueur', '$id_rencontre', '$id_hote', '$points','$fautes')";

            Database::query($sql);
          }

        $joueur_visiteur = $_POST['joueurs_2'];

        foreach($joueur_visiteur as $joueur)
          {
            $points = rand(0,50);
            $fautes = rand(0,5);

            $sql = "INSERT INTO Rencontrer(ID_Membre, ID_Rencontre, ID_Equipe, Points, Fautes) VALUES ('$joueur', '$id_rencontre', '$id_visiteur', '$points','$fautes')";
            
            Database::query($sql);
          }

        return "Match enregistré.\n";
        
      }

    else
      {
        return "Pas de joueurs sélectionnés.\n";
      }
  }
}

?>