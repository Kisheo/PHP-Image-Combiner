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
            // Handle transparency for PNG
            imagealphablending($image, true);
            imagesavealpha($image, true);
            break;
        default:
            // Skip files that are neither JPEG nor PNG
            echo "Skipping unsupported file type: $imagePath\n";
            continue 2; // Skip to the next iteration of the foreach loop
    }

    $width = imagesx($image);
    $height = imagesy($image);

    // Calculate font size based on image resolution
    $baseFontSize = 30;
    $fontSize = $baseFontSize * ($width / 1280); // Adjust 1280 according to your needs

    // Create a new image with double the height of the original
    $newImage = imagecreatetruecolor($width, $height * 2);

    // Set transparency for PNG
    if ($imageType == IMAGETYPE_PNG) {
        $alphaChannel = imagecolorallocatealpha($newImage, 0, 0, 0, 127);
        imagefill($newImage, 0, 0, $alphaChannel);
        imagesavealpha($newImage, true);
    }

    // Copy the original image twice onto the new image
    imagecopy($newImage, $image, 0, 0, 0, 0, $width, $height);
    imagecopy($newImage, $image, 0, $height, 0, 0, $width, $height);

    // Adding text
    $text = "socozy.us";
    $font = __DIR__ . '/Arial.ttf'; // Specify path to a TrueType font
    $textColor = imagecolorallocate($newImage, 255, 255, 255); // White text

    // Calculate text position for centering
    $textBox = imagettfbbox($fontSize, 0, $font, $text);
    $textWidth = $textBox[2] - $textBox[0];
    $textHeight = $textBox[7] - $textBox[1];
    $x = ($width - $textWidth) / 2;
    $y = ($height * 2 + $textHeight) / 2;

    // Adding text to image
    imagettftext($newImage, $fontSize, 0, $x, $y, $textColor, $font, $text);

    // Saving the new image
  /*  $outputPath = $outputDir . '/' . basename($imagePath);
    switch ($imageType) {
        case IMAGETYPE_JPEG:
            imagejpeg($newImage, $outputPath);
            break;
        case IMAGETYPE_PNG:
            imagepng($newImage, $outputPath);
            break;
    }*/


// Saving the new image
$outputExtension = $imageType === IMAGETYPE_JPEG ? 'jpg' : 'png'; // Determine the output extension based on image type
$outputPath = $outputDir . '/' . basename($imagePath, '.' . pathinfo($imagePath, PATHINFO_EXTENSION)) . '.' . $outputExtension; // Adjust output file path
switch ($imageType) {
    case IMAGETYPE_JPEG:
        imagejpeg($newImage, $outputPath);
        break;
    case IMAGETYPE_PNG:
        imagepng($newImage, $outputPath);
        break;
}


    // Cleaning up
    imagedestroy($image);
    imagedestroy($newImage);
}

echo "Image processing completed.";
?>
