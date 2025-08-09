<?php session_start(); ?>
<?php include('templates/header.php');?>
</center>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>my web page</title>
<link rel="stylesheet" type="text/css" href="style.css"/>
<style>
body{margin-top:-2px}
table{margin:auto;}

a{border-radius:10px;text-decoration:none;margin-left:6%;font-size:25px;font-style:italic}
a:hover{color:#00FF00;background:#660099}
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.style2 {font-family: Verdana, Arial, Helvetica, sans-serif}
</style>
</head>
<body>
<table width="100%" height="100%" border="0">
  <tr>
    <td height="165" colspan="2" bgcolor="#339900"><h1 align="center" class="style1 style2"><font color="#660000">@AGRASEN E-MAILING  SERVICES</font></h1></td>
  </tr>
  <tr>
    <td height="42" colspan="2" bgcolor="#FF6600">
	<a href="index.php">HOME</a>
	<a href="index.php?option=about">ABOUT</a>
	<a href="index.php?option=service">SERVICES</a>
	<a href="index.php?option=contact">CONTACT</a>
	<a href="index.php?option=registration">REGISTRATION</a>
	<a href="index.php?option=login">LOGIN</a>	</td>
  </tr>
  <tr>
    <td width="939" height="249" valign="top" bgcolor="#FFCCFF">
	<?php
	@$opt=$_GET['option'];
	//echo $opt;
	if($opt=="")
	{
	?>
	
	<P align="justify">This project provide services to exchange or transfer the mail using file system concept.
To hold data we using only file system instead database.
In this project we exchange or transfer the mail using file system .
this project is work similar to gmail system. User information stored inside the directory.
registration page is make to enter the user details. details are stored inside the directory using file system concept.

Session is used to hold the particular user details:Each time when a new user login or registration.
Session keep the details of the particular user.

Login Page permits only existing user to login the mailserver page.
Compose is used to sent mail whose email address is matched ,compose and hit send, sent mail reached to recipient email address inbox with message and attachment.
All received mail collected on inbox. all received mail are shown in inbox.
draft is hold the copy of send mail. copy of a sent mail is also stored in a sent

User can change the password: first check the existing password(old password), then new-password or confirm password must matched.
it replace old password with new password.now user can login with new generated password.
	
	<br/>
	<?php
	}
	else
	{
	switch($opt)
	{
	case 'login';
	include('login.php');
	break;
	case 'about';
	include('about.php');
	break;
	case 'service';
	include('services.php');
	break;
	case 'registration';
	include('regis.php');
	break;
	case 'contact';
	include('contact.php');
	break;
	case 'fpass';
	include('forgotpass.php');
	break;
	}
	}
	?>
	</td>
    <td width="249" bgcolor="#FFFFFF" valign="top"><h2><img src="image/logo1.png" alt="" width="171" height="116" />    
	</h2>
    <P><font color="#0000CC">Utkal University, Vani Vihar, Odisha</font></td>
  </tr>
  <tr>
    <td height="55" colspan="2" align="center">
      <strong>
      <marquee bgcolor="#FFFFCC">
      <font color="#FF00FF">
    Developed By @ UNEJA PARVEEN & SHRITI BONIK - BCA-III</font>
      </marquee>
      </strong> </td>
  </tr>
</table>
</body>
</html>
