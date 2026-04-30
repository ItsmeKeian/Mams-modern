/**
 * MAMS — Municipal Aid & Monitoring System
 * main.js — Global JavaScript
 * Municipality of Hernani, Eastern Samar
 */

$(document).ready(function () {

  // ── CURRENT DATE in topbar ──────────────────────────────────
  const now = new Date();
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  const dateStr = now.toLocaleDateString('en-PH', options);
  $('#currentDate').text('📅 ' + dateStr);

  // ── ACTIVE NAV ITEM based on current page ──────────────────
  const page = window.location.pathname.split('/').pop();
  $('.nav-item').each(function () {
    const href = $(this).attr('href');
    if (href && href.includes(page)) {
      $(this).addClass('active');
    }
  });

  // ── MODAL ──────────────────────────────────────────────────
  // Close modal on overlay click
  $(document).on('click', '.modal-overlay', function (e) {
    if ($(e.target).hasClass('modal-overlay')) {
      closeModal();
    }
  });

  // Close modal on X button
  $(document).on('click', '.modal-close', function () {
    closeModal();
  });

  // Close modal on ESC
  $(document).on('keydown', function (e) {
    if (e.key === 'Escape') closeModal();
  });

  // ── CONFIRM DELETE ─────────────────────────────────────────
  $(document).on('click', '.btn-delete-confirm', function () {
    const id  = $(this).data('id');
    const url = $(this).data('url');
    const msg = $(this).data('msg') || 'Are you sure you want to delete this record?';

    if (confirm(msg)) {
      $.post(url, { id: id }, function (res) {
        const r = typeof res === 'string' ? JSON.parse(res) : res;
        if (r.success) {
          showToast(r.message || 'Deleted successfully.', 'success');
          if (typeof refreshTable === 'function') refreshTable();
        } else {
          showToast(r.message || 'Failed to delete.', 'error');
        }
      });
    }
  });

});

// ── OPEN MODAL ────────────────────────────────────────────────
function openModal(id) {
  $('#' + id).addClass('show');
  $('body').css('overflow', 'hidden');
}

// ── CLOSE MODAL ───────────────────────────────────────────────
function closeModal() {
  $('.modal-overlay').removeClass('show');
  $('body').css('overflow', '');
  // reset any forms inside modals
  $('.modal form')[0]?.reset();
  $('.modal .alert').remove();
}

// ── SHOW TOAST NOTIFICATION ───────────────────────────────────
function showToast(message, type = 'success') {
  const icon = type === 'success' ? '✅' : '❌';
  const $toast = $(`
    <div class="toast ${type}">
      <span>${icon}</span>
      <span>${message}</span>
    </div>
  `);
  $('body').append($toast);
  setTimeout(() => $toast.addClass('show'), 10);
  setTimeout(() => {
    $toast.removeClass('show');
    setTimeout(() => $toast.remove(), 400);
  }, 3500);
}

// ── AJAX HELPER ───────────────────────────────────────────────
function ajaxGet(url, data, callback) {
  $.ajax({
    url: url,
    type: 'GET',
    data: data,
    dataType: 'json',
    success: callback,
    error: function (xhr) {
      console.error('AJAX GET error:', url, xhr.responseText);
      showToast('An error occurred. Please try again.', 'error');
    }
  });
}

function ajaxPost(url, data, callback) {
  $.ajax({
    url: url,
    type: 'POST',
    data: data,
    dataType: 'json',
    success: callback,
    error: function (xhr) {
      console.error('AJAX POST error:', url, xhr.responseText);
      showToast('An error occurred. Please try again.', 'error');
    }
  });
}

// ── LOADING STATE ─────────────────────────────────────────────
function showLoading(targetSelector) {
  $(targetSelector).html('<div class="loading-wrap"><div class="spinner"></div></div>');
}

function showEmpty(targetSelector, message = 'No records found.') {
  $(targetSelector).html(`
    <div class="empty-state">
      <div class="empty-state-icon">📭</div>
      <h3>No Data Available</h3>
      <p>${message}</p>
    </div>
  `);
}

// ── AVATAR INITIALS ───────────────────────────────────────────
function getInitials(name) {
  if (!name) return '?';
  const parts = name.trim().split(' ');
  if (parts.length >= 2) return parts[0][0] + parts[1][0];
  return parts[0][0];
}

// ── FORMAT NUMBER ─────────────────────────────────────────────
function formatNumber(num) {
  return Number(num || 0).toLocaleString('en-PH');
}

// ── FORMAT CURRENCY ───────────────────────────────────────────
function formatCurrency(num) {
  return '₱' + Number(num || 0).toLocaleString('en-PH', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  });
}

// ── FORMAT DATE ───────────────────────────────────────────────
function formatDate(dateStr) {
  if (!dateStr) return '—';
  const d = new Date(dateStr);
  return d.toLocaleDateString('en-PH', { year: 'numeric', month: 'short', day: 'numeric' });
}

// ── DEBOUNCE ─────────────────────────────────────────────────
function debounce(func, wait = 350) {
  let timeout;
  return function (...args) {
    clearTimeout(timeout);
    timeout = setTimeout(() => func.apply(this, args), wait);
  };
}
