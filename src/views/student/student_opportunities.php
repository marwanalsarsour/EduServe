<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الفرص المتاحة</title>
<<<<<<< HEAD:src/views/student/opportunities.php
    <link rel="icon" type="image/png" href="/public/images/logo.png">
=======
    <link rel="icon" type="image/png" href="/images/logo.png">
>>>>>>> de0294ff6a3300d692b89c2c37d2612c5ae2aa28:src/views/student/student_opportunities.php
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">


    <div class="container my-4 flex-fill">

        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-3">
            <div>
                <h3 class="mb-1">الفرص المتاحة</h3>
                <p class="text-muted mb-0">جميع فرص التدريب الميداني والعمل التطوعي</p>
            </div>

            <div class="input-group" style="max-width: 420px;">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input id="searchInput" type="text" class="form-control" placeholder="ابحث حسب العنوان أو المؤسسة">
            </div>
        </div>

        <div class="row g-2 mb-4">
            <div class="col-12 col-md-4">
                <select id="typeFilter" class="form-select">
                    <option value="all" selected>جميع الأنواع</option>
                    <option value="training">تدريب ميداني</option>
                    <option value="volunteering">عمل تطوعي</option>
                </select>
            </div>
        </div>

        <div id="opportunitiesList" class="row g-4">

            <div class="col-12 col-md-6">
                <div class="card h-100 shadow-sm opportunity-card" data-id="101" data-type="training">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <h5 class="card-title op-title mb-1">تدريب في تطوير الويب</h5>
                            <span class="badge bg-info op-type text-dark">تدريب ميداني</span>
                        </div>

                        <p class="text-muted op-org mb-2">شركة ABC للتقنية</p>

                        <p class="small text-muted mb-3">
                            <span class="op-location"><i class="bi bi-geo-alt"></i> الخليل</span>
                            <span class="mx-2">-</span>
                            <span class="op-duration"><i class="bi bi-clock"></i> شهرين</span>
                        </p>

                        <p class="op-desc mb-3">
                            تدريب عملي يركز على أساسيات البرمجة الواجهة الأمامية والعمل الجماعي.
                        </p>

                        <a href="opportunity-details.html?id=101" class="btn btn-outline-primary btn-sm mt-auto">
                            عرض التفاصيل
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="card h-100 shadow-sm opportunity-card" data-id="102" data-type="volunteering">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <h5 class="card-title op-title mb-1">برنامج التطوع المجتمعي</h5>
                            <span class="badge bg-success op-type">عمل تطوعي</span>
                        </div>

                        <p class="text-muted op-org mb-2">الهلال الأحمر</p>

                        <p class="small text-muted mb-3">
                            <span class="op-location"><i class="bi bi-geo-alt"></i> الخليل</span>
                            <span class="mx-2">•</span>
                            <span class="op-duration"><i class="bi bi-clock"></i> شهر واحد</span>
                        </p>

                        <p class="op-desc mb-3">
                            دعم الفعاليات المجتمعية والمساعدة في تنظيم الأنشطة الطلابية التطوعية.
                        </p>

                        <a  href="opportunity-details.html?id=102" class="btn btn-outline-success btn-sm mt-auto">
                            عرض التفاصيل
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

<footer class="mt-5 py-3 bg-primary text-white text-center">
        <div class="container">
            <small>
                © 2026 EduServe - جامعة بوليتكنك فلسطين
            </small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>