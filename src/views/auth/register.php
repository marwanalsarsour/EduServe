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

        <div class="container">
            <div class="text-center mt-4 mb-4 text-white">
                <img src="/images/logo.png" alt="EduServe Logo" style="width: 150px;" class="mb-3">
                <h1 class="fw-bold mb-1">EduServe</h1>
                <p class="mb-0 opacity-75 small">Palestine Polytechnic University</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">

                    <div class="card shadow-lg login-card">
                        <div class="card-body p-4 p-md-4">

                            <h3 class="text-center fw-bold mb-4">إنشاء حساب جديد</h3>

                            <form action="/register_process" method="POST" id="registerForm">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <input type="text" name="fullname" class="form-control" placeholder="الاسم الكامل (رباعي)" required>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <input type="email" name="email" id="email" class="form-control" placeholder="أدخل البريد الإلكتروني " required>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <input type="password" name="password" class="form-control" placeholder="كلمة المرور" required>
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <select name="role" class="form-select border-0 shadow-none" style="border-radius: 10px; padding: 12px; background: rgba(255, 255, 255, 0.9);" required>
                                            <option value="" selected disabled>اختر نوع الحساب...</option>
                                            <option value="student">طالب (متدرب/متطوع)</option>
                                            <option value="academic_supervisor">مشرف تدريب أكاديمي</option>
                                            <option value="volunteer_supervisor">مشرف تطوع أكاديمي</option>
                                            <option value="field_trainer">مدرب داخل الجهة المستضيفة</option>
                                            <option value="volunteer_manager">مسؤول نشاط تطوعي (مؤسسة)</option>
                                            <option value="college_admin">إدارة الكلية</option>
                                            <option value="external_entity">جهة خارجية (شركة/مؤسسة)</option>
                                        </select>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 fw-bold py-2 mb-3 shadow-sm">إنشاء الحساب</button>

                                <div class="text-center pt-3 border-top border-light-subtle">
                                    <span class="small opacity-75">لديك حساب بالفعل؟</span>
                                    <a href="login.php" class="text-primary fw-bold text-decoration-none small ms-1">تسجيل الدخول</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <p class="text-center text-white small mt-4 mb-4 opacity-75">
                © 2026 EduServe - Palestine Polytechnic University
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>