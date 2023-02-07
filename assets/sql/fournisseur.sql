\c postgres
DROP DATABASE "fournisseur";
CREATE DATABASE "fournisseur";
\c "fournisseur";

CREATE SEQUENCE "DeviseSequence" START WITH 1;
CREATE SEQUENCE "ProduitSequence" START WITH 1;
CREATE SEQUENCE "StockSequence" START WITH 1;
CREATE SEQUENCE "ProformaSequence" START WITH 1;
CREATE SEQUENCE "DetailProformaSequence" START WITH 1;
CREATE SEQUENCE "BonDeSortieSequence" START WITH 1;
CREATE SEQUENCE "DetailBonDeSortieSequence" START WITH 1;
CREATE SEQUENCE "BonDeLivraisonSequence" START WITH 1;
CREATE SEQUENCE "DetailBonDeLivraisonSequence" START WITH 1;
CREATE SEQUENCE "DetailFactureSequence" START WITH 1;

CREATE TABLE "Devise" (
	"iddevise" VARCHAR(30) PRIMARY KEY DEFAULT CONCAT('DEVISE_', NEXTVAL('"DeviseSequence"')),
	"nom_devise" VARCHAR (20), -- dollar, euro	
	"etiquette" VARCHAR (20), -- $, Ar, ..
	"valeur" FLOAT -- valeur en Ariary
);

CREATE TABLE "Produit" (
	"idproduit" VARCHAR(30) PRIMARY KEY DEFAULT CONCAT('PRODUIT_', NEXTVAL('"ProduitSequence"')),
	"designation" VARCHAR (20)
);

CREATE TABLE "Stock" (
	"idstock" VARCHAR(30) PRIMARY KEY DEFAULT CONCAT('STOCK_', NEXTVAL('"StockSequence"')),
	"idproduit" VARCHAR(30), -- ref produit 
	"quantite" FLOAT,
	"prix" FLOAT,
	"type" INT, -- -1 / 1
	"date" TIMESTAMP DEFAULT NOW(),
	FOREIGN KEY ("idproduit") REFERENCES "Produit" ("idproduit")
);

CREATE TABLE "Proforma" (
	"idproforma" VARCHAR(30) PRIMARY KEY DEFAULT CONCAT('PROFORMA_', NEXTVAL('"ProformaSequence"')),
	"acheteur" VARCHAR (20), -- entreprise acheteur 
	"ref_demande_proforma" VARCHAR(30),
	"remise" INT, -- exemple 25
	"iddevise" VARCHAR (30),
	FOREIGN KEY ("iddevise") REFERENCES "Devise" ("iddevise")
);

CREATE TABLE "DetailProforma" (
	"iddetailproforma" VARCHAR(30) PRIMARY KEY DEFAULT CONCAT('DETAILPROFORMA_', NEXTVAL('"DetailProformaSequence"')),
	"idproforma" VARCHAR(30), -- ref proforma
	"idproduit" VARCHAR(30), -- ref produit 
	"quantite" FLOAT,
	"prix" FLOAT, -- devrait etre calcule en fonction du stock
	"remise" INT, -- exemple 25
	FOREIGN KEY ("idproforma") REFERENCES "Proforma" ("idproforma"),
	FOREIGN KEY ("idproduit") REFERENCES "Produit" ("idproduit")
);


-- bon de sortie
CREATE TABLE "BonDeSortie" (
	"idbondesortie" VARCHAR(30) PRIMARY KEY DEFAULT CONCAT('BONDESORTIE_', NEXTVAL('"BonDeSortieSequence"')),
	"acheteur" VARCHAR (20), -- entreprise acheteur 
	"ref_demande_proforma" VARCHAR(30),
	"remise" INT, -- exemple 25
	"iddevise"  VARCHAR (30),
	FOREIGN KEY ("iddevise") REFERENCES "Devise" ("iddevise")
);
ALTER TABLE "BonDeSortie"
ADD "valided" int NOT NULL DEFAULT 0;

CREATE TABLE "DetailBonDeSortie" (
	"iddetailbondesortie" VARCHAR(30) PRIMARY KEY DEFAULT CONCAT('DETAILBONDESORTIE_', NEXTVAL('"DetailBonDeSortieSequence"')),
	"idbondesortie" VARCHAR(30), -- ref proforma
	"idproduit" VARCHAR(30), -- ref produit
	"designation" VARCHAR (20), -- genre hoe "Clavier am le 200" != ou = nom produit
	"quantite" FLOAT,
	"prix" FLOAT, -- devrait etre calcule en fonction du stock
	FOREIGN KEY ("idbondesortie") REFERENCES "BonDeSortie" ("idbondesortie"),
	FOREIGN KEY ("idproduit") REFERENCES "Produit" ("idproduit")
);

-- Bon de livraison
CREATE TABLE "BonDeLivraison" (
	"idbondelivraison" VARCHAR(30) PRIMARY KEY DEFAULT CONCAT('BONDELIVRAISON_', NEXTVAL('"BonDeLivraisonSequence"')),
	"acheteur" VARCHAR (20),
	"idbondesortie" VARCHAR(30),
	FOREIGN KEY ("idbondesortie") REFERENCES "BonDeSortie" ("idbondesortie")
);

CREATE TABLE "DetailBonDeLivraison" (
	"iddetailbondelivraison" VARCHAR(30) PRIMARY KEY DEFAULT CONCAT('DETAILBONDELIVRAISON_', NEXTVAL('"DetailBonDeLivraisonSequence"')),
	"idbondelivraison" VARCHAR(30),
	"idproduit" VARCHAR(30),
	"designation" VARCHAR (20), -- genre hoe "Clavier am le 200" != ou = nom produit
	"quantite" FLOAT,
	"prix" FLOAT, -- devrait etre calcule en fonction du stock
	FOREIGN KEY ("idbondelivraison") REFERENCES "BonDeLivraison" ("idbondelivraison"),
	FOREIGN KEY ("idproduit") REFERENCES "Produit" ("idproduit")
);


-- Facture
CREATE TABLE "Facture" (
	"num_facture" VARCHAR (100) PRIMARY KEY, -- doit etre generee selon le fournisseur
	"ref_bon_commande" VARCHAR (100), -- s'obtient selon le webservice
	"remise" INT, -- exemple 25
	"iddevise"  VARCHAR (30), -- Ar
	FOREIGN KEY ("iddevise") REFERENCES "Devise" ("iddevise")
);

CREATE TABLE "DetailFacture" (
	"iddetailfacture" VARCHAR(30) PRIMARY KEY DEFAULT  CONCAT('DETAILFACTURE_', NEXTVAL('"DetailFactureSequence"')),
	"num_facture" VARCHAR (100),
	"quantite" FLOAT,
	"prix" FLOAT,
	"designation" VARCHAR(20),
	"remise" INT, -- exemple 25
	FOREIGN KEY ("num_facture") REFERENCES "Facture" ("num_facture")
);

CREATE TABLE "SequenceFactureAcheteur" (
    "idacheteur" VARCHAR (30) NOT NULL,
    value INT
);

INSERT INTO "Devise" VALUES (DEFAULT, 'Ariary', 'Ar', 1);
INSERT INTO "Devise" VALUES (DEFAULT, 'dollar', '$', 3000);
INSERT INTO "Devise" VALUES (DEFAULT, 'euros', 'E', 4000);

INSERT INTO "Produit" VALUES (DEFAULT, 'Laptop');
INSERT INTO "Produit" VALUES (DEFAULT, 'Manette');
INSERT INTO "Produit" VALUES (DEFAULT, 'Onduleur');
INSERT INTO "Produit" VALUES (DEFAULT, 'Souris');
INSERT INTO "Produit" VALUES (DEFAULT, 'Clavier');


INSERT INTO "Stock" VALUES (DEFAULT, 'PRODUIT_1', 17, 200,  1, '2000-01-01 00:01:00');
INSERT INTO "Stock" VALUES (DEFAULT, 'PRODUIT_1',  5, 100,  1, '2000-01-01 00:02:00');
INSERT INTO "Stock" VALUES (DEFAULT, 'PRODUIT_1',  3, 100, -1, '2000-01-01 00:03:00');
INSERT INTO "Stock" VALUES (DEFAULT, 'PRODUIT_2', 23, 100,  1, '2000-01-01 00:04:00');
INSERT INTO "Stock" VALUES (DEFAULT, 'PRODUIT_2',  7, 150,  1, '2000-01-01 00:05:00');
INSERT INTO "Stock" VALUES (DEFAULT, 'PRODUIT_3', 57, 300,  1, '2000-01-01 00:06:00');
INSERT INTO "Stock" VALUES (DEFAULT, 'PRODUIT_4', 25, 400,  1, '2000-01-01 00:07:00');
INSERT INTO "Stock" VALUES (DEFAULT, 'PRODUIT_5',  5, 400,  1, '2000-01-01 00:08:00');
INSERT INTO "Stock" VALUES (DEFAULT, 'PRODUIT_1',  5, 400, -1, '2000-01-01 00:09:00');

INSERT INTO "SequenceFactureAcheteur" VALUES (1, 0);