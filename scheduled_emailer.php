<?php
    include 'db_connector.php';

    $conn = OpenCon();

    $dateQuery = "SELECT * FROM `reminder dates`";
    $dateStmt = $conn->prepare($dateQuery);
    if($dateStmt->execute()) $dateResult = $dateStmt->get_result();


    date_default_timezone_set("EST");
    $today = date_create(date("Y-m-d"));
    $todayString = $today->format('Y-m-d');
    while($row = $dateResult->fetch_assoc())
    {
        $dueDate = $row["date"];
        
        if(strtotime($todayString) == strtotime($dueDate))
        {
            $emailQuery = "SELECT T.email FROM Teachers T";
            $emailStmt = $conn->prepare($emailQuery);
            if($emailStmt->execute()) $emailResult=$emailStmt->get_result();

            $subject = "Book Request Due Reminder";
            $message = "This is just a general reminder to all faculty that book requests are due next week!";
            $headers = "From: noreply@localhost.com";

            while($row = $emailResult->fetch_assoc())
            {
                $email = $row["email"];
                mail($email, $subject, $message, $headers);
                //echo "Emailing " .$email. " succ<br>";
            }
            exit();
        }
    }

    CloseCon($conn);
    exit();

?>