<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ملف الطالب المتقدم | EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light text-end">


<div class="container mt-5 pb-5">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="mb-3">
                <a href="/volunteer_requests" class="btn btn-outline-secondary btn-sm px-3">
                    <i class="bi bi-arrow-right ms-1"></i> العودة لقائمة الطلبات
                </a>
            </div>

            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="bg-dark p-4 text-white d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary rounded-circle p-3 ms-3">
                            <i class="bi bi-person-fill fs-2"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold text-white"><?= htmlspecialchars($application['student_name']) ?></h4>
                            <span class="small opacity-75 text-white">الرقم الجامعي: <?= htmlspecialchars($application['university_id']) ?></span>
                        </div>
                    </div>
                    <span class="badge bg-warning text-dark px-3 py-2">طلب قيد المراجعة</span>
                </div>

                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <h6 class="fw-bold text-primary border-bottom pb-2">المعلومات الأكاديمية</h6>
                            <ul class="list-unstyled p-0">
                                <li class="mb-2"><strong>التخصص:</strong> <?= htmlspecialchars($application['major']) ?></li>
                                <li class="mb-2"><strong>المعدل التراكمي:</strong> <?= htmlspecialchars($application['gpa']) ?>%</li>
                                <li class="mb-2"><strong>المستوى الدراسي:</strong> <?= htmlspecialchars($application['level']) ?></li>
                            </ul>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <h6 class="fw-bold text-primary border-bottom pb-2">سجل التطوع السابق</h6>
                            <ul class="list-unstyled p-0">
                                <li class="mb-2"><strong>إجمالي الساعات المنجزة:</strong> <?= $prev_stats['total_hours'] ?? 0 ?> ساعة</li>
                                <li class="mb-2"><strong>عدد الفرص السابقة:</strong> <?= $prev_stats['total_opps'] ?? 0 ?></li>
                            </ul>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold text-primary border-bottom pb-2">الفرصة المتقدم إليها حالياً</h6>
                        <div class="p-3 bg-light rounded shadow-sm border-start border-4 border-info">
                            <h6 class="mb-1 fw-bold"><?= htmlspecialchars($application['opportunity_title']) ?></h6>
                            <p class="small text-muted mb-0">المؤسسة: <?= htmlspecialchars($application['org_name']) ?> | الساعات المطلوبة: <?= $application['req_hours'] ?> ساعة</p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center gap-3 mt-5">
                        <form action="/student_review/process" method="POST" class="d-inline">
                            <input type="hidden" name="app_id" value="<?= $application['id'] ?>">
                            <button type="submit" name="accept_request" class="btn btn-success px-5 py-2 fw-bold shadow-sm" onclick="return confirm('تأكيد قبول انضمام الطالب للفرصة؟')">
                                <i class="bi bi-check-lg ms-2"></i>قبول الانضمام
                            </button>
                        </form>
                        
                        <button class="btn btn-danger px-5 py-2 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            <i class="bi bi-x-lg ms-2"></i>رفض الطلب
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-end">
            <div class="modal-header">
                <h5 class="fw-bold mb-0" id="rejectModalLabel">تأكيد رفض طلب التطوع</h5>
                <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/student_review/process" method="POST">
                <input type="hidden" name="app_id" value="<?= $application['id'] ?>">
                <div class="modal-body text-start">
                    <label class="form-label small fw-bold text-end d-block">سبب الرفض (سيتم إرساله للطالب):</label>
                    <textarea name="reject_reason" class="form-control text-end" rows="3" placeholder="مثال: نعتذر، التخصص المطلوب لا يتناسب مع متطلبات الفرصة..." required></textarea>
                </div>
                <div class="modal-footer justify-content-start">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" name="confirm_reject" class="btn btn-danger px-4">تأكيد الرفض النهائي</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>