<?php
function sanitize($input) {
    return htmlspecialchars(strip_tags(trim($input)));
}

function isPositiveInt($val) {
    return filter_var($val, FILTER_VALIDATE_INT) !== false && (int)$val > 0;
}

function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}
?>