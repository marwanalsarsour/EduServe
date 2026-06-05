<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدخال التقييم النهائي - EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100">


<main class="flex-grow-1">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h4 class="fw-bold mb-4 text-primary text-center">
                            <i class="bi bi-award ms-2"></i>
                            إدخال التقييم النهائي
                        </h4>

                        <div class="alert alert-info py-2 small border-0 text-center mb-4">
                            الطالب: <strong><?= htmlspecialchars($data['student']['name'] ?? 'غير معروف') ?></strong>
                        </div>

                        <form method="POST" action="/submit_save_evaluation_process">
                            <input type="hidden" name="student_id" value="<?= htmlspecialchars($data['student']['id'] ?? '') ?>">

                            <div class="mb-3">
                                <label class="form-label fw-bold small text-secondary">الدرجة النهائية (من 100)</label>
                                <input type="number" name="final_grade" class="form-control form-control-lg text-center fw-bold border-2" 
                                       min="0" max="100" placeholder="00" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold small text-secondary">ملاحظات المشرف</label>
                                <textarea name="notes" class="form-control" rows="4" placeholder="أدخل أي ملاحظات حول أداء الطالب خلال فترة التدريب..."></textarea>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg rounded-pill fw-bold">
                                    <i class="bi bi-check-circle ms-1"></i> حفظ التقييم وإرساله
                                </button>
                                <a href="/supervisor_dashboard" class="btn btn-link text-secondary text-decoration-none">إلغاء</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<footer class="mt-auto py-3 bg-white text-center border-top">
    <small>© 2026 EduServe - جامعة بوليتكنك فلسطين</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>