<?php
    session_start();
    $uLastLoginValue = date("Y-m-d H:i:s");
    include("config.php");
    $uNameValue = $_POST['uName'];
    $uPasswordValue = $_POST['uPassword'];

    $uPasswordValue = md5(md5($uPasswordValue));

    $sql = "SELECT * FROM cmguser where userName='".$uNameValue."' AND userPassword='".$uPasswordValue."'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        //echo "user already exists.";
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare sql and bind parameters
            $stmt = $conn->prepare("UPDATE cmguser SET uLastLogin=:uLastLogin WHERE userName='".$uNameValue."'");
            
            $stmt->bindParam(':uLastLogin', $uLastLogin);            

            // insert a row            
            $uLastLogin = $uLastLoginValue;                              
            $stmt->execute();
            
            $_SESSION['uName'] = $uNameValue;

            echo("success");

        } catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }

        $conn = null;

    } else {
        echo "Invalid user name or password";
    }
?>