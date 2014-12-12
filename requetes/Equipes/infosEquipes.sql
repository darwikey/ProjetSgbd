Select c.Nom, e.Categorie,
SUM(e.Points > t.Total/2) as gagne,
SUM(e.Points = t.Total/2) as egual,
SUM(e.Points < t.Total/2) as perdu

From
	(Select ID_Rencontre, e1.*,
	SUM(r1.Points) as Points
	From Equipe e1, Rencontrer r1
	Where e1.ID_Equipe = r1.ID_Equipe
	Group by r1.ID_Rencontre, e1.ID_Equipe) e,
	(Select ID_Rencontre,
	SUM(r1.Points) as Total
	From Rencontrer r1
	Group by r1.ID_Rencontre) t,
			
	Club c

Where e.ID_Rencontre = t.ID_Rencontre
and e.ID_Club = c.ID_Club
Group by e.ID_Equipe
rder by c.Nom, gagne DESC, egual DESC, perdu DESC');
        
