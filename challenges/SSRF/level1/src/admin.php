<?php
if ($_SERVER['REMOTE_ADDR'] === "127.0.0.1") {
    system("uname -a");
    system("ifconfig eth0");
    die("Flag 1: VIS{eZZZZ_InterNal_aDmin_:>}");
}
http_response_code(403);
die("Error 403 forbidden, can only be accessed by 127.0.0.1");
