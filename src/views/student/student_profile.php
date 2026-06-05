<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>الملف الشخصي - <?= htmlspecialchars($student['fullName'] ?? 'الطالب') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/assets/img/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">

        <?php if (isset($_SESSION['msg'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $_SESSION['msg']; unset($_SESSION['msg']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm mb-5 bg-primary text-white">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-4">
                        <div class="position-relative">
                            <?php if (!empty($student['profile_image'])): ?>
                                <img id="profileImage" src="<?= $student['profile_image'] ?>" 
                                     class="rounded-circle border border-4 border-white" width="120" height="120">
                            <?php else: ?>
                                <div id="defaultAvatar" class="rounded-circle bg-white d-flex align-items-center justify-content-center border border-4 border-white"
                                     style="width:120px; height:120px;">
                                    <i class="bi bi-person-fill text-primary" style="font-size:60px;"></i>
                                </div>
                            <?php endif; ?>

                            <label for="imageUpload" class="btn btn-light btn-sm position-absolute bottom-0 end-0 rounded-circle shadow-sm">
                                <i class="bi bi-camera"></i>
                            </label>
                            <input type="file" id="imageUpload" class="d-none" accept="image/*">
                        </div>

                        <div class="text-center text-md-start">
                            <h4 id="studentName" class="fw-bold mb-1"><?= htmlspecialchars($student['fullName'] ?? 'غير معرف') ?></h4>
                            
                            <small class="badge bg-white text-primary">
                                <span id="studentMajor"><?= htmlspecialchars($student['majorName'] ?? 'التخصص') ?></span>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card text-center shadow-sm border-0 h-100">
                    <div class="card-body">
                        <i class="bi bi-award text-primary fs-2"></i>
                        <h4 id="certificatesCount" class="fw-bold mt-3"><?= $certsCount ?? 0 ?></h4>
                        <p class="text-muted mb-0">عدد الشهادات</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-center shadow-sm border-0 h-100">
                    <div class="card-body">
                        <i class="bi bi-building text-success fs-2"></i>
                        <h4 id="trainingCount" class="fw-bold mt-3"><?= $trainingCount ?? 0 ?></h4>
                        <p class="text-muted mb-0">عدد التدريبات المنجزة</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-center shadow-sm border-0 h-100">
                    <div class="card-body">
                        <i class="bi bi-heart text-danger fs-2"></i>
                        <h4 id="volunteerCount" class="fw-bold mt-3"><?= $volunteerCount ?? 0 ?></h4>
                        <p class="text-muted mb-0">عدد الأعمال التطوعية</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0" id="editSection">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">
                    <i class="bi bi-person-lines-fill text-primary ms-2"></i>
                    تعديل بيانات الحساب
                </h5>

                <form id="profileForm" action="/update_profile_process" method="POST">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">الاسم الكامل</label>
                            <input type="text" name="fullName" class="form-control" 
                                   value="<?= htmlspecialchars($student['fullName'] ?? '') ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">البريد الإلكتروني</label>
                            <input type="email" name="email" class="form-control" 
                                   value="<?= htmlspecialchars($student['email'] ?? '') ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">رقم الهاتف</label>
                            <input type="text" name="phone" class="form-control" 
                                   value="<?= htmlspecialchars($student['phoneNumber'] ?? '') ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">التخصص</label>
                            <input type="text" name="major" class="form-control" 
                                   value="<?= htmlspecialchars($student['majorName'] ?? '') ?>" readonly>
                            <div class="form-text">لا يمكن تغيير التخصص من الملف الشخصي.</div>
                        </div>

                        <div class="col-md-6 border-top pt-3">
                            <label class="form-label fw-bold text-danger">كلمة مرور جديدة</label>
                            <input type="password" name="password" class="form-control" placeholder="اتركها فارغة إذا لم ترد التغيير">
                        </div>

                        <div class="col-md-6 border-top pt-3">
                            <label class="form-label fw-bold text-danger">تأكيد كلمة المرور</label>
                            <input type="password" name="confirm_password" class="form-control" placeholder="أعد كتابة كلمة المرور">
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <a href="/student_dashboard" class="btn btn-light px-4 me-2">إلغاء</a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save ms-1"></i>
                            حفظ التغييرات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('profileForm').onsubmit = function() {
            const pass = document.querySelector('input[name="password"]').value;
            const confirm = document.querySelector('input[name="confirm_password"]').value;
            if (pass !== "" && pass !== confirm) {
                alert("كلمات المرور غير متطابقة!");
                return false;
            }
            return true;
        };
    </script>
</body>

</html>