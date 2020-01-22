
<?php

if (!empty($_POST) && !empty($_POST["email"]) && !empty($_POST["heslo"])) {

  $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $conn->prepare("SELECT id_uzivatel, role, email FROM uzivatele   WHERE email= :email and heslo = :heslo");
  $stmt->bindParam(':email', $_POST["email"]);
  $stmt->bindParam(':heslo', $_POST["heslo"]);
  $stmt->execute();
  $user = $stmt->fetch();
  if (!$user) {
    echo "user not found";
  } else {
    echo "you are logged in. Your ID is: " . $user["id_uzivatel"];
    $_SESSION["id_uzivatel"] = $user["id_uzivatel"];
    $_SESSION["username"] = $user["jmeno"];
    $_SESSION["email"] = $user["email"];
    $_SESSION["role"] = $user["role"];
    header("Location:". BASE_URL);
  }

} else if (!empty($_POST) ) {
  echo "Username and password are required";
}
?>

<main>
  <div class="margin_top">
      <h1>Login</h1>
  </div>
<form method="post">

  <input type="email" name="email" placeholder="Insert your email">
  <input type="password" name="heslo" placeholder="Password">
  <input type="submit" value="Log in">

</form>
</main>
