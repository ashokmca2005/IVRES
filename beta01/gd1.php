<?php
$img_name=$_GET['img_name'];

$w=$_GET['w'];
$h=$_GET['h'];
//$h=0;

// Load image
$image = open_image($img_name);
if ($image === false) { die ('Unable to open image'); }

// Get original width and height
$width = imagesx($image);
$height = imagesy($image);

// New width and height
$new_width =$w;
$new_height =$h;


#auto calculate height
//$new_width = $new_width;
//$new_height = $height * ($new_width/$width);


// Resample
$image_resized = imagecreatetruecolor($new_width, $new_height);
imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $new_width, $new_height, $width,$height);

// Display resized image
header('Content-type: image/jpeg');
imagejpeg($image_resized);
die();

// Send header
#	header ('Content-Type: image/jpeg');

// Display image
#imagejpeg($image);


function open_image ($file) {
        # JPEG:
        $im = @imagecreatefromjpeg($file);
        if ($im !== false) { return $im; }

        # GIF:
        $im = @imagecreatefromgif($file);
        if ($im !== false) { return $im; }

        # PNG:
        $im = @imagecreatefrompng($file);
        if ($im !== false) { return $im; }

        # GD File:
        $im = @imagecreatefromgd($file);
        if ($im !== false) { return $im; }

        # GD2 File:
        $im = @imagecreatefromgd2($file);
        if ($im !== false) { return $im; }

        # WBMP:
        $im = @imagecreatefromwbmp($file);
        if ($im !== false) { return $im; }

        # XBM:
        $im = @imagecreatefromxbm($file);
        if ($im !== false) { return $im; }

        # XPM:
        $im = @imagecreatefromxpm($file);
        if ($im !== false) { return $im; }

        # Try and load from string:
        $im = @imagecreatefromstring(file_get_contents($file));
        if ($im !== false) { return $im; }

        return false;
}

?>