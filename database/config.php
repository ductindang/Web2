<?php
define('HOST','localhost:3306');
define('DATABASE','webnangcao');
define('USERNAME','root');
define('PASSWORD','khiem3523');
define('PRIVATE_KEY','AFAWCA251!2314()');
$con = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
if (mysqli_connect_errno()){
    echo "Connection Fail: ".mysqli_connect_errno();exit;
}
?>