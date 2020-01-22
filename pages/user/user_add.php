
<main>
    <div class="margin_top">
      <h1>Správa uživatelů</h1>
    </div>
    <form action="pages/film/upload.php" method="post" class="form_align" enctype="multipart/form-data">
      <input type="text" name="jmeno" placeholder="Jméno">
      <input type="text" name="prijmeni" placeholder="Příjmení">
      <input type="email" name="email" placeholder="Email">
      <input type="password" name="heslo" placeholder="Heslo">
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

    $stmt = $conn->prepare("INSERT INTO uzivatele (jmeno,prijmeni,email, heslo, role)
    VALUES (:jmeno,:prijmeni,:email, :heslo, 2)");
    $stmt->bindParam(':jmeno', $_POST["jmeno"]);
    $stmt->bindParam(':prijmeni', $_POST["prijmeni"]);
    $stmt->bindParam(':email', $_POST["email"]);
    $stmt->bindParam(':heslo', $hashedPass);
    echo $_POST["jmeno"];
    echo $_POST["prijmeni"];
    echo $_POST["email"];
    echo $hashedPass;
    $stmt->execute();
    $successFeedback = "Registrace proběhla úspěšně!";
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
