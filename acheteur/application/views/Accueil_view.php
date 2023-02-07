<div class="content">
    <div class="row">
        <div class="col-md-6 col-md-offset-2" >
            <h3>Proforma concernant l'entreprise</h3>
            <table class="table table-bordered" id="table"></table>
        </div>
    </div>
    <script type="text/javascript">
        const url = "<?php echo "http://localhost:99/fournisseur/api/proforma" ?>";

        function success (res) {
            let str = '';
            // will work since the header is json
            if (res['status'] == 200) {
                // if success, assuming the parsed dat
                let datas = res['datas'];

                for (let data of datas) {
                    str += `<tr>
                                <td>
                                    PROFORMA : ${data.idproforma}
                                </td>
                                <td>
                                    <a href="accueil/cree_commande?ref_proforma=${data.ref_demande_proforma}">
                                        Creer bon
                                    </a>
                                </td>
                            </tr>`;
                }

                $('#table').html(str);

            } else {
                str = 'une erreur est survenue';
            }
        }

        $.get(url, success);
    </script>
</div>
