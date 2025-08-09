<?php
// Start session only if not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user = $_SESSION['user'] ?? '';
if (!$user) {
    header("Location: index.php");
    exit;
}

$profileFile = "User_Data/$user/profile.txt";
$name = $email = $password = $mobile = $address = '';
$msg = '';

// Load existing profile data
if (file_exists($profileFile)) {
    $profileData = file_get_contents($profileFile);

    // Parse fields using regex
    preg_match('/Name:\s*(.+)/', $profileData, $m1);
    preg_match('/Email:\s*(.+)/', $profileData, $m2);
    preg_match('/Password:\s*(.+)/', $profileData, $m3);
    preg_match('/Mobile:\s*(.+)/', $profileData, $m4);
    preg_match('/Address:\s*(.+)/', $profileData, $m5);

    $name     = $m1[1] ?? '';
    $email    = $m2[1] ?? '';
    $password = $m3[1] ?? '';
    $mobile   = $m4[1] ?? '';
    $address  = $m5[1] ?? '';
}

// Handle form submission
if (isset($_POST['updt'])) {
    $name = trim($_POST['n']);
    $newPassword = trim($_POST['p']);
    $password = $newPassword ?: $password; // Keep old password if empty
    $mobile = trim($_POST['m']);
    $address = trim($_POST['a']);

    // Update profile.txt
    $newData = "Name: $name\nEmail: $email\nPassword: $password\nMobile: $mobile\nAddress: $address\n";
    file_put_contents($profileFile, $newData);

    // Handle image upload
    if (!empty($_FILES['img']['name'])) {
        move_uploaded_file($_FILES['img']['tmp_name'], "User_Data/$user/".$_FILES['img']['name']);
    }

    $msg = "<font color='green'>Profile Updated Successfully!</font>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
    <table border="0" align="center">
    <caption><h1>Update Your Profile</h1></caption>
        <form method="post" enctype="multipart/form-data">
            <tr><td colspan="2" align="center"><?php echo $msg; ?></td></tr>
            <tr>
                <td>Your Name</td>
                <td><input type="text" value="<?php echo htmlspecialchars($name); ?>" name="n"></td>
            </tr>
            <tr>
                <td>Your Password</td>
                <td><input type="password" placeholder="Enter New Password (optional)" name="p"></td>
            </tr>
            <tr>
                <td>Your Mobile Number</td>
                <td><input type="text" value="<?php echo htmlspecialchars($mobile); ?>" name="m"></td>
            </tr>
            <tr>
                <td>Your Address</td>
                <td><textarea name="a"><?php echo htmlspecialchars($address); ?></textarea></td>
            </tr>
            <tr>
                <td>Upload Your Image</td>
                <td><input type="file" name="img"/></td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" value="Update Profile" name="updt">
                </td>
            </tr>
        </form>
    </table>
</body>
</html>
