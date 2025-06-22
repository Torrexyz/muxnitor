<?php
session_start();
unset($_SESSION['sessref']);
session_destroy();
?>
