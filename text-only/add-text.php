<?php

$sourceDir = __DIR__ . '/images'; // Source directory containing the image files
$outputDir = __DIR__ . '/processed_img'; // Output directory for processed images

// Check if output directory exists, if not create it
if (!file_exists($outputDir)) {
    mkdir($outputDir, 0777, true);
}

// Get all JPG and PNG images from source directory
$images = array_merge(glob($sourceDir . '/*.jpg'), glob($sourceDir . '/*.png'));

foreach ($images as $imagePath) {
    $imageType = exif_imagetype($imagePath);

    // Create image based on file type
    switch ($imageType) {
        case IMAGETYPE_JPEG:
            $image = imagecreatefromjpeg($imagePath);
            break;
        case IMAGETYPE_PNG:
            $image = imagecreatefrompng($imagePath);
            imagealphablending($image, true);
            imagesavealpha($image, true);
            break;
        default:
            echo "Skipping unsupported file type: $imagePath\n";
            continue 2;
    }

    $width = imagesx($image);
    $height = imagesy($image);

    // Calculate font size based on image resolution
    $baseFontSize = 30;
    $fontSize = $baseFontSize * ($width / 1280);

    $text = "socozy.us";
    $font = __DIR__ . '/Arial.ttf'; // Path to your TrueType font
    $textColor = imagecolorallocate($image, 255, 255, 255); // White text

    // Calculate text position
    $positions = [
        "top-left" => [0, $fontSize],
        "top-center" => [($width - $fontSize * strlen($text)) / 2, $fontSize],
        "top-right" => [$width - $fontSize * strlen($text), $fontSize],
        "bottom-left" => [0, $height - $fontSize],
        "bottom-center" => [($width - $fontSize * strlen($text)) / 2, $height - $fontSize],
        "bottom-right" => [$width - $fontSize * strlen($text), $height - $fontSize]
    ];

    // Pick a random position
    $position = array_rand($positions);
    $x = $positions[$position][0];
    $y = $positions[$position][1];

    // Add some padding
    $padding = 10;
    $x += ($x > 0) ? $padding : $padding;
    $y -= ($y < $height) ? $padding : 0;

    // Adding text to image
    imagettftext($image, $fontSize, 0, $x, $y, $textColor, $font, $text);

    // Saving the new image
    $outputExtension = $imageType === IMAGETYPE_JPEG ? 'jpg' : 'png';
    $outputPath = $outputDir . '/' . basename($imagePath, '.' . pathinfo($imagePath, PATHINFO_EXTENSION)) . '.' . $outputExtension;

    switch ($imageType) {
        case IMAGETYPE_JPEG:
            imagejpeg($image, $outputPath);
            break;
        case IMAGETYPE_PNG:
            imagepng($image, $outputPath);
            break;
    }

    // Cleaning up
    imagedestroy($image);
}

echo "Image processing completed.";
?>
