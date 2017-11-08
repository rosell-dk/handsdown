# Handsdown
Handsdown is a little fast and easy CMS without database. Content is written with static markdown files, placed in the "pages" folder. Templates use a simple mustache-like syntax. Blocks (such as site navigation) is also build with static markdown files, placed in the "blocks" folder.

### Usage:
1. Download this repository
2. You can put the files into your webroot, if your entire website should run on this system. Or you can put it in a subfolder - that works as well.
3. To create a page, create a markdown file in the "pages" folder. In order to for example make a page with the URL *yourdomain.com/about_us*, you should name your file "about_us.md".
4. If the page should be linked to in the menu, edit *blocks/menu.md*
5. Copy the standard template (templates/basic) into (templates/whatever)
6. Change the template in config.php

### Template syntax:
You simply write html an insert placeholders. Currently, the following placeholders are available:

* {{ main }}: Inserts the main content (the page). The page is determined from the URL. If you visit "/about", the engine will look for a markdown file at /pages/about.md
* {{ block:xxx }}: Inserts a block. The engine will look for a markdown file at /blocks/xxx.md
* {{ xxx }}: Inserts a variable defined in the preamble of the page

### Preamble syntax:
Here is an example of a preamble:

+++
title = "Rabbits are slowing down"
background = "slow-rabbit.jpg"
+++

To insert the title taken from the preamble above, you simply put {{ title }} into your template


### Benefits compared to using a CMS such as Wordpress
- No security updates to install
- No database setup
- Its faster to create new pages and edit existing ones.
- It runs much faster. A md-file with 50 lines is passed in just 2 ms - thanks to [Parsedown](parsedown.org)
- The texts you create are in md-format which gives more opportunities. There are for example tools available to convert md files to PDF, Word, Latex and of course HTML. The text you write in Wordpress are in HTML, which cannot be converted into markdown - *unless* you [specifiy otherwise](https://en.support.wordpress.com/markdown/)

### Benefits compared to creating a pure HTML website
- Less markup = faster to edit texts
- A template = Only one place to edit such things that appear on all pages


