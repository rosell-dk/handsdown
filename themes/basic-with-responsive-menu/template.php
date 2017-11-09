<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="{{ metatags.description }}">
  <meta name="keywords" content="{{ metatags.keywords }}">
  <meta name="author" content="{{ author }}"/>
  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
  <link rel="icon" href="/favicon.ico" type="image/x-icon">
  <meta name="generator" content="handsdown" />

  <title>{{ title }}</title>
  <link rel="stylesheet" href="/themes/{{ theme-name }}/style.css" type="text/css" media="all" />
</head>
<body>
  <div id="menu">
    <div id="menu_btn">
      <label for="drop">
        <svg width="26" height="20" viewBox="0 0 13 10">
          <path d="M0,1 13,1" stroke="#fff" stroke-width="2"></path>
          <path d="M0,5 13,5" stroke="#fff" stroke-width="2"></path>
          <path d="M0,9 13,9" stroke="#fff" stroke-width="2"></path>
        </svg>
      </label>
    </div>
    <input id="drop" type="checkbox">
    <nav id="mainnav">{{ nav }}</nav>
  </div>  

  {{ main }}

  <?php 
  // You get to the page options like this:
  // echo $page_options['metatags.keywords'];
 ?>

</body>
</html>
