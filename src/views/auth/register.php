<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء حساب جديد - EduServe</title>
    <link rel="icon" type="image/png" href="/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css" />
</head>
<body class="bg-light login-bg">
    <div class="login-overlay d-flex flex-column justify-content-center min-vh-100">
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-lg login-card">
                        <div class="card-body p-4 p-md-5">
                            <div class="text-center mb-4">
                                <img src="/images/logo.png" alt="Logo" style="width: 80px;" class="mb-2">
                                <h3 class="fw-bold">إنشاء حساب جديد</h3>
                                <p class="text-muted small">انضم إلى منصة EduServe للتدريب الميداني</p>
                            </div>

                            <form action="/register_process" method="POST">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label small fw-bold">الاسم الكامل</label>
                                        <input type="text" name="fullname" class="form-control" placeholder="أدخل اسمك الرباعي" required>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label small fw-bold">البريد الإلكتروني الجامعي</label>
                                        <input type="email" name="email" class="form-control" placeholder="username@ppu.edu.ps" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small fw-bold">كلمة المرور</label>
                                        <input type="password" name="password" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small fw-bold">تأكيد كلمة المرور</label>
                                        <input type="password" name="confirm_password" class="form-control" required>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label class="form-label small fw-bold">نوع الحساب</label>
                                        <select name="role" class="form-select" required>
                                            <option value="student">طالب متدرب</option>
                                            <option value="supervisor">مشرف أكاديمي</option>
                                            <option value="employer">مدرب ميداني (جهة تدريب)</option>
                                        </select>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 fw-bold py-2 mb-3">إنشاء الحساب</button>

                                <div class="text-center pt-3 border-top">
                                    <span class="text-muted small">لديك حساب بالفعل؟</span>
                                    <a href="login.php" class="text-primary fw-bold text-decoration-none small ms-1">تسجيل الدخول</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>