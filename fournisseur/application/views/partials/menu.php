<?php if (!isset($_GET["extern"])) { ?>
<nav class="navbar navbar-light navbar-fixed-top" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex2-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <div class="collapse navbar-collapse navbar-ex2-collapse">
      <ul class="nav navbar-nav">
        <li>
            <a href="#"> Fournisseur | PC Upgrade </a>
        </li>
      </ul>
      <ul class="nav navbar-nav">
  			<li>
            <a href="<?php echo absolute_url("accueil"); ?>">
            <i class="icon icon-home"></i>&nbsp Accueil</a>
        </li>
      </ul>
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a href="#!#" class="dropdown-toggle" data-toggle="dropdown">
            Proforma
            <b class="caret"></b>
          </a>
          <ul class="dropdown-menu dropdown-menu-inverse">
            <li>
                <a href="<?php echo absolute_url("Formulaire_proforma"); ?>">
                <i class="icon icon-file"></i>&nbsp Formulaire de proforma</a>
            </li>
            <li>
                <a href="<?php echo absolute_url("proforma/liste"); ?>">
                <i class="icon icon-list"></i>&nbsp Liste proforma</a>
            </li>
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav">
        <li>
            <a href="<?php echo absolute_url("BonDeCommande"); ?>">
            <i class="icon icon-list"></i>&nbsp Bon de commande</a>
        </li>
      </ul>
      <ul class="nav navbar-nav">
        <li>
            <a href="<?php echo absolute_url("BonDeSortie/liste"); ?>">
            <i class="icon icon-list"></i>&nbsp Liste Bon de sortie</a>
        </li>
      </ul>
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a href="#!#" class="dropdown-toggle" data-toggle="dropdown">
            Bon de livraison
            <b class="caret"></b>
          </a>
          <ul class="dropdown-menu dropdown-menu-inverse">
            <li>
                <a href="<?php echo absolute_url("BonDeLivraison/formulaire"); ?>">
                <i class="icon icon-file"></i>&nbsp Formulaire Bon de Livraison</a>
            </li>
            <li>
                <a href="<?php echo absolute_url("BonDeLivraison"); ?>">
                <i class="icon icon-list"></i>&nbsp Liste Bon de Livraison</a>
            </li>
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a href="#!#" class="dropdown-toggle" data-toggle="dropdown">
            Facture
            <b class="caret"></b>
          </a>
          <ul class="dropdown-menu dropdown-menu-inverse">
            <li>
                <a href="<?php echo absolute_url("facture/cree_facture"); ?>">
                <i class="icon icon-file"></i>&nbsp Creer</a>
            </li>
            <li>
                <a href="<?php echo absolute_url("facture/liste_facture"); ?>">
                <i class="icon icon-list"></i>&nbsp Liste</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<?php } else { ?>
[NOTE : DOCUMENT EXTERNE]
<?php } ?>
<br />
<br />
<br />
