<?php
class Facture extends CI_Controller  {
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

    public function index() {
      $produits = "";

        $options = [
            'menu'    => [],
            'current' => [
                'some_value' => 'hello world'
            ]
        ];

        load_view_set($this, "accueil_view", $options);
    }

    public function liste_facture() {
        $message = $this->input->get("message");
        $options = array(
            'menu'    => array(),
            'current' => array(
                'message' => $message,
                'devises' => $this->db->get('Devise')->result(),
                // 'fournisseurs' => $this->db->get('Fournisseur')->result(),
                'factures' => $this->db->get('Facture')->result()
            )
        );
        load_view_set($this, "liste_facture_view", $options);
    }

    public function nouvelle_facture () {
        $input = $this->input->post();
        $message = "Succes...";
        $error = false;
        try {
            if ($input['remise'] < 0 || $input['remise'] > 100)
                throw new Exception('Erreur. 0% < Reduction globale < 100%');
    
            $entreprise  = 'Q-Labs';
            $acheteur = '1';
            $num_facture = $this->general_model->get_generated_id($acheteur);
    
            $input['num_facture'] = $num_facture;
            $this->db->insert('Facture', $input);
        } catch(Exception $ex) {
            $error = true;
            $message = "<b class='text text-danger'>Echec insertion. Veuillez verifier les donnees.</b>".$ex->getMessage();
        } finally {
            if (!$error)
                redirect(absolute_url("facture/detail?num_facture=".$input['num_facture']));
            // else
            //     redirect(absolute_url("accueil?message=".$message));
        }
    }

    public function detail() {
        $input = $this->input->get();
        $numero = $input['num_facture'];
        $res = $this->db->get_where('Facture', ['num_facture' => $numero])->result();
        $facture = $res[0];
        $tva = 0.2;
        $devs = $this->db->get_where('Devise', ['iddevise' => $facture->iddevise ] )->result();
        $acheteur = array('nom' => 'U-Tech');
        $devise = $devs[0];
        $options = array(
            'menu'    => array(),
            'current' => array(
                'acheteur' => $acheteur,
                'facture' => $facture,
                'message' => !empty($input['message'])? $input['message'] : '',
                'tva' => $tva,
                'devise' => $devise,
                'num_facture' => $numero,
                'designations' => $this->db->get_where('DetailFacture', ['num_facture' => $numero])->result()
            )
        );

        load_view_set($this, "detail_facture_view", $options);
    }

    public function nouveau_detail_facture () {
        $input_get = $this->input->get();
        $num_facture = $input_get['num_facture'];
        $input = $this->input->post();
        $message = "Ok.";
        try {
            if (!is_numeric($input['prix']) || !is_numeric($input['quantite']) || !is_numeric($input['remise'])) {
                throw new Exception('Prix unitaire/Qte/remise doit etre numerique');
            }
            $this->db->insert('DetailFacture', $input);
        } catch(Exception $ex) {
            $message = "<b class='text text-danger'>Echec insertion. Veuillez verifier les donnees.</b>";
        } finally {
            redirect(absolute_url("facture/detail?num_facture=$num_facture&message=$message"));
        }
    }

    public function suppr_detail ($iddetailfacture) {
        $input = $this->input->get();
        $numero = $input['num_facture'];
        $this->db->delete('DetailFacture', ['iddetailfacture' => $iddetailfacture]);
        redirect(absolute_url("facture/detail?num_facture=$numero"));
    }

    public function cree_facture () {
        $input = $this->input->get();
        $ref = !empty($input['ref_bon_commande'])? $input['ref_bon_commande'] : '';
        $options = array(
            'menu'    => array(),
            'current' => array(
                'devises' => $this->db->get('Devise')->result(),
                'ref_bon_commande' => $ref
            )
        );
        load_view_set($this, 'nouveau_facture_view', $options);
    }
}
?>
