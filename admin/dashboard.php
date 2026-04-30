<?php
// ── SESSION & ROLE CHECK ──────────────────────────────────────
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}
$user_name = htmlspecialchars($_SESSION['name']);
$user_initial = strtoupper(substr($_SESSION['name'], 0, 1));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — MAMS Admin</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
<div class="app">

    <!-- ══════════════════════════════════
         SIDEBAR
         ══════════════════════════════════ -->
    <aside class="sidebar">

        <!-- Brand -->
        <div class="sidebar-brand">
            <div class="sidebar-seal">
                <img src="../logo.jpg" alt="Hernani Seal"
                     onerror="this.parentElement.innerHTML='🏛️';this.parentElement.style.fontSize='18px'">
            </div>
            <div class="sidebar-brand-text">
                <strong>Municipality<br>of Hernani</strong>
                <span>MAMS Admin</span>
            </div>
        </div>

        <!-- Main Navigation -->
        <div class="nav-section-label">Main Menu</div>
        <nav class="sidebar-nav">
            <a href="dashboard.php" class="nav-item active">
                <div class="nav-icon">📊</div>
                Dashboard
            </a>
            <a href="beneficiaries.php" class="nav-item">
                <div class="nav-icon">👥</div>
                Beneficiaries
            </a>
            <a href="aid_distribution.php" class="nav-item">
                <div class="nav-icon">📦</div>
                Aid Distribution
            </a>
            <a href="reports.php" class="nav-item">
                <div class="nav-icon">📋</div>
                Reports
            </a>

            <!-- Admin Section -->
            <div class="nav-section-label" style="padding-left:0;margin-top:6px;">Administration</div>
            <a href="users.php" class="nav-item">
                <div class="nav-icon">👤</div>
                Users
            </a>
            <a href="logs.php" class="nav-item">
                <div class="nav-icon">📝</div>
                Logs
            </a>
            <a href="settings.php" class="nav-item">
                <div class="nav-icon">⚙️</div>
                Settings
            </a>
        </nav>

        <!-- User Card -->
        <div class="sidebar-footer">
            <div class="user-card">
                <div class="user-avatar"><?= $user_initial ?></div>
                <div class="user-info">
                    <strong><?= $user_name ?></strong>
                    <span>Administrator</span>
                </div>
                <a href="../logout.php" class="logout-btn" title="Logout">🚪</a>
            </div>
        </div>

    </aside>

    <!-- ══════════════════════════════════
         MAIN CONTENT
         ══════════════════════════════════ -->
    <div class="main">

        <!-- TOPBAR -->
        <header class="topbar">
            <div class="topbar-left">
                <h1>Dashboard</h1>
                <p>Welcome back, <?= $user_name ?>. Here's what's happening today.</p>
            </div>
            <div class="topbar-right">
                <div class="topbar-date" id="currentDate">Loading...</div>
                <div class="topbar-badge">
                    <div class="badge-dot"></div>
                    Administrator
                </div>
            </div>
        </header>

        <!-- CONTENT -->
        <div class="content">

            <!-- STAT CARDS -->
            <div class="stat-grid">
                <div class="stat-card s-blue">
                    <div class="stat-icon">👥</div>
                    <div class="stat-val" id="statBeneficiaries">—</div>
                    <div class="stat-label">Total Registered Beneficiaries</div>
                </div>
                <div class="stat-card s-gold">
                    <div class="stat-icon">📦</div>
                    <div class="stat-val" id="statAssistance">—</div>
                    <div class="stat-label">Total Assistance Records</div>
                </div>
                <div class="stat-card s-green">
                    <div class="stat-icon">✅</div>
                    <div class="stat-val" id="statQty">—</div>
                    <div class="stat-label">Total Quantity Released</div>
                </div>
                <div class="stat-card s-red">
                    <div class="stat-icon">💰</div>
                    <div class="stat-val" id="statCost">—</div>
                    <div class="stat-label">Total Assistance Cost</div>
                </div>
            </div>

            <!-- CHARTS ROW 1 -->
            <div class="chart-grid">
                <div class="chart-card">
                    <div class="chart-card-head">
                        <h3>Beneficiaries per Barangay</h3>
                        <span class="chart-badge">All Barangays</span>
                    </div>
                    <div class="chart-wrap">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
                <div class="chart-card">
                    <div class="chart-card-head">
                        <h3>Aid Distribution per Month</h3>
                        <span class="chart-badge">Last 6 Months</span>
                    </div>
                    <div class="chart-wrap">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- CHARTS ROW 2 -->
            <div class="chart-grid">
                <div class="chart-card">
                    <div class="chart-card-head">
                        <h3>Items Distribution</h3>
                        <span class="chart-badge">By Type</span>
                    </div>
                    <div class="chart-wrap">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
                <div class="chart-card">
                    <div class="chart-card-head">
                        <h3>Assistance per Disaster Type</h3>
                        <span class="chart-badge">All Types</span>
                    </div>
                    <div class="chart-wrap">
                        <canvas id="disChart"></canvas>
                    </div>
                </div>
            </div>

        </div><!-- /content -->
    </div><!-- /main -->
</div><!-- /app -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<!-- Global JS -->
<script src="../assets/js/main.js"></script>
<!-- Dashboard JS -->
<script src="../assets/js/dashboard.js"></script>

</body>
</html>
