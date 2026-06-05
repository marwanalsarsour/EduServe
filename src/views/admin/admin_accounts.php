<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الحسابات - إدارة الكلية</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .text-custom-black { color: black; }
        .text-custom-red { color: red; }
        .btn-custom-red { background-color: red; color: white; border: none; text-decoration: none; display: inline-flex; align-items: center; }
        .btn-custom-red:hover { background-color: darkred; color: white; }
    </style>
</head>
<body class="bg-light flex-column min-vh-100">

    <div class="container my-5">
        
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 small mb-4" role="alert">
                <i class="bi bi-check-circle-fill ms-2"></i>
                <?php
                    if ($_GET['success'] === 'updated') echo "تم تحديث بيانات الحساب بنجاح.";
                    elseif ($_GET['success'] === 'deleted') echo "تم حذف الحساب نهائياً من قاعدة البيانات.";
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-custom-black mb-1">إدارة الحسابات داخل النظام</h4>
                <p class="text-muted small mb-0">إضافة حسابات مستخدمين جدد، تعديل بياناتهم الحالية، أو حذف الحساب نهائياً من قاعدة البيانات.</p>
            </div>
            <a href="/register" class="btn btn-custom-red rounded-pill px-4 fw-bold">
                <i class="bi bi-person-plus ms-1"></i> إضافة حساب جديد
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-start">
                    <thead class="table-light">
                        <tr class="small">
                            <th class="p-3 px-4 text-custom-black fw-bold">الرقم (userID)</th>
                            <th class="p-3 text-custom-black fw-bold">الاسم الكامل (fullName)</th>
                            <th class="p-3 text-custom-black fw-bold">البريد الإلكتروني (email)</th>
                            <th class="p-3 text-custom-black fw-bold">رقم الهاتف (phoneNumber)</th>
                            <th class="p-3 text-custom-black fw-bold">نوع المستخدم (role)</th>
                            <th class="p-3 text-center text-custom-black fw-bold">الإجراءات والتحكم</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users) && is_array($users)): ?>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td class="p-3 px-4 fw-bold text-secondary">#<?= htmlspecialchars($user['userID']) ?></td>
                                    <td class="p-3">
                                        <div class="fw-bold text-custom-black"><?= htmlspecialchars($user['fullName']) ?></div>
                                    </td>
                                    <td class="p-3 text-muted"><?= htmlspecialchars($user['email']) ?></td>
                                    <td class="p-3 text-muted" dir="ltr"><?= htmlspecialchars($user['phoneNumber']) ?></td>
                                    <td class="p-3">
                                        <?php 
                                            $badgeClass = 'bg-secondary-subtle text-dark';
                                            if ($user['role'] === 'إدارة كلية') $badgeClass = 'bg-danger-subtle text-custom-red';
                                            elseif ($user['role'] === 'طالب') $badgeClass = 'bg-primary-subtle text-primary';
                                            elseif (strpos($user['role'], 'مشرف') !== false) $badgeClass = 'bg-success-subtle text-success';
                                        ?>
                                        <span class="badge <?= $badgeClass ?> rounded-pill px-3 py-1 fw-bold"><?= htmlspecialchars($user['role']) ?></span>
                                    </td>
                                    <td class="p-3 text-center">
                                        <button class="btn btn-sm btn-outline-dark border-0 mx-1 btn-edit-user" 
                                                title="تعديل بيانات الحساب" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editUserModal"
                                                data-id="<?= $user['userID'] ?>"
                                                data-name="<?= htmlspecialchars($user['fullName']) ?>"
                                                data-email="<?= htmlspecialchars($user['email']) ?>"
                                                data-phone="<?= htmlspecialchars($user['phoneNumber']) ?>"
                                                data-role="<?= htmlspecialchars($user['role']) ?>">
                                            <i class="bi bi-pencil-square text-primary fs-5"></i>
                                        </button>
                                        
                                        <form action="/admin/delete-user" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الحساب نهائياً؟');">
                                            <input type="hidden" name="userID" value="<?= $user['userID'] ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger border-0 mx-1" title="حذف الحساب">
                                                <i class="bi bi-trash3-fill text-danger fs-5"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center p-4 text-muted">لا يوجد حسابات مستخدمين مسجلة بالنظام حالياً.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 bg-white">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-custom-black"><i class="bi bi-pencil-square text-primary ms-1"></i> تعديل بيانات الحساب</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/admin/update-user" method="POST">
                    <input type="hidden" name="userID" id="edit_userID"> 
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-custom-black">الاسم الكامل (fullName)</label>
                            <input type="text" name="fullName" id="edit_fullName" class="form-control bg-light border-0" maxlength="255" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-custom-black">البريد الإلكتروني (email)</label>
                            <input type="email" name="email" id="edit_email" class="form-control bg-light border-0" maxlength="255" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-custom-black">كلمة المرور الجديدة (اتركها فارغة إن لم تود تغييرها)</label>
                            <input type="password" name="password" class="form-control bg-light border-0" placeholder="••••••••" maxlength="60">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-custom-black">رقم الهاتف (phoneNumber)</label>
                            <input type="text" name="phoneNumber" id="edit_phoneNumber" class="form-control bg-light border-0" maxlength="10" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-custom-black">نوع المستخدم الحالي (role)</label>
                            <select name="role" id="edit_role" class="form-select bg-light border-0" required>
                                <option value="طالب">طالب</option>
                                <option value="مشرف تدريب">مشرف تدريب</option>
                                <option value="مشرف تطوع">مشرف تطوع</option>
                                <option value="جهة خارجية">جهة خارجية</option>
                                <option value="إدارة كلية">إدارة كلية</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-sm btn-primary rounded-pill px-4 fw-bold">حفظ التغييرات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        const editButtons = document.querySelectorAll('.btn-edit-user');
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('edit_userID').value = this.getAttribute('data-id');
                document.getElementById('edit_fullName').value = this.getAttribute('data-name');
                document.getElementById('edit_email').value = this.getAttribute('data-email');
                document.getElementById('edit_phoneNumber').value = this.getAttribute('data-phone');
                document.getElementById('edit_role').value = this.getAttribute('data-role');
            });
        });
    </script>
</body>
</html>