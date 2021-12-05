<!DOCTYPE html>
<html>
    <header>

    </header>
    <body>
        <?php
            session_start();
            session_unset();
            session_destroy();
            $_POST = array();
            $_GET = array();
            header("Location: http://localhost/staff_login.php");
        ?>
    </body>
</html>