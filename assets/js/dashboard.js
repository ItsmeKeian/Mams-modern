/**
 * MAMS — dashboard.js
 * Dashboard charts and statistics via AJAX
 */

// Chart instances (stored globally so we can destroy/update them)
let barChart, lineChart, pieChart, disChart;

const CHART_COLORS = ['#0d2b55','#d4a20f','#16a34a','#dc2626','#9333ea','#ea7c1e','#0891b2','#be185d'];
const NAVY  = '#0d2b55';
const GOLD  = '#d4a20f';
const GOLD2 = '#f0c040';
const MUTED = '#7a8db0';

$(document).ready(function () {
  loadStats();
  loadCharts();
});

// ── LOAD STAT CARDS ───────────────────────────────────────────
function loadStats() {
  ajaxGet('../php/get/get_stats.php', {}, function (res) {
    if (!res.success) return;
    const d = res.data;

    $('#statBeneficiaries').text(formatNumber(d.total_beneficiaries));
    $('#statAssistance').text(formatNumber(d.total_assistance));
    $('#statQty').text(formatNumber(d.total_qty));
    $('#statCost').text(formatCurrency(d.total_cost));
  });
}

// ── LOAD ALL CHARTS ───────────────────────────────────────────
function loadCharts() {
  ajaxGet('../php/get/get_chart_data.php', {}, function (res) {
    if (!res.success) return;
    const d = res.data;

    renderBarChart(d.barangay_labels, d.barangay_data);
    renderLineChart(d.month_labels, d.month_data);
    renderPieChart(d.item_labels, d.item_data);
    renderDisChart(d.disaster_labels, d.disaster_data);
  });
}

// ── BAR CHART — Beneficiaries per Barangay ────────────────────
function renderBarChart(labels, data) {
  const ctx = document.getElementById('barChart')?.getContext('2d');
  if (!ctx) return;
  if (barChart) barChart.destroy();

  barChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: 'Beneficiaries',
        data: data,
        backgroundColor: NAVY,
        borderRadius: 7,
        borderSkipped: false,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: NAVY,
          titleFont: { family: "'DM Sans', sans-serif", size: 12 },
          bodyFont: { family: "'DM Sans', sans-serif", size: 12 },
          padding: 10,
          cornerRadius: 8,
        }
      },
      scales: {
        x: {
          grid: { display: false },
          ticks: { font: { family: "'DM Sans', sans-serif", size: 11 }, color: MUTED }
        },
        y: {
          grid: { color: 'rgba(13,43,85,0.06)' },
          ticks: { font: { family: "'DM Sans', sans-serif", size: 11 }, color: MUTED, precision: 0 }
        }
      }
    }
  });
}

// ── LINE CHART — Aid Distribution per Month ───────────────────
function renderLineChart(labels, data) {
  const ctx = document.getElementById('lineChart')?.getContext('2d');
  if (!ctx) return;
  if (lineChart) lineChart.destroy();

  const grad = ctx.createLinearGradient(0, 0, 0, 210);
  grad.addColorStop(0, 'rgba(212,162,15,0.22)');
  grad.addColorStop(1, 'rgba(212,162,15,0)');

  lineChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [{
        label: 'Aid Records',
        data: data,
        borderColor: GOLD,
        backgroundColor: grad,
        borderWidth: 2.5,
        pointBackgroundColor: GOLD,
        pointBorderColor: '#fff',
        pointBorderWidth: 2,
        pointRadius: 5,
        pointHoverRadius: 7,
        tension: 0.4,
        fill: true,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: NAVY,
          titleFont: { family: "'DM Sans', sans-serif", size: 12 },
          bodyFont: { family: "'DM Sans', sans-serif", size: 12 },
          padding: 10,
          cornerRadius: 8,
        }
      },
      scales: {
        x: {
          grid: { display: false },
          ticks: { font: { family: "'DM Sans', sans-serif", size: 11 }, color: MUTED }
        },
        y: {
          grid: { color: 'rgba(13,43,85,0.06)' },
          ticks: { font: { family: "'DM Sans', sans-serif", size: 11 }, color: MUTED, precision: 0 }
        }
      }
    }
  });
}

// ── DOUGHNUT CHART — Items Distribution ──────────────────────
function renderPieChart(labels, data) {
  const ctx = document.getElementById('pieChart')?.getContext('2d');
  if (!ctx) return;
  if (pieChart) pieChart.destroy();

  pieChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: labels,
      datasets: [{
        data: data,
        backgroundColor: CHART_COLORS,
        borderWidth: 2.5,
        borderColor: '#fff',
        hoverOffset: 6,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      cutout: '62%',
      plugins: {
        legend: {
          position: 'right',
          labels: {
            font: { family: "'DM Sans', sans-serif", size: 11 },
            boxWidth: 12,
            padding: 14,
            color: MUTED
          }
        },
        tooltip: {
          backgroundColor: NAVY,
          titleFont: { family: "'DM Sans', sans-serif", size: 12 },
          bodyFont: { family: "'DM Sans', sans-serif", size: 12 },
          padding: 10,
          cornerRadius: 8,
        }
      }
    }
  });
}

// ── BAR CHART — Assistance per Disaster Type ─────────────────
function renderDisChart(labels, data) {
  const ctx = document.getElementById('disChart')?.getContext('2d');
  if (!ctx) return;
  if (disChart) disChart.destroy();

  disChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: 'Assistance Records',
        data: data,
        backgroundColor: CHART_COLORS.slice(0, data.length),
        borderRadius: 7,
        borderSkipped: false,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: NAVY,
          titleFont: { family: "'DM Sans', sans-serif", size: 12 },
          bodyFont: { family: "'DM Sans', sans-serif", size: 12 },
          padding: 10,
          cornerRadius: 8,
        }
      },
      scales: {
        x: {
          grid: { display: false },
          ticks: { font: { family: "'DM Sans', sans-serif", size: 11 }, color: MUTED }
        },
        y: {
          grid: { color: 'rgba(13,43,85,0.06)' },
          ticks: { font: { family: "'DM Sans', sans-serif", size: 11 }, color: MUTED, precision: 0 }
        }
      }
    }
  });
}
