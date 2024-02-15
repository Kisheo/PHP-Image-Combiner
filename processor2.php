<?php

$sourceDir = __DIR__ . '/images'; // Source directory containing the JPG images
$outputDir = __DIR__ . '/processed_img'; // Output directory for processed images

// Check if output directory exists, if not create it
if (!file_exists($outputDir)) {
    mkdir($outputDir, 0777, true);
}

$images = glob($sourceDir . '/*.jpg'); // Get all JPG images from source directory

foreach ($images as $imagePath) {
    $image = imagecreatefromjpeg($imagePath);
    $width = imagesx($image);
    $height = imagesy($image);

    // Calculate font size based on image resolution
    $baseFontSize = 40;
    $fontSize = $baseFontSize * ($width / 1280); // Adjust 1280 according to your needs

    // Create a new image with double the height of the original
    $newImage = imagecreatetruecolor($width, $height * 2);

    // Copy the original image twice onto the new image
    imagecopy($newImage, $image, 0, 0, 0, 0, $width, $height);
    imagecopy($newImage, $image, 0, $height, 0, 0, $width, $height);

    // Add text
    $text = "www.socozy.us";
    $font = __DIR__ . '/Arial.ttf'; // Specify path to a TrueType font
    $textColor = imagecolorallocate($newImage, 255, 255, 255); // White text

    // Calculate text position for centering
    $textBox = imagettfbbox($fontSize, 0, $font, $text);
    $textWidth = $textBox[2] - $textBox[0];
    $textHeight = $textBox[7] - $textBox[1];
    $x = ($width - $textWidth) / 2;
    $y = ($height * 2 + $textHeight) / 2;

    // Add text to image
    imagettftext($newImage, $fontSize, 0, $x, $y, $textColor, $font, $text);

    // Save the new image
    $outputPath = $outputDir . '/' . basename($imagePath);
    imagejpeg($newImage, $outputPath);

    // Clean up
    imagedestroy($image);
    imagedestroy($newImage);
}

echo "Image processing completed.";

?>
