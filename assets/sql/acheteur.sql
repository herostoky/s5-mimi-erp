\c postgres
DROP DATABASE "acheteur";
CREATE DATABASE "acheteur";
\c "acheteur";

CREATE SEQUENCE "DeviseSequence" START WITH 1;
CREATE SEQUENCE "FournisseurSequence" START WITH 1;
CREATE SEQUENCE "DemandeProformaSequence" START WITH 1;
CREATE SEQUENCE "DetailDemandeProformaSequence" START WITH 1;
CREATE SEQUENCE "BonDeCommandeSequence" START WITH 1;
CREATE SEQUENCE "DetailBonDeCommandeSequence" START WITH 1;
CREATE SEQUENCE "BonDeReceptionSequence" START WITH 1;
CREATE SEQUENCE "DetailDeBonReceptionSequence" START WITH 1;

CREATE TABLE "Devise" (
	"iddevise" VARCHAR (30)  PRIMARY KEY DEFAULT CONCAT('DEVISE_', NEXTVAL('"DeviseSequence"')),
	"nom_devise" VARCHAR (20), -- dollar, euro
	"etiquette" VARCHAR (20), -- $, Ar, ..
	"valeur" FLOAT -- valeur en Ariary
);

CREATE TABLE "Fournisseur" (
	"idfournisseur" VARCHAR (30) PRIMARY KEY DEFAULT CONCAT('FOURNISSEUR_', NEXTVAL('"FournisseurSequence"')),
	"nom_fournisseur" VARCHAR (20)
);

CREATE TABLE "SequenceBonFournisseur" (
    "idfournisseur" VARCHAR (30) NOT NULL,
    value INT
);

CREATE TABLE "DemandeProforma" (
	"iddemandeproforma" VARCHAR(30) PRIMARY KEY DEFAULT CONCAT('DEM_PRO_', NEXTVAL('"DemandeProformaSequence"')),
	"idfournisseur" VARCHAR (30) ,
	FOREIGN KEY ("idfournisseur") REFERENCES "Fournisseur" ("idfournisseur")
);

CREATE TABLE "DetailDemandeProforma" (
	"iddetaildemandeproforma" VARCHAR (30) PRIMARY KEY DEFAULT CONCAT('DETAIL_DEM_PRO_', NEXTVAL('"DetailDemandeProformaSequence"')),
	"iddemandeproforma" VARCHAR (30) , -- ref
	"quantite" FLOAT,
	"designation" VARCHAR (20),
	FOREIGN KEY ("iddemandeproforma") REFERENCES "DemandeProforma" ("iddemandeproforma")
);

CREATE TABLE "BonDeCommande" (
	"num_bon_commande" VARCHAR (100) PRIMARY KEY, -- doit etre generee selon le fournisseur
	"ref_proforma" VARCHAR (20), -- s'obtient selon le webservice
	"remise" INT, -- exemple 25
	"iddevise" VARCHAR (30), -- Ar
	FOREIGN KEY ("iddevise") REFERENCES "Devise" ("iddevise")
);

CREATE TABLE "DetailBonDeCommande" (
	"iddetailbondecommande" VARCHAR (30) PRIMARY KEY DEFAULT CONCAT('DET_BON_COM_', NEXTVAL('"DetailBonDeCommandeSequence"')),
	"num_bon_commande" VARCHAR (100),
	"quantite" FLOAT,
	"prix" FLOAT,
	"designation" VARCHAR(20),
	"remise" INT, -- exemple 25
	FOREIGN KEY ("num_bon_commande") REFERENCES "BonDeCommande" ("num_bon_commande")
);

CREATE TABLE "BonDeReception" (
	"iddebonreception" VARCHAR (30) PRIMARY KEY DEFAULT CONCAT('BON_DE_RECEPT_', NEXTVAL('"BonDeReceptionSequence"')),
	"ref_bon_livraison" VARCHAR (20)
);

CREATE TABLE "DetailBonDeReception" (
	"iddetailbonreception" VARCHAR (30) PRIMARY KEY DEFAULT CONCAT('DET_BON_DE_RECEPT_', NEXTVAL('"DetailDeBonReceptionSequence"')),
	"iddebonreception" VARCHAR (20),
	"quantite" FLOAT,
	"designation" VARCHAR(20),
	FOREIGN KEY ("iddebonreception") REFERENCES "BonDeReception" ("iddebonreception")
);





INSERT INTO "Fournisseur" VALUES (DEFAULT, 'U-Tech');
INSERT INTO "SequenceBonFournisseur" VALUES ('FOURNISSEUR_1', 0);

INSERT INTO "Devise" VALUES (DEFAULT, 'Ariary', 'Ar', 1);
INSERT INTO "Devise" VALUES (DEFAULT, 'dollar', '$', 3000);
INSERT INTO "Devise" VALUES (DEFAULT, 'euros', 'E', 4000);
