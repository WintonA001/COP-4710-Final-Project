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
        ?>
    </body>
</html>