<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>قائمة المتطوعين | EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100 text-end">
    
    <?php require_once BASE_PATH . '/views/layout/header.php'; ?>

    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-primary mb-0">إدارة الطلاب المتطوعين</h4>
            <span class="badge bg-primary px-3 py-2 fs-6">إجمالي المتطوعين: <?= count($volunteers) ?></span>
        </div>

        <div class="card shadow-sm border-0 overflow-hidden text-center">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="py-3 px-4 text-start">الطالب</th>
                            <th>الرقم الجامعي</th>
                            <th>الفرصة الحالية</th>
                            <th>الساعات المنجزة</th>
                            <th>الإجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($volunteers)): ?>
                            <?php foreach ($volunteers as $volunteer): ?>
                            <tr>
                                <td class="px-4 text-start fw-bold"><?= htmlspecialchars($volunteer['student_name']) ?></td>
                                <td class="text-secondary"><?= htmlspecialchars($volunteer['university_id']) ?></td>
                                <td>
                                    <span class="badge bg-info-subtle text-info px-3">
                                        <?= htmlspecialchars($volunteer['opportunity_title']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold mb-1">
                                        <?= $volunteer['completed_hours'] ?> / <?= $volunteer['required_hours'] ?> ساعة
                                    </div>
                                    <div class="progress mt-1" style="height: 6px; width: 120px; margin: 0 auto;">
                                        <?php 
                                            $required = $volunteer['required_hours'] > 0 ? $volunteer['required_hours'] : 1;
                                            $percent = ($volunteer['completed_hours'] / $required) * 100;
                                        ?>
                                        <div class="progress-bar bg-success" style="width: <?= $percent ?>%"></div>
                                    </div>
                                </td>
                                <td>
                                    <a href="/volunteer_student_details?id=<?= $volunteer['student_id'] ?>" class="btn btn-sm btn-outline-primary px-4 rounded-pill shadow-sm">
                                        <i class="bi bi-eye ms-1"></i> التفاصيل
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-people fs-1 d-block mb-2"></i>
                                        لا يوجد طلاب متطوعون حالياً في النظام.
                                    </div>
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