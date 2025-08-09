<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user = $_SESSION['user'] ?? '';
if (!$user) {
    header("Location: index.php");
    exit;
}

$profileFile = "User_Data/$user/profile.txt";
$msg = '';

if (isset($_POST['change'])) {
    $oldp = trim($_POST['oldp']);
    $newp = trim($_POST['newp']);
    $confp = trim($_POST['confp']);

    if (file_exists($profileFile)) {
        // Read profile file and normalize line endings
        $profile = file_get_contents($profileFile);
        $profile = str_replace("\r\n", "\n", $profile);

        // Extract current password (case-insensitive, single line)
        preg_match('/^Password:\s*(.+)$/im', $profile, $matches);
        $storedPassword = trim($matches[1] ?? '');

        // --- Debugging: uncomment these 2 lines to see exact values ---
        // var_dump($storedPassword);
        // var_dump($oldp);
        // exit;

        if ($oldp === $storedPassword) {
            if ($newp === $confp) {
                // Replace old password with new password in the profile
                $updatedProfile = preg_replace('/^Password:\s*.+$/im', "Password: $newp", $profile);
                file_put_contents($profileFile, $updatedProfile);
                $msg = "<font color='green'>Password Changed Successfully!</font>";
            } else {
                $msg = "<font color='red'>New Passwords Do Not Match!</font>";
            }
        } else {
            $msg = "<font color='red'>Old Password Does Not Match!</font>";
        }
    } else {
        $msg = "<font color='red'>Profile Not Found!</font>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Change Password</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
    <form method="post">
        <table align="center" border="0">
            <tr>
                <td colspan="2" align="center"><?php echo $msg; ?></td>
            </tr>
            <tr>
                <td>Old Password:</td>
                <td><input type="password" name="oldp" required></td>
            </tr>
            <tr>
                <td>New Password:</td>
                <td><input type="password" name="newp" required></td>
            </tr>
            <tr>
                <td>Confirm Password:</td>
                <td><input type="password" name="confp" required></td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" value="Change Password" name="change">
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
