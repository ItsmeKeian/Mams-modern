
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MAMS — Municipality of Hernani</title>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,400;1,600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link href="assets/css/index.css" rel="stylesheet">
<link rel="icon" href="assets/images/logo.jpg">

</head>
<body>
<div class="lines"></div>

<div class="card">

  <!-- LEFT -->
  <div class="left">
    <div class="dots"></div>

    <div class="ltop">
      <div class="ltop-seal">
        <img src="assets/images/logo.jpg" alt="Seal" onerror="this.parentElement.innerHTML='🏛️'">
      </div>
      <div class="ltop-info">
        <strong>Municipality of Hernani</strong>
        <span>Eastern Samar · Region VIII · Philippines</span>
      </div>
    </div>

    <div class="lbody">
      <div class="lgu-tag"><div class="lgu-tag-line"></div>Official LGU Portal</div>
      <h1>Aid &amp; <em>Monitoring</em><br>System</h1>
      <p>Empowering the MSWDO of Hernani with a smarter, faster, and more transparent way to manage aid and beneficiary records.</p>
      <div class="checks">
        <div class="chk"><div class="chk-ico">✓</div>DSWD FACED-aligned beneficiary registration</div>
        <div class="chk"><div class="chk-ico">✓</div>Real-time aid distribution tracking and analytics</div>
        <div class="chk"><div class="chk-ico">✓</div>Automated FACED form generation and printing</div>
        <div class="chk"><div class="chk-ico">✓</div>Role-based access with complete audit trail</div>
        <div class="chk"><div class="chk-ico">✓</div>Excel export and report generation by barangay</div>
      </div>
    </div>

    <div class="lbot">
      <div class="lbot-info">
        <div class="lbot-seal"><img src="assets/images/logo.jpg" alt="Seal" onerror="this.style.display='none'"></div>
        <div class="lbot-text">
          <strong>Municipality of Hernani</strong>
          <span>Eastern Samar · Region VIII · Philippines</span>
        </div>
      </div>
      <div class="online">System Online</div>
    </div>
  </div>

  <!-- RIGHT -->
  <div class="right">

    <div class="logo-area">
      <div class="logo-wrap">
        <img src="assets/images/logo.jpg" alt="Logo" onerror="this.style.display='none'">
      </div>
      <div class="logo-text">
        <h2>Municipality<br>of Hernani</h2>
        <p>Eastern Samar</p>
        <div class="mams-tag">MAMS Portal</div>
      </div>
    </div>

    <?php if(!empty($error)): ?>
    <div class="alert-error"><span>⚠</span><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="form-title">Welcome back,<br>sign in below.</div>
    <div class="form-sub">Access is restricted to authorized municipal personnel only.</div>

    <form method="POST" action="">
      <div class="fg">
        <label class="flabel">Username</label>
        <div class="fw">
          <span class="fi">👤</span>
          <input type="text" name="username" class="finput" placeholder="Enter your username"
            value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" autocomplete="username" required>
        </div>
      </div>
      <div class="fg">
        <label class="flabel">Password</label>
        <div class="fw">
          <span class="fi">🔒</span>
          <input type="password" name="password" id="pwdInput" class="finput"
            placeholder="Enter your password" autocomplete="current-password" required>
          <button type="button" class="feye" id="eyeBtn" onclick="togglePwd()">👁️</button>
        </div>
      </div>
      <button type="submit" class="btn">Sign In to MAMS<div class="btn-arr">→</div></button>
      <div class="btn-ul"></div>
    </form>

    <div class="ffoot">
      <div class="ffoot-left">
        <strong>MAMS</strong> · Municipal Aid &amp; Monitoring System<br>
        Municipality of Hernani · Authorized Personnel Only
      </div>
      <div class="secure">🔒 Secure</div>
    </div>

  </div>
</div>

<script>
function togglePwd(){
  const i=document.getElementById('pwdInput');
  const b=document.getElementById('eyeBtn');
  if(i.type==='password'){i.type='text';b.textContent='🙈';}
  else{i.type='password';b.textContent='👁️';}
}
</script>
</body>
</html>