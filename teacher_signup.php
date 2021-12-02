<!DOCTYPE html>
<html>
<body>
    <h3>Enter your desired email and password.</h3>
    <br>
    <br>

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
                echo "Please enter your first name";
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
                echo "Please enter your last name";
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

            $eCheckQuery = "SELECT * FROM Teachers T WHERE T.email=?";
            $eCheckSt = $conn->prepare($eCheckQuery);
            $eCheckSt->bind_param("s", $userEmail);
            $eCheckSt->execute();
            $eCheckRes = $eCheckSt->get_result();
            if($eCheckRes->num_rows > 0)
            {
                echo "<br>";
                echo "Email is already taken.";
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
            $signupQuery = "INSERT INTO Teachers(email, first_name, last_name, password) VALUES (?,?,?,?)";
            $signupSt = $conn->prepare($signupQuery);
            $signupSt->bind_param("ssss", $userEmail,$fName,$lName,$userPassword);
            if($signupSt->execute())
            {
                CloseCon($conn);
                header("Location: http://localhost/signup_success.php");
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