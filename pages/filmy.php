<?php
$conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$data = $conn->query("SELECT * FROM filmy join zanry on zanry_id_zanr=zanry.id_zanr ")->fetchAll();
echo '
<br /><br /><br /><br /><br />


<table style="width:100%" border="1">';
echo '   <tr>       
                     <th>ID</th>
                     <th>Film</th>
                     <th>zanr</th>
                     <th>datum vydani</th>
                     <th>ADMIN</th>
         </tr>';

foreach ($data as $row) {
  echo '
        <tr>
            <td>' . $row["id_film"] . '</td>
            <td> <a href="?page=film/film&id='.$row["id_film"].'">'.$row["nazev"].'</a></td>            
            <td>' . $row["nazev_zanru"] . '</td>
            <td>' . $row["rok_vydani"] . '</td>
            <td>
            ';
  if(!empty($_SESSION["role"])){
  $Role = ($_SESSION["role"]);
                if ($Role == 1){ ?>
                  <a href="?page=film/film_delete&id='.$row["id_film"].'">Upravit</a>
                  <a href="?page=film/film_update&id='.$row["id_film"].'">Smazat</a>
                <?php } } echo '
            </td>

        </tr> ';
}
echo '</table>';
?>
