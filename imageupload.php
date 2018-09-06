
<?php
// Return if there is no post request in the first place
if(!isset($_POST["submit"])) {
    echo "Page cannot be accessed.<br/>";
    return;
}

$target_dir = __DIR__ . "/uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = UPLOAD_ERR_OK;
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

$imageType = ["jpg", "png", "jpeg", "gif" ];

// Check if image file is a actual image or fake image
$isFile = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
if(!$isFile) {
    echo "File is not an image.<br/>";
    $uploadOk = $_FILES["fileToUpload"]["error"];
}

// Check file extension to double check for a fake image
foreach ($imageType as $type) {
    // If image type matches any type, set $uploadOk to 1
    if(strcasecmp($type, $imageFileType ) === 0) {
        $uploadOk = $_FILES["fileToUpload"]["error"];
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, this file name already exists.<br/>";
    $uploadOk = $_FILES["fileToUpload"]["error"];
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000 || $_FILES["fileToUpload"]["error"] === UPLOAD_ERR_FORM_SIZE) {
    echo "Sorry, your file is too large.<br/>";
    $uploadOk = $_FILES["fileToUpload"]["error"];
}

// Check if $uploadOk is ok, or set to an error code
if ($uploadOk !== UPLOAD_ERR_OK) {
    echo "Sorry, unable to upload file.<br/>";
} else if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.<br/>";
} else {
    echo "Sorry, there was an error uploading your file. Ensure its of type jpg, png, jpeg or gif.<br/>";
}

?>