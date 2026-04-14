<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>إشعارات</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/src/public/images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php require_once '../layout/header.php'; ?>
    <div class="container py-5">
        <!-- العنوان -->
        <div class="card shadow-sm border-1 mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold mb-1">
                        <i class="bi bi-bell"></i>
                        إشعارات
                    </h4>
                    <p class="text-muted mb-0">
                        متابعة آخر التحديثات المتعلقة بالطلاب والطلبات داخل الشركة/المؤسسة.
                    </p>
                </div>
                <button class="btn btn-outline-primary" onclick="markAllAsRead()">
                    <i class="bi bi-check2-all ms-1"></i>
                    تعليم الكل كمقروء
                </button>
            </div>
        </div>

        <!-- قائمة الإشعارات -->
        <div class="card shadow-sm border-1">
            <div class="card-header fw-bold bg-white">
                قائمة الإشعارات
            </div>
            <div class="list-group list-group-flush" id="notificationsList">
                <!-- تقديم طلب -->
                <div class="list-group-item list-group-item-action bg-light fw-bold notification-item"
                    data-id="1"
                    data-type="application"
                    data-read="false"
                    data-message="قام الطالب أحمد محمد بالتقديم على فرصة تدريب ويب.">
                    <div class="d-flex justify-content-between">
                        <div>
                            قام الطالب أحمد محمد بالتقديم على فرصة تدريب ويب
                        </div>
                        <small class="text-muted">منذ 10 دقائق</small>
                    </div>
                </div>
                <!-- تقرير -->
                <div class="list-group-item list-group-item-action bg-light fw-bold notification-item"
                    data-id="2"
                    data-type="report"
                    data-read="false"
                    data-message="قام الطالب عمر اسماعيل برفع تقرير أسبوعي.">

                    <div class="d-flex justify-content-between">
                        <div>
                            قام الطالب عمر اسماعيل برفع تقرير أسبوعي
                        </div>
                        <small class="text-muted">منذ ساعة</small>
                    </div>
                </div>
                <!-- حضور -->
                <div class="list-group-item list-group-item-action notification-item"
                    data-id="3"
                    data-type="attendance"
                    data-read="true"
                    data-message="تم تسجيل حضور الطالب محمد خالد اليوم.">
                    <div class="d-flex justify-content-between">
                        <div>
                            تم تسجيل حضور الطالب محمد خالد اليوم
                        </div>
                        <small class="text-muted">اليوم</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal التفاصيل -->
    <div class="modal fade" id="notificationModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">تفاصيل الإشعار</h5>
                    <button type="button" class="btn-close ms-0" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p id="modalMessage" class="mb-0"></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>