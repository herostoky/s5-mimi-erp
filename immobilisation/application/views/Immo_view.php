<div class="content">
    <div class="row">
        <div class="col-md-10 col-md-offset-1" >
            <h3>Immmobilisation : <?php echo $result['nom'] ?> (<?php echo $result['id'] ?>)</h3>
            <h4>Valeur initiale <?php echo format_money($result['valeur_init']) ?> Ar</h4>
            <h4>Methode <?php echo $result['methode'] ?></h4>
            <h4>Taux lineaire <?php echo $result['taux'] ?>%</h4>
            <?php if ($result['methode'] != 'Lineaire') { ?>
                <h4>Coef deg <?php echo round($result['coef_deg'], 2) ; ?></h4>
                <h5>Taux deg <?php echo $result['taux_deg'] . ' %'; ?></h5>
            <?php } ?>


            <form action="" method="POST">
                Date : <input type="date" name="query_date">
                <input type="submit" class="btn btn-xs btn-primary" value="Determiner valeur">
            </form>
            <hr/>
            <div class="text-danger">
                <?php echo $result['error_message']; ?>
            </div>

            <a href="<?php absolute_url('immo').'/idimmo='.$result['id'] ?>">
                <input type="submit" class="btn btn-xs btn-default" value="Voir toute la progression">
            </a>
            
            <hr/>
            
            <table class="table table-bordered">
                <tr>
                    <th>Annee</th>
                    <th>Taux lin</th>
                    <th>Taux deg</th>
                    <th>V. acquisition</th>
                    <th>Debut exo</th>
                    <th>Fin exo</th>
                    <th>Nb. jours</th>
                    <th>Amort. cumule debut</th>
                    <th>Dotation</th>
                    <th>Amortissement</th>
                    <th>Valeur nette</th>
                </tr>
                <?php 
                    foreach ($result['rows'] as $row) {
                ?>
                    <tr>
                        <td><?php echo $row['annee']; ?></td>
                        <td class="text-right">
                            <?php echo $row['taux'] . ' %'; ?>
                        </td>
                        <td class="text-right">
                            <?php echo $row['taux_deg']. ' %'; ?>
                        </td>
                        <td class="text-right">
                            <?php echo format_money($row['VA']) . ' Ar'; ?>
                        </td>
                        <td>
                            <?php echo $row['debut_exo']; ?>
                        </td>
                        <td>
                            <?php echo $row['fin_exo']; ?>
                        </td>
                        <td>
                            <?php echo $row['nb_jours']; ?>
                        </td>
                        <td class="text-right">
                            <?php echo format_money($row['amort_cumul_debut']). ' Ar'; ?>
                        </td>
                        <td class="text-right">
                            <?php echo format_money($row['dotation']). ' Ar'; ?>
                        </td>
                        <td class="text-right">
                            <?php echo format_money($row['amortissement']) . ' Ar'; ?>
                        </td>
                        <td class="text-right">
                            <?php echo format_money($row['valeur_nette']) . ' Ar'; ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>
