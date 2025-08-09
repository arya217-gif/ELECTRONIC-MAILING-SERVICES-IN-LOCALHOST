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
        $draftFile = "User_Data/$user/draft/$file";
        $trashFile = "User_Data/$user/trash/$file";
        if (file_exists($draftFile)) {
            copy($draftFile, $trashFile);
            unlink($draftFile);
        }
    }
}
?>

<h1>Draft</h1>
<hr/>
<form method="post">
    <input type="submit" name="del" value="Delete"/>
    <hr/>
    <?php
    $draftDir = "User_Data/$user/draft";
    if (is_dir($draftDir)) {
        $od = opendir($draftDir);
        $hasFiles = false;
        while (($f = readdir($od)) !== false) {
            if ($f != "." && $f != "..") {
                $safeName = htmlspecialchars($f);
                echo "<input type='checkbox' name='chk[]' value='$safeName'> ";
                echo "<a href='home.php?condrft=$safeName'>$safeName</a><hr/>";
                $hasFiles = true;
            }
        }
        closedir($od);

        if (!$hasFiles) {
            echo "<p>No draft messages.</p>";
        }
    }
    ?>
</form>
