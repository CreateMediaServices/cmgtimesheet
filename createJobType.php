<?php

include("config.php");

// $clientIDValue = $_POST['clientID'];
// $departmentValue = $_POST['deptID'];
// $jobTitleValue = $_POST['jobTitle'];
$created_at = date("Y-m-d H:i:s");

$sql = "SELECT * FROM cmg_clients";
$result = $db->query( $sql );
$totalRecords = $result->num_rows;
$counter = 0;

while ( $row = $result->fetch_assoc() ):
    $uClientId[$counter] = $row[ "id" ];    
    $counter++;
endwhile;

unset($sql);
unset($row);
unset($result);
unset($totalRecords);

$socialType[0] = "Account Management - paid media";
$socialType[1] = "Design - paid media";
$socialType[2] = "Copywriting";

$DesignType[0] = "Account Management - paid media";
$DesignType[1] = "Design - paid media";
$DesignType[2] = "Copywriting";
$DesignType[3] = "Animation";


try {

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $counter=0;
    while($counter < sizeof($uClientId)){


        if($uClientId[$counter] == 7){


        }else{

            $departmentValue = 1;

            $innercounter = 0;
            while($innercounter < sizeof($socialType)){
                // prepare sql and bind parameters
                $stmt = $conn->prepare("INSERT INTO cmg_jobtypes (clientID, jobTitle, deptID, created_at) 
                VALUES (:clientID, :jobTitle, :deptID, :created_at)");
                $stmt->bindParam(':clientID', $clientID);
                $stmt->bindParam(':jobTitle', $jobTitle);
                $stmt->bindParam(':deptID', $deptID);
                $stmt->bindParam(':created_at', $created_at);            
                
                // insert a row
                $clientID = $uClientId[$counter];
                $jobTitle = $socialType[$innercounter];
                $deptID = $departmentValue;
                $created_at = $created_at;
                
                $stmt->execute();
                $innercounter++;
            }

            $departmentValue = 2;

            $innercounter = 0;
            while($innercounter < sizeof($DesignType)){
                // prepare sql and bind parameters
                $stmt = $conn->prepare("INSERT INTO cmg_jobtypes (clientID, jobTitle, deptID, created_at) 
                VALUES (:clientID, :jobTitle, :deptID, :created_at)");
                $stmt->bindParam(':clientID', $clientID);
                $stmt->bindParam(':jobTitle', $jobTitle);
                $stmt->bindParam(':deptID', $deptID);
                $stmt->bindParam(':created_at', $created_at);            
                
                // insert a row
                $clientID = $uClientId[$counter];
                $jobTitle = $DesignType[$innercounter];
                $deptID = $departmentValue;
                $created_at = $created_at;
                $stmt->execute();
                $innercounter++;
            }

        }
       
        $counter++;

    }
    
    echo("success");

} catch(PDOException $e){
    echo "Error: " . $e->getMessage();
}

?>