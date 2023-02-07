<?php
class Accueil extends CI_Controller  {
    public function __construct() {
        parent::__construct();
        // some useful stuffs
        $this->load->helper("url_helper");
        $this->load->helper("tool_helper");
        $this->load->helper("formater_helper");
        $this->load->helper("view_helper");

		$this->load->model('general_model');
        $this->load->database();
    }

    public function liste_bonDeLivraison(){
      $options = [
          'menu'    => [],
          'current' => []
      ];

      load_view_set($this, "liste_bon_de_livraison_view", $options);
    }

    public function index() {
      // $produits =

        $options = [
            'menu'    => [],
            'current' => [
                'some_value' => 'hello world'
            ]
        ];

        load_view_set($this, "accueil_view", $options);
    }

    public function liste_bon() {
        $message = $this->input->get("message");
        $options = array(
            'menu'    => array(),
            'current' => array(
                'message' => $message,
                'devises' => $this->db->get('Devise')->result(),
                // 'fournisseurs' => $this->db->get('Fournisseur')->result(),
                'commandes' => $this->db->get('BonDeCommande')->result()
            )
        );
        load_view_set($this, "listebon_view", $options);
    }

    public function nouvelle_commande () {
        $input = $this->input->post();
        $message = "Succes...";
        $error = false;
        try {
            if ($input['remise'] < 0 || $input['remise'] > 100)
                throw new Exception('Erreur. 0% < Reduction globale < 100%');
    
			$entreprise  = 'E-vidy';
			$fournisseur = 'FOURNISSEUR_1';
            $num_bon_commande = $this->general_model->get_generated_id( $fournisseur);
    
            $input['num_bon_commande'] = $num_bon_commande;
            $this->db->insert('BonDeCommande', $input);
        } catch(Exception $ex) {
            $error = true;
            $message = "<b class='text text-danger'>Echec insertion. Veuillez verifier les donnees.</b>".$ex->getMessage();
        } finally {
            if (!$error)
                redirect(absolute_url("accueil/detail?num_bon_commande=".$input['num_bon_commande']));
            else
                redirect(absolute_url("accueil?message=".$message));
        }
    }

    public function detail() {
        $input = $this->input->get();
        $numero = $input['num_bon_commande'];
        $res = $this->db->get_where('BonDeCommande', ['num_bon_commande' => $numero])->result();
        $commande = $res[0];
        $tva = 0.2;
        $devs = $this->db->get_where('Devise', ['iddevise' => $commande->iddevise ] )->result();
        $fournisseur = array('nom' => 'U-Tech');
        $devise = $devs[0];
        $options = array(
            'menu'    => array(),
            'current' => array(
                'fournisseur' => $fournisseur,
                'commande' => $commande,
                'message' => !empty($input['message'])? $input['message'] : '',
                'tva' => $tva,
                'devise' => $devise,
                'num_bon_commande' => $numero,
                'designations' => $this->db->get_where('DetailBonDeCommande', ['num_bon_commande' => $numero])->result()
            )
        );

        load_view_set($this, "detail_view", $options);
    }

    public function nouveau_detailcmd () {
        $input_get = $this->input->get();
        $num_bon_commande = $input_get['num_bon_commande'];
        $input = $this->input->post();
        $message = "Ok.";
        try {
            if (!is_numeric($input['prix']) || !is_numeric($input['quantite']) || !is_numeric($input['remise'])) {
                throw new Exception('Prix unitaire/Qte/remise doit etre numerique');
            }
            $this->db->insert('DetailBonDeCommande', $input);
        } catch(Exception $ex) {
            $message = "<b class='text text-danger'>Echec insertion. Veuillez verifier les donnees.</b>";
        } finally {
            redirect(absolute_url("accueil/detail?num_bon_commande=$num_bon_commande&message=$message"));
        }
    }

    public function suppr_detail ($iddetailbondecommande) {
        $input = $this->input->get();
        $numero = $input['num_bon_commande'];
        $this->db->delete('DetailBonDeCommande', ['iddetailbondecommande' => $iddetailbondecommande]);
        redirect(absolute_url("accueil/detail?num_bon_commande=$numero"));
    }

    public function cree_commande () {
        $input = $this->input->get();
        $ref = $input["ref_proforma"];
        $options = array(
            'menu'    => array(),
            'current' => array(
                'devises' => $this->db->get('Devise')->result(),
                'ref_proforma' => $ref
            )
        );
        load_view_set($this, 'nouveaucmd_view', $options);
    }
}
?>
