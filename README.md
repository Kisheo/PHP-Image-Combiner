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
