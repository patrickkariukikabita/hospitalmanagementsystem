<?php
session_start();
include('include/config.php');
$_SESSION['dlogin'] == "";
date_default_timezone_set('America/New_York');
$ldate = date('d-m-Y h:i:s A', time());
$did = $_SESSION['id'];
mysqli_query($con, "UPDATE doctorslog  SET logout = '$ldate' WHERE uid = '$did' ORDER BY id DESC LIMIT 1");
session_unset();
$_SESSION['errmsg'] = "You have successfully logout";
?>
<script language="javascript">
    document.location = "../../index.php";
</script>