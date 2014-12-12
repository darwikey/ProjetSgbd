Select c.Nom, c.Ville, c.ID_Club,
       (Select count(*) 
       From Equipe e
       Where c.ID_Club = e.ID_Club) as NombreEquipe,
       (Select count(*) 
       From Joueur j, Membre m
       Where c.ID_Club = m.ID_Club
       and m.ID_Membre = j.ID_Membre) as NombreJoueur
From Club c

