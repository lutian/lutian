<?php

include('CustomHeadlines.php');

// initializing class
$ch = new CustomHeadlines();

// define inverse color of text to false (it will be in black or white depends on predominance of the image background color)
$ch->colorInverse = false;
// define the image path
$image = 'images/example.jpg';
// define the result image path
$imageResult = 'images/example_result1.jpg';
// define the text box background transparency (0:full color/100: 100% transparent)
$alpha = 40;
// define the text of headlines
$headline = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua';
// set the font family (default: arial)
$ch->getFontFile();
// define headlines font size (it could be different if the box size is smaller respect the text)
$ch->setFontSize(18);
// define headlines box size
$areaX = 10;
$areaY = 10;
$areaW = 560;
$areaH = 90;
// generate the image result with headlines box
$ch->Create($image,$headline,$areaX,$areaY,$areaW,$areaH,$alpha,$imageResult);

echo '<h3>Example 1:</h3>';
echo '<p><img src="'.$ch->getImage().'"></p>';

$imageResult = 'images/example_result2.jpg';
$areaX = 10;
$areaY = 100;
$areaW = 560;
$areaH = 90;

$ch->Create($image,$headline,$areaX,$areaY,$areaW,$areaH,$alpha,$imageResult);

echo '<p><img src="'.$ch->getImage().'"></p>';

$imageResult = 'images/example_result3.jpg';
$areaX = 10;
$areaY = 250;
$areaW = 560;
$areaH = 90;

$ch->Create($image,$headline,$areaX,$areaY,$areaW,$areaH,$alpha,$imageResult);

echo '<p><img src="'.$ch->getImage().'"></p>';

echo '<h3>Example 2:</h3>';

// headlines will shown on inverse color respect the background box
$ch->colorInverse = true;
$ch->getFontFile();
$ch->setFontSize(22);
$image = 'images/example2.jpg';
$imageResult = 'images/example2_result1.jpg';
$alpha = 50;
$areaX = 10;
$areaY = 10;
$areaW = 450;
$areaH = 120;

$ch->Create($image,$headline,$areaX,$areaY,$areaW,$areaH,$alpha,$imageResult);

echo '<p><img src="'.$ch->getImage().'"></p>';

$imageResult = 'images/example2_result2.jpg';
$areaX = 10;
$areaY = 80;
$areaW = 450;
$areaH = 120;

$ch->Create($image,$headline,$areaX,$areaY,$areaW,$areaH,$alpha,$imageResult);

echo '<p><img src="'.$ch->getImage().'"></p>';

$imageResult = 'images/example2_result3.jpg';
$areaX = 10;
$areaY = 250;
$areaW = 450;
$areaH = 120;

$ch->Create($image,$headline,$areaX,$areaY,$areaW,$areaH,$alpha,$imageResult);

echo '<p><img src="'.$ch->getImage().'"></p>';
