<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مراجعة التقارير الأسبوعية - EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <div class="container my-5 flex-grow-1">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0 text-dark">
                <i class="bi bi-file-earmark-text ms-2 text-primary"></i>طلبات مراجعة التقارير
            </h4>
            <span class="badge bg-primary rounded-pill px-3 py-2">
                <?= isset($data['reports']) ? count($data['reports']) : 0 ?> تقارير موجودة
            </span>
        </div>

        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="table-dark">
                        <tr>
                            <th class="p-3">الطالب</th>
                            <th>نوع التقرير</th>
                            <th>تاريخ الرفع</th>
                            <th>محتوى التقرير</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($data['reports'])): ?>
                            <?php foreach($data['reports'] as $report): ?>
                                <tr>
                                    <td class="fw-bold"><?= htmlspecialchars($report['student_name'] ?? 'غير معروف') ?></td>
                                    <td><?= htmlspecialchars($report['week_number'] ?? '-') ?></td>
                                    <td><?= htmlspecialchars($report['created_at'] ?? '-') ?></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-info fw-bold" data-bs-toggle="modal" data-bs-target="#view-report-<?= $report['id'] ?>">
                                            <i class="bi bi-eye"></i> عرض المحتوى
                                        </button>
                                    </td>
                                    <td><span class="badge bg-secondary rounded-pill px-3">بانتظار المراجعة</span></td>
                                </tr>

                                <div class="modal fade" id="view-report-<?= $report['id'] ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header"><h5 class="modal-title">تفاصيل التقرير</h5></div>
                                            <div class="modal-body" style="text-align: right;">
                                                <?= nl2br(htmlspecialchars($report['report_content'] ?? 'لا يوجد محتوى')) ?>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="p-5 text-muted">لا توجد تقارير حالياً.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>