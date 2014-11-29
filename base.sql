-- ============================================================
--   Nom de la base   :  BASKETBALL                                
--   Nom de SGBD      :  MariaDB
--   Date de creation :  17/11/14
-- ============================================================

drop table Entrainer;
drop table Sentrainer;
drop table Rencontrer;
drop table Equipe;
drop table Rencontre;
drop table Responsable;
drop table Joueur;
drop table Entraineur;
drop table Membre;
drop table Club;

-- ============================================================
--   Table : Club
-- ============================================================

create table Club
(
ID_Club		int		unsigned auto_increment	not null,
Nom		varchar(30)		 		not null,
Ville		varchar(30)				not null,

Primary Key(ID_Club)
) Engine = InnoDB;

-- ============================================================
--   Table : Membre
-- ============================================================

create table Membre
(
ID_Membre	int		unsigned auto_increment not null,
ID_Club		int		unsigned		not null,
Nom		varchar(30)				not null,
Prenom		varchar(30)				not null,
Date_Entree	date					not null,

Primary Key(ID_Membre),
Foreign Key(ID_Club) References Club(ID_Club)
) Engine = InnoDB;

-- ============================================================
--   Table : Entraineur
-- ============================================================

create table Entraineur
(
ID_Membre	int		unsigned		not null,

Primary Key(ID_Membre),
Foreign Key(ID_Membre) References Membre(ID_Membre)
) Engine = InnoDB;

-- ============================================================
--   Table : Joueur
-- ============================================================

create table Joueur
(
Num_Licence	int		unsigned auto_increment not null,
ID_Membre	int		unsigned		not null,
Date_Naissance	date			 		not null,
Adresse		text						,

Primary Key(Num_Licence),
Foreign Key(ID_Membre) References Membre(ID_Membre)
) Engine = InnoDB;

-- ============================================================
--   Table : Responsable
-- ============================================================

create table Responsable
(
ID_Membre	int		unsigned		not null,
Activite        varchar(30)				not null,

Primary Key(ID_Membre),
Foreign Key(ID_Membre) References Membre(ID_Membre)
) Engine = InnoDB;

-- ============================================================
--   Table : Rencontre
-- ============================================================

create table Rencontre
(
ID_Rencontre	int		unsigned auto_increment not null,
Date_match	date			 		not null,

Primary Key(ID_Rencontre)
)Engine = InnoDB;

-- ============================================================
--   Table : Equipe
-- ============================================================

create table Equipe
(
ID_Equipe	int		unsigned auto_increment not null,
Categorie	varchar(30)		 		not null,
ID_Club		int		unsigned		not null,

Primary Key(ID_Equipe),
Foreign Key(ID_Club) References Club(ID_Club)
) Engine = InnoDB;

-- ============================================================
--   Table : Rencontrer
-- ============================================================

create table Rencontrer
(
ID_Membre	int		unsigned		not null,
ID_Rencontre	int		unsigned		not null,
ID_Equipe	int		unsigned		not null,
Points		int		unsigned		not null,
Fautes		int		unsigned		not null,

Primary Key(ID_Membre, ID_Rencontre),
Foreign Key(ID_Equipe) References Equipe(ID_Equipe),
Foreign Key(ID_Membre) References Joueur(ID_Membre)
) Engine = InnoDB;

-- ============================================================
--   Table : Sentrainer
-- ============================================================

create table Sentrainer
(
ID_Membre	  int		unsigned		not null,
Date_Entrainement date					not null,
ID_Equipe 	  int		unsigned		not null,

Primary Key(ID_Membre, Date_Entrainement),
Foreign Key(ID_Equipe) References Equipe(ID_Equipe),
Foreign Key(ID_Membre) References Entraineur(ID_Membre)
) Engine = InnoDB;

-- ============================================================
--   Table : Entrainer
-- ============================================================

create table Entrainer
(
ID_Membre	   int		unsigned		not null,
Date_Entrainement  date					not null,
ID_Equipe	   int		unsigned		not null,

Primary Key(ID_Membre, Date_Entrainement),
Foreign Key(ID_Equipe) References Equipe(ID_Equipe),
Foreign Key(ID_Membre) References Joueur(ID_Membre)
) Engine = InnoDB;
