<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$msg = '';

if(isset($_POST['l'])) {
    $email = trim($_POST['e']);
    $pass  = trim($_POST['p']);

    $userDir = "User_Data/$email";
    $profileFile = "$userDir/profile.txt";

    if(file_exists($profileFile)) {
        // Read profile.txt to get stored password
        $profile = file_get_contents($profileFile);
        preg_match('/Password:\s*(.+)/', $profile, $matches);
        $storedPassword = trim($matches[1] ?? '');

        if($pass === $storedPassword) {
            $_SESSION['user'] = $email;
            echo "<script>window.location='home.php'</script>";
            exit;
        } else {
            $msg = "<h1 align='center'><font color='red' face='cursive'>Invalid Password</font></h1>";
        }
    } else {
        $msg = "<h1 align='center'><font color='red' face='cursive'>Invalid User</font></h1>";
    }
}

// Handle forgot password option
@$ot = $_GET['option'];
if($ot === 'fpass') {
    include('forgot.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Login Page</title>
<link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
<?php echo $msg; ?>
<form method="post" enctype="multipart/form-data">
<table width="403" border="0" cellspacing="10" align="center">
  <tr>
    <td width="147">Enter Your Email Id</td>
    <td width="222"><input type="email" placeholder="abc@gmail.com" name="e" required/></td>
  </tr>
  <tr>
    <td>Enter Your Password</td>
    <td><input type="password" placeholder="Your Password" name="p" required/></td>
  </tr>
  <tr>
    <td colspan="2" align="center">
        <input type="submit" value="Login" name="l"/>
        <a href="index.php?option=fpass">Forgot Password</a>
    </td>
  </tr>
</table>
</form>
</body>
</html>
