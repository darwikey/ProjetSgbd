<?php

include_once('Database.php');


class Club 
{
	static function getList()
	{
		$q = Database::query('Select * from Club');
		$r = '';
		
		while ($data = $q->fetch())
		{
		
			$r = $r . '<p> <h2> Club ' . $data['ID'] .':</h2>'
			.'Ville : ' . $data['Ville'] .
			'</p>';

		}

		$q->closeCursor();
		
		return $r;
	}
}

?>