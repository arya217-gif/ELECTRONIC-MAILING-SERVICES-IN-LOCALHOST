<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$user = $_SESSION['user'] ?? '';
if (!$user) {
    header("Location: index.php");
    exit;
}

// Handle deletion
if (isset($_POST['del']) && !empty($_POST['chk'])) {
    foreach ($_POST['chk'] as $v) {
        $file = basename($v); // prevent directory traversal
        $trashFile = "User_Data/$user/trash/$file";
        if (file_exists($trashFile)) {
            unlink($trashFile);
        }
    }
}
?>

<h1>Trash</h1>
<hr/>
<form method="post">
    <input type="submit" name="del" value="Delete"/>
    <hr/>
    <?php
    $trashDir = "User_Data/$user/trash";
    if (is_dir($trashDir)) {
        $od = opendir($trashDir);
        $hasFiles = false;
        while (($f = readdir($od)) !== false) {
            if ($f != "." && $f != "..") {
                $safeName = htmlspecialchars($f);
                echo "<input type='checkbox' name='chk[]' value='$safeName'> ";
                echo "<a href='home.php?contrs=$safeName'>$safeName</a><hr/>";
                $hasFiles = true;
            }
        }
        closedir($od);

        if (!$hasFiles) {
            echo "<p>No messages in Trash.</p>";
        }
    }
    ?>
</form>
