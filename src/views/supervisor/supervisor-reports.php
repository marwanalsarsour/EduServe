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
    <?php require_once '../layout/header.php'; ?>

    <div class="container my-5 flex-grow-1">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0 text-dark">
                <i class="bi bi-file-earmark-text ms-2 text-primary"></i>طلبات مراجعة التقارير
            </h4>
            <span class="badge bg-danger rounded-pill px-3 py-2">
                <?= count($data['reports']) ?> تقارير جديدة
            </span>
        </div>

        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="table-dark">
                        <tr>
                            <th class="p-3">الطالب</th>
                            <th>الأسبوع</th>
                            <th>تاريخ الرفع</th>
                            <th>التقرير (PDF)</th>
                            <th>الحالة</th>
                            <th>الإجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($data['reports'])): ?>
                            <?php foreach($data['reports'] as $report): ?>
                                <tr>
                                    <td class="fw-bold"><?= htmlspecialchars($report['student_name']) ?></td>
                                    <td>الأسبوع <?= $report['week_number'] ?></td>
                                    <td><?= date('Y/m/d', strtotime($report['created_at'])) ?></td>
                                    <td>
                                        <a href="/uploads/reports/<?= $report['file_path'] ?>" target="_blank" class="btn btn-sm btn-link text-danger text-decoration-none fw-bold">
                                            <i class="bi bi-file-pdf"></i> عرض التقرير
                                        </a>
                                    </td>
                                    <td><span class="badge bg-warning text-dark rounded-pill px-3">قيد الانتظار</span></td>
                                    <td>
                                        <div class="btn-group shadow-sm">
                                            <button onclick="submitStatus(<?= $report['id'] ?>, 'approved')" class="btn btn-sm btn-success" title="قبول"><i class="bi bi-check-lg"></i></button>
                                            <button onclick="submitStatus(<?= $report['id'] ?>, 'rejected')" class="btn btn-sm btn-danger" title="رفض"><i class="bi bi-x-lg"></i></button>
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modal-<?= $report['id'] ?>">ملاحظات</button>
                                        </div>
                                    </td>
                                </tr>

                                <div class="modal fade" id="modal-<?= $report['id'] ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <form action="/supervisor/reports/process/<?= $report['id'] ?>" method="POST" class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">إرسال ملاحظات: <?= $report['student_name'] ?></h5>
                                                <button type="button" class="btn-close ms-0 me-auto" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="status" value="rejected">
                                                <textarea name="feedback" class="form-control rounded-3" rows="4" placeholder="اكتب ملاحظاتك للطالب هنا (سيتم رفض التقرير تلقائياً عند الإرسال)..."></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary w-100 rounded-pill">إرسال الملاحظات ورفض التقرير</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="p-5 text-muted">لا توجد تقارير بانتظار المراجعة حالياً.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <form id="quick-status-form" method="POST" style="display:none;">
        <input type="hidden" name="status" id="form-status">
    </form>

    <script>
        function submitStatus(id, status) {
            if(confirm('هل أنت متأكد من ' + (status === 'approved' ? 'قبول' : 'رفض') + ' هذا التقرير؟')) {
                const form = document.getElementById('quick-status-form');
                form.action = '/supervisor/reports/process/' + id;
                document.getElementById('form-status').value = status;
                form.submit();
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>