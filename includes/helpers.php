<?php 

/* -------------------------------------------------------------------------- */
/*                         // Function to Upload Image                        */
/* -------------------------------------------------------------------------- */
function uploadImage($file, $uploadDirectory, $entityName = "img", $allowedTypes = ['image/jpeg', 'image/png'], $maxSize = 500000)
{
    $imageFileName = NULL;

    if ($file['error'] === 0) {
        // Check if the file type is valid
        if (in_array($file['type'], $allowedTypes)) {
            // Check if the file size is within the allowed limit
            if ($file['size'] <= $maxSize) {
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                // Generate a unique filename for the image (you can use a better method if needed)
                $imageFileName = $entityName . '-' . uniqid() .'.'. $ext;

                // Move the uploaded file to the server directory
                $imagePath = $uploadDirectory . $imageFileName;
                move_uploaded_file($file['tmp_name'], $imagePath);
            } else {
                $_SESSION['error'] = "Image size must be less than " . ($maxSize / 1000000) . " MB.";
            }
        } else {
            $_SESSION['error'] = "Invalid image format. Allowed types: " . implode(', ', $allowedTypes);
        }
    }

    return $imageFileName;
}


/* -------------------------------------------------------------------------- */
/*                          Human Readable Timestamp                          */
/* -------------------------------------------------------------------------- */

function timestampToCustomHumanReadable($timestamp) {
    $currentTimestamp = time();
    $timeDifference = abs($currentTimestamp - $timestamp);

    $secondsPerMinute = 60;
    $secondsPerHour = $secondsPerMinute * 60;
    $secondsPerDay = $secondsPerHour * 24;
    $secondsPerWeek = $secondsPerDay * 7;
    $secondsPerMonth = $secondsPerDay * 30; // Approximate
    $secondsPerYear = $secondsPerDay * 365; // Approximate

    if ($timeDifference >= $secondsPerYear) {
        $years = floor($timeDifference / $secondsPerYear);
        return $years . " year" . ($years > 1 ? "s" : "") . " ago";
    } elseif ($timeDifference >= $secondsPerMonth) {
        $months = floor($timeDifference / $secondsPerMonth);
        return $months . " month" . ($months > 1 ? "s" : "") . " ago";
    } elseif ($timeDifference >= $secondsPerWeek) {
        $weeks = floor($timeDifference / $secondsPerWeek);
        return $weeks . " week" . ($weeks > 1 ? "s" : "") . " ago";
    } elseif ($timeDifference >= $secondsPerDay) {
        $days = floor($timeDifference / $secondsPerDay);
        return $days . " day" . ($days > 1 ? "s" : "") . " ago";
    } elseif ($timeDifference >= $secondsPerHour) {
        $hours = floor($timeDifference / $secondsPerHour);
        return $hours . " hour" . ($hours > 1 ? "s" : "") . " ago";
    } else {
        $minutes = floor($timeDifference / $secondsPerMinute);
        return $minutes . " minute" . ($minutes > 1 ? "s" : "") . " ago";
    }
}


?>