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

  <style>
/* Pretty printing styles. Used with prettify.js. */
/* Other themes available here: https://rawgit.com/google/code-prettify/master/styles/index.html */

/* SPAN elements with the classes below are added by prettyprint. */
.pln { color: #000 }  /* plain text */

@media screen {
  .str { color: #080 }  /* string content */
  .kwd { color: #008 }  /* a keyword */
  .com { color: #800 }  /* a comment */
  .typ { color: #606 }  /* a type name */
  .lit { color: #066 }  /* a literal value */
  /* punctuation, lisp open bracket, lisp close bracket */
  .pun, .opn, .clo { color: #660 }
  .tag { color: #008 }  /* a markup tag name */
  .atn { color: #606 }  /* a markup attribute name */
  .atv { color: #080 }  /* a markup attribute value */
  .dec, .var { color: #606 }  /* a declaration; a variable name */
  .fun { color: red }  /* a function name */
}

/* Use higher contrast and text-weight for printable form. */
@media print, projection {
  .str { color: #060 }
  .kwd { color: #006; font-weight: bold }
  .com { color: #600; font-style: italic }
  .typ { color: #404; font-weight: bold }
  .lit { color: #044 }
  .pun, .opn, .clo { color: #440 }
  .tag { color: #006; font-weight: bold }
  .atn { color: #404 }
  .atv { color: #060 }
}

pre.prettyprint { padding: 10px 15px; border: 1px solid #888; background-color: #ddd; display: inline-block; }

  </style>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.js" type="text/javascript"></script>
  <script>
/* Init script */
document.addEventListener("DOMContentLoaded", function() {
  var i=0, preTags = document.getElementsByTagName('pre');
  for (; preTags[i]; i++) {
    preTags[i].className = 'prettyprint';
  }
  prettyPrint();
});
  </script>
</head>
<body>
<?php
// Insert menu
$menu_md = file_get_contents('nav.md');
echo '<nav>';
echo $Parsedown->text($menu_md);
echo '</nav>';
?>
<?php
echo $Parsedown->text($page_md);
?>

<br>
---------------------<br>
<?php
echo 'Page rendered in ' . ((microtime(true) - $start_time) * 1000) . ' ms';
?>
<br><br>
<b>You find handsdown useful? Please share, or star it on github.</b><br>
<a href="https://twitter.com/intent/tweet?text=Build your website using static markdown files. Start here: https://github.com/rosell-dk/handsdown" target="_blank">Share on twitter</a> - 
<a href="https://www.facebook.com/sharer/sharer.php?u=https%3A//github.com/rosell-dk/handsdown">Share on Facebook</a>
<!-- http://www.sharelinkgenerator.com/ -->
</body>
</html>
