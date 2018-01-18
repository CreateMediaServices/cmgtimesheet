<?php

if( $_GET['pageStatus'] != 'ZdPrxEet5eexqbl' ):
    exit(0);
endif;   

include( 'config.php' );

$created_atValue = date("Y-m-d");
$currentDate = new DateTime($created_atValue);

$userSql = "SELECT * FROM cmg_user WHERE uActive=1 AND uEmailStatus=1";
$userResult = $db->query( $userSql );
$userTotalRecords = $userResult->num_rows;

$adminContent = '';
$emailResult = $created_atValue;

$counter=0;

while ( $userRow = $userResult->fetch_assoc() ):

    $uNameValue = $userRow[ "userName" ];
    $userEmailValue = $userRow[ "userEmail" ];

    $sqlSelect = "SELECT * FROM cmg_timetracker where 
                    userName='" . $uNameValue . "' ORDER BY jobDate 
                    DESC LIMIT 1";

    $resultSelect = $db->query( $sqlSelect );
    $totalRecordsSelect = $resultSelect->num_rows;  

    if($totalRecordsSelect == 0 ){
        $uName[$counter] = $uNameValue;
        $userEmail[$counter] = $userEmailValue;
        $counter++;
    }
    
    while ( $rowSelect = $resultSelect->fetch_assoc() ):

        $uDateSelect = $rowSelect[ "jobDate" ];
        $taskDate = new DateTime($uDateSelect);

        $days = $taskDate->diff($currentDate)->format("%a");

        // Timesheet not updated mmore than 2 days.
        if($days > 2 ){

            $uName[$counter] = $uNameValue;
            $userEmail[$counter] = $userEmailValue;
            $counter++;

        }

    endwhile;
endwhile;

for($counter=0; $counter < sizeof($userEmail); $counter++ ){
    // Email Block
    $emailHeaders = 'From: no-reply@createmedia-group.com'. "\r\n" .
                    'Reply-To: no-reply@createmedia-group.com'. "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

    $emailHeaders = "MIME-Version: 1.0" . "\r\n";
    $emailHeaders .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    
    $tableLabel = 'width="500" valign="top" align="left"
                    style="font-size:14px; font-family:Arial;
                    color:#88898a; line-height:120%;"';

    $tableHeading = 'width="500" valign="top" align="left"
                    style="font-size:14px; font-family:Arial;
                    color:#88898a; line-height:120%;"';
                
    $emailSubject = "Timesheet notification!";
    $emailMessageDetail = "<table width='500'>
        <tr>
            <td $tableHeading height='5'></td>
        </tr>
        <tr>
            <th $tableLabel>Timesheet notification!</th>
        </tr>
        <tr>
            <td $tableHeading height='5'></td>
        </tr>
        <tr>
            <td $tableLabel>
                It's more then 2 days you logged in to timesheet.                   
            </td>
        </tr>
        <tr>
            <td $tableLabel>
                <a href='http://clients.createmedia-group.com/cmg/time-sheet/'>Login</a>
            </td>
        </tr>
        <tr>
            <td $tableHeading height='5'></td>
        </tr>
    </table>";

    $uNameValue = strtoupper($uName[$counter]);

    $emailMessage = "
    <html>
    <head>
    </head>
    <body>
        $emailMessageDetail 
    </body>
    </html>
    ";
    
    $adminContent .= "<table width='500'>
        <tr>
            <td $tableLabel>
                $uNameValue
            </td>                
        </tr>
        <tr>
            <td $tableHeading height='5'></td>
        </tr>
    </table>";

    //$emailSentTo = $userEmail[$counter];
    $emailSentTo = 'shakeel.rehman@createmedia-group.com';
    mail($emailSentTo, $emailSubject, $emailMessage, $emailHeaders,
            "-f no-reply@createmedia-group.com");

        $emailResult .= $uNameValue.PHP_EOL;
}

$adminHeader .= "<table width='500'>
<tr>
    <td $tableHeading>
        List of team member who did not entered hours more than 2 days
    </td>
</tr>
<tr>
    <td $tableHeading>
        Users
    </td>
</tr>
</table>";

$emailSubject = "Timesheet notofication!";
$emailMessage = "
<html>
<head>
</head>
<body>    
    $adminHeader
    $adminContent
</body>
</html>
";

//$emailSentTo = 'hina.khan@createmedia-group.com';
$emailSentTo = 'shakeel.rehman@createmedia-group.com';
mail($emailSentTo, $emailSubject, $emailMessage, $emailHeaders,
         "-f no-reply@createmedia-group.com");

$emailSentTo = 'clients.create@gmail.com';
mail($emailSentTo, $emailSubject, $emailMessage, $emailHeaders,
        "-f no-reply@createmedia-group.com");

$filename = 'missingDates.txt';
if (file_exists($filename)){
    $fp = fopen($filename, "a");
    fwrite ($fp, $emailResult.PHP_EOL);
    fclose ($fp);                    
}else{
    $fh = fopen($filename, "w");
    if($fh==false)
        die("unable to create file");
    fwrite ($fh, $emailResult.PHP_EOL);
    fclose ($fh);                    
}

unset($userSql);
unset($userRow);
unset($userResult);
unset($userTotalRecords);

?>