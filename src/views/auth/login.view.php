<!DOCTYPE html>
<html lang="ar" dir="rtl">
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>تسجيل الدخول</title>
  <link rel="icon" type="image/png" href="/images/logo.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="/css/styles.css" />

</head>

<body class="bg-light login-bg">

  <div class="login-overlay d-flex flex-column justify-content-center min-vh-100">

    <div class="container">
      <div class="text-center mt-5 mb-4 text-white">
        <img src="/images/logo.png" alt="EduServe Logo" style="width: 180px;" class="mb-3">
        <h1 class="fw-bold mb-1">EduServe</h1>
        <p class="mb-0 opacity-75">Palestine Polytechnic University</p>
      </div>

      <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4">

          <div class="card shadow-lg login-card">
            <div class="card-body p-3 p-md-4">

              <h3 class="text-center fw-bold mb-3">تسجيل الدخول</h3>

              <?php if (isset($_GET['error'])): ?>
                  <div class="alert alert-danger py-2 small text-center" role="alert">
                      <?php 
                          if ($_GET['error'] == 'wrong_credentials') echo "البريد أو كلمة المرور غير صحيحة";
                          elseif ($_GET['error'] == 'empty_fields') echo "يرجى ملء جميع الحقول";
                          else echo "حدث خطأ ما، حاول مجدداً";
                      ?>
                  </div>
              <?php endif; ?>
    
              <form action="/login_process" method ="POST" id="loginForm">
    <div class="mb-3">
        <input type="email" id="email" name="email" class="form-control" placeholder="ادخل بريدك الالكتروني" required>
    </div>
    <div class="mb-3">
        <div class="input-group">
            <input type="password" id="password" name="password" class="form-control" placeholder="ادخل كلمة المرور" required>
            <button class="btn btn-inline-light btn-outline-light" type="button" id="togglePassword">
                <i class="bi bi-eye-slash"></i>
            </button>
        </div>
    </div>
    
    <button type="submit" id="loginBtn" class="btn btn-primary w-100 mb-2">دخول</button>
    
   <div class="text-center pt-3 border-top">
        <span class="text-muted small">ليس لديك حساب؟</span>
        <a href="/register" class="text-primary fw-bold text-decoration-none small ms-1">إنشاء حساب جديد</a>
    </div>

    <div id="loginMsg" class="alert d-none mt-3" role="alert"></div>
</form>
            </div>
          </div>
        </div>

        <p class="text-center text-white small mt-4 mb-0">
          © 2026 EduServe - Palestine Polytechnic University
        </p>
      </div>
    </div>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
</body>

</html>