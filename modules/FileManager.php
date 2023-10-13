<?php
class FileManager
{
    public static function uploadSubmissionImage($image, $item_id): void
    {
        $authorId = $_SESSION['user_id'];

        // Insert the image into the file system (/uploads/submissions/uid/item_id/image)
        if (!self::setImageFormat($image, IMAGE_PREFERRED_FORMAT)) {
            return;
        }

        // Create the directory if it doesn't exist
        if (!file_exists('uploads/submissions/' . $authorId)) {
            mkdir('uploads/submissions/' . $authorId, 0777, true);
        }

        // Create the directory if it doesn't exist
        if (!file_exists('uploads/submissions/' . $authorId . '/' . $item_id)) {
            mkdir('uploads/submissions/' . $authorId . '/' . $item_id, 0777, true);
        }

        // Remove the old image
        if (file_exists('uploads/submissions/' . $authorId . '/' . $item_id . '/image.' . IMAGE_PREFERRED_FORMAT)) {
            unlink('uploads/submissions/' . $authorId . '/' . $item_id . '/image.' . IMAGE_PREFERRED_FORMAT);
        }

        // Resize and move the image to the correct location
        $path = 'uploads/submissions/' . $authorId . '/' . $item_id . '/image.' . IMAGE_PREFERRED_FORMAT;
        $succeeded = self::resizeImage($image, 200, 250, $path);

        if (!$succeeded) {
            // TODO: add logger
        }
    }

    public static function uploadProfileImage($image): void
    {
        $authorId = $_SESSION['user_id'];

        // Make sure the provided image is actually an image
        if (!exif_imagetype($image['tmp_name'])) {
            return;
        }

        // Insert the image into the file system (/uploads/submissions/uid/item_id/image)
        if (!self::setImageFormat($image, IMAGE_PREFERRED_FORMAT)) {
            return;
        }

        // Create the directory if it doesn't exist
        if (!file_exists('uploads/profiles/' . $authorId)) {
            mkdir('uploads/profiles/' . $authorId, 0777, true);
        }

        // Remove the old profile picture
        if (file_exists('uploads/profiles/' . $authorId . '/image.' . IMAGE_PREFERRED_FORMAT)) {
            unlink('uploads/profiles/' . $authorId . '/image.' . IMAGE_PREFERRED_FORMAT);
        }

        // Resize and move the image to the correct location
        $path = 'uploads/profiles/' . $authorId . '/image.' . IMAGE_PREFERRED_FORMAT;
        $succeeded = self::resizeImage($image, 200, 250, $path);

        if (!$succeeded) {
            // TODO: add logger
        }
    }

    public static function getProfilePicture(): string
    {
        $uid = $_SESSION['user_id'];

        // Get the profile picture from the file system
        $profile_picture = 'uploads/profiles/' . $uid . '/image.' . IMAGE_PREFERRED_FORMAT;

        // Check if the profile picture exists
        if (!file_exists($profile_picture)) {
            // Get the default profile picture from the file system
            $profile_picture = 'assets/default_profile.png';
        }

        return $profile_picture;
    }

    private static function resizeImage($image, $width, $height, $path): bool
    {
        $imageString = imagecreatefromstring(file_get_contents($image['tmp_name']));
        $image = imagescale($imageString, $width, $height);

        switch (IMAGE_PREFERRED_FORMAT) {
            case "png":
                imagepng($image, $path);
                break;
            case "jpg":
                imagejpeg($image, $path);
                break;
            case "gif":
                imagegif($image, $path);
                break;
            default:
                return false;
        }

        return true;
    }

    private static function setImageFormat($image, $target): bool
    {
        // Get the image format
        $image_format = exif_imagetype($image['tmp_name']);

        // Convert the image to target format without imagick
        switch ($image_format) {
            case IMAGETYPE_JPEG:
                $type = 'jpg';
                break;
            case IMAGETYPE_PNG:
                $type = 'png';
                break;
            case IMAGETYPE_GIF:
                $type = 'gif';
                break;
            default:
                return false;
        }

        switch ($target) {
            case "png":
                if ($type === 'png') {
                    return false;
                }
                $imageString = imagecreatefromstring(file_get_contents($image['tmp_name']));
                imagepng($imageString, $image['tmp_name']);
                break;
            case "jpg":
                if ($type === 'jpg') {
                    return false;
                }
                $imageString = imagecreatefromstring(file_get_contents($image['tmp_name']));
                imagejpeg($imageString, $image['tmp_name']);
                break;
            case "gif":
                if ($type === 'gif') {
                    return false;
                }
                $imageString = imagecreatefromstring(file_get_contents($image['tmp_name']));
                imagegif($imageString, $image['tmp_name']);
                break;
            default:
                return false;
        }

        return true;
    }

    public static function getSubmissionImage(int $id, int | null $uid): string
    {
        $authorId = $_SESSION['user_id'] ?? $uid;

        // Get the image from the file system
        $image = 'uploads/submissions/' . $authorId . '/' . $id . '/image.' . IMAGE_PREFERRED_FORMAT;

        // Check if the image exists
        if (!file_exists($image)) {
            // Get the default image from the file system
            $image = 'assets/default_image.png';
        }

        return $image;
    }
}