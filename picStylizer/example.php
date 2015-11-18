<?php

include('picStylizer.php');

// initialize
$pS = new picStylizer();

// define minization (default: true)
$pS->setMinization();

// define css style by default
$css = 'body {background-color:#000;font-family:courier;color:#fff;font-size:14px;}';
$pS->setCssInit($css);

// gen sprites, styles and html example
$pS->getSprite();
