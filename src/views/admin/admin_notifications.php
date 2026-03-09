<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إشعارات الإدارة</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/assets/img/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php require_once '../layout/header.php'; ?>
    <div class="container py-5">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold mb-1">
                        <i class="bi bi-bell"></i>
                        إشعارات
                    </h4>
                    <p class="text-muted mb-0">
                        متابعة جميع إشعارات النظام.
                    </p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary" onclick="markAllAsRead()">
                        <i class="bi bi-check2-all ms-1"></i>
                        تعليم الكل كمقروء
                    </button>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header fw-bold bg-white">
                قائمة الإشعارات
            </div>
            <div class="list-group list-group-flush" id="notificationsList">
                <div class="list-group-item list-group-item-action bg-light fw-bold notification-item"
                    data-message="تم تقديم تقرير تدريب جديد من الطالب أحمد محمد وسيتم مراجعته." data-student="أحمد محمد"
                    data-id="201234" data-type="تقرير تدريب">
                    <div class="d-flex justify-content-between">
                        <div>
                            <i class="bi bi-dot text-danger"></i>
                            <strong>أحمد محمد</strong>
                            قام برفع تقرير تدريب جديد.
                            <br>
                            <small class="text-muted">
                                الرقم الجامعي: 201234
                            </small>
                        </div>
                        <small class="text-muted">
                            منذ ساعة
                        </small>
                    </div>
                </div>

                <div class="list-group-item list-group-item-action notification-item"
                    data-message="تم قبول الطالب علي محمود في فرصة تدريب لدى شركة الاتصالات." data-student="علي محمود"
                    data-id="204567" data-type="قبول تدريب">
                    <div class="d-flex justify-content-between">
                        <div>
                            <strong>علي محمود</strong>
                            تم قبوله في فرصة تدريب.
                            <br>
                            <small class="text-muted">
                                الرقم الجامعي: 204567
                            </small>
                        </div>
                        <small class="text-muted">
                            أمس
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="notificationModal">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">
                        تفاصيل الإشعار
                    </h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>الطالب:</strong> <span id="modalStudent"></span></p>
                    <p><strong>الرقم الجامعي:</strong> <span id="modalId"></span></p>
                    <p><strong>نوع الإشعار:</strong> <span id="modalType"></span></p>
                    <hr>
                    <p id="modalMessage"></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>