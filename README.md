# PHP Image Combiner

This PHP script processes images in a specified directory, duplicating each image vertically and adding custom text to the center(Optional). It's designed to run in a local environment with XAMPP or similar server setups that support PHP and the GD library.

## Features

- **Image Duplication**: Combines two copies of the same image, one on top of the other, in a single image file.
- **Text Overlay**: Adds the text to the center of the combined image.
- **Dynamic Text Sizing**: Adjusts the font size of the text overlay based on the resolution of the images.

## Prerequisites

- PHP 7.0 or higher with GD library enabled.
- XAMPP (or similar) local server environment.
- TrueType font file (e.g., Arial.ttf) for text overlay.

## Installation

1. **Set Up XAMPP**: Ensure XAMPP is installed and running on your machine. The Apache server needs to be active.
2. **Clone Repository**: Clone this repository into your `htdocs` directory of XAMPP or the respective directory of your server setup.
git clone https://github.com/Kisheo/PHP-Image-Combiner.git
3. **Configure Script**: Place your TrueType font file in the same directory as the script and update the `$font` variable in `imageprocessor.php` to match the name of your font file.

## Usage

1. **Prepare Images**: Copy the images you want to process into the `images` directory located in the same directory as `imageprocessor.php`.
2. **Run Script**: Navigate to `http://localhost/your-repo-name/imageprocessor.php` in your web browser. Replace `your-repo-name` with the actual name of your repository.
3. **View Results**: Processed images will be saved in the `processed_img` directory. You can view or download them from there.
4. The script works with jpg files.

## Customization

To change the text overlay, edit the `$text` variable in the script. To adjust the base font size for different image resolutions, modify the `$baseFontSize` and the calculation for `$fontSize`.

## Contributing

Contributions to this project are welcome. Please fork the repository and submit a pull request with your improvements.

## License

This project is open-sourced under the MIT License. See the LICENSE file for more details.
