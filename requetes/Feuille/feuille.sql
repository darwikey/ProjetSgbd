Select c.Nom as Nom_Club, e.Categorie, m.Nom, m.Prenom, r0.Points, r0.Fautes, 

       r0.Points = (Select max(Points) 
		From Rencontrer r
		Where r.ID_Rencontre = r0.ID_Rencontre
		and r.ID_Equipe = r0.ID_Equipe
		) as MeilleurJoueur,

	r0.Fautes = (Select max(Fautes) 
		From Rencontrer r
		Where r.ID_Rencontre = r0.ID_Rencontre
		and r.ID_Equipe = r0.ID_Equipe
		) as PireJoueur 
								
From (
(
 (
  (Rencontrer r0 inner join Equipe e
   On e.ID_Equipe = r0.ID_Equipe) 
  inner join Club c            
  On e.ID_Club = c.ID_Club) 
 inner join Membre m
 On r0.ID_Membre = m.ID_Membre) 
inner join Joueur j
On m.ID_Membre = j.ID_Membre)

Where r0.ID_Rencontre = ' . $id_rencontre . '

Order by Nom_Club, Points DESC, Fautes ASC'
