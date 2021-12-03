<?php

    include 'db_connector.php';

    $conn = OpenCon();

    echo 'Connected succ';

    CloseCon($conn);

?>