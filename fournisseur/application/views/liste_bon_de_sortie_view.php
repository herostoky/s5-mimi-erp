<?php
  $nb = 0;
  if($bondesortie!=null){ $nb = count($bondesortie);}
?>
<div class="content">
    <div class="row">
        <div class="col-md-5 col-md-offset-2" >
        	<h3>Bon de Sortie</h3>
        	<table class="table table-bordered">
        		<tr>
        			<th>ID</th>
              <th>Client acheteur</th>
              <th></th>
              <th></th>
        		</tr>
          <?php for($i=0;$i<$nb;$i++){?>
            <tr>
              <td><?php echo $bondesortie[$i]->idbondesortie?></td>
              <td><?php echo $bondesortie[$i]->acheteur?></td>
              <td><a href=<?php echo site_url("BonDeSortie/details?ref=".$bondesortie[$i]->idbondesortie) ?>>Voir details</a></td>
              <td><a href=<?php echo site_url("BonDeLivraison/formulaire?idBonDeSortie=".$bondesortie[$i]->idbondesortie."&acheteur=". $bondesortie[$i]->acheteur) ?>><button class="btn btn-primary">Créer bon de livraison</button></a></td>
            </tr>
          <?php }?>
        	</table>
        </div>
    </div>
</div>
