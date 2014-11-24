<?php 
include_once('Database.php');
include_once('Club.php');
include_once('Equipe.php');
include_once('Joueur.php');
include_once('Match.php');

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
	return 'machin';
}

?>




