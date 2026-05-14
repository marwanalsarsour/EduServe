<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ملف المتدرب - EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body class="reports-page text-end bg-light">
    <?php require_once '../src/views/layout/header.php'; ?>

    <div class="container py-5">
        <div class="d-flex align-items-center mb-4">
            <a href="/trainer/dashboard" class="btn btn-outline-secondary btn-sm ms-3">
                <i class="bi bi-arrow-right"></i> عودة
            </a>
            <h4 class="fw-bold mb-0">تفاصيل المتدرب: <?= htmlspecialchars($student['name']) ?></h4>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                    <div class="mb-3">
                        <label class="small text-muted d-block">التخصص</label>
                        <span class="fw-bold text-dark"><?= htmlspecialchars($student['major']) ?></span>
                    </div>
                    <div class="mb-3">
                        <label class="small text-muted d-block">الرقم الجامعي</label>
                        <span class="fw-bold text-dark"><?= htmlspecialchars($student['student_id_number']) ?></span>
                    </div>
                    <div class="mb-3">
                        <label class="small text-muted d-block">البريد الإلكتروني</label>
                        <span class="fw-bold text-dark"><?= htmlspecialchars($student['email']) ?></span>
                    </div>
                    <hr>
                    <div class="mb-0">
                        <label class="small text-muted d-block">تاريخ البدء في التدريب</label>
                        <span class="fw-bold text-primary"><?= date('d F Y', strtotime($student['start_date'])) ?></span>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 border-right-info">
                    <h5 class="fw-bold mb-4 text-info"><i class="bi bi-bar-chart-line ms-2"></i>ملخص الإنجاز</h5>
                    
                    <div class="row text-center g-3 mb-4">
                        <div class="col-6">
                            <div class="p-3 bg-light rounded-3">
                                <small class="text-muted d-block">الساعات المنجزة</small>
                                <span class="fs-4 fw-bold text-dark"><?= $completed_hours ?> / 120</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-light rounded-3">
                                <small class="text-muted d-block">نسبة التقدم</small>
                                <span class="fs-4 fw-bold text-success"><?= $progress_percent ?>%</span>
                            </div>
                        </div>
                    </div>

                    <h6 class="fw-bold mb-3">سجل التقارير الدورية المعتمدة</h6>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light text-secondary">
                                <tr>
                                    <th>الشهر/الفترة</th>
                                    <th>التقييم العام</th>
                                    <th>تاريخ الإرسال</th>
                                    <th>الإجراء</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($reports)): ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">لا توجد تقارير مرسلة لهذا الطالب بعد.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach($reports as $report): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($report['period']) ?></td>
                                        <td>
                                            <span class="badge bg-success-subtle text-success px-3">
                                                <?= htmlspecialchars($report['rating']) ?>
                                            </span>
                                        </td>
                                        <td><?= date('Y-m-d', strtotime($report['created_at'])) ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-light border" title="عرض التفاصيل">
                                                <i class="bi bi-eye"></i>
                                            </button>
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
    </div>
</body>
</html>