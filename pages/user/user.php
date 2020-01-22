<?php

if ($_GET["page"] == "user/user") {
  if ($_GET["action"] == "delete") {
    include "user_delete.php";
  } else if ($_GET["action"] == "update") {
    include "user_update.php";
  }

   else {
     include "user_add.php";
    include "user_read_all.php";
  }
} else {
  include "user_add.php";
  include "user_read_all.php";
}
?>

