<!DOCTYPE html>
<html>
    <header>

    </header>
    <body>
        <?php
            session_start();

            if(strcmp($_SESSION["userType"], "teacher") == 0)
            {
                $bool = 0;
            }
            else
            {
                $bool = 1;
            }

            session_unset();
            session_destroy();
            $_POST = array();
            $_GET = array();
            if($bool == 0)
            {
                header("Location: http://localhost/login_page.php");
            }
            else
            {
                header("Location: http://localhost/staff_login.php");
            }
            
        ?>
    </body>
</html>