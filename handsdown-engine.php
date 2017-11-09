<?php


include 'config.php';



$start_time = microtime(true);


// Get template
// ------------
$template_filename = $themes_path . '/' . $theme . '/template.php';

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
$page_filename_no_ext = $pages_path . '/' . $page;

if (is_dir($page_filename_no_ext)) {
  $page_filename_no_ext .= '/index';
}
//echo $page_filename;

if (!is_file($page_filename_no_ext . '.md')) {
  header("HTTP/1.0 404 Not Found");
  $page_filename_no_ext = $pages_path . '/404';
}
$page_md = file_get_contents($page_filename_no_ext . '.md');


// Prepare Parsedown
// ------------------
include('lib/Parsedown.php');
$Parsedown = new Parsedown();


// Parse front matter (TOML format, but only partly supported)
// ----------------------------------------------------------------
$pagevars = array();
if (strncmp($page_md, "+++", 3) === 0) {

  $endpos = strpos($page_md, '+++', 3);
  $frontmatter = trim(substr($page_md, 3, $endpos - 3));
  $page_md = substr($page_md, $endpos + 3);

  $lines = preg_split("/\\r\\n|\\r|\\n/", $frontmatter);

  $group_prefix = '';
  foreach ($lines as $line) {
    // Grouping
    if (preg_match('/\[(.*)\]/', $line, $matches)) {
      $group_prefix = $matches[1] . '.';
    }
    // String assignments
    if (preg_match('/(\w+)\\s*=\\s*([\'"])(.*)\\2/', $line, $matches)) {
      $pagevars[$group_prefix . $matches[1]] = $matches[3];
    }
  }
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

    case 'theme-name':
      global $theme;
      return $theme;
  }
/*
  if (strncmp($tag, "block:", 6) === 0) {
    $block_name = trim(substr($tag, 6));
    $block_filename = 'blocks/' . $block_name . '.md';
    if (!is_file($block_filename)) {
      return 'Block not found: ' . $block_filename;
    }
    $block_md = file_get_contents($block_filename);
    return $Parsedown->text($block_md);
  }*/

  if (isset($pagevars[$tag])) {
    return $pagevars[$tag];
  }

  global $shortcodes_path;
  if (is_file($shortcodes_path . '/' . $tag . '.php')) {
    include $shortcodes_path . '/' . $tag . '.php';
  }

  global $blocks_path;
  if (is_file($blocks_path . '/' . $tag . '.md')) {
    $block_md = file_get_contents($blocks_path . '/' . $tag . '.md');
    return $Parsedown->text($block_md);
  }
  
  return '';
}, $template_contents);


//echo $template_contents;

