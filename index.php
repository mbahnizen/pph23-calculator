<?php
/**
 * Root shim for Laragon / local development.
 *
 * When accessing /pph23-calculator/ directly (without Nginx try_files),
 * this forwards to the real entry point at public/index.php.
 *
 * In production, Nginx handles this via:
 *   try_files $uri $uri/ /pph23-calculator/public/index.php?$args;
 */
require_once __DIR__ . '/public/index.php';
