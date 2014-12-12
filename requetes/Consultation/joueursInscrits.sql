-- requete prenant en parametre une date

Select * 
From Membre m, Joueur j 
Where j.ID_Membre = m.ID_Membre
and m.Date_Entree <= $date
