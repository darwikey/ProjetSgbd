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

  public static function lastId()
  {
    return self::$bdd->lastInsertId();
  }

  static function isValidDate($date)
  {
    if(preg_match("#[0-9]{4}-[0-9]{2}-[0-9]{2}#", $date))
      {
        $cut = explode('-', $date);
                
        return checkdate($cut[1], $cut[2], $cut[0]);
      }
        
    return false;
  }
}
?>