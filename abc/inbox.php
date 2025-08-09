<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$user = $_SESSION['user'] ?? '';
if (!$user) {
    header("Location: index.php");
    exit;
}

// Handle delete -> Move to Trash
if (isset($_POST['del']) && !empty($_POST['chk'])) {
    foreach ($_POST['chk'] as $v) {
        $file = basename($v); // security: prevent directory traversal
        $inboxFile = "User_Data/$user/inbox/$file";
        $trashFile = "User_Data/$user/trash/$file";
        if (file_exists($inboxFile)) {
            copy($inboxFile, $trashFile);
            unlink($inboxFile);
        }
    }
}
?>

<h1>Inbox</h1>
<hr/>
<form method="post">
    <input type="submit" name="del" value="Delete"/>
    <hr/>
    <?php
    $inboxDir = "User_Data/$user/inbox";
    if (is_dir($inboxDir)) {
        $od = opendir($inboxDir);
        $hasFiles = false;
        while (($f = readdir($od)) !== false) {
            if ($f != "." && $f != "..") {
                $safeName = htmlspecialchars($f); // Safe for HTML
                echo "<input type='checkbox' name='chk[]' value='$safeName'> ";
                echo "<a href='home.php?coninb=$safeName'>$safeName</a><hr/>";
                $hasFiles = true;
            }
        }
        closedir($od);

        if (!$hasFiles) {
            echo "<p>No inbox messages.</p>";
        }
    }
    ?>
</form>
