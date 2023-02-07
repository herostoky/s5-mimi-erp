<div class="content">
    <div class="row">
        <div class="col-md-6 col-md-offset-2">
           <h4>
                Mouvement :: <b><?php echo $libelle; ?> | Restant <?php echo $computed['total_quantite'];?></b>
           </h4>
            <form action="<?php echo absolute_url("accueil/inserer_stock?idproduit=$idproduit&libelle=$libelle"); ?>" method="POST">
                <input hidden type="text" name="idproduit" value="<?php echo $idproduit; ?>" required size="2">
                <select id="select" name="type">
                    <option value="1">ENTREE</option>
                    <option value="-1">SORTIE</option>
                </select>
                <input id="prix" type="text" name="prix" placeholder="Prix Unitaire" required>
                x Qt
                <input type="text" name="quantite" placeholder="quantite" required>
                <input type="text" name="date" placeholder="date" value="<?= $now ?>" required>

                <input type="submit" class="btn btn-xs btn-primary"  value="Ajouter">
            </form>
            <?php echo $message; ?>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-md-7 col-md-offset-2">
        <table class="table table-bordered">
            <tr>
                <th>Date</th>
                <th>Nombre</th>
                <th>Type</th>
                <th>Prix Unitaire</th>
                <th>Methode :: <?php echo $computed['methode']; ?></th>
                <th>Total</th>
            </tr>
            <?php

                foreach ($computed['details'] as $detail) { 
                    $type_label = "ENTREE";
                    $class = "background-color:white";
                    if ($detail['type'] < 0) {
                        $type_label = "SORTIE";
                        $class = "background-color:pink";
                    }
            ?>
                <tr style="<?php echo $class ?>">
                    <td><?php echo $detail['date']; ?></td>
                    <td class="text text-right"><?php echo $detail['quantite']; ?></td>
                    <td><?php echo $type_label; ?></td>

                    <td class="text text-right"><?php echo format_money($detail['prix']) ?> Ar</td>
                    <td class="text text-right"><?php echo format_money($detail['stock_value']) ?> Ar</td>
                    <td class="text text-right"><?php echo format_money($detail['total']) ?> Ar</td>
                </tr>
            <?php } ?>
        </table>
        
        </div>
    </div>
</div>

<script type="text/javascript">
    function check() {
        const val = $("#select").val();
        if (val < 0) {
            $("#prix").hide();
            $("#prix").val(0);
        } else {
            $("#prix").show();
            $("#prix").val('');
        }
    }
    check();
    $("#select").on('change', ev => check());
</script>
