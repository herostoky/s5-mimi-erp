



<div class="content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2" >
            <h3 class="text text-primary">Nouvelle facture</h3>
            <form action="<?php echo absolute_url("facture/nouvelle_facture"); ?>" method="post">
				NUM BON:
                <select name="ref_bon_commande" id="ref_bon_commande" >
                    
                
                <input type="number" id="remise" name="remise" value="" size="11" placeholder="remise" required>
                <select name="iddevise">
                    <?php foreach($devises as $devise) { ?>
                    
                    <option value="<?php echo $devise->iddevise; ?>">
                        <?php echo $devise->nom_devise; ?>
                    </option>
                    
                    <?php } ?>
                </select>

                
                <input type="submit" value="Valider">
            </form>
            <script type="text/javascript">
                const url = "<?php echo "http://localhost:99/acheteur/BonDeCommande" ?>";

                function success (res) {
                    let str = '';
                    // will work since the header is json
                    if (res['status'] == 200) {
                        // if success, assuming the parsed dat
                        let datas = res['datas'];

                        for (let data of datas) {
                            str += `<option value="${data.num_bon_commande}">
                                        ${data.num_bon_commande}
                                    </option>`;
                        }
                        str += `</select>`;
                        $('#ref_bon_commande').html(str);

                    } else {
                        str = 'une erreur est survenue';
                    }
                }

        $.get(url, success);
    </script>
        </div>
    </div>
</div>
