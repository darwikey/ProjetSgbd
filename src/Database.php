
<?php
class Database
{
	private static $bdd;
	
	public static function init()
	{
		try 
		{
			self::$bdd = new PDO('mysql:host=localhost;dbname=basketball', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
		catch (Exception $e)
		{
			die('Erreur :' . $e->getMessage());
		}
	}

	public static function query($sql)
	{
		return self::$bdd->query($sql);
	}

}
?>