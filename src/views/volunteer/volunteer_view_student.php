<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ملف الطالب المتقدم</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php require_once '../layout/header.php'; ?>

<div class="container mt-5 pb-5">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="bg-dark p-4 text-white d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary rounded-circle p-3 ms-3">
                            <i class="bi bi-person-fill fs-2"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold text-white">ياسين محمد عمر</h4>
                            <span class="small opacity-75 text-white">الرقم الجامعي: 202110543</span>
                        </div>
                    </div>
                    <span class="badge bg-warning text-dark px-3 py-2">طلب قيد المراجعة</span>
                </div>

                <div class="card-body p-4 text-start">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <h6 class="fw-bold text-primary border-bottom pb-2">المعلومات الأكاديمية</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2"><strong>التخصص:</strong> هندسة أنظمة حاسوب</li>
                                <li class="mb-2"><strong>المعدل التراكمي:</strong> 88.5%</li>
                                <li class="mb-2"><strong>المستوى الدراسي:</strong> سنة رابعة</li>
                            </ul>
                        </div>
                        <div class="col-md-6 mb-4">
                            <h6 class="fw-bold text-primary border-bottom pb-2">سجل التطوع السابق</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2"><strong>إجمالي الساعات المنجزة:</strong> 50 ساعة</li>
                                <li class="mb-2"><strong>عدد الفرص السابقة:</strong> 2</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold text-primary border-bottom pb-2">الفرصة المتقدم إليها حالياً</h6>
                        <div class="p-3 bg-light rounded shadow-sm border-start border-4 border-info">
                            <h6 class="mb-1 fw-bold">برمجة تطبيقات الهاتف</h6>
                            <p class="small text-muted mb-0">المؤسسة: شركة تكنو - الساعات المطلوبة: 30 ساعة</p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center gap-3 mt-5">
                        <form action="volunteer_process.php" method="POST" class="d-inline">
                            <input type="hidden" name="student_id" value="1">
                            <button type="submit" name="accept_request" class="btn btn-success px-5 py-2 fw-bold shadow-sm">
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

<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="fw-bold">رفض طلب التطوع</h5>
                <button type="button" class="btn-close ms-0" data-bs-dismiss="modal"></button>
            </div>
            <form action="volunteer_process.php" method="POST">
                <div class="modal-body text-start">
                    <label class="form-label small fw-bold">سبب الرفض (سيصل للطالب):</label>
                    <textarea name="reject_reason" class="form-control" rows="3" placeholder="مثال: التخصص غير مطابق لمتطلبات الفرصة..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="confirm_reject" class="btn btn-danger px-4">تأكيد الرفض</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>