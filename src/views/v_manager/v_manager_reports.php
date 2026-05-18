<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>التقارير والإحصائيات - EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .report-card { border-right: 4px solid red !important; }
        .bg-gradient-red { background: linear-gradient(45deg, red, black); }
        .text-custom-red { color: red; }
        .text-custom-black { color: black; }
    </style>
</head>
<body class="bg-light text-end">
    <?php require_once '../src/views/layout/header.php'; ?>

    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-custom-black mb-1">تقارير النشاط التطوعي</h4>
                <p class="text-muted small">ملخص الأداء العام وساعات التطوع المنجزة</p>
            </div>
            <button onclick="window.print()" class="btn btn-danger rounded-pill px-4 shadow-sm">
                <i class="bi bi-file-earmark-pdf me-2"></i> طباعة التقرير
            </button>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 report-card">
                    <small class="text-muted d-block mb-1">إجمالي المتطوعين</small>
                    <h3 class="fw-bold text-custom-black mb-0"><?= $summary['total_volunteers'] ?></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 report-card">
                    <small class="text-muted d-block mb-1">ساعات بانتظار الاعتماد</small>
                    <h3 class="fw-bold text-warning mb-0"><?= $summary['pending_hours'] ?></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 report-card">
                    <small class="text-muted d-block mb-1">ساعات تم اعتمادها</small>
                    <h3 class="fw-bold text-success mb-0"><?= $summary['approved_hours'] ?></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 report-card">
                    <small class="text-muted d-block mb-1">متطوعون أتموا الساعات</small>
                    <h3 class="fw-bold text-custom-red mb-0"><?= $summary['completed_volunteers'] ?></h3>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white py-3 border-0">
                <h6 class="fw-bold mb-0 text-custom-red"><i class="bi bi-graph-up-arrow ms-2"></i>تحليل أداء المتطوعين</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary small">
                        <tr>
                            <th class="px-4 py-3">المتطوع</th>
                            <th class="text-center">الساعات المطلوبة</th>
                            <th class="text-center">الساعات المعتمدة</th>
                            <th class="text-center">آخر ملاحظة مسجلة</th>
                            <th class="text-center">الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($performance as $p): 
                            $is_completed = $p['approved_hours'] >= $p['required_hours'];
                        ?>
                        <tr class="bg-white">
                            <td class="px-4 py-3">
                                <span class="fw-bold text-custom-black"><?= htmlspecialchars($p['name']) ?></span>
                                <div class="text-muted extra-small"><?= htmlspecialchars($p['student_id_number']) ?></div>
                            </td>
                            <td class="text-center"><?= $p['required_hours'] ?></td>
                            <td class="text-center fw-bold <?= $is_completed ? 'text-success' : 'text-danger' ?>">
                                <?= $p['approved_hours'] ?>
                            </td>
                            <td class="text-center small text-muted"><?= htmlspecialchars($p['last_note'] ?? 'لا توجد ملاحظات') ?></td>
                            <td class="text-center">
                                <?php if($is_completed): ?>
                                    <span class="badge bg-success-subtle text-success rounded-pill px-3">مكتمل</span>
                                <?php else: ?>
                                    <span class="badge bg-warning-subtle text-warning rounded-pill px-3">قيد التنفيذ</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>