
# Theme: basic-with-responsive-menu
A simple theme with a responsive menu.

## Requirements

### Required blocks
You must place a file "nav.md" in the blocks folder. This defines the main navigation.

It might for example contain something like this:

<pre>
- [Home](/)
- [About us](/about_us "Click to read about the awesomeness of us")
- [Products](/products "Everybody's got something to sell")
  - [The Pill](/products/the_pill "Red og green?")
  - [The Saw](/products/the_saw)
- [Github](https://github.com/rosell-dk/handsdown)
</pre>

### Required frontmatter

On pages, use a frontmatter like this:

<pre>
+++
title = "Hands down the simplest file-oriented CMS"
author = "Bjørn Rosell"

[metatags]
description = "Hands down - the notoriously unnoticed CMS"
keywords = "CMS, file-oriented, PHP, templates"
+++
</pre>


