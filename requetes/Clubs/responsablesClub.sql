-- requete prenant en parametre l'ID d'un club

Select * 
From Membre m, Responsable r 
Where m.ID_Club = $idClub 
and m.ID_Membre = r.ID_Membre
