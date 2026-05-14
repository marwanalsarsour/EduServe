<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لوحة تحكم المدرب - EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php require_once '../src/views/layout/header.php'; ?>

    <div class="container py-5">
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card shadow-sm p-4 text-center stat-card">
                    <i class="bi bi-people text-primary fs-1 mb-2"></i>
                    <h6 class="text-muted">الطلاب المعينين</h6>
                    <h3 class="fw-bold text-dark"><?= $stats['total_students'] ?></h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm p-4 text-center border-start border-4 border-warning stat-card">
                    <i class="bi bi-clock-history text-warning fs-1 mb-2"></i>
                    <h6 class="text-muted">بانتظار تأكيد الحضور</h6>
                    <h3 class="fw-bold text-dark"><?= $stats['pending_attendance'] ?></h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm p-4 text-center border-start border-4 border-success stat-card">
                    <i class="bi bi-file-earmark-check text-success fs-1 mb-2"></i>
                    <h6 class="text-muted">تقارير مكتملة</h6>
                    <h3 class="fw-bold text-dark"><?= $stats['completed_reports'] ?></h3>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm p-4">
            <h5 class="fw-bold mb-4"><i class="bi bi-list-stars ms-2"></i>قائمة الطلاب الحالية</h5>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr class="text-muted small uppercase">
                            <th>اسم الطالب</th>
                            <th>التخصص</th>
                            <th>ساعات الإنجاز</th>
                            <th class="text-center">الإجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($students)): ?>
                            <?php foreach ($students as $student): ?>
                            <tr>
                                <td>
                                    <div class="fw-bold text-dark"><?= htmlspecialchars($student['name']) ?></div>
                                </td>
                                <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($student['major']) ?></span></td>
                                <td>
                                    <div class="d-flex align-items-center" style="min-width: 150px;">
                                        <small class="me-2 fw-bold"><?= $student['total_hours'] ?>/120</small>
                                        <div class="progress flex-grow-1" style="height: 6px;">
                                            <div class="progress-bar bg-primary" style="width: <?= ($student['total_hours']/120)*100 ?>%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <a href="/trainer/student-details?id=<?= $student['id'] ?>" class="btn btn-sm btn-primary px-3">
                                        عرض الملف
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">لا يوجد طلاب معينين حالياً.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>