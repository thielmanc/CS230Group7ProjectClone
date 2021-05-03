<?php
// provides helper functions for validating uploaded files and handling them

// possible error codes that can be returned
// extends built-in error codes found at https://www.php.net/manual/en/features.file-upload.errors.php
const UPLOAD_ERR_INVALID_NAME = -1;
const UPLOAD_ERR_INVALID_TYPE = -2;
const UPLOAD_ERR_CUST_SIZE = -3;
const UPLOAD_ERR_PHP_CODE_DETECTED = -4;

// mapping of acceptable image mime types to acceptable extensions for that type
const SAFE_IMAGE_TYPES = [
    'image/jpeg' => ['jpg', 'jpeg', 'jfif'],
    'image/png' => ['png']
];

const MB = 1048576;
const DEFAULT_MAX_FILE_SIZE = 4 * MB;

// checks the given file for errors
// can return any of the codes defined at https://www.php.net/manual/en/features.file-upload.errors.php
// could also return any of the 4 custom codes above
function check_file($file, $allowed_types = SAFE_IMAGE_TYPES, $maxsize = DEFAULT_MAX_FILE_SIZE) {
    if(!$file) {
        return UPLOAD_ERR_NO_FILE;
    }

    if ($file['error']) {
        return $file['error'];
    }

    if($file['size'] == 0) {
        return UPLOAD_ERR_NO_FILE; // this check probably isnt necessary
    }

    // file name must contain a valid name and exactly one extension
    $valid_name_regex = '/^[a-zA-Z0-9_ -]+\.[a-zA-Z0-9]+$/';
    if(preg_match($valid_name_regex, $file['name']) !== 1) {
        return UPLOAD_ERR_INVALID_NAME;
    }

    // checks file mime type and extension
    // both must be valid
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!array_key_exists($file['type'], $allowed_types) || !in_array($ext, $allowed_types[$file['type']])) {
        return UPLOAD_ERR_INVALID_TYPE;
    }

    if ($file['size'] > $maxsize) {
        return UPLOAD_ERR_CUST_SIZE;
    }

    /*
        files stored correctly can still execute php code if used with include() or require()
        this tests for possible php code in the file

        right now, this is trivial to bypass because it only checks for <?php opening tags, not <? or <?=
        rejecting based on <? and <?= created too many false positives

        rejects a file if it contains any of the following cases:
            - <?php [anything] ?>
            - <?php [; or { or } or :] [whitespace] [eof]
            - <?php [; or { or } or :] [whitespace] [single-line comment on last line or half-open block comment or closed block comment followed only by whitespace]
    */
    $php_regex = '/<\?php[\s\S]*(?:\?>|[;{}:]\s*(?:(?:\/\/.*|#.*|\/\*(?:[^\*]|\*[^\/])*(\*\/\s*(?!\S))?|)\s*)*\z)/';
    if(preg_match($php_regex, file_get_contents($file['tmp_name'])) !== 0) {
        // file contains an opening php tag, and a sequence of characters that could form the end of a php script
        // high chance of php code being in the file, file should be rejected
        return UPLOAD_ERR_PHP_CODE_DETECTED;
    }

    return UPLOAD_ERR_OK;
}

// returns a random filename with the given file's extension
function safe_file_name_gen($file) {
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    return uniqid('', true).".$ext";
}