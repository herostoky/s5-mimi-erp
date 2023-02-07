<div class="content">
    <div class="row">
        <div class="col-md-5 col-md-offset-2" >
        	<h3>Bon de Reception</h3>
        	<table class="table table-bordered">
        		<tr>
        			<th>ID</th>
        			<th>Reference Bon de livraison</th>
              <th></th>
        		</tr>

          <?php foreach($bonDeReceptions as $dbr){ ?>
            <tr>
              <td><?php echo $dbr->iddebonreception ?></td>
              <td><?php echo $dbr->ref_bon_livraison ?></td>
              <td><a href="<?php echo absolute_url("BonDeReception/detailsBonDeReception/".$dbr->iddebonreception) ?>"><button class="btn btn-success">Voir Détails</button></a></td>
            </tr>
          <?php } ?>

        	</table>
        </div>
    </div>
</div>
