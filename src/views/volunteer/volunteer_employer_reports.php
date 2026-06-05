<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تقارير جهات التطوع | EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">



<div class="container py-5">
    <h3 class="fw-bold text-primary mb-4">تقارير المؤسسات المستضيفة</h3>
    
    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="table-responsive">
            <table class="table mb-0 align-middle text-center">
                <thead class="bg-dark text-white">
                    <tr>
                        <th class="py-3 px-4 text-start">المؤسسة</th>
                        <th>اسم الطالب</th>
                        <th>تاريخ التقرير</th>
                        <th>المرفق</th>
                        <th>الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($reports)): ?>
                        <?php foreach($reports as $report): ?>
                        <tr>
                            <td class="px-4 text-start fw-bold text-secondary"><?= htmlspecialchars($report['org_name']) ?></td>
                            <td><?= htmlspecialchars($report['student_name']) ?></td>
                            <td><?= date('Y-m-d', strtotime($report['created_at'])) ?></td>
                            <td>
                                <a href="/public/uploads/reports/<?= $report['file_path'] ?>" target="_blank">
                                    <i class="bi bi-file-earmark-pdf text-danger fs-5"></i>
                                </a>
                            </td>
                            <td>
                                <a href="/volunteer_report_details/<?= $report['id'] ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    مراجعة والرد
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="py-5 text-muted">لا يوجد تقارير مقدمة من المؤسسات حتى الآن.</td>
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