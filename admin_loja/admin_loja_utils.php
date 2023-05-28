<?php
    if (isset($_POST['rowID'])) {
        $rowID = $_POST['rowID'];

        $name = "idEncomenda";
        $value = $rowID;
        $expiry = time() + (86400 * 30); // Expiry time in seconds (30 days from now)
        $path = "/"; // Path on the domain where the cookie is accessible

        setcookie($name, $value, $expiry, $path);
    }
?>