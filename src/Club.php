<?php

include_once('Database.php');


function getListClub()
{
	$q = Database::query('Select * from Club');
	$r = '';
	
	while ($data = $q->fetch())
	{
	
		$r = $r . '<p> <h1> Club ' . $data['ID_Club']
		.':</h1>'
		.'Ville : ' . $data['Ville'] .
		'</p>';

	}

	$q->closeCursor();
	
	return $r;
}

?>