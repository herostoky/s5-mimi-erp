<?php if (!isset($_GET["extern"])) { ?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
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
            <a href="#">Immobilisation</a>
        </li>
      </ul>
      <ul class="nav navbar-nav">
  			<li>
            <a href="<?php echo absolute_url("accueil"); ?>">
            <i class="icon icon-home"></i>&nbsp Accueil</a>
        </li>
        <li>
            <a href="<?php echo absolute_url("accueil/nouvel_immo"); ?>">
            <i class="icon icon-file"></i>&nbsp Ajouter</a>
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
