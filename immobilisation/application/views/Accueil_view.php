<div class="content">
    <div class="row">
        <div class="col-md-10 col-md-offset-1" >
            <h3>Liste immobilisations</h3>
            <form action="<?php absolute_url('accueil') ?>" method="GET">
                <input type="text" name="search" placeholder="Mot cle" >
                <input type="submit" class="btn btn-xs btn-primary" value="Rechercher">
            </form>
            <hr/>
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Valeur initiale</th>
                    <th>Debut usage</th>
                    <th>Fin exercice</th>
                    <th>Duree amortissement</th>
                    <th>Coeficient degressif</th>
                </tr>
                <?php 
                    foreach ($liste_immo as $immo) {
                        $id = $immo->idimmobilisation;
                        $date_fin = $immo->jour_fin_exo .'/'.$immo->mois_fin_exo;
                        $taux = round(100 /$immo->duree_amortissement, 2);
                ?>
                    <tr>
                        <td class="text-left"><?php echo $immo->idimmobilisation; ?></td>
                        <td  class="text-left"><?php echo $immo->nom; ?></td>
                        <td  class="text-right"><?php echo format_money($immo->valeur); ?> Ar</td>
                        <td class="text-left"><?php echo $immo->debut_usage; ?></td>
                        <td class="text-right"><?php echo $date_fin; ?></td>
                        <td class="text-right">
                            <?php echo $immo->duree_amortissement; ?> ans 
                            (<?php echo $taux ?> %)
                        </td>
                        <td class="text-right"><?php echo round($immo->coef_deg, 2); ?></td>
                        <td>
                            <a href="<?php echo absolute_url('immo') . "?methode=lineaire&idimmo=$id" ; ?>">     
                                <button class="btn btn-xs btn-primary">Mode lineaire</button>
                            </a>
                        </td>
                        <td>
                            <a href="<?php echo absolute_url('immo') . "?methode=degressif&idimmo=$id" ; ?>">     
                                <button class="btn btn-xs btn-danger">Mode degressif</button>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>
