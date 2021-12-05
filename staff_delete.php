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
            else
            {
                echo "wtf";
                exit();
            }

            $deleteQuery = "DELETE FROM Staff WHERE email=?";
            $deleteSt = $conn->prepare($deleteQuery);
            $deleteSt->bind_param("s",$email);
            if($deleteSt->execute())
            {
                echo "<h3>Account " .$email. " has been deleted.";
            }
            else
            {
                echo "Account with this email address not found.";
            }
            CloseCon($conn);
            session_start();
            $_SESSION["opSuccess"] = "Deletion of account for " .$email. " successful.";
            header("Location: http://localhost/staff_list.php");
        ?>
    </body>
</html>