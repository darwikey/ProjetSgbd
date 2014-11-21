<?php 
include_once('Database.php');
include_once('Club.php');


function main()
{
	// Init Database
	Database::init();

	if (isset($_GET['page']))
	{
		if ($_GET['page'] == 'club')
		{
			echo getListClub();
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




