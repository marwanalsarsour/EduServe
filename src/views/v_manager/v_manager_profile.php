<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الملف الشخصي - مسؤول النشاط</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body class="bg-light text-end">
    <?php require_once '../layout/header.php'; ?>

    <div class="container py-5">
        <div class="row g-4 justify-content-center">
            
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 text-center p-4 h-100">
                    <div class="mx-auto bg-danger-subtle rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                        <i class="bi bi-person-workspace fs-1 text-danger"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-1">تامر القاضي</h5>
                    <p class="text-muted small">مسؤول نشاط تطوعي - EduServe</p>
                    
                    <div class="bg-white border rounded-3 p-3 mt-3 text-end shadow-sm">
                        <div class="mb-2 border-bottom pb-2">
                            <small class="text-secondary d-block">المؤسسة التابع لها:</small>
                            <span class="fw-bold text-dark">مؤسسة التطوع المجتمعي</span>
                        </div>
                        <div class="mb-0 pt-1">
                            <small class="text-secondary d-block">تاريخ التفعيل:</small>
                            <span class="fw-bold">15 يناير 2026</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h6 class="fw-bold mb-0 text-danger"><i class="bi bi-person-gear ms-2"></i>تعديل المعلومات الحساب</h6>
                    </div>
                    <div class="card-body p-4">
                        <form action="update_profile.php" method="POST">
                            <div class="row g-4">
                                <div class="col-md-12">
                                    <label class="small fw-bold text-secondary mb-2">الاسم الكامل للمسؤول</label>
                                    <input type="text" class="form-control bg-light border-0 py-2 shadow-sm" value="تامر القاضي" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="small fw-bold text-secondary mb-2">البريد الإلكتروني</label>
                                    <input type="email" class="form-control bg-light border-0 py-2 shadow-sm" value="tamer@example.com" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="small fw-bold text-secondary mb-2">رقم التواصل</label>
                                    <input type="text" class="form-control bg-light border-0 py-2 shadow-sm" value="059xxxxxxx">
                                </div>
                            </div>
                            <div class="text-start mt-4">
                                <button type="submit" class="btn btn-danger rounded-pill px-5 fw-bold shadow-sm">حفظ التعديلات</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 border-right-dark">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-shield-lock ms-2 text-danger"></i>تحديث الأمان</h6>
                    </div>
                    <div class="card-body p-4">
                        <p class="small text-muted mb-4">يُنصح بتغيير كلمة المرور بشكل دوري لضمان حماية بيانات المتطوعين.</p>
                        <form action="change_password.php" method="POST">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="small fw-bold text-secondary mb-2">كلمة المرور الجديدة</label>
                                    <input type="password" class="form-control bg-light border-0 py-2 shadow-sm" placeholder="********" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="small fw-bold text-secondary mb-2">تأكيد كلمة المرور</label>
                                    <input type="password" class="form-control bg-light border-0 py-2 shadow-sm" placeholder="********" required>
                                </div>
                            </div>
                            <div class="text-start mt-4">
                                <button type="submit" class="btn btn-outline-dark rounded-pill px-4 fw-bold shadow-sm">تغيير كلمة السر</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>