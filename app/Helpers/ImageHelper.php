<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * Generate thumbnails with watermark for uploaded images
     *
     * @param string $sourceImagePath Path to the original image
     * @param string $targetDirectory Directory to save thumbnails
     * @param string $filename Filename without extension
     * @param string $extension File extension
     * @return array Array containing paths to the generated thumbnails
     */
    public static function generateThumbnailsWithWatermark($sourceImagePath, $targetDirectory, $filename, $extension)
    {
        // Define thumbnail sizes
        $sizes = [
            ['width' => 300, 'suffix' => '_thumb_small'],
            ['width' => 800, 'suffix' => '_thumb_large']
        ];
        
        $thumbnails = [];
        
        foreach ($sizes as $size) {
            $thumbnailPath = self::createThumbnailWithWatermark(
                $sourceImagePath,
                $targetDirectory,
                $filename . $size['suffix'] . '.' . $extension,
                $size['width']
            );
            
            if ($thumbnailPath) {
                $thumbnails[] = $thumbnailPath;
            }
        }
        
        return $thumbnails;
    }
    
    /**
     * Create a single thumbnail with watermark
     *
     * @param string $sourceImagePath Path to the source image
     * @param string $targetDirectory Directory to save the thumbnail
     * @param string $filename Filename for the thumbnail
     * @param int $targetWidth Target width for the thumbnail
     * @return string|null Path to the created thumbnail or null on failure
     */
    private static function createThumbnailWithWatermark($sourceImagePath, $targetDirectory, $filename, $targetWidth)
    {
        // Load the source image
        $sourceImageInfo = getimagesize($sourceImagePath);
        if (!$sourceImageInfo) {
            return null;
        }
        
        list($sourceWidth, $sourceHeight, $sourceType) = $sourceImageInfo;
        
        // Calculate target height maintaining aspect ratio
        $aspectRatio = $sourceHeight / $sourceWidth;
        $targetHeight = intval($targetWidth * $aspectRatio);
        
        // Create a blank canvas for the thumbnail
        $thumbnail = imagecreatetruecolor($targetWidth, $targetHeight);
        
        // Enable transparency for PNG/GIF
        if ($sourceType == IMAGETYPE_PNG || $sourceType == IMAGETYPE_GIF) {
            imagealphablending($thumbnail, false);
            imagesavealpha($thumbnail, true);
            $transparent = imagecolorallocatealpha($thumbnail, 255, 255, 255, 127);
            imagefilledrectangle($thumbnail, 0, 0, $targetWidth, $targetHeight, $transparent);
        }
        
        // Load the original image based on its type
        switch ($sourceType) {
            case IMAGETYPE_JPEG:
                $sourceImage = imagecreatefromjpeg($sourceImagePath);
                break;
            case IMAGETYPE_PNG:
                $sourceImage = imagecreatefrompng($sourceImagePath);
                break;
            case IMAGETYPE_GIF:
                $sourceImage = imagecreatefromgif($sourceImagePath);
                break;
            default:
                return null; // Unsupported image type
        }
        
        // Resize the original image to fit the thumbnail dimensions
        imagecopyresampled(
            $thumbnail,
            $sourceImage,
            0,
            0,
            0,
            0,
            $targetWidth,
            $targetHeight,
            $sourceWidth,
            $sourceHeight
        );
        
        // Add watermark
        self::addWatermark($thumbnail, $targetWidth, $targetHeight);
        
        // Create target directory if it doesn't exist
        $fullTargetPath = storage_path('app/public/' . $targetDirectory);
        if (!file_exists($fullTargetPath)) {
            mkdir($fullTargetPath, 0755, true);
        }
        
        $fullFilePath = $fullTargetPath . '/' . $filename;
        
        // Save the thumbnail based on its original type
        $result = false;
        switch ($sourceType) {
            case IMAGETYPE_JPEG:
                $result = imagejpeg($thumbnail, $fullFilePath, 85);
                break;
            case IMAGETYPE_PNG:
                $result = imagepng($thumbnail, $fullFilePath);
                break;
            case IMAGETYPE_GIF:
                $result = imagegif($thumbnail, $fullFilePath);
                break;
        }
        
        // Free up memory
        imagedestroy($thumbnail);
        imagedestroy($sourceImage);
        
        // Return the path if successful
        if ($result) {
            return $targetDirectory . '/' . $filename;
        }
        
        return null;
    }
    
    /**
     * Add watermark to the image
     *
     * @param resource $image GD image resource
     * @param int $imageWidth Width of the image
     * @param int $imageHeight Height of the image
     */
    private static function addWatermark(&$image, $imageWidth, $imageHeight)
    {
        // Get watermark logo path from settings
        $watermarkPath = self::getWatermarkPath();
        
        if (!file_exists($watermarkPath)) {
            return; // Watermark file doesn't exist
        }
        
        // Get watermark image info
        $watermarkInfo = getimagesize($watermarkPath);
        if (!$watermarkInfo) {
            return;
        }
        
        list($watermarkWidth, $watermarkHeight, $watermarkType) = $watermarkInfo;
        
        // Create watermark image based on its type
        switch ($watermarkType) {
            case IMAGETYPE_JPEG:
                $watermark = imagecreatefromjpeg($watermarkPath);
                break;
            case IMAGETYPE_PNG:
                $watermark = imagecreatefrompng($watermarkPath);
                break;
            case IMAGETYPE_GIF:
                $watermark = imagecreatefromgif($watermarkPath);
                break;
            default:
                return; // Unsupported watermark type
        }
        
        // Calculate proportional size for watermark (max 10% of image width/height)
        $maxWatermarkWidth = intval($imageWidth * 0.15); // 15% of image width
        $maxWatermarkHeight = intval($imageHeight * 0.15); // 15% of image height
        
        // Maintain aspect ratio
        $watermarkRatio = $watermarkHeight / $watermarkWidth;
        
        if ($maxWatermarkWidth / $maxWatermarkHeight > 1 / $watermarkRatio) {
            // Width is the limiting factor
            $newWatermarkWidth = $maxWatermarkWidth;
            $newWatermarkHeight = intval($newWatermarkWidth * $watermarkRatio);
        } else {
            // Height is the limiting factor
            $newWatermarkHeight = $maxWatermarkHeight;
            $newWatermarkWidth = intval($newWatermarkHeight / $watermarkRatio);
        }
        
        // Create a new image for the resized watermark
        $resizedWatermark = imagecreatetruecolor($newWatermarkWidth, $newWatermarkHeight);
        
        // Preserve transparency for PNG/GIF
        if ($watermarkType == IMAGETYPE_PNG || $watermarkType == IMAGETYPE_GIF) {
            imagealphablending($resizedWatermark, false);
            imagesavealpha($resizedWatermark, true);
            $transparent = imagecolorallocatealpha($resizedWatermark, 255, 255, 255, 127);
            imagefilledrectangle($resizedWatermark, 0, 0, $newWatermarkWidth, $newWatermarkHeight, $transparent);
        }
        
        // Resize the watermark
        imagecopyresampled(
            $resizedWatermark,
            $watermark,
            0,
            0,
            0,
            0,
            $newWatermarkWidth,
            $newWatermarkHeight,
            $watermarkWidth,
            $watermarkHeight
        );
        
        // Calculate position (bottom right with 10px margins)
        $xPos = $imageWidth - $newWatermarkWidth - 10;
        $yPos = $imageHeight - $newWatermarkHeight - 10;
        
        // Ensure watermark stays within bounds
        $xPos = max(10, min($xPos, $imageWidth - $newWatermarkWidth - 10));
        $yPos = max(10, min($yPos, $imageHeight - $newWatermarkHeight - 10));
        
        // Merge the watermark onto the image
        $opacity = 70; // Opacity percentage (0-100)
        self::imageCopyMergeAlpha($image, $resizedWatermark, $xPos, $yPos, 0, 0, $newWatermarkWidth, $newWatermarkHeight, $opacity);
        
        // Free up memory
        imagedestroy($watermark);
        imagedestroy($resizedWatermark);
    }
    
    /**
     * Get the path to the watermark image
     *
     * @return string Path to the watermark image
     */
    private static function getWatermarkPath()
    {
        // Try to get custom logo from settings
        $customLogoPath = \App\Models\Setting::where('pengaturan', 'logo-web')->value('nilai');
        
        if ($customLogoPath && file_exists(public_path($customLogoPath))) {
            return public_path($customLogoPath);
        }
        
        // Default logo
        $defaultLogo = 'img/icon/logo_96x96.png';
        $defaultLogoPath = public_path($defaultLogo);
        
        if (file_exists($defaultLogoPath)) {
            return $defaultLogoPath;
        }
        
        // Return a default image if none found
        return public_path('favicon.ico'); // This is more likely to exist
    }
    
    /**
     * Custom function to merge images with alpha transparency
     *
     * @param resource $dstImg Destination image
     * @param resource $srcImg Source image (watermark)
     * @param int $dstX X-coordinate in destination image
     * @param int $dstY Y-coordinate in destination image
     * @param int $srcX X-coordinate in source image
     * @param int $srcY Y-coordinate in source image
     * @param int $srcW Source width
     * @param int $srcH Source height
     * @param int $opacity Opacity percentage (0-100)
     */
    private static function imageCopyMergeAlpha(&$dstImg, &$srcImg, $dstX, $dstY, $srcX, $srcY, $srcW, $srcH, $opacity)
    {
        // Convert 0-100 opacity to 0-127 range (0 = opaque, 127 = transparent)
        $opacity = 127 - intval(($opacity * 127) / 100);
        
        // Create a new truecolor image for blending
        $blend = imagecreatetruecolor($srcW, $srcH);
        imagealphablending($blend, false);
        imagesavealpha($blend, true);
        
        // Fill with transparent color
        $transparent = imagecolorallocatealpha($blend, 0, 0, 0, 127);
        imagefill($blend, 0, 0, $transparent);
        
        // Copy source image to blend image
        imagecopy($blend, $srcImg, 0, 0, $srcX, $srcY, $srcW, $srcH);
        
        // Adjust alpha channel for opacity
        if ($opacity !== 127) {
            for ($x = 0; $x < $srcW; $x++) {
                for ($y = 0; $y < $srcH; $y++) {
                    $color = imagecolorat($blend, $x, $y);
                    $alpha = ($color >> 24) & 0xFF;
                    
                    // Calculate new alpha based on opacity
                    $newAlpha = min(127, max(0, $alpha + $opacity));
                    
                    if ($newAlpha !== $alpha) {
                        $rgba = imagecolorsforindex($blend, $color);
                        $newColor = imagecolorallocatealpha($blend, $rgba['red'], $rgba['green'], $rgba['blue'], $newAlpha);
                        imagesetpixel($blend, $x, $y, $newColor);
                    }
                }
            }
        }
        
        // Copy the blended image onto the destination
        imagecopy($dstImg, $blend, $dstX, $dstY, 0, 0, $srcW, $srcH);
        
        // Free up memory
        imagedestroy($blend);
    }
}