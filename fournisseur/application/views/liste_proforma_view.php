<div class="content">
    <div class="row">
        <div class="col-md-5 col-md-offset-2" >
        	<h3>Proforma</h3>
        	<table class="table table-bordered">
        		<tr>
        			<th>ID</th>
                    <th>Client acheteur</th>
                    <th>Ref demande proforma</th>
                    <th>Remise</th>
        			<!-- <th>Devise</th> -->
        		</tr>
        		<?php foreach ($proformas as $proforma) { ?>
	        		<tr>
                        <td><?php echo $proforma->idproforma; ?></td>
	        			<td><?php echo $proforma->acheteur; ?></td>
	        			<td>
                            <a href="<?php echo baseurl_acheteur()."DemandeProforma/liste?extern=true&ref_demande=".$proforma->ref_demande_proforma; ?>">
                                <?php echo $proforma->ref_demande_proforma; ?>                                    
                            </a>
                        </td>
                        <td class="text text-right"><?php echo $proforma->remise; ?></td>
                        <td>
	        				<a href="<?php echo absolute_url("proforma/liste?ref_proforma=".$proforma->idproforma); ?>">
	        					Voir details
	        				</a>
	        			</td>
	        		</tr>
        		<?php } ?>
        	</table>
        </div>
    </div>
</div>