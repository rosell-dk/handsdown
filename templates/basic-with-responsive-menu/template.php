<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ title }}</title>
  <link rel="stylesheet" href="/templates/basic-with-responsive-menu/style.css" type="text/css" media="all" />
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


</body>
</html>
