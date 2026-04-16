<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول | EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css" />
</head>

<body class="bg-light login-bg">
    <div class="login-overlay d-flex flex-column justify-content-center min-vh-100">
        <div class="container">
            <div class="text-center mt-5 mb-4 text-white">
                <img src="/public/images/logo.png" alt="EduServe Logo" style="width: 180px;" class="mb-3">
                <h1 class="fw-bold mb-1">EduServe</h1>
                <p class="mb-0 opacity-75">Palestine Polytechnic University</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4">
                    <div class="card shadow-lg login-card border-0">
                        <div class="card-body p-3 p-md-4">
                            <h3 class="text-center fw-bold mb-4">تسجيل الدخول</h3>

                            <?php if (isset($_GET['error'])): ?>
                                <div class="alert alert-danger py-2 small text-center" role="alert">
                                    <?php 
                                        if ($_GET['error'] == 'wrong_credentials') echo "البريد أو كلمة المرور غير صحيحة";
                                        elseif ($_GET['error'] == 'empty_fields') echo "يرجى ملء جميع الحقول";
                                        else echo "حدث خطأ ما، حاول مجدداً";
                                    ?>
                                </div>
                            <?php endif; ?>

                            <form action="/login_process" method="POST" id="loginForm">
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">البريد الإلكتروني</label>
                                    <input type="email" name="email" class="form-control" placeholder="example@ppu.edu" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">كلمة المرور</label>
                                    <div class="input-group">
                                        <input type="password" id="password" name="password" class="form-control" placeholder="********" required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="bi bi-eye-slash" id="toggleIcon"></i>
                                        </button>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 mb-3 py-2">دخول</button>

                                <div class="text-center pt-3 border-top">
                                    <span class="text-muted small">ليس لديك حساب؟</span>
                                    <a href="/register" class="text-primary fw-bold text-decoration-none small ms-1">إنشاء حساب جديد</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <p class="text-center text-white small mt-4 mb-0">
                © 2026 EduServe - Palestine Polytechnic University
            </p>
        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const toggleIcon = document.querySelector('#toggleIcon');

        togglePassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            toggleIcon.classList.toggle('bi-eye');
            toggleIcon.classList.toggle('bi-eye-slash');
        });
    </script>
</body>
</html>