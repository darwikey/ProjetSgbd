SELECT Activite

FROM   Responsable r INNER JOIN Membre m
       ON r.ID_Membre = m.ID_Membre

WHERE  m.ID_Club = $id_club
AND    Activite = $_POST['role']
