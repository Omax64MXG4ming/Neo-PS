<?php

// ========================================
// NEO PS REMOTE CONTROL
// ========================================

require_once __DIR__ . "/app.php";

header("Content-Type: application/json; charset=utf-8");


// ========================================
// RESPONSE
// ========================================

echo json_encode(
    [
        "bot" => (int)($bot ?? 1),
        "sfx" => (int)($sfx ?? 1)
    ],
    JSON_UNESCAPED_SLASHES
);
