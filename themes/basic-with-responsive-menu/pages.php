<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="{{ metatags.description }}">
  <meta name="keywords" content="{{ metatags.keywords }}">
  <meta name="author" content="{{ author }}"/>
  <link rel="shortcut icon" href="{{ root-url }}favicon.ico" type="image/x-icon">
  <link rel="icon" href="{{ root-url }}favicon.ico" type="image/x-icon">
  <meta name="generator" content="handsdown" />

  <title>{{ title }}</title>
  <link rel="stylesheet" href="{{ theme-url }}/style.css" type="text/css" media="all" />
</head>
<body class="{{ template-name }}">
  {{ nav }}
  {{ main }}

  <?php 
  // You get to the page options like this:
  // $page_options['metatags.keywords'];
  // Use it when you need to do some logic based on page options.
  // When no logic is needed, use the placeholders instead (the mustache-syntax) - it is more readable
 ?>


</body>
</html>
