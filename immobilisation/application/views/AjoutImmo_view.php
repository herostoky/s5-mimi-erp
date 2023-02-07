<div class="content">
    <div class="row">
        <div class="col-md-3 col-md-offset-2" >
            <h3>Ajouter une immobilisation</h3>
            <form class="form" action="<?php echo absolute_url('accueil/add') ?>" method="POST">
                <div class="form-group">
                    Nom <input class="form-control" type="text" name="nom"  required="" placeholder="Nom de l'immobilisation">
                </div>
                <div class="form-group">
                    Valeur <input class="form-control" type="number" name="valeur"  required="" placeholder="Valeur initiale">
                </div>
                <div class="form-group">
                    Debut usage <input class="form-control" type="date" name="debut_usage"  required="" placeholder="Date premier usage">
                </div>
                <div class="form-group">
                    Fin d'exercice :
                    Jour <select name="jour_fin_exo">
                        <?php $i = 1; while ($i <= 31) { ?>
                            <option value="<?php echo $i ?>"><?php echo $i ?></option>
                        <?php ++$i; } ?>
                    </select>
                    Mois <select name="mois_fin_exo">
                        <?php $i = 1; while ($i <= 12) { ?>
                            <option value="<?php echo $i ?>"><?php echo $i ?></option>
                        <?php ++$i; } ?>
                    </select>
                </div>
                <div class="form-group">
                    Taux :
                    Duree amorti <input type="number" name="duree_amortissement" size="3" required="">
                    <br/>
                    Coef. degressif <input type="text" name="coef_deg" size="3" required="">
                </div>
                <input type="submit" class="btn btn-primary" value="Ajouter">
            </form>

            <div>
                <span class="text text-danger"><?php echo $error ?></span>
            </div>
        </div>
    </div>
</div>
