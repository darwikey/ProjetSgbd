<?php

date_default_timezone_set('UTC');

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
    $q = Database::query('SELECT Nom, ID_Club FROM Club');

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
          $r = $r . '<option value="' . $data['ID_Club'];
          $r = $r . '">' . $data['Nom'] . '</option>';
        }

      $r = $r . '</select> </p>';
      
      $r = $r . '<p> Activité : <br/>
                  <input type="checkbox" name="activite[]" value="Entraineur">Entraineur <br/>
                  <input type="checkbox" name="activite[]" value="Joueur">Joueur <br/>                
                  <input type="checkbox" name="activite[]" value="Responsable">Responsable <br/>
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
    if(Database::isValidDate($_POST['naissance']) and Database::isValidDate($_POST['entree']))
      {
        if($_POST['nom'] != '' and $_POST['prenom'] != '' and isset($_POST['activite']))
          {
            $id_club = $_POST['club'];
            $nom     = strip_tags($_POST['nom']);
            $prenom  = strip_tags($_POST['prenom']);
            $entree  = $_POST['entree'];
            
            $sql = "INSERT INTO Membre(ID_Membre, ID_Club, Nom, Prenom, Date_Entree) VALUES ('','$id_club', '$nom', '$prenom', '$entree')";
            Database::query($sql);

            $id_membre = Database::lastId();

            // Insertion dans la table Entraineur
            if(in_array("Entraineur", $_POST['activite']))
              {
                $sql = "INSERT INTO Entraineur(ID_Membre) VALUES ('$id_membre')";
                Database::query($sql);
              }
              
            // Insertion dans la table Joueur
            if(in_array("Joueur", $_POST['activite']))
              {
                $naissance = $_POST['naissance'];

                if($_POST['adresse'] == '')
                  {
                    $adresse = NULL;
                  }

                else
                  {
                    $adresse = $_POST['adresse'];
                  }

                $sql = "INSERT INTO Joueur(Num_Licence, ID_Membre, Date_Naissance, Adresse) VALUES ('','$id_membre','$naissance','$adresse')";
                Database::query($sql);
              }
                        
            // Insertion dans la table Responsable
            if(in_array("Responsable", $_POST['activite']))
              {

                // Verifie que le poste n'est pas déjà occupé
                $q = Database::query('SELECT Activite
                                      FROM   Responsable r INNER JOIN Membre m
                                             ON r.ID_Membre = m.ID_Membre
                                      WHERE  m.ID_Club = ' . $id_club . '
                                      AND    Activite = \'' . $_POST['role'] . '\'');

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
    // Obtenir les personnes n'ayant pas de rôles de responsable
    $q = Database::query('SELECT m.ID_Membre, m.Nom, m.Prenom 
                          FROM Membre m
                          WHERE NOT EXISTS (SELECT r.ID_Membre 
                                            FROM Responsable r 
                                            WHERE m.ID_Membre = r.ID_Membre)');

    $r = '<form action="index.php?page=ajouterClub" method="post">
               <p> Entrez le nom : 
                <input type="text" name="nom" /> </p>
               <p> Entrez la ville :
                <input type="text" name="ville" /> </p>
               <p> Choisissez un président : 
                <select name="president">';

    while($data = $q->fetch())
      {
        $r = $r . '<option value="'.$data['ID_Membre'].'">';
        $r = $r . $data['ID_Membre'] . ' ' . $data['Nom'] . ' ' . $data['Prenom'] . '</option>';          
      }
      
    $r = $r . '</p> <p> <input type="submit" value="Enregistrer" /> </p>';
      
    return $r;
  }

  static function verifyClub()
  {
    if(isset($_POST['nom']) and isset($_POST['ville']))
      {
        $nom       = $_POST['nom'];
        $ville     = $_POST['ville'];
        $president = $_POST['president'];
        
        $sql = "INSERT INTO Club(ID_Club, Nom, Ville) VALUES ('','$nom','$ville')";
        Database::query($sql);
        
        // Recupere l'ID du club ajouté à la table Club
        $id_club = Database::lastId();

        $date = getdate();
        $date_formatee = $date['year'].'-'.$date['mon'].'-'.$date['mday'];

        $sql = "UPDATE Membre SET ID_Club='$id_club', Date_Entree='$date_formatee' WHERE ID_Membre='$president'";
        Database::query($sql);

        $sql = "INSERT INTO Responsable(ID_Membre, Activite) VALUES ('$president', 'President')";
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
    $q = Database::query('SELECT Nom, ID_Club FROM Club');

    $r = '<form action="index.php?page=ajouterEquipe" method="post">
               <p> Choisissez le club : 
                <select name="club">';

    while($data = $q->fetch())
      {
        $r = $r . '<option value="'.$data['ID_Club'].'">';
        $r = $r . $data['ID_Club'].' '.$data['Nom'].'</option>';
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
    $club = $_POST['club'];

    $sql = "INSERT INTO Equipe(ID_Equipe, Categorie, ID_Club) VALUES ('', '$categorie', '$club')";
    Database::query($sql);

    return "Equipe ajoutée avec succés.\n";
  }

  /*
    Ajout d'un match
  */

  static function addMatchDate()
  {
    $r = '<form action="index.php?page=ajouterMatchJoueur" method="post">
                <p> Entrez une date pour le match (AAAA-MM-JJ) : 
                 <input type="text" name="date" />
                </p>';

    $q = Database::query("SELECT c.Nom, e.Categorie, e.ID_Equipe FROM Club c, Equipe e WHERE c.ID_Club = e.ID_Club");
    
    $r = $r . '<p> Club hôte :
                <select name="locaux">';

    $result = $q->fetchAll();
      
    foreach($result as $data)
      {
        $r = $r . '<option value="'.$data['Nom'].'_'.$data['Categorie'].'_'.$data['ID_Equipe'].'">';
        $r = $r . $data['Nom'].' - '.$data['Categorie'].'</option>';
      }
    
    $r = $r . '</select>';
    
    $r = $r . '</p> <p> Club visiteur :
                     <select name="visiteurs">';
        
    foreach($result as $data)
      { 
        $r = $r . '<option value="'.$data['Nom'].'_'.$data['Categorie'].'_'.$data['ID_Equipe'].'">';
        $r = $r . $data['Nom'].' - '.$data['Categorie'].'</option>';
      } 
    
    $r = $r . '</select></p>';
    
    $r = $r . '<p><input type="submit" value="Suivant" /></p>';            
    
    return $r . '</form>';
  }
  
  static function addMatchPlayer()
  {
	$r = '';

    if(isset($_POST['date']) and Database::isValidDate($_POST['date']))
      {        
        $locaux    = explode('_', $_POST['locaux']);
        $visiteurs = explode('_', $_POST['visiteurs']);
        $date      = $_POST['date'];

        // Equipe de clubs différents mais de même catégorie ?
        if(($locaux[0] != $visiteurs[0]) and ($locaux[1] == $visiteurs[1]))
          {
            $q = Database::query('SELECT DISTINCT m.ID_Membre, m.Nom, m.Prenom, j.Num_Licence, c.Nom AS NomClub 

                                  FROM (Joueur j 
                                        INNER JOIN Membre m
                                        ON m.ID_Membre = j.ID_Membre)
                                       INNER JOIN Club c
                                       ON m.ID_Club = c.ID_Club

                                  WHERE c.Nom IN (\''.$locaux[0].'\',\''.$visiteurs[0].'\')

                                  AND m.ID_Membre NOT IN (SELECT m.ID_Membre

                                                          FROM (Rencontre re
                                                                INNER JOIN  Rencontrer rr
                                                                ON re.ID_Rencontre = rr.ID_Rencontre)
                                                               INNER JOIN Membre m
                                                               ON rr.ID_Membre = m.ID_Membre

                                                           WHERE re.Date_match = \''.$date.'\')

                                  ORDER BY c.Nom');

            if($data = $q->fetch())
              {
                $nom_club = $data['NomClub'];
                
                $r = $r . '<form action="index.php?page=enregistrerMatch';
                $r = $r .  '&id_hote='.$locaux[2].'&id_visiteur='.$visiteurs[2].'&date='.$date.'" method="post">';

                $r = $r . '<p> Selection des joueurs de '.$nom_club.' : <br/>';

                do
                  {
                    $r = $r . '<input type="checkbox" name="joueurs_1[]" value="'.$data['ID_Membre'].'">';
                    $r = $r . $data['Num_Licence'].' '.$data['Nom'].' '.$data['Prenom'].'</input> <br/>';
                    
                  }while($data = $q->fetch() and $nom_club == $data['NomClub']);

                $nom_club = $data['NomClub'];
                
                if($data)
                  {
                    $r = $r . '</p> <p> Selection des joueurs de '. $nom_club.' : <br/>';
                    
                    do
                      {
                        $r = $r . '<input type="checkbox" name="joueurs_2[]" value="'.$data['ID_Membre'].'">';
                        $r = $r . $data['Num_Licence'].' '.$data['Nom'].' '.$data['Prenom'].'</input> <br/>';
                        
                      }while($data = $q->fetch() and $nom_club == $data['NomClub']);
                    
                    $r = $r . '<input type="submit" value="Suivant">';
                  }

                else
                  {
                    $r = "Pas de joueurs disponibles pour une des équipes.\n";
                  }
              }
            
            else
              {
                $r = "Pas de joueurs disponibles pour les deux équipes.\n";
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
    
    return $r . '</form>';
  }
  
  static function verifyMatch()
  {
    $id_hote     = $_GET['id_hote'];
    $id_visiteur = $_GET['id_visiteur'];
    $date        = $_GET['date'];

    if(isset($_POST['joueurs_1']) and isset($_POST['joueurs_2']))
      {
        $sql = "INSERT INTO Rencontre(ID_Rencontre, Date_match) VALUES (' ', '$date')";
        Database::query($sql);
        
        $id_rencontre = Database::lastId();
        
        $joueur_hote = $_POST['joueurs_1'];
        
        foreach($joueur_hote as $joueur)
          {
            $points = rand(0,rand(0,50));
            $fautes = rand(0,rand(0,5));
            
            $sql = "INSERT INTO Rencontrer(ID_Membre, ID_Rencontre, ID_Equipe, Points, Fautes) VALUES ('$joueur', '$id_rencontre', '$id_hote', '$points','$fautes')";

            Database::query($sql);
          }

        $joueur_visiteur = $_POST['joueurs_2'];

        foreach($joueur_visiteur as $joueur)
          {
            $points = rand(0,rand(0,50));
            $fautes = rand(0,rand(0,5));
            
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