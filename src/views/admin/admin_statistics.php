<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>التقارير والإحصائيات العامة - إدارة الكلية</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .text-custom-black { color: black; }
        .text-custom-red { color: red; }
        .btn-custom-red { background-color: red; color: white; border: none; }
        .btn-custom-red:hover { background-color: darkred; color: white; }
        
        @media print {
            body { background-color: white !important; color: black !important; }
            header, .no-print, .btn, button { display: none !important; }
            .printable-card { border: 2px solid black !important; box-shadow: none !important; padding: 40px !important; background: white !important; }
        }
    </style>
</head>
<body class="bg-light flex-column min-vh-100">

    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4 no-print">
            <div>
                <h4 class="fw-bold text-custom-black mb-1">الإحصائيات والتقارير الرسمية</h4>
                <p class="text-muted small mb-0">استعراض شامل لبيانات وساعات التدريب المعتمدة داخل المنظومة.</p>
            </div>
            <button onclick="window.print()" class="btn btn-custom-red rounded-pill px-4 fw-bold">
                <i class="bi bi-printer ms-1"></i> توليد وطباعة التقرير الدوري
            </button>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-5 bg-white printable-card">
            <div class="text-center mb-5">
                <img src="/public/images/logo.png" alt="" class="mb-3 d-none d-print-block mx-auto" style="max-height: 70px;">
                <h3 class="fw-bold text-custom-black">تقرير حالة التدريب الميداني والأنشطة التطوعية</h3>
                <p class="text-muted small mb-0">تقرير رسمي صادر ومستخرج ديناميكياً من نظام EduServe لإدارة الكلية</p>
                <span class="text-dark small fw-semibold">تاريخ الاستخراج: <?= date('Y-m-d H:i') ?></span>
            </div>
            
            <hr class="text-secondary mb-4">

            <div class="row g-4 text-center mb-5">
                <div class="col-4 border-start border-secondary">
                    <h6 class="text-muted small fw-bold">عدد الطلاب المستفيدين</h6>
                    <h2 class="fw-bold text-custom-black"><?= number_format($stats['totalStudents'] ?? 0) ?> طالب</h2>
                </div>
                <div class="col-4 border-start border-secondary">
                    <h6 class="text-muted small fw-bold">إجمالي الساعات المسجلة</h6>
                    <h2 class="fw-bold text-custom-red"><?= number_format($stats['totalHours'] ?? 0) ?> ساعة</h2>
                </div>
                <div class="col-4">
                    <h6 class="text-muted small fw-bold">الشركاء والمؤسسات النشطة</h6>
                    <h2 class="fw-bold text-custom-black"><?= number_format($stats['totalPartners'] ?? 0) ?> جهة</h2>
                </div>
            </div>

            <h5 class="fw-bold mb-3 text-custom-black"><i class="bi bi-table text-custom-red ms-2 no-print"></i>بيانات المؤسسات الخارجية الشريكة ومعدلات الطلاب</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>الجهة الشريكة / مكان التدريب</th>
                            <th>عدد الطلاب المربوطين</th>
                            <th>ساعات التدريب المنجزة والمصدقة</th>
                            <th>الحالة العامة للجهة</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($partners) && is_array($partners)): ?>
                            <?php foreach ($partners as $partner): ?>
                                <tr>
                                    <td class="fw-bold text-custom-black"><?= htmlspecialchars($partner['partner_name']) ?></td>
                                    <td><?= $partner['student_count'] ?? 0 ?> طلاب</td>
                                    <td><?= number_format($partner['total_hours'] ?? 0) ?> ساعة معتمدة</td>
                                    <td>
                                        <?php if (($partner['total_hours'] ?? 0) > 0): ?>
                                            <span class="text-success fw-bold">نشط / مستقر</span>
                                        <?php else: ?>
                                            <span class="text-muted">قيد الانتظار</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <i class="bi bi-folder-x display-6 d-block mb-2"></i>
                                    لا توجد بيانات أو مؤسسات شريكة مسجلة في قاعدة البيانات حالياً.
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