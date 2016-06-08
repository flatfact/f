<?php
require 'sdk/facebook.php';

$facebook = new Facebook(array(
  'appId'  => '',
  'secret' => '',
));

// Get User ID
$user = $facebook->getUser();

if ($user) {
  try {
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $loginUrl = $facebook->getLoginUrl();
}

// Save to mysql
if ($user) {
	if($_GET["code"] != "")
	{
        $con = mysqli_connect("localhost","root","pass","userdata") or die(mysql_error());
        $signup = $con->query("INSERT INTO user (fbID,name,link,create_date)
          VALUES 	('".trim($user_profile["id"])."',
  					       '".trim($user_profile["name"])."',
  					       '".trim($user_profile["link"])."',
  					       '".trim(date("Y-m-d H:i:s"))."')";
	}
}

// Logout
if($_GET["Action"] == "Logout")
{
	$facebook->destroySession();
	header("location:index.php");
	exit();
}

if(isset($_POST['sn'])){
  print_r ($_SESSION);
}
?>


<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://code.getmdl.io/1.1.3/material.blue_grey-blue.min.css" />
<script defer src="https://code.getmdl.io/1.1.3/material.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<link href='https://fonts.googleapis.com/css?family=Kanit&subset=thai,latin' rel='stylesheet' type='text/css'>
</head>
<style>
.centered {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
.box{
  width: 400px;
  height: auto;
  padding: 20px;
  background-color: #fafafa;
  text-align: center;
}
body{
  background-color: #37474f;
  font-family: 'Kanit', sans-serif;
}
</style>

<body>
  <div class="centered box">
    <h2>กรุณาสมัครสมาชิก</h2>
    <br>
    <button name="sn" href="<?php echo $loginUrl; ?>" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
      สมัครสมาชิก
    </button>
  </div>
</body>

</html>
