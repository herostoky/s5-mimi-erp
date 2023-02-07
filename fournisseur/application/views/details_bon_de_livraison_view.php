<div class="content">
    <div class="row text-center">
      <h1>Bon de Livraison N° <?php echo $idBonDeLivraison ?></h1>
    </div>

    <div class="row">
		<div class="col-md-6 col-md-offset-3">
		  <form action="<?php echo absolute_url("BonDeLivraison/ajout_ligne_bondelivraison") ?>" method="GET">
      <div class="col-md-4">
        <input type="hidden" name="idBonDeLivraison" value="<?php echo $idBonDeLivraison ?>">

			  <label>Produit</label>
			  <select name="idProduit" class="form-control">
    <?php foreach($produits as $produit) { ?>
          <option value="<?php echo $produit->idproduit ?>"><?php echo $produit->designation ?></option>
    <?php } ?>
        </select>
			</div>
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
      <?php foreach($detailsBonDeLivraison as $detailBonDeLivraison) { ?>
            <tr>
              <td><?php echo $detailBonDeLivraison->designation ?></td>
              <td><?php echo $detailBonDeLivraison->quantite ?></td>
              <th><a href="<?php echo absolute_url("BonDeLivraison/delete_detail/".$detailBonDeLivraison->iddetailbondelivraison."/".$idBonDeLivraison)?>"><button class="btn btn-danger">Supprimer</button></a></th>
            </tr>
      <?php } ?>
          </tbody>
        </table>
      </div>
    </div>

</div>
