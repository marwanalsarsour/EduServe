<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الملف الشخصي - إدارة المنظومة</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .text-custom-black { color: black; }
        .text-custom-red { color: red; }
        .btn-custom-red { background-color: red; color: white; border: none; }
        .btn-custom-red:hover { background-color: darkred; color: white; }
        .profile-avatar { width: 100px; height: 100px; background-color: gainsboro; border: 3px solid red; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; color: black; }
    </style>
</head>
<body class="bg-light flex-column min-vh-100">

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                        <i class="bi bi-check-circle-fill ms-2"></i> <?= htmlspecialchars($success) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill ms-2"></i> <?= htmlspecialchars($error) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
                    <div class="bg-dark p-4 text-center text-white position-relative">
                        <h4 class="fw-bold mb-1">إعدادات الحساب الشخصي</h4>
                        <p class="text-light opacity-75 small mb-0">يمكنك تعديل بياناتك الشخصية وتحديث كلمة المرور من هنا.</p>
                    </div>

                    <div class="card-body p-5">
                        <div class="d-flex flex-column align-items-center mb-4">
                            <div class="profile-avatar rounded-circle mb-3 shadow-sm">
                                <i class="bi bi-person-badge"></i>
                            </div>
                            <h5 class="fw-bold text-custom-black mb-0"><?= htmlspecialchars($adminData['fullName'] ?? 'مسؤول النظام') ?></h5>
                            <span class="badge bg-danger rounded-pill px-3 py-2 mt-2 fw-semibold fs-7"><?= htmlspecialchars($adminData['role'] ?? 'إدارة كلية') ?></span>
                        </div>

                        <hr class="text-secondary opacity-25 mb-4">

                        <form action="/admin/profile/update" method="POST" class="needs-validation" novalidate>
                            
                            <div class="row g-4">
                                <div class="col-12 col-md-6">
                                    <label for="fullName" class="form-label fw-bold small text-custom-black">الاسم بالكامل</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted"><i class="bi bi-person"></i></span>
                                        <input type="text" class="form-control" id="fullName" name="fullName" value="<?= htmlspecialchars($adminData['fullName'] ?? '') ?>" required>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="phoneNumber" class="form-label fw-bold small text-custom-black">رقم الهاتف / الجوال</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted"><i class="bi bi-telephone"></i></span>
                                        <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" value="<?= htmlspecialchars($adminData['phoneNumber'] ?? '') ?>" required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="email" class="form-label fw-bold small text-custom-black">البريد الإلكتروني الرسمي</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted"><i class="bi bi-envelope"></i></span>
                                        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($adminData['email'] ?? '') ?>" required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="password" class="form-label fw-bold small text-custom-black">كلمة المرور الجديدة (اتركها فارغة للإبقاء على الحالية)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted"><i class="bi bi-shield-lock"></i></span>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="••••••••">
                                    </div>
                                    <div class="form-text small text-muted">للحفاظ على أمان حسابك، اختر كلمة مرور قوية تحتوي على رموز وأرقام.</div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-5">
                                <button type="submit" class="btn btn-custom-red py-3 rounded-3 fw-bold shadow-sm">
                                    <i class="bi bi-cloud-check ms-2"></i> حفظ التغييرات وتحديث البيانات
                                </button>
                                <a href="/admin/admin_dashboard" class="btn btn-outline-secondary py-2 rounded-3 small fw-bold">العودة للوحة التحكم</a>
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