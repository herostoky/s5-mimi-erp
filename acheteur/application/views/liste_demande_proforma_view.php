<div class="content">
    <div class="row">
        <div class="col-md-5 col-md-offset-2" >
        	<h3>Demandes proforma</h3>
        	<table class="table table-bordered">
        		<tr>
        			<th>ID</th>
        			<th>Fournisseur</th>
        		</tr>
        		<?php foreach ($dem_proformas as $demande) { ?>
	        		<tr>
	        			<td><?php echo $demande->iddemandeproforma ?></td>
	        			<td><?php echo $fournisseur_map[$demande->idfournisseur]; ?></td>
	        			<td>
	        				<a href="<?php echo absolute_url("DemandeProforma/liste?ref_demande=".$demande->iddemandeproforma); ?>">
	        					Voir details
	        				</a>
	        			</td>
	        		</tr>
        		<?php } ?>
        	</table>
        </div>
    </div>
</div>