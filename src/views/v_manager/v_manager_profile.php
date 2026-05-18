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
    <?php require_once '../src/views/layout/header.php'; ?>

    <div class="container py-5">
        <div class="row g-4 justify-content-center">
            
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 text-center p-4 h-100">
                    <div class="mx-auto bg-danger-subtle rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                        <i class="bi bi-person-workspace fs-1 text-danger"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-1"><?= htmlspecialchars($profile['name']) ?></h5>
                    <p class="text-muted small">مسؤول نشاط تطوعي - EduServe</p>
                    
                    <div class="bg-white border rounded-3 p-3 mt-3 text-end shadow-sm">
                        <div class="mb-2 border-bottom pb-2">
                            <small class="text-secondary d-block">المؤسسة التابع لها:</small>
                            <span class="fw-bold text-dark"><?= htmlspecialchars($profile['organization_name'] ?? 'غير محدد') ?></span>
                        </div>
                        <div class="mb-0 pt-1">
                            <small class="text-secondary d-block">تاريخ التفعيل:</small>
                            <span class="fw-bold"><?= date('d M Y', strtotime($profile['created_at'])) ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <?php if(isset($_SESSION['success_profile'])): ?>
                    <div class="alert alert-success border-0 shadow-sm mb-4"><?= $_SESSION['success_profile']; unset($_SESSION['success_profile']); ?></div>
                <?php endif; ?>

                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h6 class="fw-bold mb-0 text-danger"><i class="bi bi-person-gear ms-2"></i>تعديل معلومات الحساب</h6>
                    </div>
                    <div class="card-body p-4">
                        <form action="/v_manager/profile/update" method="POST">
                            <div class="row g-4">
                                <div class="col-md-12">
                                    <label class="small fw-bold text-secondary mb-2">الاسم الكامل للمسؤول</label>
                                    <input type="text" name="name" class="form-control bg-light border-0 py-2 shadow-sm" value="<?= htmlspecialchars($profile['name']) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="small fw-bold text-secondary mb-2">البريد الإلكتروني</label>
                                    <input type="email" name="email" class="form-control bg-light border-0 py-2 shadow-sm" value="<?= htmlspecialchars($profile['email']) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="small fw-bold text-secondary mb-2">رقم التواصل</label>
                                    <input type="text" name="phone" class="form-control bg-light border-0 py-2 shadow-sm" value="<?= htmlspecialchars($profile['phone'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="text-start mt-4">
                                <button type="submit" class="btn btn-danger rounded-pill px-5 fw-bold shadow-sm">حفظ التعديلات</button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="text-center">
                    <a href="/v_manager/dashboard" class="btn btn-link text-decoration-none text-secondary small">
                        <i class="bi bi-arrow-right ms-1"></i> العودة للوحة التحكم
                    </a>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>