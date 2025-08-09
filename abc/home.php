<?php
session_start();
if (empty($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

$user = $_SESSION['user'];
error_reporting(E_ALL); // show errors during development

// Find user profile image
$pExt = ['jpg', 'png', 'jpeg', 'bmp', 'gif'];
$img = '';
$userDir = "User_Data/$user";

if (is_dir($userDir)) {
    $sc = opendir($userDir);
    while (($file = readdir($sc)) !== false) {
        if ($file != '.' && $file != '..') {
            $filedata = pathinfo($file);
            if (!empty($filedata['extension']) && in_array(strtolower($filedata['extension']), $pExt)) {
                $img = $filedata['basename'];
                break; // take the first image
            }
        }
    }
    closedir($sc);
}

// Handle theme
$themeFile = "$userDir/theme";
$background = '';
if (file_exists($themeFile) && filesize($themeFile) > 0) {
    $background = trim(file_get_contents($themeFile));
}

// Save theme if changed
if (!empty($_REQUEST['thm'])) {
    file_put_contents($themeFile, $_REQUEST['thm']);
    $background = $_REQUEST['thm'];
}
?>
<?php include('templates/header.php'); ?>
<?php include('templates/sidebar.php'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>My Web Page</title>
<style>
body { margin-top:-2px }
table { margin:auto }
a { border-radius:8px; text-decoration:none; margin-left:2%; font-size:16px }
a:hover { color:#00FF00; background:#FF0000; padding:5px }
img { margin-top:-1px; margin-bottom:-5px }
</style>
</head>
<body style="background-image:url('theme/<?php echo $background; ?>');">
<table width="80%" height="100%" border="0" bordercolor="#CCCCCC" cellpadding="0" cellspacing="0" align="left">
  <tr style="background-color:#660066">
    <td height="30" colspan="2">
        <span style="color:#FFFF00">Welcome <?php echo htmlspecialchars($user); ?></span>
        <span style="margin-left:55%"><a href="home.php" style="color:#FF0000">Home</a></span>
        <span><a href="profile.php" style="color:#FF0000">Profile</a></span>
        <span><a href="home.php?option=set" style="color:#FF0000">Setting</a></span>
        <span><a href="logout.php" style="color:#FF0000">Logout</a></span>
    </td>
  </tr>
  <tr>
    <td height="119" colspan="2" style="background-color:#CCCCCC">
        <?php if ($img): ?>
            <span><?php echo "<img src='User_Data/$user/$img' height='119px'/>"; ?></span>
        <?php endif; ?>
        <span style="margin-left:45%">
            <a href="home.php?option=edit">Edit_Profile</a>
            <a href="home.php?option=pass">Change_Password</a>
            <a href="home.php?option=theme">Change_Themes</a>
        </span>
    </td>
  </tr>
  <tr>
    <td width="198" align="center" valign="top" style="background-color:#66FFCC;padding:10px">
        <a href="home.php?option=compose">COMPOSE</a><br/><br/>
        <a href="home.php?option=inbox">INBOX</a><br/><br/>
        <a href="home.php?option=sent">SENT</a><br/><br/>
        <a href="home.php?option=draft">DRAFT</a><br/><br/>
        <a href="home.php?option=spam">SPAM</a><br/><br/>
        <a href="home.php?option=trash">TRASH</a><br/>
    </td>
    <td width="878" height="516" valign="top" style="background-color:#CCFFFF">
        <?php
        $opt = $_GET['option'] ?? '';
        switch ($opt) {
            case 'edit': include('editprofile.php'); break;
            case 'pass': include('changepassword.php'); break;
            case 'theme': include('changetheme.php'); break;
            case 'admin': include('admin.php'); break;
            case 'compose': include('compose.php'); break;
            case 'inbox': include('inbox.php'); break;
            case 'sent': include('sent.php'); break;
            case 'draft': include('draft.php'); break;
            case 'spam': include('spam.php'); break;
            case 'trash': include('trash.php'); break;
            case 'set': include('setting.php'); break;
        }

        // Show message content for inbox, sent, trash, draft, spam
        $folders = [
            'coninb' => 'inbox',
            'consent' => 'sent',
            'contrs' => 'trash',
            'condrft' => 'draft',
            'conspam' => 'spam'
        ];

        foreach ($folders as $param => $folder) {
            if (!empty($_GET[$param])) {
                $filename = basename($_GET[$param]); // security
                $filePath = "$userDir/$folder/$filename";
                if (file_exists($filePath)) {
                    $msg = file_get_contents($filePath);
                    echo nl2br(htmlspecialchars($msg));
                }
            }
        }
        ?>
    </td>
  </tr>
  <tr>
    <td colspan="2" align="center">
        <marquee bgcolor="#66FF00">Developed By @ Uneja Parveen & Shriti Bonik - BCA-III</marquee>
    </td>
  </tr>
</table>
</body>
</html>
