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
            <a href="#"> E-vidy </a>
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
            Demande Proforma 
            <b class="caret"></b>
          </a>
          <ul class="dropdown-menu dropdown-menu-inverse">
            <li>
                <a href="<?php echo absolute_url("DemandeProforma"); ?>">
                  <i class="icon icon-file"></i>&nbsp Saisie
                </a>
            </li>
            <li>
              <a href="<?php echo absolute_url("DemandeProforma/liste"); ?>">
                <i class="icon icon-list"></i>&nbsp Liste
              </a>
            </li>
          </ul>
        </li>
      </ul>

      <ul class="nav navbar-nav">
        <li>
            <a href="<?php echo absolute_url("accueil/liste_bon"); ?>">
            <i class="icon icon-list"></i>&nbsp Liste bon de commandes</a>
        </li>
      </ul>

      <ul class="nav navbar-nav">
        <li>
            <a href="<?php echo absolute_url("accueil/liste_bonDeLivraison"); ?>">
            <i class="icon icon-list"></i>&nbsp Liste Bon de Livraison</a>
        </li>
      </ul>

      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a href="#!#" class="dropdown-toggle" data-toggle="dropdown">
            Bon de reception
            <b class="caret"></b>
          </a>
          <ul class="dropdown-menu dropdown-menu-inverse">
            <li>
                <a href="<?php echo absolute_url("BonDeReception/formulaire"); ?>">
                <i class="icon icon-file"></i>&nbsp Saisie Bon de Reception</a>
            </li>
            <li>
                <a href="<?php echo absolute_url("BonDeReception/"); ?>">
                <i class="icon icon-list"></i>&nbsp Liste Bon de Reception</a>
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
