SELECT c.Nom,
SUM(e.Points > t.Total/2) AS gagne,
SUM(e.Points = t.Total/2) AS egual,
SUM(e.Points < t.Total/2) AS perdu
FROM ((SELECT ID_Rencontre, e1.*,
        SUM(r1.Points) AS Points
	FROM Equipe e1, Rencontrer r1
	WHERE e1.ID_Equipe = r1.ID_Equipe
	GROUP BY r1.ID_Rencontre, e1.ID_Equipe) e 
                
	INNER JOIN (SELECT ID_Rencontre,
  	       	   SUM(r1.Points) as Total
		   FROM Rencontrer r1
		   GROUP BY r1.ID_Rencontre) t
                   ON e.ID_Rencontre = t.ID_Rencontre)
 
INNER JOIN Club c
ON e.ID_Club = c.ID_Club
WHERE e.Categorie = \'' . $_POST['categorie'] . '\'
GROUP BY e.ID_Equipe
ORDER BY gagne DESC, egual DESC, perdu DESC
