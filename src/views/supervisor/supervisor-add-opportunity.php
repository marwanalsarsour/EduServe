<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة فرصة تدريب</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">

<?php require_once '../layout/header.php'; ?>

<main class="flex-grow-1">
<div class="container my-5">

    <div class="card shadow-sm">
        <div class="card-body p-4">

            <h4 class="fw-bold mb-4">
                <i class="bi bi-plus-circle ms-2"></i>
                إضافة فرصة تدريب جديدة
            </h4>

            <form method="POST" action="../../supervisor/opportunity">

                <div class="row g-3">

                    <!-- عنوان التدريب -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">عنوان التدريب</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <!-- نوع التدريب -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">نوع التدريب</label>
                        <select name="type" class="form-select" required>
                            <option value="">اختر النوع</option>
                            <option value="volunteer">تطوعي</option>
                            <option value="internship">تدريب عملي</option>
                        </select>
                    </div>

                    <!-- اسم الشركة -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">اسم الشركة / المؤسسة</label>
                        <input type="text" name="organization" class="form-control" required>
                    </div>

                    <!-- الموقع -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">الموقع</label>
                        <input type="text" name="location" class="form-control" required>
                    </div>

                    <!-- المدة -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">مدة التدريب</label>
                        <input type="text" name="duration" class="form-control" placeholder="مثال: شهرين" required>
                    </div>

                    <!-- تاريخ البدء -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">تاريخ البدء</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>

                    <!-- آخر موعد للتقديم -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">آخر موعد للتقديم</label>
                        <input type="date" name="deadline" class="form-control" required>
                    </div>

                    <!-- عدد المقاعد -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">عدد المقاعد</label>
                        <input type="number" name="seats" class="form-control" min="1" required>
                    </div>

                    <!-- البريد -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">بريد التواصل</label>
                        <input type="email" name="contact_email" class="form-control">
                    </div>

                    <!-- الهاتف -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">رقم الهاتف</label>
                        <input type="text" name="contact_phone" class="form-control">
                    </div>

                    <!-- الحالة -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">حالة الفرصة</label>
                        <select name="status" class="form-select">
                            <option value="active">متاحة</option>
                            <option value="closed">مغلقة</option>
                        </select>
                    </div>

                    <!-- الوصف -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">الوصف</label>
                        <textarea name="description" rows="4" class="form-control" required></textarea>
                    </div>

                    <!-- المتطلبات -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">المتطلبات الأساسية</label>
                        <textarea name="requirements" rows="3" class="form-control"></textarea>
                    </div>

                </div>

                <div class="mt-4 text-start">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check-circle ms-1"></i>
                        حفظ الفرصة
                    </button>

                    <a href="/supervisor/opportunities" class="btn btn-outline-secondary">
                        إلغاء
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>
</main>

<footer class="mt-5 py-3 bg-primary text-white text-center">
    <div class="container">
        <small>© 2026 EduServe - جامعة بوليتكنك فلسطين</small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>