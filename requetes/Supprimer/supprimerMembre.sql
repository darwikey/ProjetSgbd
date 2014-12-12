-- requete prenant en parametre l'ID d'un membre

Delete From Responsable Where ID_Membre = $id_membre;
Delete From Entraineur Where ID_Membre= $id_membre;
Delete From Rencontrer Where ID_Membre= $id_membre;
Delete From Joueur Where ID_Membre = $id_membre;
Delete From Membre Where ID_Membre = $id_membre;