<?php
class BonDeCommande extends CI_Controller  {
    public function __construct() {
        parent::__construct();
        // some useful stuffs
        $this->load->helper("url_helper");
        $this->load->helper("tool_helper");
        $this->load->helper("formater_helper");
        $this->load->helper("view_helper");

        // $this->load->model("produit_model");
        $this->load->database();
    }

    public function index() {
        $options = [
                'menu'    => [],
                'current' => []
            ];
        load_view_set($this, "liste_bon_view", $options);
    }

    public function nouvelle_sortie () {
        $input = $this->input->get();
        $input["acheteur"] = "acheteur";
        $message = "Succes...";
        $error = false;
        try {
            $this->db->insert('BonDeSortie', $input);
        } catch(Exception $ex) {
            $error = true;
            $message = "<b class='text text-danger'>Echec insertion. Veuillez verifier les donnees.</b>".$ex->getMessage();
        } finally {
            if (!$error)
                redirect(absolute_url("BonDeSortie/liste"));
            else
                redirect(absolute_url("accueil?message=".$message));
        }
    }

    public function details() {
        $input = $this->input->get();
        $numero = $input['num_bon_commande'];
        $options = [
                'menu'    => [],
                'current' => [
                    'devises' => $this->db->get('Devise')->result(),
                    'num_bon_commande' => $numero
                ]
            ];
        load_view_set($this, "saisie_bondesortie_view", $options);
    }
}

?>