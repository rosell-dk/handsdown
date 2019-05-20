<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);


//require_once "vendor/spyc/Spyc.php";

$root_url = '/';

$time_start = microtime(true);

# include 'config.php';


// Prepare Parsedown
// ------------------
//require_once 'vendor/parsedown/Parsedown.php';
$Parsedown = new Parsedown();


// Here options from frontmatter are stored
// Note that same array is used for all frontmatters.
// If you use same key in a block as in a page, it will override
$frontmatter_options = Spyc::YAMLLoad(__DIR__ . '/handsdown-config.yaml');

$theme = $frontmatter_options['theme'];

/** Parse front matter
 *
 */
function parseFrontmatter(&$text_md) {
  global $frontmatter_options;

  if (strncmp($text_md, "+++", 3) === 0) {
    // TOML format, but only partly supported
    $endpos = strpos($text_md, '+++', 3);
    $frontmatter = trim(substr($text_md, 3, $endpos - 3));
    $text_md = substr($text_md, $endpos + 3);

    $lines = preg_split("/\\r\\n|\\r|\\n/", $frontmatter);

    $group_prefix = '';
    foreach ($lines as $line) {
      // Grouping
      if (preg_match('/\[(.*)\]/', $line, $matches)) {
        $group_prefix = $matches[1] . '.';
      }
      // String assignments
      if (preg_match('/([\w-]+)\\s*=\\s*([\'"])(.*)\\2/', $line, $matches)) {
        $frontmatter_options[$group_prefix . $matches[1]] = $matches[3];
      }
    }
  }
  if (strncmp($text_md, "---", 3) === 0) {
    $endpos = strpos($text_md, '---', 3);
    $frontmatter = trim(substr($text_md, 3, $endpos - 3));
    $text_md = substr($text_md, $endpos + 3);

    $array = Spyc::YAMLLoadString($frontmatter);

    foreach ($array as $index => $item) {
      $frontmatter_options[$index] = $item;
    }
  }
}


function mustache_substitute($text, $content_variable) {

  return preg_replace_callback('/{{((?:[^}]|}[^}])+)}}/', function($matches) use ($content_variable) {
    global $Parsedown;
    global $frontmatter_options;

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
      case 'content':
        return $content_variable;
//        return $Parsedown->text($c);

      case 'theme-name':
        global $theme;
        return $theme;

      case 'root-url':
        global $root_url;
        return $root_url;

      case 'theme-url':
        global $root_url;
        global $theme;
        return $root_url . 'themes/' . $theme . '/';
    }
    if (isset($frontmatter_options[$tag])) {
      return $frontmatter_options[$tag];
    }

/*
    global $shortcodes_path;
    if (is_file($shortcodes_path . '/' . $tag . '.php')) {
      ob_start();
      include $shortcodes_path . '/' . $tag . '.php';
      return ob_get_clean();
    }*/

    $block_html = find_and_parse_md_or_php_file('blocks', $tag, $content_variable);
    if ($block_html !== FALSE) {
      return $block_html;
    }

    return '';
//    return 'unknown tag: "' . $tag . '"';
  }, $text);
}


/**
 *  Tries to locate a file with extension md or php
 *  If file exists:
 *    - File is included (in order for PHP to execute)
 *    - Front matter is parsed
 *    - Mustache tags are subsituted (with helper)
 *    - Markdown is parsed into HTML
 *    - Template is located (if available), and content is wrapped in template
 *         Ie. ('pages', 'about') will look for a template called "pages.php"
 *         In the future we might look for "pages-about.php" first
 */
function find_and_parse_md_or_php_file($type, $slug, $content_variable = '') {

  $filename_without_extension = 'handsdown-content/' . $type . '/' . $slug;
  if (is_file($filename_without_extension . '.md')) {
    $filename = $filename_without_extension . '.md';
  }
  else if (is_file($filename_without_extension . '.php')) {
    $filename = $filename_without_extension . '.php';
  }
  else {
    //echo 'not found: ' . $filename_without_extension . '<br><br>';
    return FALSE;
  }

  ob_start();
  include $filename;
  $content = ob_get_clean();

  parseFrontmatter($content);

  $content = mustache_substitute($content, $content_variable);

  if ($type != 'themes') {


    // Parse markdown
    global $Parsedown;
    $content = $Parsedown->text($content);


    // Wrap it in template, if there is one
    global $theme;
    $wrapped_content = find_and_parse_md_or_php_file('themes', $theme . '/' . $type . '-' . $slug, $content);
    if ($wrapped_content !== FALSE) {
      $content = $wrapped_content;
    }
    else {
      $wrapped_content = find_and_parse_md_or_php_file('themes', $theme . '/' . $type, $content);
      if ($wrapped_content !== FALSE) {
        $content = $wrapped_content;
      }
    }
  }

  return $content;
}


// Get page md
// ------------
$page = $_GET['page'];
if ($page == '') {
  $page = 'index';
}

if (is_dir('pages/' . $page)) {
  $page .= '/index';
}

$result = find_and_parse_md_or_php_file('pages', $page, 'hmmm');
if ($result !== FALSE) {
  echo $result;
}
else {
  header("HTTP/1.0 404 Not Found");
  echo find_and_parse_md_or_php_file('pages', '404', '');
}


$time_end = microtime(true);

echo '<!-- Handsdown CMS created this page in: ' . round(($time_end - $time_start) * 1000, 2) . ' ms -->';
