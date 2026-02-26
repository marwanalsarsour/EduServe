<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل الفرصة</title>
<<<<<<< HEAD:src/views/student/opportunity-details.php
    <link rel="icon" type="image/png" href="/public/images/logo.png">
=======
    <link rel="icon" type="image/png" href="/images/logo.png">
>>>>>>> de0294ff6a3300d692b89c2c37d2612c5ae2aa28:src/views/student/student_opportunity-details.php
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
    <main class="flex-grow-1 flex-fill">
        <div class="container my-4">

            <div class="row g-4 my-4">
                <div class="col-12 col-lg-8">

                    <div class="card shadow-sm">
                        <div class="card-body p-4">

                            <div class="d-flex flex-column flex-md-row justify-content-between gap-2">
                                <div>
                                    <h3 class="fw-bold mb-1" id="opTitle">تدريب في تطوير الويب</h3>
                                    <p class="text-muted mb-0">
                                        <span id="opOrg">شركة ABC للتقنية</span>
                                        <span class="mx-2">•</span>
                                        <span id="opLocation">الخليل</span>
                                    </p>
                                </div>

                                <div class="d-flex align-items-start gap-2">
                                    <span class="badge bg-info text-dark" id="opType">تدريب ميداني</span>
                                    <span class="badge bg-success" id="opStatus">متاح</span>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <div class="border rounded p-3 h-100">
                                        <div class="text-muted small mb-1"><i class="bi bi-clock ms-1"></i> المدة</div>
                                        <div class="fw-semibold" id="opDuration">شهرين</div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="border rounded p-3 h-100">
                                        <div class="text-muted small mb-1"><i class="bi bi-calendar-event ms-1"></i> تاريخ البدء</div>
                                        <div class="fw-semibold" id="opStartDate">01/07/2026</div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="border rounded p-3 h-100">
                                        <div class="text-muted small mb-1"><i class="bi bi-hourglass-split ms-1"></i> آخر موعد للتقديم</div>
                                        <div class="fw-semibold" id="opDeadline">20/06/2026</div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="border rounded p-3 h-100">
                                        <div class="text-muted small mb-1"><i class="bi bi-people ms-1"></i> المقاعد المتاحة</div>
                                        <div class="fw-semibold" id="opSeats">10</div>
                                    </div>
                                </div>
                            </div>

                            <h5 class="mt-4 fw-bold">الوصف</h5>
                            <p id="opDescription" class="mb-3">
                                تدريب عملي يركز على أساسيات تطوير الواجهات الأمامية، العمل الجماعي، وبناء واجهات مستخدم متجاوبة.
                            </p>

                            <h5 class="mt-4 fw-bold">المتطلبات الأساسية</h5>
                            <ul id="opRequirements" class="mb-0">
                                <li>معرفة أساسية بـ HTML & CSS</li>
                                <li>معرفة أساسية بـ JavaScript</li>
                                <li>مهارات العمل الجماعي والتواصل</li>
                            </ul>

                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">الإجراءات</h5>

                            <a id="applyBtn" href="apply.html?id=101" class="btn btn-success w-100 mb-2">
                                <i class="bi bi-send ms-1"></i> قدم الآن
                            </a>

                            <button class="btn btn-outline-secondary w-100 mb-3" type="button" id="saveBtn">
                                <i class="bi bi-bookmark ms-1"></i> حفظ الفرصة
                            </button>
                        </div>
                    </div>

                    <div class="card shadow-sm mt-3">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-2">معلومات الجهة المنظمة</h6>
                            <p class="text-muted small mb-2" id="opContactEmail">
                                <i class="bi bi-envelope ms-1"></i> hr@abctech.com
                            </p>
                            <p class="text-muted small mb-0" id="opContactPhone">
                                <i class="bi bi-telephone ms-1"></i> +970-000-000000
                            </p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </main>

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