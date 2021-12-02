<!DOCTYPE html>
<html>
    <body>
        <?php
            include 'db_connector.php';

            $conn = OpenCon();

            $email;
            if($_POST["staffEmail"])
            {
                $email = $_POST["staffEmail"];
            }

            $resetQuery = "UPDATE Staff SET password='temporarypassword' WHERE email=?";
            $resetSt = $conn->prepare($resetQuery);
            $resetSt->bind_param("s",$email);
            if(!$resetSt->execute())
            {
                echo "Account with this email address not found.";
                CloseCon($conn);
                exit();
            }
            else
            {
                $subject = "Password Reset";
                $message = "Your password has been reset by the administrator.\n\nYour temporary password is: temporarypassword";
                $headers = "From: noreply@localhost.com";
                mail($email, $subject, $message, $headers);
                CloseCon($conn);
                echo "<h3>Account password for " .$email. " has been set to the temporary password.";
            }
        ?>
    </body>
</html>