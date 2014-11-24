<?php

include_once('Database.php');


class Match 
{
	static function getList()
	{
		$q = Database::query('Select * from Rencontre');
		$r = '';
		
		while ($data = $q->fetch())
		{
		
			$r = $r . '<p> <h2> Match ' . $data['ID'] .':</h2><ul>'
			
			. '</ul></p>';

		}

		$q->closeCursor();
		
		return $r;
	}
}

?>