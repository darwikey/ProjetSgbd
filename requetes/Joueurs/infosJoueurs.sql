SELECT c.Nom AS Nom_Club, 
       m.Date_Entree, m.Nom, m.Prenom, 
       j.Adresse, j.Date_Naissance, j.ID_Membre, j.Num_Licence,
       AVG(rr.Points) AS MoyennePoints,
       STD(rr.Points) AS EcartTypePoints,
       AVG(rr.Fautes) AS MoyenneFautes,
       STD(rr.Fautes) AS EcartTypeFautes

       FROM (((Membre m 
    INNER JOIN Joueur j
    ON m.ID_Membre = j.ID_Membre) 
   INNER JOIN Rencontrer rr
   ON rr.ID_Membre = m.ID_Membre)
 INNER JOIN Club c
 ON c.ID_Club = m.ID_Club)
INNER JOIN Rencontre re
ON re.ID_Rencontre = rr.ID_Rencontre

WHERE YEAR(re.Date_match) = YEAR(NOW())
GROUP BY c.Nom, j.ID_Membre			
