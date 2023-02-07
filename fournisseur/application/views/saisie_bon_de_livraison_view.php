<div class="content">
    <div class="row text-center">
      <h1>Bon de Livraison</h1>
    </div>

    <div class="row">
		<div class="col-md-6 col-md-offset-3">
		  <form action="<?php echo absolute_url("BonDeLivraison/create") ?>" method="GET">
			<div class="col-md-4">
			  <label>Acheteur</label>
			  <input type="text" name="acheteur" placeholder="Acheteur" value="<?php echo $acheteur ?>" class="form-control" required>
			</div>
			<div class="col-md-4">
			  <label>ID Bon de sortie</label>
			  <input type="text" name="idBonDeSortie" placeholder="ID Bon de sortie" value="<?php echo $idBonDeSortie ?>" class="form-control" required>
			</div>
			<div class="col-md-2" style="margin-top: 24px">
			  <button type="submit" class="btn btn-primary">Créer</button>
			</div>
		  </form>
		</div>
    </div>


</div>
