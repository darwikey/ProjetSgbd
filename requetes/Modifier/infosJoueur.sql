-- requete prenant en parametre l'ID d'un membre

SELECT r.Activite, m.*, j.Date_Naissance, j.Adresse,

       (SELECT COUNT(*) 
        FROM Entraineur e1
        WHERE e1.ID_Membre = $choosen_one) AS entraine,

       (SELECT COUNT(*)
        FROM Joueur j1
        WHERE j1.ID_Membre = $choosen_one) AS joue,

       (SELECT COUNT(*)
        FROM Responsable r1
        WHERE r1.ID_Membre = $choosen_one) AS gere

FROM (Membre m 
      INNER JOIN Joueur j
      ON j.ID_Membre = m.ID_Membre)
     LEFT OUTER JOIN Responsable r
     ON r.ID_Membre = $choosen_one
WHERE m.ID_Membre = $choosen_one
