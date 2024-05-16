<?php
function addBackgroundToPng($DestinationToSaveFile, $usePathInfo)
{
    if ($usePathInfo === 'png') {
        // Load the PNG image
        $image = imagecreatefrompng($DestinationToSaveFile);

        // Create a new true color image with the same size
        $width = imagesx($image);
        $height = imagesy($image);
        $backgroundImage = imagecreatetruecolor($width, $height);

        // Allocate the background color
        $backgroundColor = imagecolorallocate($backgroundImage, 255, 255, 255); // Hex color #E9ECEF

        // Fill the background with the color
        imagefill($backgroundImage, 0, 0, $backgroundColor);

        // Copy the original PNG image onto the background image
        imagecopy($backgroundImage, $image, 0, 0, 0, 0, $width, $height);

        // Save the new image
        imagepng($backgroundImage, $DestinationToSaveFile);

        // Free memory
        imagedestroy($image);
        imagedestroy($backgroundImage);
    }
}
