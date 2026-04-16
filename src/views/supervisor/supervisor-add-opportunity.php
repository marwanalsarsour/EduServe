<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة فرصة تدريب - EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100 ">

<?php require_once __DIR__ . '/../layout/header.php'; ?>

<main class="flex-grow-1">
<div class="container my-5">

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4 p-md-5">

            <h4 class="fw-bold mb-4 text-primary">
                <i class="bi bi-plus-circle ms-2"></i>
                إضافة فرصة تدريب جديدة
            </h4>

            <?php if(isset($_SESSION['error_msg'])): ?>
                <div class="alert alert-danger border-0 mb-4"><?= $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?></div>
            <?php endif; ?>

            <form method="POST" action="/submit_opportunity_process">

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-secondary">عنوان التدريب</label>
                        <input type="text" name="title" class="form-control bg-light border-0 py-2" placeholder="مثال: مطور ويب Junior" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-secondary">نوع التدريب</label>
                        <select name="type" class="form-select bg-light border-0 py-2" required>
                            <option value="">اختر النوع</option>
                            <option value="volunteer">تطوعي</option>
                            <option value="internship">تدريب عملي</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-secondary">اسم الشركة / المؤسسة</label>
                        <input type="text" name="organization" class="form-control bg-light border-0 py-2" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-secondary">الموقع (المدينة)</label>
                        <input type="text" name="location" class="form-control bg-light border-0 py-2" placeholder="مثال: الخليل - وادي الهرية" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-secondary">مدة التدريب</label>
                        <input type="text" name="duration" class="form-control bg-light border-0 py-2" placeholder="مثال: شهرين (200 ساعة)" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-secondary">تاريخ البدء المتوقع</label>
                        <input type="date" name="start_date" class="form-control bg-light border-0 py-2" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-secondary">آخر موعد للتقديم</label>
                        <input type="date" name="deadline" class="form-control bg-light border-0 py-2" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-secondary">عدد المقاعد المتاحة</label>
                        <input type="number" name="seats" class="form-control bg-light border-0 py-2" min="1" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-secondary">بريد التواصل</label>
                        <input type="email" name="contact_email" class="form-control bg-light border-0 py-2">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-secondary">رقم الهاتف</label>
                        <input type="text" name="contact_phone" class="form-control bg-light border-0 py-2">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold small text-secondary">حالة الفرصة</label>
                        <select name="status" class="form-select bg-light border-0 py-2">
                            <option value="active">متاحة فوراً</option>
                            <option value="closed">مغلقة مؤقتاً</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold small text-secondary">وصف التدريب والمهام</label>
                        <textarea name="description" rows="4" class="form-control bg-light border-0" required placeholder="اكتب تفاصيل عن ما سيتعلمه الطالب..."></textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold small text-secondary">المتطلبات والمهارات المطلوبة</label>
                        <textarea name="requirements" rows="3" class="form-control bg-light border-0" placeholder="مثال: معرفة جيدة بأساسيات PHP و OOP"></textarea>
                    </div>
                </div>

                <div class="mt-5 text-start">
                    <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">
                        <i class="bi bi-check-circle ms-1"></i>
                        حفظ ونشر الفرصة
                    </button>
                    <a href="/supervisor_dashboard" class="btn btn-link text-secondary text-decoration-none">إلغاء</a>
                </div>

            </form>

        </div>
    </div>

</div>
</main>

<footer class="mt-auto py-3 bg-white text-secondary text-center border-top">
    <div class="container">
        <small>© 2026 EduServe - جامعة بوليتكنك فلسطين</small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>