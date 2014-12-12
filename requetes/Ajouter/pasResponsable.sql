SELECT m.ID_Membre, m.Nom, m.Prenom 

FROM Membre m

WHERE NOT EXISTS (SELECT r.ID_Membre 
                  FROM Responsable r 
                  WHERE m.ID_Membre = r.ID_Membre)'
