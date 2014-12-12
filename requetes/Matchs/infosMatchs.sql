SELECT DISTINCT rr.ID_Equipe, c.Nom, e.Categorie, re.Date_match, re.ID_Rencontre,
SUM(rr.Points) AS points, 
SUM(rr.Fautes) AS fautes 
		                      
FROM ((Club c
  INNER JOIN Equipe e
  ON e.ID_Club = c.ID_Club) 
 INNER JOIN Rencontrer rr
 ON e.ID_Equipe = rr.ID_Equipe)
INNER JOIN Rencontre re
ON re.ID_Rencontre = rr.ID_Rencontre

GROUP BY e.ID_Equipe, rr.ID_Rencontre
ORDER BY re.Date_match, re.ID_Rencontre, points DESC
