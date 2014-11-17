-- ============================================================
--   Nom de la base   :  BASKETBALL                                
--   Nom de SGBD      :  MySQL
--   Date de creation :  17/11/14
-- ============================================================

drop table Membre;
drop table Entraineur;
drop table Joueur;
drop table Responsable;
drop table Club;
drop table Match;
drop table Rencontrer;
drop table Equipe;
drop table Joueur;
drop table Entrainer;

-- ============================================================
--   Table : Membre
-- ============================================================

create table Membre
(
ID_Membre	int		unsigned auto_increment not null,
Nom		varchar(30)				not null,
Prenom		varchar(30)				not null,
Date_Entree	date					not null,

Primary Key(ID_Membre)
) Engine = InnoDB;

-- ============================================================
--   Table : Entraineur
-- ============================================================

create table Entraineur
(
ID_Membre	int		unsigned		not null,

Primary Key(ID_Membre)
) Engine = InnoDB;

-- ============================================================
--   Table : Joueur
-- ============================================================

create table Joueur
(
ID_Membre	int					not null,
Num_Licence	int		unsigned auto_increment not null,
Date_Naissance	date			 		not null,
Adresse		text					not null,
Points		int					not null,
Fautes		int					not null,

Primary Key(ID_Membre)
) Engine = InnoDB;

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
--   Table : Responsable
-- ============================================================

create table Responsable
(
ID_Membre	int		unsigned		not null,
Role		varchar(30)				not null,
ID_Club		int		unsigned		not null,

Primary Key(ID_Membre)
Foreign Key(ID_Club) References Club(ID_Club)
) Engine = InnoDB;

-- ============================================================
--   Table : Match
-- ============================================================

create table Match
(
ID_Rencontre	int		unsigned auto_increment not null,
Date_match	date			 		not null,
Score		varchar(15)				not null,

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

Primary Key(ID_Equipe)
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

Primary Key(ID_Membre, ID_Rencontre)
Foreign Key(ID_Equipe) References Equipe(ID_Equipe)
) Engine = InnoDB;

-- ============================================================
--   Table : Jouer
-- ============================================================

create table Jouer
(
ID_Membre	int		unsigned		not null,
Date_Match	date					not null,
ID_Equipe	int		unsigned		not null,

Primary Key(ID_Membre, Date_Match)
Foreign Key(ID_Equipe) References Equipe(ID_Equipe)
) Engine = InnoDB;

-- ============================================================
--   Table : Entrainer
-- ============================================================

create table Entrainer
(
ID_Membre	   int		unsigned		not null,
Date_Entrainement  date					not null,
ID_Equipe	   int		unsigned		not null,

Primary Key(ID_Membre, Date_Entrainement)
Foreign Key(ID_Equipe) References Equipe(ID_Equipe)
) Engine = InnoDB;
