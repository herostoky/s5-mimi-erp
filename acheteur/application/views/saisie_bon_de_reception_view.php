<div class="content">
    <div class="row text-center">
      <h1>Bon de Reception</h1>
    </div>

    <div class="row">
		<div class="col-md-6 col-md-offset-3">
		  <form action="<?php echo absolute_url("BonDeReception/create") ?>" method="GET">
			<div class="col-md-4">
			  <label>Reference Bon de livraison</label>
			  <input type="text" name="ref_bon_livraison" value="<?php echo $ref_bon_livraison ?>" class="form-control" required>
			</div>
			<div class="col-md-2" style="margin-top: 24px">
			  <button type="submit" class="btn btn-primary">Créer</button>
			</div>
		  </form>
		</div>
    </div>


</div>
