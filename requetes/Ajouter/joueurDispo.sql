SELECT DISTINCT m.ID_Membre, m.Nom, m.Prenom, j.Num_Licence, c.Nom AS NomClub 

FROM (Joueur j 
      INNER JOIN Membre m
      ON m.ID_Membre = j.ID_Membre)
     INNER JOIN Club c
     ON m.ID_Club = c.ID_Club

WHERE c.Nom IN (\''.$locaux[0].'\',\''.$visiteurs[0].'\')
AND m.ID_Membre NOT IN (SELECT m.ID_Membre
                        FROM (Rencontre re
                              INNER JOIN  Rencontrer rr
                              ON re.ID_Rencontre = rr.ID_Rencontre)
                             INNER JOIN Membre m
                             ON rr.ID_Membre = m.ID_Membre
                        WHERE re.Date_match = \''.$date.'\')

ORDER BY c.Nom
