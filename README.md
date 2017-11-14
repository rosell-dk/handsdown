# Handsdown
Handsdown is a little fast and easy CMS without database. Content is written in static markdown files. Templates use a simple mustache-like syntax. Blocks (such as site navigation) is also build with static markdown files.

### Installation
1. Put the files into your webroot
2. That's it! - A small demo site is available

### Creating pages
Pages are written in *markdown*. If you don't already know *markdown*, google it and love it. This file is markdown, by the way.

Pages resides in the "pages" folder. The filename determines the URL. Ie creating a file "about.md" in the pages folder, will result in the URL */about*. 

Metadata can be set in the frontmatter, using YAML. Here is an example:

---
title: About us
author: Bjørn Rosell
---

The metadata is used by the theme. As such, the meaning is defined by the theme.


### The menu
The demo site has a site menu available. The default theme expects the menu to be defined in */blocks/nav.md*. 

Other themes might utilize other ways to define the menu. For example, they may require it to be defined in the theme options yaml file (not implemented yet) - like this:

```
menu:
  - Blog: /blog
  - Corporate: http://corporate-site.com
  - About us: /about
    - Mission: /about/mission
    - Contact us: /about/contact
``` 


### Template syntax:
You simply write html an insert placeholders. Currently, the following placeholders are available:

* {{ content }}: Inserts the main content (the page). The page is determined from the URL. If you visit "/about", the engine will look for a markdown file at /pages/about.md
* {{ xxx }}: Either insert a block, a shortcode or a variable defined in the frontmatter of the page (whichever exists).
  * The engine will look for blocks at /blocks/xxx.md
  * The engine will look for page variables in the frontmatter of the page (see below)


### Benefits compared to using a CMS such as Wordpress
- No security updates to install
- No database setup
- Its faster to create new pages and edit existing ones.
- It runs much faster. A md-file with 50 lines is passed in just 2 ms - thanks to [Parsedown](parsedown.org)
- The texts you create are in md-format which gives more opportunities. There are for example tools available to convert md files to PDF, Word, Latex and of course HTML. The text you write in Wordpress are in HTML, which cannot be converted into markdown - *unless* you [specifiy otherwise](https://en.support.wordpress.com/markdown/)

### Benefits compared to creating a pure HTML website
- Less markup = faster to edit texts
- A template = Only one place to edit such things that appear on all pages

### Roadmap
- Considering implementing real mustache templates (https://github.com/bobthecow/mustache.php)




