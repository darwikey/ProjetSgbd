-- ============================================================
--    Suppression des donnees
-- ============================================================

delete from Rencontrer;
delete from Rencontre;
delete from Joueur;
delete from Entraineur;
delete from Responsable;
delete from Equipe;
delete from Club;
delete from Membre;

-- ============================================================
--    Creation des donnees
-- ============================================================

-- Club

insert into Club values (1, 'Gryffondor',  'Bordeaux');
insert into Club values (2, 'Serpentard',  'Paris');
insert into Club values (3, 'Poufsouffle', 'Marseille');
insert into Club values (4, 'Serdaigle',   'Grenoble');

-- Equipe

insert into Equipe values (1, 'Senior', 1);
insert into Equipe values (2, 'Senior', 2);
insert into Equipe values (3, 'Senior', 3);
insert into Equipe values (4, 'Senior', 4);

-- Membre

insert into Membre values (1,  1  ,'Philippi'  ,'Alexandre'  ,'2012-09-01');
insert into Membre values (2,  1  ,'Paillassa' ,'Maxime'     ,'2011-01-15');
insert into Membre values (3,  1  ,'Maupeu'    ,'Xavier'     ,'2010-03-12');
insert into Membre values (4,  1  ,'Adotevi'   ,'Lionel'     ,'2013-09-11');
insert into Membre values (5,  1  ,'Angeletti' ,'Isabelle'   ,'2011-10-21');
insert into Membre values (6,  2  ,'Apery'     ,'Celine'     ,'2012-11-15');
insert into Membre values (7,  2  ,'Boudjeltia','Reda'       ,'2012-09-14');
insert into Membre values (8,  2  ,'Chabot'    ,'Romain'     ,'2012-10-30');
insert into Membre values (9,  2  ,'Carrie'    ,'Mathieu'    ,'2010-04-15');
insert into Membre values (10, 2  ,'Cidere'    ,'Laurent'    ,'2012-05-15');
insert into Membre values (11, 3  ,'Cleriot'   ,'Simon'      ,'2009-09-14');
insert into Membre values (12, 3  ,'Devoir'    ,'Loic'       ,'2012-01-13');
insert into Membre values (13, 3  ,'Dury'      ,'Victor'     ,'2009-05-15');
insert into Membre values (14, 3  ,'Nizet'     ,'Aurélien'   ,'2011-12-15');
insert into Membre values (15, 3  ,'Sabir'     ,'Reda'       ,'2009-06-24');
insert into Membre values (16, 4  ,'Zouad'     ,'Lotfi'      ,'2012-10-30');
insert into Membre values (17, 4  ,'Fiot'      ,'Arthur'     ,'2012-09-01');
insert into Membre values (18, 4  ,'Gaulon'    ,'Pierre'     ,'2012-09-01');
insert into Membre values (19, 4  ,'Patrone'   ,'Agnés'      ,'2012-09-11');
insert into Membre values (20, 4  ,'Zouari'    ,'Firas'      ,'2010-11-15');

-- Entraineur

insert into Entraineur values (1);

insert into Entraineur values (6);

insert into Entraineur values (11);

insert into Entraineur values (16);

-- Joueur

-- Gryffondor
insert into Joueur values (1,  1,  '1993-06-09', null);
insert into Joueur values (2,  2,  '1993-08-09', null);
insert into Joueur values (3,  3,  '1989-05-15', null);
insert into Joueur values (4,  4,  '1987-01-25', null);
insert into Joueur values (5,  5,  '1975-10-20', null);

-- Serpentard
insert into Joueur values (6,  6,  '1993-04-21', null);
insert into Joueur values (7,  7,  '1990-12-24', null);
insert into Joueur values (8,  8,  '1992-04-01', null);
insert into Joueur values (9,  9,  '1979-02-17', null);
insert into Joueur values (10, 10, '1995-06-03', null);

-- Poufsouffle
insert into Joueur values (11, 11, '1987-11-07', null);
insert into Joueur values (12, 12, '1993-05-24', null);
insert into Joueur values (13, 13, '1993-06-17', null);
insert into Joueur values (14, 14, '1993-06-09', null);
insert into Joueur values (15, 15, '1993-09-08', null);

-- Serdaigle
insert into Joueur values (16, 16, '1986-03-17', null);
insert into Joueur values (17, 17, '1994-03-24', null);
insert into Joueur values (18, 18, '1994-08-12', null);
insert into Joueur values (19, 19, '1993-07-22', null);
insert into Joueur values (20, 20, '1991-02-17', null);

-- Responsable

insert into Responsable values (1,  'President');
insert into Responsable values (6,  'President');
insert into Responsable values (11, 'President');
insert into Responsable values (16, 'President');

-- Rencontre

-- Gryffondor - Serpentard
insert into Rencontre values (1,  '2014-10-04');

-- Gryffondor - Poufsouffle
insert into Rencontre values (2,  '2014-10-11');

-- Gryffondor - Serdaigle
insert into Rencontre values (3,  '2014-10-18');

-- Serpentard - Poufsouffle
insert into Rencontre values (4,  '2014-10-25');

-- Serpentard - Serdaigle
insert into Rencontre values (5,  '2014-11-01');

-- Poufsouffle - Serdaigle
insert into Rencontre values (6,  '2014-11-08');

-- Serpentard - Gryffondor
insert into Rencontre values (7,  '2014-11-15');

-- Poufsouffle - Gryffondor
insert into Rencontre values (8,  '2014-11-22');

-- Serdaigle - Gryffondor 
insert into Rencontre values (9,  '2014-11-29');

-- Poufsouffle - Serpentard 
insert into Rencontre values (10,  '2014-12-06');

-- Serdaigle - Serpentard 
insert into Rencontre values (11,  '2014-12-13');

-- Serdaigle - Poufsouffle
insert into Rencontre values (12,  '2014-12-20');

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

-- Rencontre 7
insert into Rencontrer values (6,  7, 2, 10, 4);
insert into Rencontrer values (7,  7, 2, 2,  0);
insert into Rencontrer values (8,  7, 2, 3,  2);
insert into Rencontrer values (9,  7, 2, 10, 4);
insert into Rencontrer values (10, 7, 2, 12, 3);

insert into Rencontrer values (1,  7, 1, 10,  1);
insert into Rencontrer values (2,  7, 1, 13,  3);
insert into Rencontrer values (3,  7, 1, 10,  1);
insert into Rencontrer values (4,  7, 1, 8,   0);
insert into Rencontrer values (5,  7, 1, 2,   1);

-- Rencontre 8
insert into Rencontrer values (11, 8, 3, 5,  1);
insert into Rencontrer values (12, 8, 3, 2,  0);
insert into Rencontrer values (13, 8, 3, 14, 2);
insert into Rencontrer values (14, 8, 3, 11, 2);
insert into Rencontrer values (15, 8, 3, 6,  1);

insert into Rencontrer values (1,  8, 1, 16, 3);
insert into Rencontrer values (2,  8, 1, 11, 1);
insert into Rencontrer values (3,  8, 1, 2,  0);
insert into Rencontrer values (4,  8, 1, 8,  1);
insert into Rencontrer values (5,  8, 1, 5,  0);

-- Rencontre 9
insert into Rencontrer values (16, 9, 4, 15, 4);
insert into Rencontrer values (17, 9, 4, 4,  1);
insert into Rencontrer values (18, 9, 4, 11, 2);
insert into Rencontrer values (19, 9, 4, 2,  1);
insert into Rencontrer values (20, 9, 4, 6,  1);

insert into Rencontrer values (1,  9, 1, 17, 1);
insert into Rencontrer values (2,  9, 1, 6,  1);
insert into Rencontrer values (3,  9, 1, 3,  1);
insert into Rencontrer values (4,  9, 1, 2,  3);
insert into Rencontrer values (5,  9, 1, 8,  1);

-- Rencontre 10
insert into Rencontrer values (11, 10, 3, 7,  1);
insert into Rencontrer values (12, 10, 3, 4,  1);
insert into Rencontrer values (13, 10, 3, 15, 2);
insert into Rencontrer values (14, 10, 3, 12, 0);
insert into Rencontrer values (15, 10, 3, 4,  0);

insert into Rencontrer values (6,  10, 2, 4,  3);
insert into Rencontrer values (7,  10, 2, 4,  4);
insert into Rencontrer values (8,  10, 2, 15, 3);
insert into Rencontrer values (9,  10, 2, 24, 3);
insert into Rencontrer values (10, 10, 2, 6,  2);

-- Rencontre 11
insert into Rencontrer values (16, 11, 4, 5,  2);
insert into Rencontrer values (17, 11, 4, 14, 1);
insert into Rencontrer values (18, 11, 4, 9,  3);
insert into Rencontrer values (19, 11, 4, 6,  2);
insert into Rencontrer values (20, 11, 4, 12, 3);

insert into Rencontrer values (6,  11, 2, 10, 3);
insert into Rencontrer values (7,  11, 2, 12, 4);
insert into Rencontrer values (8,  11, 2, 2,  2);
insert into Rencontrer values (9,  11, 2, 18, 3);
insert into Rencontrer values (10, 11, 2, 17, 4);

-- Rencontre 12
insert into Rencontrer values (16, 12, 4, 8,  1);
insert into Rencontrer values (17, 12, 4, 17, 2);
insert into Rencontrer values (18, 12, 4, 6,  3);
insert into Rencontrer values (19, 12, 4, 14, 1);
insert into Rencontrer values (20, 12, 4, 5,  0);

insert into Rencontrer values (11, 12, 3, 7,  0);
insert into Rencontrer values (12, 12, 3, 2,  0);
insert into Rencontrer values (13, 12, 3, 15, 2);
insert into Rencontrer values (14, 12, 3, 10, 3);
insert into Rencontrer values (15, 12, 3, 5,  4);


-- Sentrainer

-- Entrainer
