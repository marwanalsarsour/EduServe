<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>لوحة تحكم الجهة الخارجية | EduServe</title>
    <link rel="icon" href="/public/images/logo.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        :root { 
            --primary-color: blue; 
            --secondary-bg: white; 
            --text-dark: black;
            --danger-color: red;
        }

        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background-color: ghostwhite; 
            color: black;
        }

        .stat-card { 
            transition: transform 0.2s; 
            cursor: pointer; 
            background-color: white;
            border: 1px solid gray;
            border-radius: 12px;
        }

        .stat-card:hover { 
            transform: translateY(-5px); 
            border-color: blue;
        }

        .card-header {
            background-color: white;
            color: black;
            border-bottom: 1px solid gray;
        }
        
        .text-primary { color: blue !important; }
        .bg-primary { background-color: blue !important; }
        .btn-primary { background-color: blue; border-color: blue; }

        main {
            padding-top: 20px;
            padding-bottom: 40px;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <div class="container py-4">
        <main>
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom" style="border-color: black !important;">
                <h1 class="h3 fw-bold">لوحة التحكم الإحصائية</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <span class="badge border p-2" style="color: black; background-color: white; border-color: gray !important;">
                        <i class="bi bi-calendar3 ms-1"></i> <?= date('Y/m/d') ?>
                    </span>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4 text-white" style="background-color: blue; border-radius: 15px;">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold mb-1">أهلاً بك، <?= htmlspecialchars($orgData['name']) ?></h2>
                        <p class="mb-0 fs-5">لديك <?= $stats['pending_apps'] ?? 0 ?> طلبات جديدة بانتظار مراجعتك اليوم.</p>
                    </div>
                    <i class="bi bi-building fs-1 d-none d-md-block" style="font-size: 4rem !important; opacity: 0.5;"></i>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm stat-card h-100">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-megaphone fs-1" style="color: blue;"></i>
                            <h6 class="mt-3 fw-bold" style="color: black;">الفرص المنشورة</h6>
                            <h2 class="fw-bold"><?= $stats['opps_count'] ?? 0 ?></h2>
                            <a href="/external/opportunities" class="btn btn-sm mt-2" style="color: blue; border: 1px solid blue;">عرض التفاصيل</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm stat-card h-100">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-clock-history fs-1" style="color: orange;"></i>
                            <h6 class="mt-3 fw-bold" style="color: black;">طلبات جديدة</h6>
                            <h2 class="fw-bold"><?= $stats['pending_apps'] ?? 0 ?></h2>
                            <a href="/external/applications" class="btn btn-sm mt-2" style="color: orange; border: 1px solid orange;">مراجعة الطلبات</a>
                        </div>
                    </div>
                </div>

                <?php if (isset($stats['entity_type']) && $stats['entity_type'] === 'شركة'): ?>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm stat-card h-100" style="border-top: 5px solid blue !important;">
                        <div class="card-body p-4 text-center">
                            <i class="bi bi-person-badge fs-2" style="color: blue;"></i>
                            <div class="small mt-2" style="color: gray;">المدرب المعتمد</div>
                            <div class="fw-bold mb-3">
                                <?= htmlspecialchars($stats['trainer_name']) ?>
                            </div>
                            <a href="/trainer/dashboard" class="btn btn-sm w-100" style="background-color: white; border: 1px solid blue; color: blue;">الملف الشخصي</a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (isset($stats['entity_type']) && $stats['entity_type'] === 'مؤسسة'): ?>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm stat-card h-100" style="border-top: 5px solid green !important;">
                        <div class="card-body p-4 text-center">
                            <i class="bi bi-person-workspace fs-2" style="color: green;"></i>
                            <div class="small mt-2" style="color: gray;">مسؤول النشاط</div>
                            <div class="fw-bold mb-3">
                                <?= htmlspecialchars($stats['manager_name']) ?>
                            </div>
                            <a href="/v_manager/dashboard" class="btn btn-sm w-100" style="background-color: white; border: 1px solid green; color: green;">الملف الشخصي</a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <div class="row g-4">
                <div class="col-12 col-lg-8">
                    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0">نظرة عامة على المتدربين</h6>
                            <a href="/external/trainees" class="btn btn-sm" style="color: blue;">مشاهدة جميع المتدربين</a>
                        </div>
                        <div class="card-body">
                            <div class="row g-3 text-center">
                                <div class="col-md-6">
                                    <div class="p-4 rounded border bg-light">
                                        <i class="bi bi-person-check fs-2" style="color: green;"></i>
                                        <h4 class="fw-bold mt-2"><?= $stats['active_trainees'] ?? 0 ?></h4>
                                        <p class="mb-0 text-muted">متدرب يمارس نشاطه حالياً</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-4 rounded border bg-light">
                                        <i class="bi bi-journal-text fs-2" style="color: blue;"></i>
                                        <h4 class="fw-bold mt-2"><?= $stats['total_apps'] ?? 0 ?></h4>
                                        <p class="mb-0 text-muted">إجمالي سجلات النظام</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                        <div class="card-header py-3">
                            <h6 class="fw-bold mb-0">الشهادات الرقمية</h6>
                        </div>
                        <div class="card-body text-center py-5">
                            <i class="bi bi-patch-check-fill" style="font-size: 3rem; color: blue;"></i>
                            <p class="mt-3 px-3" style="color: black;">بإمكانك الآن اعتماد وإصدار شهادات الإتمام إلكترونياً للطلاب المتميزين.</p>
                            <a href="/external/certificates" class="btn btn-primary px-4 mt-2">إصدار شهادة جديدة</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <footer class="bg-white border-top py-4 mt-auto" style="border-color: gray !important;">
        <div class="container text-center" style="color: black;">
            <p class="mb-0 small">جميع الحقوق محفوظة &copy; <?= date('Y') ?> - منصة EduServe لخدمات التدريب</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>