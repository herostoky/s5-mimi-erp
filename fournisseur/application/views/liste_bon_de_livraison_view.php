<div class="content">
    <div class="row">
        <div class="col-md-5 col-md-offset-2" >
        	<h3>Bon de Livraison</h3>
        	<table class="table table-bordered">
        		<tr>
        			<th>ID</th>
        			<th>Acheteur</th>
              <th>ID Bon de sortie</th>
              <td></td>
        		</tr>

          <?php foreach($bonDeLivraisons as $bdl){ ?>
            <tr>
              <td><?php echo $bdl->idbondelivraison ?></td>
              <td><?php echo $bdl->acheteur ?></td>
              <td><?php echo $bdl->idbondesortie ?></td>
              <td><a href="<?php echo absolute_url("BonDeLivraison/detailsBonDeLivraison/".$bdl->idbondelivraison) ?>"><button class="btn btn-success">Voir Détails</button></a></td>
            </tr>
          <?php } ?>

        	</table>
        </div>
    </div>
</div>
