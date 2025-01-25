<?php
 require_once("bookmark_fns.php");
 do_html_header("Resetting password");
 // creating short variable name
 $username = $_POST['username'];
 try {
 $password = reset_password($username);
 notify_password($username, $password);
 echo 'Your new password has been emailed to you.<br>';
 }
ptg18145125
584 Chapter 27  Building User Authentication and Personalization
 catch (Exception $e) {
 echo 'Your password could not be reset - please try again later.';
 }
 do_html_url('login.php', 'Login');
 do_html_footer();
?>