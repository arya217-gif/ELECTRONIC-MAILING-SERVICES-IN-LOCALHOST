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
        $file = basename($v); // prevent directory traversal
        $spamFile = "User_Data/$user/spam/$file";
        $trashFile = "User_Data/$user/trash/$file";
        if (file_exists($spamFile)) {
            copy($spamFile, $trashFile);
            unlink($spamFile);
        }
    }
}
?>

<h1>Spam</h1>
<hr/>
<form method="post">
    <input type="submit" name="del" value="Delete"/>
    <hr/>
    <?php
    $spamDir = "User_Data/$user/spam";
    if (is_dir($spamDir)) {
        $od = opendir($spamDir);
        $hasFiles = false;
        while (($f = readdir($od)) !== false) {
            if ($f != "." && $f != "..") {
                $safeName = htmlspecialchars($f); // Safe for HTML
                echo "<input type='checkbox' name='chk[]' value='$safeName'> ";
                echo "<a href='home.php?conspam=$safeName'>$safeName</a><hr/>";
                $hasFiles = true;
            }
        }
        closedir($od);

        if (!$hasFiles) {
            echo "<p>No spam messages.</p>";
        }
    }
    ?>
</form>
