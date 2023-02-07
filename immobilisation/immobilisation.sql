CREATE DATABASE "immobilisation";
\c "immobilisation";

CREATE SEQUENCE "prodSeq" START WITH 1;

CREATE TABLE "Produit" (
	"idproduit" VARCHAR (20) PRIMARY KEY DEFAULT NEXTVAL('"prodSeq"'),
	"nom" VARCHAR (20),
	"debut_usage" DATE,
	"duree_amorti" INT, -- duree d'amortissement
	"taux_amorti" INT
);