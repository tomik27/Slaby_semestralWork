

<?php
$id_uzivatele = $_GET["id"];
echo $id_uzivatele;
$conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$data = $conn->query("SELECT * FROM uzivatele WHERE id_uzivatel = $id_uzivatele")->fetch(); ?>

<main>

    <div class="margin_top">
      <h1>Správa uživatelů</h1>
    </div>
    <form method="post" class="form_align" enctype="multipart/form-data">
      <input type="text" name="jmeno" placeholder="Jméno"  value="<?= $data["jmeno"]; ?>">
      <input type="text" name="prijmeni" placeholder="Příjmení" value="<?= $data["prijmeni"]; ?>"/>
      <input type="email" name="email" placeholder="Email" value="<?= $data["email"]; ?>"/>
      <input type="text" name="role" placeholder="Role" value="<?= $data["role"]; ?>"/>
      <input type="submit" name="isSubmitted" value="Přidat">
    </form>
    <?php
    $errorFeedbacks = array();
    $successFeedback = "";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      if (empty($_POST["email"])) {
        $feedbackMessage = "email is required";
        array_push($errorFeedbacks, $feedbackMessage);
      }

      if (empty($_POST["jmeno"])) {
        $feedbackMessage = "jmeno is required";
        array_push($errorFeedbacks, $feedbackMessage);
      }

      if (empty($_POST["prijmeni"])) {
        $feedbackMessage = "prijmeni is required";
        array_push($errorFeedbacks, $feedbackMessage);
      }

      if (empty($_POST["heslo"])) {
        $feedbackMessage = "password is required";
        array_push($errorFeedbacks, $feedbackMessage);
      }
      if (empty($errorFeedbacks)) {
        //success

        $hashedPass = hash('sha512',$_POST["heslo"]);
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("UPDATE uzivatele SET email= :email, jmeno= :jmeno, prijemni= :prijemni, role= :role where id =$id_uzivatele");
        $stmt->bindParam(':jmeno', $_POST["jmeno"]);
        $stmt->bindParam(':prijmeni', $_POST["prijmeni"]);
        $stmt->bindParam(':email', $_POST["email"]);
        $stmt->bindParam(':heslo', $hashedPass);
        $stmt->execute();
        $successFeedback = "Zmena proběhla úspěšně!";
      }
    }
    ?>
    <?php
    if (!empty($errorFeedbacks)) {
      echo "Form contains following errors:<br>";
      foreach ($errorFeedbacks as $errorFeedback) {
        echo $errorFeedback . "<br>";
      }
    } else if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($successFeedback)) {
      echo $successFeedback;
    }
    ?>
