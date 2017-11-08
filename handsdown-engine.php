<?php


include 'config.php';

$md_path = 'pages/';


$start_time = microtime(true);


// Get template
// ------------
$template_filename = 'templates/' . $template . '/template.php';

if (!is_file($template_filename)) {
  echo 'template not found: ' . $template_filename;
  exit;
}
$template_contents = file_get_contents($template_filename);


// Get page md
// ------------
$page = $_GET['page'];
if ($page == '') {
  $page = 'index';
}
$page_filename_no_ext = $md_path . $page;

if (is_dir($page_filename_no_ext)) {
  $page_filename_no_ext .= '/index';
}
//echo $page_filename;

if (!is_file($page_filename_no_ext . '.md')) {
  header("HTTP/1.0 404 Not Found");
  $page_filename_no_ext = $md_path . '404';
}
$page_md = file_get_contents($page_filename_no_ext . '.md');


// Prepare Parsedown
// ------------------
include('lib/Parsedown.php');
$Parsedown = new Parsedown();


// Parse front matter (TOML format, but only strings are supported)
// ----------------------------------------------------------------
$pagevars = array();
if (strncmp($page_md, "+++", 3) === 0) {

  $endpos = strpos($page_md, '+++', 3);
  $frontmatter = trim(substr($page_md, 3, $endpos - 3));

  $page_md = substr($page_md, $endpos + 3);

  preg_replace_callback('/(\w+)\\s*=\\s*([\'"])(.*)\\2/', function($matches) {
    global $pagevars;
    $pagevars[$matches[1]] = $matches[3];
  }, $frontmatter);
}



// Substitute template (mustache-like syntax)
// ------------------------------------------

echo preg_replace_callback('/{{((?:[^}]|}[^}])+)}}/', function($matches) {
  global $Parsedown;
  global $pagevars;

  $tag = trim($matches[1]);

  switch ($tag) {
/*
    case 'title':
      // If first line in md-file is a heading, use that as the title
      preg_match('/#\s*(.*)/', $page_md, $matches);
      if (count($matches) == 2) {
        return $matches[1];
      }
      return 'default title';*/
    case 'main':
      global $page_md;
      return $Parsedown->text($page_md);
  }
  if (strncmp($tag, "block:", 6) === 0) {
    $block_name = trim(substr($tag, 6));
    $block_filename = 'blocks/' . $block_name . '.md';
    if (!is_file($block_filename)) {
      return 'Block not found: ' . $block_filename;
    }
    $block_md = file_get_contents($block_filename);
    return $Parsedown->text($block_md);
  }

  if (isset($pagevars[$tag])) {
    return $pagevars[$tag];
  }

  
  return $tag . 'a';
}, $template_contents);


//echo $template_contents;

