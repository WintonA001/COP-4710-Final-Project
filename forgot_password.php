<!DOCTYPE html>
<html>
    <h3>If you have forgotten your password, enter your email below to receive a temporary login password.</h3>
    <form method="post" name="emailSubmission">
        Email:
        <input type="text" name="email">
        <br>
        <input type="submit" name="submit">
    </form>

    <?php

        include 'db_connector.php';

        $conn = OpenCon();

        if(isset($_POST["email"]))
        {
            $email = $_POST["email"];
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                echo "<br>";
                echo "Invalid email fomrat";
                $_POST = array();
                CloseCon($conn);
                exit();
            }

            $eCheckQuery = "SELECT * FROM Teachers T WHERE T.email=?";
            $eCheckSt = $conn->prepare($eCheckQuery);
            $eCheckSt->bind_param("s", $email);
            $eCheckSt->execute();
            $eCheckRes = $eCheckSt->get_result();
            if($eCheckRes->num_rows < 1)
            {
                echo "<br>";
                echo "No accounts found with this email";
                CloseCon($conn);
                $_POST = array();
                exit();
            }

            $row = $eCheckRes->fetch_assoc();
            $foundEmail = $row["email"];
            $updateQuery = "UPDATE Teachers SET password='temporarypassword' WHERE email=?";
            $updateSt = $conn->prepare($updateQuery);
            $updateSt->bind_param("s", $foundEmail);
            $updateSt->execute();

            $toEmailAddress = $foundEmail;
            $subject = "Password Reset";
            $message = "Your password has been reset.\n\nYour temporary password is: temporarypassword";
            $headers = "From: noreply@localhost.com";
            mail($toEmailAddress, $subject, $message, $headers);
            CloseCon($conn);
            header("Location: http://localhost/reset_success.php");
            exit();
        }

    ?>
</html>
