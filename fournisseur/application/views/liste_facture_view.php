<div class="content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2" >
            <h3 class="text text-primary">Facture existantes : </h3>
                <?php 
                    foreach($factures as $facture) { 
                        $numero = $facture->num_facture;
                        $ref_bon_commande = $facture->ref_bon_commande;
                ?>
                    <li>
                        <a href="<?php echo absolute_url("facture/detail?num_facture=$numero"); ?>">
                            <b><?php echo "$numero";?> - <?php echo "$ref_bon_commande";?></b>
                        </a>
                    </li>
                <?php } ?>
        </div>
    </div>
</div>
