<!DOCTYPE html>
<html>
    <body>
        <?php

            session_start();
            if(!$_SESSION["userEmail"] || strcmp($_SESSION["userEmail"], "wintonartz012@gmail.com") != 0)
                header("Location: http://localhost/staff_login.php");
        ?>

        <h3>Enter the desired email and password.</h3><br><br>

        <form method="post" name="userSignup">
            First Name:*
            <input type="text" name="fName">
            <br>
            Last Name:*
            <input type="text" name="lName">
            <br>
            Email:*
            <input type="text" name="userEmail">
            <br>
            Password:*
            <input type="text" name="userPassword">
            <br>
            <input type="submit" name="submit">
        </form>
        <br>
        <p>* Required Forms</p>
        <br>

        <?php

            include 'db_connector.php';

            $fName=null;
            $lName=null;
            $userEmail=null;
            $userPassword=null;

            if(isset($_POST["fName"]))
            {
                $fName = $_POST["fName"];
                if(strcmp($fName, "") == 0)
                {
                    echo "<br>";
                    echo "Please enter a first name";
                    $_POST = array();
                    exit();
                }
            }

            if(isset($_POST["lName"]))
            {
                $lName = $_POST["lName"];
                if(strcmp($lName, "") == 0)
                {
                    echo "<br>";
                    echo "Please enter a last name";
                    $_POST = array();
                    exit();
                }
            }

            $conn = OpenCon();

            if(isset($_POST["userEmail"]))
            {
                $userEmail = $_POST["userEmail"];
                if(!filter_var($userEmail, FILTER_VALIDATE_EMAIL))
                {
                    echo "<br>";
                    echo "Invalid email format";
                    $_POST = array();
                    exit();
                }

                $eCheckQuery = "SELECT * FROM Staff T WHERE T.email=?";
                $eCheckSt = $conn->prepare($eCheckQuery);
                $eCheckSt->bind_param("s", $userEmail);
                $eCheckSt->execute();
                $eCheckRes = $eCheckSt->get_result();
                if($eCheckRes->num_rows > 0)
                {
                    echo "<br>";
                    echo "Email already exists.";
                    CloseCon($conn);
                    $_POST = array();
                    exit();
                }
            }

            if(isset($_POST["userPassword"]))
            {
                $userPassword = $_POST["userPassword"];
                if(mb_strlen($userPassword) < 10)
                {
                    echo "<br>";
                    echo "Invalid password - Needs at least 10 characters";
                    $_POST = array();
                    exit();
                }
            }

            if ($fName && $lName && $userEmail && $userPassword)
            {
                $signupQuery = "INSERT INTO Staff(email, first_name, last_name, password) VALUES (?,?,?,?)";
                $signupSt = $conn->prepare($signupQuery);
                $signupSt->bind_param("ssss", $userEmail,$fName,$lName,$userPassword);
                if($signupSt->execute())
                {
                    $subject = "Staff Account Assigned";
                    $message = "The site administrator has created your account. You can log in using this email and the password: " .$userPassword. "";
                    $headers = "From: noreply@localhost.com";

                    mail($userEmail, $subject, $message, $headers);
                    CloseCon($conn);
                    header("Location: http://localhost/staff_list.php");
                }
                else
                {
                    echo "Signup failed";
                    CloseCon($conn);
                    return;
                }
            }
            $_POST = array();

        ?>
    </body>
</html>