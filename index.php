<?php
/**
 * Shim to forward root requests to public/index.php
 * This fixes the 404 error when accessing the folder root /pph23-calculator/
 */
require_once __DIR__ . '/public/index.php';
