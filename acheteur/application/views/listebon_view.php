<div class="content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2" >
            <h3 class="text text-primary">Bon de commande existants : </h3>
                <?php 
                    foreach($commandes as $commande) { 
                        $numero = $commande->num_bon_commande;
                        $ref_proforma = $commande->ref_proforma;
                ?>
                    <li>
                        <a href="<?php echo absolute_url("accueil/detail?num_bon_commande=$numero"); ?>">
                            <b><?php echo "$numero";?></b>
                        </a>
                    </li>
                <?php } ?>
        </div>
    </div>
</div>
