<div class="content">
    <div class="row">
        <div class="col-md-5 col-md-offset-2" >
            <h3>Etat du stock</h3>
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Qte restante</th>
                    <th>Valeur du stock</th>
                </tr>
                <?php 
                    foreach ($produits_restant as $idproduit => $prop) { 
                        $libelle = $prop['name'];
                ?>
                    <tr>
                        <td><?php echo $idproduit; ?></td>
                        <td><?php echo $prop['name']; ?></td>
                        <td><?php echo $prop['count']; ?></td>
                        <td class="text text-right"><?php echo format_money($prop['stock_value']); ?>Ar</td>
                        <td>
                            <a href="<?php echo absolute_url('accueil') . "?idproduit=$idproduit&libelle=$libelle" ; ?>">     Voir etat
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>
