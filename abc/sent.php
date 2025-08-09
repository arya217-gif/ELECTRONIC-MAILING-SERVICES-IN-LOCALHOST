<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$user = $_SESSION['user'] ?? '';
if (!$user) {
    header("Location: index.php");
    exit;
}

// Handle deletion first
if (isset($_POST['del']) && !empty($_POST['chk'])) {
    foreach ($_POST['chk'] as $v) {
        $file = basename($v); // security: strip any directory traversal
        $sentFile = "User_Data/$user/sent/$file";
        $trashFile = "User_Data/$user/trash/$file";
        if (file_exists($sentFile)) {
            copy($sentFile, $trashFile);
            unlink($sentFile);
        }
    }
}
?>

<h1>Sent Items</h1>
<hr/>
<form method="post">
    <input type="submit" name="del" value="Delete"/>
    <hr/>
    <?php
    $sentDir = "User_Data/$user/sent";
    if (is_dir($sentDir)) {
        $od = opendir($sentDir);
        $hasFiles = false;
        while (($f = readdir($od)) !== false) {
            if ($f != "." && $f != "..") {
                $safeName = htmlspecialchars($f);
                echo "<input type='checkbox' name='chk[]' value='$safeName'> ";
                echo "<a href='home.php?consent=$safeName'>$safeName</a><hr/>";
                $hasFiles = true;
            }
        }
        closedir($od);

        if (!$hasFiles) {
            echo "<p>No sent messages.</p>";
        }
    }
    ?>
</form>
