# CustomHeadlines

CustomHeadlines is a PHP class that add headlines to images with text and background color depending on the image color index of selected area

# Usage

// Define parameters

// Image Source
```php
$image = 'images/example.jpg';
// Image result
$imageResult = 'images/example_result1.jpg';
// alpha of the box area
$alpha = 40;
// text of headline
$headline = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua';
// Fontsize
$fontSize = 18;
// Box area position and measures
$areaX = 10;
$areaY = 10;
$areaW = 560;
$areaH = 90;

// Initialize Class
$ch = new CustomHeadlines();

// Create image
$ch->Create($image,$headline,$fontSize,$areaX,$areaY,$areaW,$areaH,$alpha,$imageResult);

// Get the image
$imgaeResult = $ch->getImage();
```
