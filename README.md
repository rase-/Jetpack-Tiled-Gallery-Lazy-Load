WP-jQuery-Lazy-Load
===================

A simple plugin that uses jQuery Lazy Load to lazily load all images in posts and pages for WordPress.

This plugin has two purposes: to provide a modifiable and simple approach to lazy loading, and to provide instructions on how to implement different kinds of supported lazy loading approaches.

## Things to note
The first thing to note is that lazy loading is supported throughout WordPress, so that features that can potentially be broken by lazy loading, such as Photon (in Jetpack), have small requirements to work properly. The data attribute used to store the original image src, should be stored in the `data-lazy-src`, like in this plugin. This way Photon can snatch your original image (instead of the placeholder) and pass it through Photon. If you don't care about using Photon, then it doesn't matter which data attribute you use.

## Background
This plugin uses the jQuery Lazy Load plugin by Mika Tuupola (https://github.com/tuupola/jquery_lazyload/), and is based on the Lazy Load plugin (http://wordpress.org/plugins/lazy-load/) written by the WordPress.com VIP team at Automattic, the TechCrunch 2011 Redesign team, and Jake Goldman (10up LLC).
