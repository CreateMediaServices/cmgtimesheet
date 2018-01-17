<?php
    session_start();
    include("config.php");
    
    $_SESSION['uName'] = "";

    header("Location: ".$siteBaseURL);

?>