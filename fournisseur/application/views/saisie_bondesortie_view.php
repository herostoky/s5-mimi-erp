<div class="content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2" >
            <h3 class="text text-primary">Nouveau bon de sortie</h3>
            <form action="<?php echo absolute_url("accueil/nouvelle_commande"); ?>" method="post">
				<input type="text" class="form-control" name="acheteur" id="acheteur" placeholder="Entreprise acheteur" required>
                <input type="text" id="num_bon_commande" size="3" name="num_bon_commande" value="<?php echo $num_bon_commande; ?>" placeholder="num_bon_commande" required>
                <input type="text" id="produit" name="produit" value="" size="11" placeholder="produit" required>
                <input type="text" id="prix" name="prix" value="" size="11" placeholder="prix" required>
                <input type="text" id="quantite" name="quantite" value="" size="11" placeholder="quantite" required>
                <select name="iddevise">
                    <?php foreach($devises as $devise) { ?>
                    
                    <option value="<?php echo $devise->iddevise; ?>">
                        <?php echo $devise->nom_devise; ?>
                    </option>
                    
                    <?php } ?>
                </select>

                
                <input type="submit" value="Valider">
            </form>
            
        </div>
    </div>
</div>
