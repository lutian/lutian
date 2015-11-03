<?php

include('CustomHeadlines.php');

$ch = new CustomHeadlines();

$ch->colorInverse = false;
$image = 'images/example.jpg';
$imageResult = 'images/example_result1.jpg';
$alpha = 40;
$headline = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua';
$fontSize = 18;
$areaX = 10;
$areaY = 10;
$areaW = 560;
$areaH = 90;

$ch->Create($image,$headline,$fontSize,$areaX,$areaY,$areaW,$areaH,$alpha,$imageResult);

echo '<h3>Example 1:</h3>';
echo '<p><img src="'.$ch->getImage().'"></p>';

$imageResult = 'images/example_result2.jpg';
$areaX = 10;
$areaY = 100;
$areaW = 560;
$areaH = 90;

$ch->Create($image,$headline,$fontSize,$areaX,$areaY,$areaW,$areaH,$alpha,$imageResult);

echo '<p><img src="'.$ch->getImage().'"></p>';

$imageResult = 'images/example_result3.jpg';
$areaX = 10;
$areaY = 250;
$areaW = 560;
$areaH = 90;

$ch->Create($image,$headline,$fontSize,$areaX,$areaY,$areaW,$areaH,$alpha,$imageResult);

echo '<p><img src="'.$ch->getImage().'"></p>';

echo '<h3>Example 2:</h3>';

// headlines will shown on inverse color respect the background box
$ch->colorInverse = true;
$image = 'images/example2.jpg';
$imageResult = 'images/example2_result1.jpg';
$alpha = 50;
$areaX = 10;
$areaY = 10;
$areaW = 450;
$areaH = 120;

$ch->Create($image,$headline,$fontSize,$areaX,$areaY,$areaW,$areaH,$alpha,$imageResult);

echo '<p><img src="'.$ch->getImage().'"></p>';

$imageResult = 'images/example2_result2.jpg';
$areaX = 10;
$areaY = 80;
$areaW = 450;
$areaH = 120;

$ch->Create($image,$headline,$fontSize,$areaX,$areaY,$areaW,$areaH,$alpha,$imageResult);

echo '<p><img src="'.$ch->getImage().'"></p>';

$imageResult = 'images/example2_result3.jpg';
$areaX = 10;
$areaY = 250;
$areaW = 450;
$areaH = 120;

$ch->Create($image,$headline,$fontSize,$areaX,$areaY,$areaW,$areaH,$alpha,$imageResult);

echo '<p><img src="'.$ch->getImage().'"></p>';
