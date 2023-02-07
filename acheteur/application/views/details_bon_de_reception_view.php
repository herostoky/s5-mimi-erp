<div class="content">
    <div class="row text-center">
      <h1>Bon de Reception N° <?php echo $idBonDeReception ?></h1>
    </div>

    <div class="row">
		<div class="col-md-6 col-md-offset-3">
		  <form action="<?php echo absolute_url("BonDeReception/ajout_ligne_bondereception") ?>" method="GET">
        <input type="hidden" name="idBonDeReception" value="<?php echo $idBonDeReception ?>">

  			<div class="col-md-4">
  			  <label>Désignation</label>
  			  <input type="text" name="designation" placeholder="Désignation" class="form-control" required>
  			</div>
  			<div class="col-md-2">
  			  <label>Quantité</label>
  			  <input type="number" name="quantite" placeholder="Quantité" class="form-control" min=1 required>
  			</div>
  			<div class="col-md-2" style="margin-top: 24px">
  			  <button type="submit" class="btn btn-primary">Insérer</button>
  			</div>
		  </form>
		</div>
    </div>

    <div class="row" style="margin-top: 50px">
      <div class="col-md-6 col-md-offset-3">
        <table class="table table-bordered">
          <thead class="thead-dark">
            <tr>
              <th>Désignation</th>
              <th>Quantité</th>
              <th></th>
            <tr>
          </thead>
          <tbody>
      <?php foreach($detailsBonDeReception as $detailBonDeReception) { ?>
            <tr>
              <td><?php echo $detailBonDeReception->designation ?></td>
              <td><?php echo $detailBonDeReception->quantite ?></td>
              <th><a href="<?php echo absolute_url("BonDeReception/delete_detail/".$detailBonDeReception->iddetailbonreception."/".$idBonDeReception)?>"><button class="btn btn-danger">Supprimer</button></a></th>
            </tr>
      <?php } ?>
          </tbody>
        </table>
      </div>
    </div>

</div>
