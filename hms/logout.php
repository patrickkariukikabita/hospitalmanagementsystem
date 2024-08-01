<?php


session_start();
include('include/config.php');
function logout_user_with_session_id($con, $session_id)
{
    date_default_timezone_set('America/New_York');
    $ldate = date('d-m-Y h:i:s A', time());
    mysqli_query($con, "UPDATE userlog SET logout = '$ldate' WHERE uid = '$session_id' ORDER BY id DESC LIMIT 1");
    return [
        "message" => "You have successfully logged out.",
        "redirect_url" => "../index.php"
    ];
}

$response = logout_user_with_session_id($con, $_SESSION['id']);
$_SESSION['errmsg'] = $response['message'];
$_SESSION['login'] == "";
session_unset();
echo "<script language='javascript'>document.location='{$response['redirect_url']}';</script>";

?>