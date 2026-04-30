<?php
/**
 * MAMS — get_chart_data.php
 * Returns all dashboard chart data as JSON
 */

session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

require_once '../../dbconnect.php';
header('Content-Type: application/json');

try {

    // ── Beneficiaries per Barangay ──
    $barangay_labels = [];
    $barangay_data   = [];
    $r = $conn->query("SELECT barangay, COUNT(*) as cnt FROM beneficiaries GROUP BY barangay ORDER BY cnt DESC LIMIT 8");
    while ($row = $r->fetch_assoc()) {
        $barangay_labels[] = $row['barangay'];
        $barangay_data[]   = (int)$row['cnt'];
    }

    // ── Aid Distribution per Month (last 6 months) ──
    $month_labels = [];
    $month_data   = [];
    $r2 = $conn->query("
        SELECT DATE_FORMAT(date_received, '%b %Y') as mo,
               MIN(date_received) as sort_date,
               COUNT(*) as cnt
        FROM assistance_records
        GROUP BY mo
        ORDER BY sort_date DESC
        LIMIT 6
    ");
    $months_raw = [];
    while ($row = $r2->fetch_assoc()) {
        $months_raw[] = ['label' => $row['mo'], 'cnt' => (int)$row['cnt'], 'sort' => $row['sort_date']];
    }
    // reverse to chronological order
    $months_raw = array_reverse($months_raw);
    foreach ($months_raw as $m) {
        $month_labels[] = $m['label'];
        $month_data[]   = $m['cnt'];
    }

    // ── Items Distribution by Type ──
    $item_labels = [];
    $item_data   = [];
    $r3 = $conn->query("SELECT assistance_type, COUNT(*) as cnt FROM assistance_records GROUP BY assistance_type ORDER BY cnt DESC");
    while ($row = $r3->fetch_assoc()) {
        $item_labels[] = $row['assistance_type'];
        $item_data[]   = (int)$row['cnt'];
    }

    // ── Assistance per Disaster Type ──
    $disaster_labels = [];
    $disaster_data   = [];
    $r4 = $conn->query("SELECT disaster_type, COUNT(*) as cnt FROM assistance_records GROUP BY disaster_type ORDER BY cnt DESC LIMIT 6");
    while ($row = $r4->fetch_assoc()) {
        $disaster_labels[] = $row['disaster_type'];
        $disaster_data[]   = (int)$row['cnt'];
    }

    echo json_encode([
        'success' => true,
        'data' => [
            'barangay_labels'  => $barangay_labels,
            'barangay_data'    => $barangay_data,
            'month_labels'     => $month_labels,
            'month_data'       => $month_data,
            'item_labels'      => $item_labels,
            'item_data'        => $item_data,
            'disaster_labels'  => $disaster_labels,
            'disaster_data'    => $disaster_data,
        ]
    ]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
