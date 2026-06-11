<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الملف الشخصي - EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body class="reports-page text-end bg-light">

    <div class="container py-5">

        <?php if(isset($_GET['status']) && $_GET['status'] === 'success'): ?>
            <div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm border-0" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                تم تحديث بياناتك بنجاح!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row g-4 justify-content-center">

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 text-center p-4 h-100">
                    <div class="mx-auto bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center mb-3"
                         style="width: 100px; height: 100px;">
                        <i class="bi bi-person-vcard fs-1 text-primary"></i>
                    </div>

                    <h5 class="fw-bold text-dark mb-1">
                        <?= htmlspecialchars($profile['employeeName'] ?? '') ?>
                    </h5>

                    <p class="text-muted small">مدرب ميداني لدى EduServe</p>

                    <div class="bg-white border rounded-3 p-3 mt-3 text-end shadow-sm">

                        <div class="mb-2 border-bottom pb-2">
                            <small class="text-secondary d-block">جهة التدريب الحالية:</small>
                            <span class="fw-bold text-dark">
                                <?= htmlspecialchars($profile['entityName'] ?? 'لم يتم التحديد') ?>
                            </span>
                        </div>

                        <div class="mb-0 pt-1">
                            <small class="text-secondary d-block">موقع جهة التدريب:</small>
                            <span class="fw-bold">
                                <?= htmlspecialchars($profile['location'] ?? '') ?>
                            </span>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-7">

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h6 class="fw-bold mb-0 text-primary">
                            <i class="bi bi-person-gear ms-2"></i>
                            تعديل المعلومات الشخصية
                        </h6>
                    </div>

                    <div class="card-body p-4">
                        <form action="/trainer/profile/update" method="POST">

                            <div class="row g-4">

                                <div class="col-md-12">
                                    <label class="small fw-bold text-secondary mb-2">
                                        الاسم الكامل للمدرب
                                    </label>

                                    <input
                                        type="text"
                                        name="employeeName"
                                        class="form-control bg-light border-0 py-2 shadow-sm"
                                        value="<?= htmlspecialchars($profile['employeeName'] ?? '') ?>"
                                        required>
                                </div>

                                <div class="col-md-6">
                                    <label class="small fw-bold text-secondary mb-2">
                                        البريد الإلكتروني المهني
                                    </label>

                                    <input
                                        type="email"
                                        name="employeeEmail"
                                        class="form-control bg-light border-0 py-2 shadow-sm"
                                        value="<?= htmlspecialchars($profile['employeeEmail'] ?? '') ?>"
                                        required>
                                </div>

                                <div class="col-md-6">
                                    <label class="small fw-bold text-secondary mb-2">
                                        موقع جهة التدريب
                                    </label>

                                    <input
                                        type="text"
                                        name="location"
                                        class="form-control bg-light border-0 py-2 shadow-sm"
                                        value="<?= htmlspecialchars($profile['location'] ?? '') ?>"
                                        required>
                                </div>

                            </div>

                            <div class="text-start mt-4">
                                <button type="submit"
                                        class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">
                                    حفظ البيانات
                                </button>
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