<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مراجعة التقارير</title>

    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light d-flex flex-column min-vh-100">

<div class="container my-5 flex-grow-1">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-dark">
            <i class="bi bi-file-earmark-text ms-2 text-primary"></i>
            طلبات مراجعة التقارير
        </h4>

        <span class="badge bg-primary rounded-pill px-3 py-2">
            <?= count($data['reports'] ?? []) ?> تقارير
        </span>
    </div>

    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">

        <div class="table-responsive">
            <table class="table table-hover align-middle text-center mb-0">

                <thead class="table-dark">
                    <tr>
                        <th>الطالب</th>
                        <th>نوع التقرير</th>
                        <th>تاريخ الرفع</th>
                        <th>المحتوى</th>
                        <th>الملف</th>
                    </tr>
                </thead>

                <tbody>

                <?php if (!empty($data['reports'])): ?>

                    <?php foreach ($data['reports'] as $report): ?>

                        <tr>
                            <td class="fw-bold">
                                <?= htmlspecialchars($report['student_name']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($report['reportType']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($report['created_at']) ?>
                            </td>

                            <td>
                                <button class="btn btn-sm btn-outline-info"
                                        data-bs-toggle="modal"
                                        data-bs-target="#rep<?= $report['id'] ?>">
                                    عرض
                                </button>
                            </td>

                            <td>
                                <?php if (!empty($report['filePath'])): ?>

                                    <?php 
                                        $ext = strtolower(pathinfo($report['filePath'], PATHINFO_EXTENSION));
                                    ?>

                                    <a href="<?= $report['filePath'] ?>"
                                       target="_blank"
                                       class="btn btn-sm btn-outline-primary">

                                        <?php if (in_array($ext, ['jpg','jpeg','png','gif'])): ?>
                                            <i class="bi bi-image"></i>
                                        <?php elseif ($ext == 'pdf'): ?>
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        <?php else: ?>
                                            <i class="bi bi-paperclip"></i>
                                        <?php endif; ?>

                                        فتح الملف
                                    </a>

                                <?php else: ?>
                                    <span class="text-muted">لا يوجد</span>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="rep<?= $report['id'] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">التقرير</h5>
                                    </div>

                                    <div class="modal-body text-end">
                                        <?= nl2br(htmlspecialchars($report['report_content'])) ?>
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                                    </div>

                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="5" class="p-5 text-muted">
                            لا توجد تقارير حالياً
                        </td>
                    </tr>

                <?php endif; ?>

                </tbody>

            </table>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>