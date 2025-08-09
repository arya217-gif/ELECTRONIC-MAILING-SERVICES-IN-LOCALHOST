<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<?php
if(isset($_POST['save']))
{
    $n  = $_POST['n'];
    $e  = $_POST['e'];
    $p  = $_POST['p'];
    $m  = $_POST['m'];
    $a  = $_POST['a'];
    $ff = $_POST['ff'];

    // Ensure email is not empty
    if(empty($e)) {
        $msg = "<font color='red' face='cursive'>Email cannot be empty!</font>";
    }
    else {
        $userDir = "User_Data/$e";

        if(file_exists($userDir))
        {
            $msg="<font color='green' face='cursive'>User Already Exists</font>";
        }
        else
        {
            // Create directories safely
            mkdir($userDir, 0777, true);
            mkdir("$userDir/inbox");
            mkdir("$userDir/sent");
            mkdir("$userDir/draft");
            mkdir("$userDir/spam");
            mkdir("$userDir/trash");
            //mkdir("$userDir/password"); // Optional

            // Move uploaded file
            if(!empty($_FILES['img']['name'])){
                move_uploaded_file($_FILES['img']['tmp_name'], "$userDir/".$_FILES['img']['name']);
            }

            // Store all user info in one file
            $profileData = "Name: $n\nEmail: $e\nPassword: $p\nMobile: $m\nFirstPhone: $ff\nAddress: $a\n";
            file_put_contents("$userDir/profile.txt", $profileData);

            $msg="<font color='green' face='cursive'>You Are Registered Successfully!</font>";
        }
    }
}
?>
<link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
    <table border="0" align="center" cellpadding="3">
    <caption><h2>Fill This Form.......</h2></caption>
        <form method="post" enctype="multipart/form-data">
            <tr>
                <td colspan="2"><?php echo @$msg;?></td>
            </tr>
            <tr>
                <td>Your Name</td>
                <td><input type="text" placeholder="Enter Your Name" name="n"></td>
            </tr>
            <tr>
                <td>Your Email Id</td>
                <td><input type="email" placeholder="abc@gmail.com" name="e"></td>
            </tr>
            <tr>
                <td>Your Password</td>
                <td><input type="password" placeholder="Enter Your Password" name="p"></td>
            </tr> 
            <tr>
                <td>Your Mobile Number</td>
                <td><input type="text" placeholder="Enter Mobile Number" name="m"></td>
            </tr>
            <tr>
                <td>Your First Phone Number</td>
                <td><input type="text" placeholder="Enter First Phone Number" name="ff"></td>
            </tr>
            <tr>
                <td>Your Address</td>
                <td><textarea placeholder="Enter Your Address" name="a"></textarea></td>
            </tr>
            <tr>
                <td>Upload Your Image</td>
                <td><input type="file" name="img"/></td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" value="Save" name="save">
                    <input type="reset" value="Reset">
                </td>
            </tr>
        </form>
    </table>
</body>
</html>
