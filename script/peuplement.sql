-- creation de l'utilisateur administrateur


INSERT INTO utilisateur (nomUtilisateur,prenom, mail,password,administrateur,valide,jeton) VALUES ('admin','admin','admin@admin.fr','$2y$10$jGiIoMtD2PM3o6O1GmReFOsXtt5zEy9NJCLlIUmmyp44TOH4XqGm6',1,1,'646efa9527b81');

-- creation de 3 utilisateurs dont un qui est inscrit mais pas validé

INSERT INTO utilisateur (nomUtilisateur,prenom, mail,password,administrateur,valide,jeton) VALUES 
('Reinhardt','Django','manoir.demesreves@roulotte.eu','$2y$10$X/8l849jCd/3AU0/1B17supm9J4AWCDhBekpy7cPExLC3eVqFRHGq',0,1,'646efacfdbee0'),
('Hendrix','Jimi','little.wing@foxylady.com','$2y$10$hm5eCJket14z6ZdWtcJTb.OLP1Ch6yS3rmVEC6JsbkTS5K6lbJz8q',0,1,'646efb87272be'),
('Beck','Jeff','blow@truth.fr','$2y$10$C8eC8RmZlfpFLuGVI8C99.zejSSO2Gb4RD1BMkeOP25eUESwDssdK',0,0,'646efbeaccf36');



-- creation finitions


INSERT INTO finition(finition)VALUES
('Sunburst'),
('Snow White'),
('Black'),
('Blue'),
('White'),
('Green'),
('Black Silver'),
('Surf Green'),
('Daphne Blue'),
('Vintage Cherry'),
('Charcoal Burst'),
('Honey Burst'),
('Cherry'),
('Blue Crimson Pearl'),
('Butterscotch'),
('Amber Tiger Eye'),
('Blonde');

-- creation modeles

INSERT INTO modele (modele)VALUES
('Sg'),
('Hollow-body'),
('Télécaster'),
('Les paul'),
('Jaguar'),
('Mustang'),
('Firebird'),
('Explorer'),
('Stratocaster'),
('Double cut'),
('Flying V');


-- creation genres

INSERT INTO genre(genre)VALUES
('Blues'),
('Heavy métal'),
('Death métal'),
('Punk'),
('Funk'),
('Rock'),
('Pop'),
('Jazz'),
('Djent'),
('Country'),
('Brit pop'),
('Fusion'),
('Stoner');

-- creation de marque 

INSERT INTO marque(nom_marque)VALUES
('Gibson'),
('Fender'),
('Ibanez'),
('Esp'),
('Music Man'),
('Gretsch'),
('Charvel'),
('LTD'),
('Schecter'),
('Epiphone'),
('Jackson');


-- association guitare_genre 

INSERT INTO guitare_genre(fkIdGuitare,fkIdGenre)VALUES
(1,1),
(1,2),
(1,5),
(2,2),
(2,13),
(3,2),
(3,3),
(3,9),
(4,1),
(4,4),
(4,6),
(6,1),
(6,6),
(7,2),
(7,6),
(10,1),
(10,5),
(10,7),
(10,11),
(11,5),
(11,12),
(12,4),
(12,13),
(16,1),
(16,6),
(17,2),
(17,3),
(17,9),
(18,9),
(19,3),
(19,9),
(20,3),
(20,9),
(22,1),
(22,6),
(22,10),
(23,1),
(23,8),
(24,8),
(25,4),
(25,7),
(26,1),
(26,6),
(26,10);




-- association guitare finition
INSERT INTO guitare_finition(fkIdGuitare,fkIdFinition)VALUES
(12,8),
(1,1),
(5,13),
(5,11),
(2,2),
(10,1),
(6,5),
(11,4),
(7,5),
(7,6),
(8,3),
(8,6),
(15,12),
(15,4),
(22,5),
(17,11),
(21,16),
(21,2),
(16,13),
(26,15),
(18,16),
(24,1),
(24,10),
(25,6),
(25,9),
(23,1),
(13,12),
(3,7),
(4,10),
(8,11),
(14,17),
(19,2),
(19,7);


-- association guitare marque

INSERT INTO guitare_marque(fkIdGuitare,fkIdMarque)VALUES
(1,7),
(2,4),
(3,4),
(4,1),
(5,9),
(6,2),
(7,7),
(8,8),
(9,8),
(10,2),
(11,2),
(12,2),
(13,1),
(14,1),
(15,1),
(16,1),
(17,9),
(18,11),
(20,9),
(21,3),
(22,6),
(23,3),
(24,10),
(25,6),
(26,2);

-- association guitare modele

INSERT INTO guitare_modele(fkIdGuitare,fkIdModele)VALUES
(2,4),
(4,1),
(5,11),
(7,10),
(10,3),
(11,9),
(13,4),
(16,2),
(18,10),
(20,10),
(22,2),
(24,2),
(26,3);



-- creation d'une collection de guitares par un utilisateur

INSERT INTO favoris(nomFavoris,fkIdUtilisateur)VALUES
('Jazz',2),
('Blues',2),
('Blues',3),
('Rock',3),
('Funk',3);



-- ajout de guitare dans une collection 
INSERT INTO favoris_guitare(fkIdFavoris,fkIdGuitare)VALUES
(1,24),
(1,23),
(2,10),
(2,16),
(2,6),
(3,6),
(3,1),
(3,26),
(3,14),
(4,6),
(4,12),
(4,15),
(5,1),
(5,11);





