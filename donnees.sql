-- ============================================================
--    Suppression des donnees
-- ============================================================

delete from Membre;
delete from Entraineur;
delete from Joueur;
delete from Club;
delete from Responsable;
delete from Rencontre;
delete from Equipe;
delete from Rencontrer;
delete from Sentrainer;
delete from Entrainer;

-- ============================================================
--    Creation des donnees
-- ============================================================

-- Membre

insert into Membre values (1  ,'Philippi'  ,'Alexandre'  ,'01-SEP-2012');
insert into Membre values (2  ,'Paillassa' ,'Maxime'     ,'15-JAN-2011');
insert into Membre values (3  ,'Maupeu'    ,'Xavier'     ,'12-MAR-2010');
insert into Membre values (4  ,'Adotevi'   ,'Lionel'     ,'11-SEP-2012');
insert into Membre values (5  ,'Angeletti' ,'Isabelle'   ,'21-OCT-2011');
insert into Membre values (6  ,'Apery'     ,'Celine'     ,'15-NOV-2012');
insert into Membre values (7  ,'Boudjeltia','Reda'       ,'14-SEP-2012');
insert into Membre values (8  ,'Chabot'    ,'Romain'     ,'30-OCT-2012');
insert into Membre values (9  ,'Carrie'    ,'Mathieu'    ,'25-APR-2010');
insert into Membre values (10 ,'Cidere'    ,'Laurent'    ,'15-MAY-2012');
insert into Membre values (11 ,'Cleriot'   ,'Simon'      ,'24-MAR-2009');
insert into Membre values (12 ,'Devoir'    ,'Loic'       ,'13-JAN-2012');
insert into Membre values (13 ,'Dury'      ,'Victor'     ,'01-SEP-2008');
insert into Membre values (14 ,'Nizet'     ,'Aurélien'   ,'15-DEC-2011');
insert into Membre values (15 ,'Sabir'     ,'Reda'       ,'24-JUN-2009');
insert into Membre values (16 ,'Zouad'     ,'Lotfi'      ,'30-OCT-2012');
insert into Membre values (17 ,'Fiot'      ,'Arthur'     ,'01-SEP-2012');
insert into Membre values (18 ,'Gaulon'    ,'Pierre'     ,'01-SEP-2012');
insert into Membre values (19 ,'Patrone'   ,'Agnés'      ,'11-SEP-2012');
insert into Membre values (20 ,'Zouari'    ,'Firas'      ,'11-JUN-2010');

-- Entraineur

insert into Entraineur values (1);

insert into Entraineur values (6);

insert into Entraineur values (11);

insert into Entraineur values (16);

-- Joueur

-- Gryffondor
insert into Joueur values (1,  1,  '09-JUN-1993');
insert into Joueur values (2,  2,  '08-SEP-1993');
insert into Joueur values (3,  3,  '19-JAN-1989');
insert into Joueur values (4,  4,  '21-JUL-1987');
insert into Joueur values (5,  5,  '20-OCT-1975');

-- Serpentard
insert into Joueur values (6,  6,  '21-APR-1993');
insert into Joueur values (7,  7,  '24-DEC-1990');
insert into Joueur values (8,  8,  '01-APR-1992');
insert into Joueur values (9,  9,  '25-FEB-1979');
insert into Joueur values (10, 10, '15-JUN-1995');

-- Poufsouffle
insert into Joueur values (11, 11, '14-AUG-1987');
insert into Joueur values (12, 12, '24-MAY-1993');
insert into Joueur values (13, 13, '17-JUN-1993');
insert into Joueur values (14, 14, '09-JUN-1993');
insert into Joueur values (15, 15, '08-SEP-1993');

-- Serdaigle
insert into Joueur values (16, 16, '17-MAR-1986');
insert into Joueur values (17, 17, '18-NOV-1994');
insert into Joueur values (18, 18, '25-MAR-1994');
insert into Joueur values (19, 19, '22-JUN-1993');
insert into Joueur values (20, 20, '17-FEB-1991');

-- Club

insert into Club values (1, 'Gryffondor',  'Bordeaux');
insert into Club values (2, 'Serpentard',  'Paris');
insert into Club values (3, 'Poufsouffle', 'Marseille');
insert into Club values (4, 'Serdaigle',   'Grenoble');

-- Responsable

insert into Responsable values (1,  'President', 1);
insert into Responsable values (6,  'President', 2);
insert into Responsable values (11, 'President', 3);
insert into Responsable values (16, 'President', 4);

-- Rencontre

-- Gryffondor - Serpentard
insert into Rencontre values (1,  '04-OCT-2014');

-- Gryffondor - Poufsouffle
insert into Rencontre values (2,  '11-OCT-2014');

-- Gryffondor - Serdaigle
insert into Rencontre values (3,  '18-OCT-2014');

-- Serpentard - Poufsouffle
insert into Rencontre values (4,  '25-OCT-2014');

-- Serpentard - Serdaigle
insert into Rencontre values (5,  '01-NOV-2014');

-- Poufsouffle - Serdaigle
insert into Rencontre values (6,  '08-NOV-2014');

-- Equipe

insert into equipe values (1, 'Senior', 1);
insert into equipe values (2, 'Senior', 2);
insert into equipe values (3, 'Senior', 3);
insert into equipe values (4, 'Senior', 4);

-- Rencontrer

-- Rencontre 1
insert into Rencontrer values (1,  1, 1, 20, 3);
insert into Rencontrer values (2,  1, 1, 15, 0);
insert into Rencontrer values (3,  1, 1, 0,  1);
insert into Rencontrer values (4,  1, 1, 2,  0);
insert into Rencontrer values (5,  1, 1, 0,  0);

insert into Rencontrer values (6,  1, 2, 5,  3);
insert into Rencontrer values (7,  1, 2, 0,  1);
insert into Rencontrer values (8,  1, 2, 0,  1);
insert into Rencontrer values (9,  1, 2, 12, 3);
insert into Rencontrer values (10, 1, 2, 1,  3);

-- Rencontre 2
insert into Rencontrer values (1,  2, 1, 14, 1);
insert into Rencontrer values (2,  2, 1, 17, 0);
insert into Rencontrer values (3,  2, 1, 0,  1);
insert into Rencontrer values (4,  2, 1, 0,  0);
insert into Rencontrer values (5,  2, 1, 0,  0);

insert into Rencontrer values (11, 2, 3, 3,  0);
insert into Rencontrer values (12, 2, 3, 5,  0);
insert into Rencontrer values (13, 2, 3, 10, 0);
insert into Rencontrer values (14, 2, 3, 12, 0);
insert into Rencontrer values (15, 2, 3, 5,  1);

-- Rencontre 3
insert into Rencontrer values (1,  3, 1, 22, 1);
insert into Rencontrer values (2,  3, 1, 4,  0);
insert into Rencontrer values (3,  3, 1, 2,  1);
insert into Rencontrer values (4,  3, 1, 0,  0);
insert into Rencontrer values (5,  3, 1, 8,  3);

insert into Rencontrer values (16, 3, 4, 5,  0);
insert into Rencontrer values (17, 3, 4, 1,  2);
insert into Rencontrer values (18, 3, 4, 17, 0);
insert into Rencontrer values (19, 3, 4, 0,  0);
insert into Rencontrer values (20, 3, 4, 3,  1);

-- Rencontre 4

insert into Rencontrer values (6,  4, 2, 22, 1);
insert into Rencontrer values (7,  4, 2, 4,  3);
insert into Rencontrer values (8,  4, 2, 17, 1);
insert into Rencontrer values (9,  4, 2, 20, 3);
insert into Rencontrer values (10, 4, 2, 8,  3);

insert into Rencontrer values (11, 4, 3, 5,  0);
insert into Rencontrer values (12, 4, 3, 1,  1);
insert into Rencontrer values (13, 4, 3, 5,  0);
insert into Rencontrer values (14, 4, 3, 0,  0);
insert into Rencontrer values (15, 4, 3, 3,  1);

-- Rencontre 5
insert into Rencontrer values (6,  5, 2, 10, 4);
insert into Rencontrer values (7,  5, 2, 12, 3);
insert into Rencontrer values (8,  5, 2, 2,  2);
insert into Rencontrer values (9,  5, 2, 18, 4);
insert into Rencontrer values (10, 5, 2, 17, 4);

insert into Rencontrer values (16, 5, 4, 3,  1);
insert into Rencontrer values (17, 5, 4, 11, 0);
insert into Rencontrer values (18, 5, 4, 10, 4);
insert into Rencontrer values (19, 5, 4, 7,  1);
insert into Rencontrer values (20, 5, 4, 9,  3);

-- Rencontre 6
insert into Rencontrer values (11, 6, 3, 9,  1);
insert into Rencontrer values (12, 6, 3, 2,  0);
insert into Rencontrer values (13, 6, 3, 17, 4);
insert into Rencontrer values (14, 6, 3, 8,  3);
insert into Rencontrer values (15, 6, 3, 3,  1);

insert into Rencontrer values (16, 6, 4, 6,  2);
insert into Rencontrer values (17, 6, 4, 18, 2);
insert into Rencontrer values (18, 6, 4, 3,  2);
insert into Rencontrer values (19, 6, 4, 11, 0);
insert into Rencontrer values (20, 6, 4, 1,  3);



-- Sentrainer

-- Entrainer
