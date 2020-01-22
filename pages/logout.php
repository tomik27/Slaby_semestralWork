<h1>LOGOUT</h1>

<?php

session_destroy();
header("Location:". BASE_URL);
