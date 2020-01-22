<?php
ob_start();                 // output buffering
session_start();            // spusteni session
include "pages/config.php"; // include configu
?>

<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title>ČESKÁ FILMOVÁ DATABÁZE</title>
  <link rel="stylesheet" href="css/test2.css">
  <meta name="theme-color" content="#fafafa">
</head>

<body>
<header>
  <div>
    <nav>
      <a href="<?=BASE_URL ?>">Hlavní stránka</a>
      <a href="<?=BASE_URL . "?page=filmy" ?>">Filmy</a>
      <a href="<?=BASE_URL . "?page=kontakt" ?>">Kontakt</a>
      <a href="#">Hodnocení</a>
      <?php if(empty($_SESSION["id_uzivatel"])) { ?>
        <a href="<?=BASE_URL . "?page=login" ?>">Login</a>
        <a href="<?=BASE_URL . "?page=user/user_add" ?>">Registrace</a>
      <?php } else { ?>
        <a href="<?=BASE_URL . "?page=logout" ?>">Logout</a>
        <?php if($_SESSION["role"] == 1) { ?>
          <a href="<?=BASE_URL . "?page=film/film_add" ?>">Správa filmů</a>
          <a href="<?=BASE_URL . "?page=user/user" ?>">Správa uzivatelu</a>

        <?php } ?>
      <?php } ?>

    </nav>
  </div>
</header>
<?php
if(isset($_GET["page"])) {
  $file = "./pages/" . $_GET['page'] . ".php";

  if (file_exists($file)) {
    include $file;
  } else {
    include "./pages/default.php";
  }
}else{
  include "./pages/default.php";
}
?>
<footer>
  <div class="full-width-wrapper">
    <div class="flex-wrap">
      <section>
        <h4>Kino</h4>
        <ul>
          <li><a href="#">Informace</a></li>
          <li><a href="#">Reference</a></li>
          <li><a href="#">Přihlášení</a></li>
        </ul>
      </section>

      <section>
        <h4>Odkazy</h4>
        <ul>
          <li><a target="_blank" href="https://www.csfd.cz/">ČSFD</a></li>
          <li><a target="_blank" href="https://www.upce.cz/">UPCE</a></li>
          <li><a target="_blank" href="https://www.facebook.com/">Facebook</a></li>
        </ul>
      </section>

      <section>
        <h4>Kontakt</h4>
        <address>
          Humpolecká 1731, 393 01 Pelhřimov<br>
          Česká republika <br>
          +420 123 456 789 <br>
          Email: <a href="mailto:mail@upce.cz">
            mail@upce.cz</a> <br>
        </address>
      </section>
    </div>
    <section style="margin: auto" class="card">
      <p>
        Copyright
        <?php echo date("Y"); ?>
      </p>
    </section>
  </div>
</footer>
</body>
</html>
