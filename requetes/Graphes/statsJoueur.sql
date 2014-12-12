-- requete prenant en parametre l'ID d'un joueur et l'annee souhaitée

Select Month(Date_Match) AS mois,
Sum(r.Points) as PointsMois,
Sum(r.Fautes) as FautesMois,
sum((Select sum(r1.Points)
	From Rencontrer r1
    Where r1.ID_Rencontre = r.ID_Rencontre
    and r1.ID_Equipe = r.ID_Equipe)
    >
    (Select sum(r1.Points)
	From Rencontrer r1
    Where r1.ID_Rencontre = r.ID_Rencontre)/2) as Gagne,
    
count(r.ID_Rencontre) as NombreMatch

From Joueur j, Rencontrer r, Rencontre a
Where j.ID_Membre ='$idJoueur' 
and j.ID_Membre = r.ID_Membre
and r.ID_Rencontre = a.ID_Rencontre
And Year(Date_Match) ='$annee' 
Group by mois 
Order by mois ASC
