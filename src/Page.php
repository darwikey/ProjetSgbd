<?php 
include_once('Database.php');
include_once('Club.php');
include_once('Equipe.php');
include_once('Joueur.php');
include_once('Match.php');
include_once('Statistique.php');
include_once('Ajouter.php');

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
          echo Equipe::getList();
		}
      else if ($_GET['page'] == 'joueur')
		{
          echo Joueur::getList();
		}
      else if ($_GET['page'] == 'match')
		{
          echo Match::getList();
		}
      else if ($_GET['page'] == 'statistique')
		{
          echo Statistique::getPage();
		}
      else if ($_GET['page'] == 'ajouter')
		{
          echo Ajouter::getPage();
		}
      else if ($_GET['page'] == 'ajouterMembre')
		{
          echo Ajouter::verifyMembre();
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


function getFirstPage()
{
  return '<div style="text-align: center"><img src="img/basket-manager.jpg" width=1000/></div>';
}

?>




