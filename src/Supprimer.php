<?php

include_once('Database.php');

class Supprimer
{
	static function getPage()
	{
		$r = '';
		
		if (isset($_POST['choix']))
		{
			Supprimer::deleteMembre($_POST['choix']);
			$r = '<h2>Membre supprimé</h2>';
		}
	
		$joueur = Database::query("Select ID_Membre, Nom, Prenom 
			From Membre");
	
		$r = $r . '<form action="index.php?page=supprimer" method="post">
               <p> Qui voulez-vous supprimer ?
                <select name="choix">';

		while($data = $joueur->fetch())
		{
			$nom_joueur     = $data['Nom'];
			$prenom_joueur  = $data['Prenom'];
			$id_membre      = $data['ID_Membre'];

			$r = $r . '<option value="'.$id_membre.'">' . $id_membre . ' ' . $nom_joueur . ' ' . $prenom_joueur . '</option>';
		}
			
        $r = $r . '<input type="submit" value="Supprimer"> </p> </form>';
		
		return $r;	
	}
	

	static function deleteMembre($id_membre)
	{
		Database::query('Delete From Responsable Where ID_Membre=' . $id_membre
		. ';Delete From Entraineur Where ID_Membre=' . $id_membre
		. ';Delete From Rencontrer Where ID_Membre=' . $id_membre
		. ';Delete From Joueur Where ID_Membre=' . $id_membre
		. ';Delete From Membre Where ID_Membre=' . $id_membre);		
	}
}
?>