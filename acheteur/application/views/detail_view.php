<div class="content">
  
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <form class="form" action="<?php echo absolute_url("accueil/nouveau_detailcmd?num_bon_commande=$num_bon_commande")?>" method="post">
        <h4>Nouvel element</h4>
        <input type="hidden" name="num_bon_commande" value="<?php echo $commande->num_bon_commande ?>" placeholder="Numero bon de commande" required>
        <input type="text" name="designation" placeholder="Designation" required>
        <input type="number" name="prix" size="7" placeholder="P.Unitaire" required>
        <input type="number" name="remise" size="8" placeholder="remise" required>
        <input type="number" name="quantite" size="5" placeholder="qte" required>
        <button class="btn btn-xs btn-success">Ajouter</button>
      </form>
      <?php echo $message ?>
    </div>
    
  </div>
  
  <div class="row">
    <center>
      <h3 class="text text-primary">Q-Labs</h3>
    </center>
  </div>

  <div class="row">
      <div class="col-md-10 col-md-offset-1" >
            <h3 class="text text-primary">Bon de commande <?php echo $commande->num_bon_commande ?></h3>

          <div class="col-md-3">
            <table class="table table-bordered">
              <tr>
                <th>Fournisseur</th>
                <th>Remise globale</th>
                <th>TVA</th>
              </tr>
              <tr>
                <td><?php echo $fournisseur["nom"] ?></td>
                <td><?php echo $commande->remise ?>%</td>
                <td><?php echo $tva * 100 ?>%</td>
              </tr>
            </table>
          </div> </br>
          <table id="result" class="table table-bordered" >
              <tr>
                  <th>Designation</th>
                  <!-- <th>Type</th> -->
                  <!-- <th>Unite</th> -->
                  <th>Prix Unitaire</th>
                  <th>Quantite</th>
                  <th>Reduction</th>
                  <th>Montant</th>
                  <th>x Remise</th>
                  <th>x Remise globale <?php echo $commande->remise ?>%</th>
                  <th>Montant TTC</th>
                  <th></th>
              </tr>

            <?php
              $lang  = $devise->etiquette == '$' ? 'en' : 'fr';
              $unite = $devise->nom_devise. ($devise->etiquette == 'Ar' ? '' : 's'); 

              $total = 0;
              $total_redux = 0; // remise par ligne
              $total_redux_globale = 0; // remise sur toutes les donnees
              $total_ttc = 0; // net remise + calcul TVA
              foreach($designations as $des) {
                $redux_100 = ($des->remise); // reduction en %
                $montant_no_redux = $des->quantite * $des->prix; // prix brute total
                $montant_redux = $montant_no_redux * (1 - ($des->remise / 100)); // valeur apres reduction (net remise)
                $montant_redux_global = $montant_redux * (1 - ($commande->remise / 100));
                $montant_ttc = $montant_redux_global * (1 + $tva);

                $total += $montant_no_redux; // total brute : remise et taxe non inclus
                $total_redux += $montant_redux; // reduction individuelle
                $total_redux_globale += $montant_redux_global; //  // total net remise (total brute avec reduction individuelle + globale ) 
                $total_ttc += $montant_ttc; // total taxe inclus
                $total_ttc = round($total_ttc, 2);
            ?>
              <tr>
                <td class="text-left"><?php echo $des->designation ?></td>    
                <!-- <td class="text-left"></td>    -->
                <!--  <td class="text-right"><? //$des->unite ?></td> -->
                <td class="text-right"><?php echo format_money($des->prix) ?>  <?php echo $devise->etiquette ?></td>    
                <td class="text-right">x <?php echo $des->quantite ?></td>    
                <td class="text-right"><?php echo $redux_100 ."%" ?></td>    
                <td class="text-right"><?php echo format_money($montant_no_redux) ?> <?php echo $devise->etiquette ?></td>    
                <td class="text-right"><?php echo format_money($montant_redux) ?> <?php echo $devise->etiquette ?></td>    
                <td class="text-right"><?php echo format_money($montant_redux_global) ?> <?php echo $devise->etiquette ?></td>    
                <td class="text-right"><?php echo format_money($montant_ttc) ?> <?php echo $devise->etiquette ?></td>    
                <td class="text-right">
                  <a href='<?php echo absolute_url("accueil/suppr_detail/$des->iddetailbondecommande?num_bon_commande=$commande->num_bon_commande") ?>' onclick="return(confirm('Supprimer?'))">
                    <button class="btn btn-xs btn-danger">x</button>
                  </a>
                </td>    
              </tr>
            <?php }?>
              <tr>
                <td colspan="4" class="text-right"><b>Total</b></td>    
                <td class="text-right"><?php echo format_money($total) ?> <?php echo $devise->etiquette ?></td>    
                <td class="text-right"><?php echo format_money($total_redux) ?> <?php echo $devise->etiquette ?></td>    
                <td class="text-right">
                  <b>Net remise</b>
                  <?php echo format_money($total_redux_globale) ?> <?php echo $devise->etiquette ?>
                </td>    
                <td class="text-right">
                  <b>TTC</b> <?php echo format_money($total_ttc) ?> <?php echo $devise->etiquette ?></td>    
              </tr>
          </table>

          <center>"Arrêté le présent bon de commande à la somme de <b><?php echo to_letter_float($total_ttc, $lang, $devise->nom_devise) ?>  </b>"</center>

          

      </div>
  </div>   
    </br>
  <div class="row">
    <div class="col-md-12 col-md-offset-1">
      Le fournisseur
      <?php
        $i = 240;
        while ($i--) echo "&nbsp";
      ?>
      Le client
    </div>
  </div> 
</div>