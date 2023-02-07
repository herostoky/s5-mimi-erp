<?php

    $nbdetail=0;
    if($details!=null)$nbdetail=count($details);
    $total = 0;
    $totaltva=0;
?>
<div class="content">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <form class="form" action="<?php echo absolute_url("BonDeSortie/nouveau_detail?ref=$bondesortie->idbondesortie")?>" method="post">
        <h4>Nouvel element</h4>
        <input type="hidden" name="bon_de_sortie" value="<?php echo $bondesortie->idbondesortie ?>" required>
        <select id="produit" name="produit">
            <?php
            for($i=0 ,$key = array_keys($produits) ; $i< count($key);$i++){?> 
                    <option value="<?php echo $key[$i] ;?>"> <?php echo $produits[$key[$i]]["name"] ;?></option>
            <?php } ?>
        </select>
        <input type="number" name="quantite" size="5" placeholder="qte" required>
        <button class="btn btn-xs btn-success">Ajouter</button>
      </form>
      <?php echo $message ?>
    </div>
    
  </div>
  
  <div class="row">
      <div class="col-md-10 col-md-offset-1" >

          <div class="col-md-3">
            <table class="table table-bordered">
              <tr>
                <th>Acheteur</th>
                <th>Remise globale</th>
                <th>reference</th>
                <th>devise</th>
              </tr>
              <tr>
                <td> <?php echo $bondesortie->acheteur;?></td>
                <td> <?php echo $bondesortie->remise;?>%</td>
                <td><?php echo $bondesortie->ref_demande_proforma;?></td>
                <td><?php echo $devise->etiquette;?></td>
                
              </tr>
            </table>
          </div> </br>
          <table id="result" class="table table-bordered" >
              <tr>
                    <th>ID</th>
                  <th>Designation</th>
                  <th>Quantite</th>
                  <th>Prix unitaire</th>
                  <th>Montant</th>
                  <th>x Remise globale <?php echo $bondesortie->remise; ?>%</th>
                  <th>Montant TTC</th>
                  <th></th>
              </tr>
              <?php
                for($i=0;$i<$nbdetail;$i++){
                    $total += $details[$i]->prix * $details[$i]->quantite;
              ?>
                <tr>
                    <td><?php echo $details[$i]->idproduit;?></td>
                    <td><?php echo $details[$i]->designation;?></td>
                    <td><?php echo $details[$i]->quantite;?></td>
                    <td><?php echo $details[$i]->prix;?></td>
                    <td><?php echo $details[$i]->prix * $details[$i]->quantite ;?></td>
                    <td><?php echo $details[$i]->prix;?></td>
                    <td><?php echo $details[$i]->prix * $details[$i]->quantite * (1 + ($tva / 100)) ;?></td>

                    <td><a href=<?php echo absolute_url("BonDeSortie/enlever_detail?ref=".$details[$i]->iddetailbondesortie."&bon=".$bondesortie->idbondesortie)?>> <button class="btn btn-xs btn-danger">x</button></a></td>
                </tr>
              <?php }
                $montant_no_redux = $total * (1 - ($bondesortie->remise / 100));
                $totaltva = $montant_no_redux * (1 + ($tva / 100));
              ?>
              <tr>
                <td colspan="4" class="text-right"><b>Total</b></td>    
                <td class="text-right"><?php echo $total ; ?> <?php echo $devise->etiquette ?></td>    
                <td class="text-right"><?php echo  $montant_no_redux; ?> <?php echo $devise->etiquette ?></td>    
                 
                <td class="text-right">
                   <?php echo $totaltva; ?> <?php echo $devise->etiquette ?></td>    
              </tr>
          </table>
      </div>
  </div>   
  
</div>