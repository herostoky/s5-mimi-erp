* Fournisseur
 - changement de methode (facultative)
 - Table produit
 - gestion de stock (CMUP)
  fonction CMUP
  fonction FIFO
  fonction LIFO

 - creation proforma en fonction demande de proforma
 	- manana iddemandeproforma (reference)
 	- Choisisser-na : 
 		Produit (prix, designation), 
 		Saisisser-na ny quantite sy ny reduction
 	- Alefa any am client par mail (plutot omena lien)

 - bon de sortie
 	- manana numero_bon_de_commande
 	- donnee en fonction bon de commande
 	- nom entreprise
 	- signature
 	- date
 	- lignes designation, qte, prix unitaire, total
 
 - bon de livraison
 	- manana numero bon de sortie
 	- numero bon de livraison
 	- nom entreprise
 	- destinataire
 	- adresse destination
 	- date
 	- lignes designation, qte
 	- signature client (recu par)

 - facture
 	- manana numero_bon_de_commande
 	- affichage bon de commande fa facture fotsiny no entete

* Entreprise acheteur
	- fonctionnalite demande proforma
		- SANS PRIX, qte et designation fotsiny
		- any am fournisseur lasa misy iddemandeproforma vaovao
		- fournisseur genere proforma
		- fournisseur donne le lien du proforma
		- on l'insere dans la base de l'acheteur idproforma => url proforma

	- liste proforma validee
		- Hack : any am fournisseur misy page liste proforma validee (en fonction demande)
		- click 
		--> saisisser-na bon de commande ary manana reference idproforma (Fournisseur)
