<?php 
include_once('Database.php');
include_once('Club.php');
include_once('Equipe.php');
include_once('Joueur.php');
include_once('Match.php');
include_once('Consultation.php');
include_once('Ajouter.php');
include_once('Feuille.php');
include_once('Modifier.php');
include_once('Supprimer.php');


function main()
{
  // Init Database
  Database::init();

  if (isset($_GET['page']))
	{
      if ($_GET['page'] == 'club')
		{
          echo Club::getList();
		}
      else if ($_GET['page'] == 'equipe')
		{
          echo Equipe::whichInformation();
		}
      else if ($_GET['page'] == 'joueur')
		{
          echo Joueur::getList();
		}
      else if ($_GET['page'] == 'match')
		{
          echo Match::whichInformation();
		}
      else if ($_GET['page'] == 'consultation')
		{
          echo Consultation::getPage();
		}
      else if ($_GET['page'] == 'ajouter')
		{
          echo Ajouter::getPage();
		}
      else if ($_GET['page'] == 'ajouterMembre')
		{
          echo Ajouter::verifyMembre();
		}
      else if ($_GET['page'] == 'ajouterClub')
		{
          echo Ajouter::verifyClub();
		}
      else if ($_GET['page'] == 'ajouterEquipe')
		{
          echo Ajouter::verifyEquipe();
		}
      else if ($_GET['page'] == 'ajouterMatchJoueur')
		{
          echo Ajouter::addMatchPlayer();
		}
      else if ($_GET['page'] == 'enregistrerMatch')
		{
          echo Ajouter::verifyMatch();
		}
      else if ($_GET['page'] == 'feuille')
        {
          echo Feuille::getFeuilleMatch($_GET['rencontre']);
        }
      else if ($_GET['page'] == 'modifier')
        {
          echo Modifier::getPage();
        }
      else if ($_GET['page'] == 'modifierMembre')
        {
          echo Modifier::modifyMembre();
        }
      else if ($_GET['page'] == 'modifierMembreInformation')
        {
          echo Modifier::modifyMembreInformation();
        }
      else if ($_GET['page'] == 'modifierMembreSauvegarde')
        {
          echo Modifier::modifyMembreSave();
        }
	  else if ($_GET['page'] == 'supprimer')
        {
          echo Supprimer::getPage();
        }
      else
		{
          echo getFirstPage();
		}
	}
  else
	{
      echo getFirstPage();
	}
}

// Première page du site
function getFirstPage()
{
  return '<div style="text-align: center"><img src="img/basket-manager.jpg" width=1000/></div>';
}

?>
