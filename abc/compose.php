<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user = $_SESSION['user'] ?? '';
if (!$user) {
    header("Location: index.php");
    exit;
}

$err = '';

function sanitizeFileName($str) {
    // Remove special characters not allowed in Windows filenames
    return preg_replace('/[<>:"\/\\\|\?\*]/', '_', $str);
}

if (isset($_POST['send'])) {
    $to = strtolower(trim($_POST['to']));
    $sub = trim($_POST['sub']);
    $msg = $_POST['msg'];

    $safeSub = sanitizeFileName($sub);
    $recipientFolder = "User_Data/$to";

    if (file_exists($recipientFolder)) {
        // Save to receiver's inbox
        $subj = sanitizeFileName($user . " " . $sub);
        file_put_contents("$recipientFolder/inbox/$subj", $msg);

        // Save to sender's sent folder
        $subj1 = sanitizeFileName($to . " " . $sub);
        file_put_contents("User_Data/$user/sent/$subj1", $msg);

        $err = "<font color='green'>Message Successfully Sent</font>";
    } else {
        // Save failed message to sender inbox and sent
        $subj = sanitizeFileName($to . " " . $sub . " Message Failed");
        file_put_contents("User_Data/$user/inbox/$subj", $msg);

        $subj1 = sanitizeFileName($to . " " . $sub);
        file_put_contents("User_Data/$user/sent/$subj1", $msg);

        $err = "<font color='red'>Message Failed: Recipient Not Found</font>";
    }
}

if (isset($_POST['save'])) {
    $sub = trim($_POST['sub']);
    $msg = $_POST['msg'];
    $subj = sanitizeFileName($user . " " . $sub);
    file_put_contents("User_Data/$user/draft/$subj", $msg);
    $err = "<font color='blue'>Message Successfully Saved to Drafts</font>";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Compose Message</title>
<style>
input {width:500px; border-radius:10px; background-color:#FF99FF; color:#0000FF}
textarea {border-radius:10px; background-color:#FF99FF; color:#0000FF}
input[type=submit]:hover {background:pink}
input[type=submit] {width:100px}
</style>
</head>
<body>
<table border="" width="100%" align="center" bgcolor="#999999">
<form method="post">
    <tr>
        <td colspan="2" align="center"><?php echo $err; ?></td>
    </tr>
    <tr>
        <td width="57">To :</td>
        <td width="447"><input type="email" placeholder="abc@gmail.com" name="to" required></td>
    </tr>
    <tr>
        <td>Subject :</td>
        <td><input type="text" placeholder="Enter Your Subject" name="sub"></td>
    </tr>
    <tr>
        <td>Message :</td>
        <td><textarea placeholder="Write Your Message" rows="25" cols="70" name="msg"></textarea></td>
    </tr>
    <tr>
        <td colspan="2" align="center">
            <input type="submit" value="Send" name="send"/>
            <input type="submit" value="Save" name="save">
        </td>
    </tr>
</form>
</table>
</body>
</html>
