<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رفع تقرير</title>
    <link rel="icon" type="image/png" href="/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light d-flex flex-column min-vh-100">

    <main class="flex-grow-1">
        <div class="container py-4 ">

            <h4 class="fw-bold mb-4 mt-4 text-primary">
                <i class="bi bi-upload ms-2"></i>
                تقديم تقرير جديد
            </h4>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">

                    <form action="/submit_report_process" method="POST" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">نوع التقرير</label>
                            <select class="form-select" name="reportType" required>
                                <option value="" selected disabled>اختر النوع...</option>
                                <option value="تقرير دوري">تقرير دوري</option>
                                <option value="تقرير أسبوعي">تقرير أسبوعي</option>
                                <option value="تقرير نهائي">تقرير نهائي</option>
                                <option value="أخرى">أخرى</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">ملف التقرير (PDF فقط)</label>
                            <input type="file" class="form-control" name="report_file" accept=".pdf" required>
                            <div class="form-text">يرجى رفع الملف بصيغة PDF فقط لضمان التوافق.</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">وصف مختصر أو ملاحظات</label>
                            <textarea class="form-control" name="content" rows="4"
                                placeholder="اكتب وصفاً موجزاً لما يتضمنه التقرير..." required></textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="bi bi-send-check ms-1"></i>
                                إرسال التقرير
                            </button>

                            <a href="/student_reports" class="btn btn-outline-secondary px-4">
                                <i class="bi bi-x-circle ms-1"></i> إلغاء
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </main>

    <footer class="mt-auto py-3 bg-primary text-white text-center">
        <div class="container">
            <small>
                © 2026 EduServe - جامعة بوليتكنك فلسطين
            </small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>