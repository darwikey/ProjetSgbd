-- requete prenant en parametre une date

Select m.Nom, m.Prenom,
sum(r.Points) as MoyennePoints
				
From Membre m, Joueur j, Rencontrer r, Rencontre a, Equipe e
Where m.ID_Membre = j.ID_Membre
and r.ID_Membre = m.ID_Membre
and a.ID_Rencontre = r.ID_Rencontre
and a.Date_Match = $date 
and e.Categorie = $data1['Categorie'] 
and e.ID_Equipe = r.ID_Equipe
Group by j.ID_Membre
Order by MoyennePoints DESC
