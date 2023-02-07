<div class="content">
    <div class="row">
        <div class="col-md-6 col-md-offset-2" >
        	<h4>
        		Proforma ID = <?php echo $proforma->idproforma ?> 
                | Client : <?php echo $proforma->acheteur; ?> 
        	</h4>
            <h4>
                 Ref demande : <?php echo $proforma->ref_demande_proforma; ?> 
                | Remise globale : <?php echo $proforma->remise; ?> % 
            </h4>
        	<table class="table table-bordered">
        		<tr>
                    <th>Designation</th>
                    <th>Qte</th>
                    <th>Prix</th>
        			<th>Remise</th>
        		</tr>
        		<?php 
                    foreach ($details as $detail) { 
                        $produit = $produits_map[$detail->idproduit];
                ?>
	        		<tr>
                        <td><?php echo $produit->designation; ?></td>
                        <td class="text text-right">
                            <?php echo $detail->quantite; ?>
                        </td>
                        <td class="text text-right"><?php echo $detail->prix; ?> Ar</td>
	        			<td class="text text-right"><?php echo $detail->remise; ?>%</td>
	        		</tr>
        		<?php } ?>
        	</table>
        </div>
    </div>
</div>