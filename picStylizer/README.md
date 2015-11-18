# picStylizer

picStylizer is a PHP class that create sprite and css style file from images folder

# Usage

```php
// Initialize Class
$pS = new picStylizer();

// define minization (default: true)
$pS->setMinization();

// define css style by default
$css = 'body {backgound-color:#000;font-family:courier;color:#fff,font-size:14px;}';
$pS->setCssInit($css);

// gen sprites, styles and html example
$pS->getSprite();
```
