<div class="content">
    <div class="row text-center">
      <h1>Demande de Proforma</h1>
    </div>

    <div class="row">
		<div class="col-md-6 col-md-offset-3">
		  <form action="<?php echo absolute_url("DemandeProforma/ajout_ligne_demandeproforma") ?>" method="GET">
			<div class="col-md-4">
			  <label>Désignation</label>
			  <input type="text" name="designation" placeholder="Désignation" class="form-control" required>
			</div>
			<div class="col-md-2">
			  <label>Quantité</label>
			  <input type="number" name="quantite" placeholder="Quantité" class="form-control" required>
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
            <tr>
          </thead>
          <tbody>
      <?php for($i=0; $i<count($produits); $i++) { ?>
            <tr>
              <td><?php echo $produits[$i]['designation']; ?></td>
              <td class="text-right"><?php echo $produits[$i]['quantite']; ?></td>
            </tr>
      <?php } ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="row">
      <form action="<?php echo absolute_url("DemandeProforma/validation_demandeproforma") ?>">
        <div class="col-md-1 col-md-offset-3">
          <label>Fournisseur</label>
          <select name="idFournisseur" class="form-control">
      <?php foreach($fournisseurs as $fournisseur) { ?>
            <option value="<?php echo $fournisseur['idfournisseur']; ?>"><?php echo $fournisseur['nom_fournisseur']; ?></option>
      <?php } ?>
          </select>
        </div>
        <div class="col-md-3" style="margin-top: 24px">
            <button type="submit" class="btn btn-warning">Valider</button>
            <a href="<?php echo absolute_url("DemandeProforma/annulation_demandeproforma") ?>"><button class="btn btn-danger">Annuler</button></a>
        </div>
      </form>
    </div>

</div>
