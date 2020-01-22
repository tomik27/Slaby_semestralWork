<?php
$conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$data3 = $conn->query("SELECT * FROM zanry")->fetchAll();
?>
<main>
    <div class="margin_top">
      <h1>Správa filmů</h1>
    </div>
    <form method="post" class="form_align" enctype="multipart/form-data">
      <input type="text" name="nazev" placeholder="Název">
      <input list="zanry" name="zanr" placeholder="žánr">
      <input type="date" name="rok_vydani" placeholder="datum">
      <input type="text" name="popis" placeholder="Popis">
      <input type="text" name="cesta" placeholder="Cesta k souboru">
      <input type="file" name="fileToUpload" id="fileToUpload">
      <input type="submit" name="submit" value="Upload">
      <datalist id="zanry">


        <?php
        foreach ($data3 as $row) {
        ?>
        <option value=<?= $row["nazev_zanru"];?>>
          <?php
          }
          ?>
      </datalist>
    </form>


    <?php



    $errorFeedbacks = array();
    $successFeedback = "";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      if (empty($_POST["nazev"])) {
        $feedbackMessage = "nazev is required";
        array_push($errorFeedbacks, $feedbackMessage);
      }

      if (empty($_POST["rok_vydani"])) {
        $feedbackMessage = "rok_vydani is required";
        array_push($errorFeedbacks, $feedbackMessage);
      }


      if (empty($_POST["zanr"])) {
        $feedbackMessage = "zanr is required";
        array_push($errorFeedbacks, $feedbackMessage);
      }

      $target_dir = "Uploads/";
      $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
      // Check if image file is a actual image or fake image
      if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
          echo "File is an image - " . $check["mime"] . ".";
          $uploadOk = 1;
        } else {
          echo "File is not an image.";
          $uploadOk = 0;
        }
      }
      // Check if file already exists
      if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
      }
      // Check file size
      if ($_FILES["fileToUpload"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
      }
     $dir="";
      // Allow certain file formats
      if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
      }
      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
      } else {
        echo 'soubor zapisu' . $_FILES["fileToUpload"]["tmp_name"];
        $upload_dir = "./Uploads/";
        echo $upload_dir;
        if (is_dir($target_dir) && is_writable($target_dir)) {
          // do upload logic here

          if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
            $dir= $upload_dir. basename($_FILES["fileToUpload"]["name"]);
          } else {
            echo "Sorry, there was an error uploading your file.";
          }
        } else {
          echo 'Upload directory is not writable, or does not exist.';
        }
      }
      if (empty($dir)) {
        $feedbackMessage = "cesta k souboru is required";
        array_push($errorFeedbacks, $feedbackMessage);
      }

       if (empty($errorFeedbacks)) {
        echo 'jeto tak:'.$dir . '  zanr  '.$_POST["zanr"];
 $idZanr=0;
         foreach ($data3 as $row) {
       if($_POST["zanr"]==$row["nazev_zanru"]){
         $idZanr = $row["id_zanr"];
         echo 'id je '.$row["id_zanr"];
       }
         }
      $stmt = $conn->prepare("INSERT INTO filmy (cesta_k_obrazku,nazev,rok_vydani,zanry_id_zanr,popis)
    VALUES (:cesta_k_obrazku,:nazev,:rok_vydani,:zanr,:popis)");
      $stmt->bindParam(':cesta_k_obrazku', $dir);
      $stmt->bindParam(':nazev', $_POST["nazev"]);
      $stmt->bindParam(':rok_vydani', $_POST["rok_vydani"]);
      $stmt->bindParam(':zanr', $idZanr);
      $stmt->bindParam(':popis', $_POST["popis"]);
      $stmt->execute();
      $successFeedback = "Přidání filmu proběhlo úspěšně!";
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
    }
    ?>
