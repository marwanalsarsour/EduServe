<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title'] ?></title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body class="reports-page text-end bg-light">

    <div class="container py-5">
        <?php if(isset($_SESSION['success_msg'])): ?>
            <div class="alert alert-success border-0 shadow-sm mb-4"><?= $_SESSION['success_msg']; unset($_SESSION['success_msg']); ?></div>
        <?php endif; ?>

        <div class="row g-4 justify-content-center">
            
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 text-center p-4 h-100">
                    <div class="mx-auto bg-success-subtle rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                        <i class="bi bi-person-workspace fs-1 text-success"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-1"><?= htmlspecialchars($data['profile']['name']) ?></h5>
                    <p class="text-muted small">مشرف التدريب الأكاديمي - EduServe</p>
                    
                    <div class="bg-white border rounded-3 p-3 mt-3 text-end shadow-sm">
                        <div class="mb-2 border-bottom pb-2">
                            <small class="text-secondary d-block">الكلية / القسم:</small>
                            <span class="fw-bold text-dark"><?= htmlspecialchars($data['profile']['faculty'] ?? 'تكنولوجيا المعلومات') ?></span>
                        </div>
                        <div class="mb-0 pt-1">
                            <small class="text-secondary d-block">نطاق الإشراف:</small>
                            <span class="fw-bold text-success">التدريب الميداني (Internship)</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h6 class="fw-bold mb-0 text-success"><i class="bi bi-gear-wide-connected ms-2"></i>إعدادات حساب مشرف التدريب</h6>
                    </div>
                    <div class="card-body p-4">
                        <form action="/update_supervisor_profile_process" method="POST">
                            <div class="row g-4">
                                <div class="col-md-12">
                                    <label class="small fw-bold text-secondary mb-2">الاسم الأكاديمي الكامل</label>
                                    <input type="text" name="name" class="form-control bg-light border-0 py-2 shadow-sm" value="<?= htmlspecialchars($data['profile']['name']) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="small fw-bold text-secondary mb-2">البريد الإلكتروني الجامعي</label>
                                    <input type="email" name="email" class="form-control bg-light border-0 py-2 shadow-sm" value="<?= htmlspecialchars($data['profile']['email']) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="small fw-bold text-secondary mb-2">رقم التواصل / الداخلي</label>
                                    <input type="text" name="phone" class="form-control bg-light border-0 py-2 shadow-sm" value="<?= htmlspecialchars($data['profile']['phone']) ?>">
                                </div>
                            </div>
                            <div class="text-start mt-4">
                                <button type="submit" class="btn btn-success rounded-pill px-5 fw-bold shadow-sm text-white">حفظ التعديلات</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 border-right-success">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3"><i class="bi bi-shield-lock ms-2 text-success"></i>تحديث كلمة المرور</h6>
                        <form action="/update_supervisor_password_process" method="POST">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="small fw-bold text-secondary mb-2">كلمة المرور الجديدة</label>
                                    <input type="password" name="password" class="form-control bg-light border-0 py-2 shadow-sm" placeholder="********" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="small fw-bold text-secondary mb-2">تأكيد كلمة المرور</label>
                                    <input type="password" name="confirm_password" class="form-control bg-light border-0 py-2 shadow-sm" placeholder="********" required>
                                </div>
                            </div>
                            <div class="text-start mt-4">
                                <button type="submit" class="btn btn-outline-success rounded-pill px-4 fw-bold">تحديث كلمة السر</button>
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