<?php
session_start();
session_destroy();
header("location: /site_etec/index.php");
?>