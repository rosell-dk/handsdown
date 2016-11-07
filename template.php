<?php
$start_time = microtime(true);

$page = $_GET['page'];
if ($page == '') {
  $page = 'index';
}
$page_filename_no_ext = 'pages/' . $page;
if (is_dir($page_filename_no_ext)) {
  $page_filename_no_ext .= '/index';
}
//echo $page_filename;
$page_md = file_get_contents($page_filename_no_ext . '.md');

include('lib/Parsedown.php');
$Parsedown = new Parsedown();

// TODO: grab first line, insert it as <title>
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php 
// If first line in md-file is a heading, use that as the title
preg_match('/#\s*(.*)/', $page_md, $matches);
$title = 'default title';
if (count($matches) == 2) {
  $title = $matches[1];
}
echo $title;

// By the way, should you want to support other metadata, such as keywords for search engines, you could
// consider using the same syntax for metadata as MultiMarkdown does: http://fletcher.github.io/MultiMarkdown-4/metadata
?></title>
  <link rel="stylesheet" href="/css/style.css" type="text/css" media="all" />

</head>
<body>
<?php
// Insert menu
$menu_md = file_get_contents('menu.md');
echo '<menu>';
echo $Parsedown->text($menu_md);
echo '</menu>';
?>
<?php
echo $Parsedown->text($page_md);
?>

<br>
---------------------<br>
<?php
echo 'Page rendered in ' . ((microtime(true) - $start_time) * 1000) . ' ms';
?>
</body>
</html>
