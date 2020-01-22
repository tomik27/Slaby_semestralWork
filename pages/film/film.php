<?php
$id_film = $_GET["id"];
$hodnoceni = 'nehodnoceno';
$conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if(!empty($_SESSION["id_uzivatel"])){
$id= $_SESSION["id_uzivatel"];
$data = $conn->query("SELECT * FROM filmy JOIN hodnocene_filmy_uzivatelem ON hodnocene_filmy_uzivatelem.filmy_id_film=filmy.id_film
 WHERE id_film = $id_film AND uzivatele_id_uzivatel=$id")->fetch();
echo $data["hodnoceni_filmu"];
  if( $data["hodnoceni_filmu"]!=null){
    $hodnoceni = $data["hodnoceni_filmu"];
  }
}
$dataFilmu = $conn->query("SELECT * FROM filmy join zanry on zanry_id_zanr=zanry.id_zanr WHERE id_film = $id_film ")->fetch();
?>
<main>
  <div class="margin_top">
    <h1>Login</h1>
  </div>
  <form method="post" class="form_align" enctype="multipart/form-data">
    <input type="text" name="jmeno" placeholder="Jméno"  value="<?= $dataFilmu["nazev"];?>">
    <input type="text" name="prijmeni" placeholder="Příjmení" value="<?= $dataFilmu["rok_vydani"]; ?>"/>
    <input type="text" name="prijmeni" placeholder="Příjmení" value="<?= $dataFilmu["nazev_zanru"]; ?>"/>
    <input type="text" name="email" placeholder="Email" value="<?=$hodnoceni  ?>"/>
  </form>
  <?php echo '<img src="' . $dataFilmu["cesta_k_obrazku"] . '"/>';

   if(!empty($_SESSION["id_uzivatel"])){echo $hodnoceni; echo '
        <img class="obrazek_film" src="./Uploads/obr5.jpg" height="40" width="40">
        C:/xampp/htdocs/untitled1/Uploads/obr5.jpg
<h1>Hvezdy</h1>
  <form method="post" id="ratingsForm" enctype="multipart/form-data">
    <div class="stars">
      <input type="radio" name="star" value="1" class="star-1" id="star-1" '; if($data["hodnoceni_filmu"]==1){echo ' checked';} echo' />
      <label class="star-1" for="star-1">1</label>
      <input type="radio" name="star"  value="2"  class="star-2" id="star-2" '; if($data["hodnoceni_filmu"]==2){echo ' checked';} echo' />
      <label class="star-2" for="star-2">2</label>
      <input type="radio" name="star"  value="3"  class="star-3" id="star-3" '; if($data["hodnoceni_filmu"]==3){echo ' checked';}  echo' />
      <label class="star-3" for="star-3">3</label>
      <input type="radio" name="star"  value="4"  class="star-4" id="star-4" '; if($data["hodnoceni_filmu"]==4){echo ' checked';} echo'/>
      <label class="star-4" for="star-4">4</label>
      <input type="radio" name="star"  value="5"  class="star-5" id="star-5" '; if($data["hodnoceni_filmu"]==5){echo ' checked';} echo' />
      <label class="star-5" for="star-5">5</label>
      <span></span>
    </div>
    <input type="submit" name="isSubmitted" value="Pridat">
  </form>'; }
  ?>
<main/>
  <h1>Hodnoceni uzivatelem</h1>>

  <?php
  foreach ($data as $row) {
    echo '   
   <form  id="ratingsForm" enctype="multipart/form-data">
    <div class="stars">
      <input type="radio" name="star" value="1" class="star-1" id="star-1" '; if($row["hodnoceni_filmu"]==1){echo ' checked';} echo' />
      <label class="star-1" for="star-1">1</label>
      <input type="radio" name="star"  value="2"  class="star-2" id="star-2" '; if($row["hodnoceni_filmu"]==2){echo ' checked';} echo' />
      <label class="star-2" for="star-2">2</label>
      <input type="radio" name="star"  value="3"  class="star-3" id="star-3" '; if($row["hodnoceni_filmu"]==3){echo ' checked';}  echo' />
      <label class="star-3" for="star-3">3</label>
      <input type="radio" name="star"  value="4"  class="star-4" id="star-4" '; if($row["hodnoceni_filmu"]==4){echo ' checked';} echo'/>
      <label class="star-4" for="star-4">4</label>
      <input type="radio" name="star"  value="5"  class="star-5" id="star-5" '; if($row["hodnoceni_filmu"]==5){echo ' checked';} echo' />
      <label class="star-5" for="star-5">5</label>
      <span></span>
    </div>
  </form>';
  }

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  $radioVal = $_POST["star"];
 if($radioVal=="1") {
   echo 'choose one';
 }else if($radioVal=="2"){
   echo 'choose second';
 }
    }
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo $radioVal;
    $id= $_SESSION["id_uzivatel"];
  $data2 = $conn->query("SELECT * FROM hodnocene_filmy_uzivatelem WHERE filmy_id_film = $id_film AND uzivatele_id_uzivatel=$id")->fetch();
if(empty($data2["hodnoceni_filmu"])){
  $stmt = $conn->prepare("INSERT INTO hodnocene_filmy_uzivatelem (filmy_id_film,uzivatele_id_uzivatel,hodnoceni_filmu)
    VALUES (:filmy_id_film,:uzivatele_id_uzivatel,:hodnoceni_filmu)");
  $stmt->bindParam(':filmy_id_film', $id_film);
  $stmt->bindParam(':uzivatele_id_uzivatel', $_SESSION["id_uzivatel"]);
  $stmt->bindParam(':hodnoceni_filmu', $radioVal);
  $stmt->execute();
}else{
  echo 'hodnota je';
  echo $radioVal;
  $stmt = $conn->prepare("UPDATE hodnocene_filmy_uzivatelem SET hodnoceni_filmu= :hodnoceni_filmu where uzivatele_id_uzivatel =$id AND filmy_id_film = $id_film");
  $stmt->bindParam(':hodnoceni_filmu', $radioVal);
  $stmt->execute();
  header('Location: '.$_SERVER['REQUEST_URI']);
  $successFeedback = "Zmena proběhla úspěšně!";
}
  if($_SESSION["role"]==2) {

}
  }

?>
