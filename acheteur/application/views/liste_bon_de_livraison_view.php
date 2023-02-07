<script type="text/javascript">
       const url = "<?php echo "http://localhost/gestion/fournisseur/api/BonDeLivraison" ?>";
       const absolute_url = "<?php echo absolute_url('') ?>";

       function success (res) {

           let str = `<tr>
                         <th>ID</th>
                         <th>Acheteur</th>
                         <td></td>
                       </tr>`;
           if (res['status'] == 200) {
               let datas = res['datas'];

               for (let data of datas) {
                   str += `<tr>
                               <td>${data.idbondelivraison}</td>
                               <td>${data.acheteur}</td>
                               <td><a href="${absolute_url}BonDeReception/formulaire?ref_bon_livraison=${data.idbondelivraison}"><button class="btn btn-primary">Créer Bon de reception</button></a></td>
                           </tr>`;
               }

               $('#table').html(str);

           } else {
               str = 'une erreur est survenue';
           }
       }

       $.get(url, success);
   </script>

<div class="content">
    <div class="row">
        <div class="col-md-5 col-md-offset-2" >
        	<h3>Bon de Livraison</h3>
        	<table id="table" class="table table-bordered">

        	</table>
        </div>
    </div>
</div>
