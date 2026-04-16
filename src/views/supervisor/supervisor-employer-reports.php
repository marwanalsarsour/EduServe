<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تقارير جهات التدريب - EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100">
    <?php require_once __DIR__ . '/../layout/header.php'; ?>

    <div class="container my-5">
        <h4 class="fw-bold mb-4">
            <i class="bi bi-building-check ms-2 text-primary"></i>تقارير أداء الطلاب من الشركات
        </h4>
        
        <div class="card shadow-sm border-0 rounded-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="table-dark">
                        <tr>
                            <th class="py-3">اسم الطالب</th>
                            <th class="py-3">الشركة</th>
                            <th class="py-3">تقييم المدرب</th>
                            <th class="py-3">ملاحظات المدرب</th>
                            <th class="py-3">تاريخ التقرير</th>
                            <th class="py-3">الإجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($data['reports'])): ?>
                            <?php foreach($data['reports'] as $report): ?>
                            <tr>
                                <td class="fw-bold"><?= htmlspecialchars($report['student_name']) ?></td>
                                <td><?= htmlspecialchars($report['company_name']) ?></td>
                                <td>
                                    <div class="text-warning">
                                        <?php 
                                        $rating = $report['rating'];
                                        for($i=1; $i<=5; $i++) {
                                            if($i <= $rating) echo '<i class="bi bi-star-fill"></i>';
                                            elseif($i - 0.5 <= $rating) echo '<i class="bi bi-star-half"></i>';
                                            else echo '<i class="bi bi-star"></i>';
                                        }
                                        ?>
                                        <span class="text-dark small ms-1">(<?= $rating ?>)</span>
                                    </div>
                                </td>
                                <td class="text-muted small">
                                    <?= mb_strimwidth(htmlspecialchars($report['notes']), 0, 50, "...") ?>
                                </td>
                                <td><?= date('Y/m/d', strtotime($report['report_date'])) ?></td>
                                <td>
                                    <a href="/supervisor/report_details?id=<?= $report['report_id'] ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        تفاصيل كاملة
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="py-5 text-muted">لا يوجد تقارير مرسلة من الشركات حتى الآن.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <footer class="mt-auto py-3 bg-white text-center border-top">
        <small>© 2026 EduServe - جامعة بوليتكنك فلسطين</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>