<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الملف الشخصي - مشرف التطوع الأكاديمي | EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body class="reports-page text-end bg-light">
    
    <?php require_once BASE_PATH . '/views/layout/header.php'; ?>

    <div class="container py-5">
        <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] == 'updated'): ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
                    <i class="bi bi-check-circle-fill ms-2"></i> تم تحديث المعلومات الشخصية بنجاح.
                    <button type="button" class="btn-close ms-0" data-bs-dismiss="alert"></button>
                </div>
            <?php elseif ($_GET['status'] == 'pass_updated'): ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
                    <i class="bi bi-shield-check ms-2"></i> تم تغيير كلمة المرور بنجاح.
                    <button type="button" class="btn-close ms-0" data-bs-dismiss="alert"></button>
                </div>
            <?php elseif ($_GET['status'] == 'pass_mismatch'): ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill ms-2"></i> كلمات المرور غير متطابقة!
                    <button type="button" class="btn-close ms-0" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="row g-4 justify-content-center">
            
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 text-center p-4 h-100">
                    <div class="mx-auto bg-warning-subtle rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                        <i class="bi bi-person-badge fs-1 text-warning"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-1"><?= htmlspecialchars($user['name']) ?></h5>
                    <p class="text-muted small">منسق العمل التطوعي - EduServe</p>
                    
                    <div class="bg-white border rounded-3 p-3 mt-3 text-end shadow-sm">
                        <div class="mb-2 border-bottom pb-2">
                            <small class="text-secondary d-block">جهة الإشراف:</small>
                            <span class="fw-bold text-dark">شؤون الطلبة / خدمة المجتمع</span>
                        </div>
                        <div class="mb-0 pt-1">
                            <small class="text-secondary d-block">نطاق العمل:</small>
                            <span class="fw-bold text-warning">الساعات التطوعية (Volunteer)</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h6 class="fw-bold mb-0 text-warning"><i class="bi bi-person-lines-fill ms-2"></i>إعدادات حساب مشرف التطوع</h6>
                    </div>
                    <div class="card-body p-4">
                        <form action="/volunteer_profile_update" method="POST">
                            <div class="row g-4 text-end">
                                <div class="col-md-12">
                                    <label class="small fw-bold text-secondary mb-2">الاسم الكامل للمشرف</label>
                                    <input type="text" name="full_name" class="form-control bg-light border-0 py-2 shadow-sm" value="<?= htmlspecialchars($user['name']) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="small fw-bold text-secondary mb-2">البريد الجامعي</label>
                                    <input type="email" name="email" class="form-control bg-light border-0 py-2 shadow-sm" value="<?= htmlspecialchars($user['email']) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="small fw-bold text-secondary mb-2">هاتف التواصل</label>
                                    <input type="text" name="phone" class="form-control bg-light border-0 py-2 shadow-sm" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="text-start mt-4">
                                <button type="submit" class="btn btn-warning rounded-pill px-5 fw-bold shadow-sm text-dark">حفظ المعلومات</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 border-right-warning">
                    <div class="card-body p-4 text-end">
                        <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-key-fill ms-2 text-warning"></i>تأمين الحساب</h6>
                        <form action="/volunteer_password_update" method="POST">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="small fw-bold text-secondary mb-2">كلمة المرور الجديدة</label>
                                    <input type="password" name="new_password" class="form-control bg-light border-0 py-2 shadow-sm" placeholder="********" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="small fw-bold text-secondary mb-2">تأكيد كلمة المرور</label>
                                    <input type="password" name="confirm_password" class="form-control bg-light border-0 py-2 shadow-sm" placeholder="********" required>
                                </div>
                            </div>
                            <div class="text-start mt-4">
                                <button type="submit" class="btn btn-outline-warning rounded-pill px-4 fw-bold text-dark">تحديث كلمة السر</button>
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