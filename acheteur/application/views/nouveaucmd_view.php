<div class="content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2" >
            <h3 class="text text-primary">Nouveau bon de commande</h3>
            <form action="<?php echo absolute_url("accueil/nouvelle_commande"); ?>" method="post">
				REF PROFORMA
                <input type="text" id="ref_proforma" size="15" name="ref_proforma" value="<?php echo $ref_proforma; ?>" placeholder="ref_proforma" required>
                <input type="number" id="remise" name="remise" value="" size="11" placeholder="remise" required>
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
