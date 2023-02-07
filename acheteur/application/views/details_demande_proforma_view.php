<div class="content">
    <div class="row">
        <div class="col-md-5 col-md-offset-2" >
        	<h4>
        		Proforma ID = <?php echo $dem_proforma->iddemandeproforma ?> 
        		| Fournisseur : <?php echo $fournisseur_map[$dem_proforma->idfournisseur]; ?>
        	</h4>
        	<table class="table table-bordered">
        		<tr>
        			<th>Designation</th>
        			<th>Qte</th>
        		</tr>
        		<?php foreach ($details as $detail) { ?>
	        		<tr>
	        			<td><?php echo $detail->designation; ?></td>
	        			<td class="text text-right"><?php echo $detail->quantite; ?></td>
	        		</tr>
        		<?php } ?>
        	</table>
        </div>
    </div>
</div>