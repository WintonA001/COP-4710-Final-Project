<!DOCTYPE html>
<html>
    <body>

        <h1 style="vertical-align: middle;">Log In</h1>
        <form method="post" name="userLogin">
            User Email:
            <input type="text" name="userEmail">
            <br>
            Password:
            <input type="password" name="userPassword">
            <br>
            <input type="submit" name="submit">
        </form>
        <a href="forgot_password.php">Forgot your password?</a>
        <br>
        <a href="teacher_signup.php">Need an account? Register Here!</a>
        <br>
        <a href="staff_login.php">Staff Login</a>
        <br>

        <?php
            
            include 'db_connector.php';

            $conn = OpenCon();

            if(isset( $_POST["userEmail"])) 
            {
                $userEmail = $_POST["userEmail"];

                $emailQuery = "SELECT T.email FROM Teachers T WHERE T.email=?";
                $eStmt = $conn->prepare($emailQuery);
                $eStmt->bind_param("s", $userEmail);
                $eStmt->execute();
                $emailQueryResult = $eStmt->get_result();
                if($emailQueryResult && $emailQueryResult->num_rows > 0) $emailRow = $emailQueryResult->fetch_assoc();
                else
                { 
                    echo "Invalid email";
                    return;
                }
                $retrievedEmail = $emailRow["email"];

                if(strcmp($retrievedEmail, $userEmail) == 0)
                {
                    if( isset( $_POST["userPassword"]))
                    {
                        $userPassword = $_POST["userPassword"];

                        $passwordQuery = "SELECT T.password FROM Teachers T WHERE T.email=?";
                        $pStmt = $conn->prepare($passwordQuery);
                        $pStmt->bind_param("s", $userEmail);
                        $pStmt->execute();
                        $passQueryResult = $pStmt->get_result();
                        if($passQueryResult && $passQueryResult->num_rows > 0) $passRow = $passQueryResult->fetch_assoc();
                        else
                        {
                            echo "Must input password";
                            return;
                        }
                        $retrievedPassword = $passRow["password"];

                        if(strcmp($retrievedPassword, $userPassword) == 0)
                        {
                            session_start();
                            $_SESSION["userEmail"] = $userEmail;
                            $_SESSION["userType"] = "teacher";
                            header("Location: http://localhost/teacher_dashboard.php");
                        }
                        else
                        {
                            echo "Password does not match";
                        }
                    }
                    else
                    {
                        echo "Must input password";
                    }
                }
                else
                {
                    echo "No account with this email found";
                }
                $_POST = array();
            }

            CloseCon($conn);
        ?>

    </body>
</html>