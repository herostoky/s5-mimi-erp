\c postgres;
DROP DATABASE "immobilisation";
CREATE DATABASE "immobilisation";
\c "immobilisation";

CREATE SEQUENCE "prodSeq" START WITH 1;

CREATE TABLE "Immobilisation" (
	"idimmobilisation" VARCHAR (20) PRIMARY KEY DEFAULT CONCAT('IMMO', NEXTVAL('"prodSeq"')),
	"nom" VARCHAR (20),
	"valeur" NUMERIC (20, 3),
	"debut_usage" DATE,
	"jour_fin_exo" INT, -- chaque fin d'exercice represente une annee
	"mois_fin_exo" INT, -- chaque fin d'exercice represente une annee
	"duree_amortissement" INT, -- taux lineaire
	"coef_deg" NUMERIC(5, 3) -- taux deg = (100 / duree = taux lin) * coef_deg
);


INSERT INTO "Immobilisation" VALUES (DEFAULT, '4x4', 100000, '2016-02-22', 31, 12,     5, 1.75);
INSERT INTO "Immobilisation" VALUES (DEFAULT, 'Serveur', 250000, '2016-02-01', 5, 11, 10, 1.75);
INSERT INTO "Immobilisation" VALUES (DEFAULT, 'Ventilo', 350000, '2016-01-01', 6, 11, 10, 1.75);