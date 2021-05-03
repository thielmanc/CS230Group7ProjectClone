<?php
require_once 'dbhandler.php';

function dismiss($mid) {
    safe_query('UPDATE messages SET dismissed = TRUE WHERE mid = ?', 'i', $mid);
}