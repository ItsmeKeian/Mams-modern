<?php
/**
 * MAMS — get_stats.php
 * Returns dashboard summary statistics as JSON
 */

session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

require_once '../../dbconnect.php';
header('Content-Type: application/json');

try {
    $total_beneficiaries = $conn->query("SELECT COUNT(*) as cnt FROM beneficiaries")->fetch_assoc()['cnt'] ?? 0;
    $total_assistance    = $conn->query("SELECT COUNT(*) as cnt FROM assistance_records")->fetch_assoc()['cnt'] ?? 0;
    $total_qty           = $conn->query("SELECT COALESCE(SUM(quantity),0) as s FROM assistance_records")->fetch_assoc()['s'] ?? 0;
    $total_cost          = $conn->query("SELECT COALESCE(SUM(cost),0) as s FROM assistance_records")->fetch_assoc()['s'] ?? 0;

    echo json_encode([
        'success' => true,
        'data' => [
            'total_beneficiaries' => (int)$total_beneficiaries,
            'total_assistance'    => (int)$total_assistance,
            'total_qty'           => (int)$total_qty,
            'total_cost'          => (float)$total_cost,
        ]
    ]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
