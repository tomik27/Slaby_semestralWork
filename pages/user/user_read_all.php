<?php

$conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$data = $conn->query("SELECT * FROM uzivatele")->fetchAll();

echo '<table class="tabulka_crud"';

echo '  
  <tr>
    <th>ID</th>
    <th>Email</th> 
    <th>Jmeno</th>
    <th>Prijmeni</th>
    <th>Role</th>
    <th>Akce</th>
  </tr>';

foreach ($data as $row) {

  echo '   
   <tr >
    <td >' . $row["id_uzivatel"] . '</td>
    <td >' . $row["email"] . '</td >
    <td >' . $row["jmeno"] . '</td > 
    <td >' . $row["prijmeni"] . '</td > 
     <td >' . $row["role"] . '</td > 
 

  <td>
  <a href="?page=user/user_update&action=update&id='.$row["id_uzivatel"].'">Upravit</a>
  <a href="?page=user/user_delete&action=delete&id='.$row["id_uzivatel"].'">Smazat</a>
  <td/>
<?php }  
           </tr >';
}

echo '</table>';
