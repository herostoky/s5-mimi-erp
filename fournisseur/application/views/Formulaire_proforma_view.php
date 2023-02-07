<script type="text/javascript">
    var detailsProduit = [];
function addProduit(){
      
        let produit = document.getElementById('produit').value;
        let nom =document.getElementById('produit').selectedOptions[0].text;
        let quantite = document.getElementById('quantite').value || 1;
        let remise = document.getElementById('remise').value || 0;
        let item = {
            produit : produit,
            nom : nom,
            quantite : quantite ,
            remise : remise 
        };
        detailsProduit.push(item);
        displayAddedProduit(item);
        
    }
  function displayAddedProduit(produit){
       let body = document.getElementById("details").getElementsByTagName('tbody')[0];
         let newRow = body.insertRow();
            let newCell = newRow.insertCell();
            newCell.appendChild(document.createTextNode(produit.nom));
            newCell = newRow.insertCell();
            newCell.appendChild(document.createTextNode(produit.quantite));
            newCell = newRow.insertCell();
            newCell.appendChild(document.createTextNode(produit.remise));

    }
   function saveProFormat(){
       // let url ="./Formulaire/Enregistrer";
        let data ={
            acheteur : document.getElementById("acheteur").value,
            refdemandeproforma : document.getElementById("refdemandeproforma").value,
            remiseg : document.getElementById("remiseg").value || 0,
            tva : document.getElementById("tva").value || 20,
            details : detailsProduit
        };
        let inputdata = document.getElementById("data");
        inputdata.value= JSON.stringify(data);
       
        $("#form").submit();
       /*$.ajax({
            type: 'POST',
            url: url,
            data: JSON.stringify(data),
            dataType: 'json',
            
        }).done(function(data){
            console.log(data);
        }).fail(function(data){
            console.log(data);
        });*/
    }
</script>

<div class="content">
    <div class="row">
        <div  class="col-md-8 col-md-offset-2">
            <div >
				<h5><?php echo isset($_GET["message"]) ? $_GET["message"] : ""; ?></h5>
                <div class="form-group row">
                    <div  class="col-md-5 ">
                        <label for="acheteur">Entreprise acheteur</label>
                        <input type="text" class="form-control" name="acheteur" id="acheteur" placeholder="Entreprise acheteur" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div  class="col-md-3">
                        <label for="refdemandeproforma">demande proforma</label>
                        <select class="form-control" id="refdemandeproforma" name="refdemandeproforma" required>
                            <?php
                                foreach($refsDemandeProforma as $element){?> 
                                    <option value="<?php echo $element["iddemandeproforma"] ;?>"> <?php echo $element["iddemandeproforma"] ;?></option>
                            <?php } ?>
                        
                        </select>
                    </div>
                </div> 
                <div class="form-group row">
                    <div  class="col-md-2 ">
                        <label for="remiseg">Remise globale</label>
                        <input type="number" class="form-control" name="remiseg" id="remiseg" placeholder="--">
                    </div> 
                </div> 
                <div class="form-group row">
                    <div  class="col-md-2">
                            <label for="tva">TVA</label>
                            <input class="form-control" id="tva" type="number" value="<?php echo $tva ;?>" name="tva" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div  class="col-md-2 ">
                        <label for="produit">produit</label>
                        <select class="form-control" id="produit" name="produit">
                            <?php
                            for($i=0 ,$key = array_keys($produits) ; $i< count($key);$i++){?> 
                                    <option value="<?php echo $key[$i] ;?>"> <?php echo $produits[$key[$i]]["name"] ;?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div  class="col-md-2 ">
                        <label for="quantite">Quantite</label>
                        <input class="form-control" id="quantite" type="number" value="1" name="quantite" >
                    </div>
                    <!--<div  class="col-md-2 ">
                        <label for="prix">prix</label>
                        <input class="form-control" id="prix" type="number" value="5000" name="prix" readonly>
                    </div>-->
                    <div  class="col-md-2 ">
                        <label for="remise">remise</label>
                        <input class="form-control" id="remise" type="number" name="remise">
                    </div>
                </div>
                <div class="form-group row">
                    <div  class="col-md-2">
                        <button type="button" onclick="addProduit()"  class="btn btn-primary btn-lg btn-block ">+  Ajouter</button>
                    </div>
                <div>
                    
            </div >
        </div>
    </div>
    
        <table class="table" id="details">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Produit</th>
                    <th scope="col">Quantite</th>
                    <th scope="col">remise</th>
                </tr>
            </thead>
            <tbody >
                
                
            </tbody>
        </table>
   
    <div class="form-group row">
        <div  class="col-md-5">
        <form id="form" action="./Formulaire_proforma/Enregistrer" method="POST">
            <input type="hidden" id="data" name="data">
        </form >
            <button type="button" id="savebtn" onclick="saveProFormat()"  class="btn btn-primary btn-lg btn-block ">Enregistrer Proforma</button>
        </div>
    <div>

</div>
