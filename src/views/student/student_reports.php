<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سجل التقارير</title>
    <link rel="icon" type="image/png" href="/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light d-flex flex-column min-vh-100">
    <div class="flex-grow-1">
        <div class="container py-4">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">سجل التقارير الخاصة بك</h4>

                <a href="/student_report-submit" class="btn btn-primary">
                    <i class="bi bi-upload ms-1"></i>
                    رفع تقرير جديد
                </a>
            </div>

            <?php if (isset($_SESSION['msg'])): ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <?= $_SESSION['msg']; unset($_SESSION['msg']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm border-0">
                <div class="card-body table-responsive p-0">

                    <table class="table table-hover text-center align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>نوع التقرير</th>
                                <th>المحتوى</th>
                                <th>الملف المرفق</th>
                            </tr>
                        </thead>

                        <tbody id="reportsTableBody">
                            <?php if (empty($reports)): ?>
                                <tr>
                                    <td colspan="4" class="text-muted py-5">
                                        <i class="bi bi-info-circle d-block mb-2 fs-3"></i>
                                        لا توجد تقارير مرفوعة حالياً.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($reports as $report): ?>
                                    <tr>
                                        <td><strong><?= $report['reportID'] ?></strong></td>
                                        <td>
                                            <span class="badge bg-info text-dark">
                                                <?= htmlspecialchars($report['reportType']) ?>
                                            </span>
                                        </td>
                                        <td class="text-truncate" style="max-width: 250px;">
                                            <?= htmlspecialchars($report['content']) ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($report['data'])): ?>
                                                <a href="<?= $report['data'] ?>" class="btn btn-sm btn-outline-primary" target="_blank">
                                                    <i class="bi bi-file-earmark-pdf ms-1"></i> عرض التقرير
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted small">لا يوجد ملف</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>

    <footer class="mt-5 py-3 bg-primary text-white text-center">
        <div class="container">
            <small>
                © 2026 EduServe - جامعة بوليتكنك فلسطين
            </small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>