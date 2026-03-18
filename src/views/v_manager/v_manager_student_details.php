<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تفاصيل المتطوع - EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light text-end">
    <?php require_once '../layout/header.php'; ?>
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
                    <div class="bg-danger-subtle rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-person-badge fs-2 text-danger"></i>
                    </div>
                    <h5 class="fw-bold">أنس جابر القواسمي</h5>
                    <p class="text-muted small">رقم الطالب: 221143</p>
                    <hr>
                    <div class="d-flex justify-content-between mb-2">
                        <span>إجمالي الساعات المنجزة:</span>
                        <span class="fw-bold text-danger">35 ساعة</span>
                    </div>
                    <div class="progress rounded-pill" style="height: 10px;">
                        <div class="progress-bar bg-danger" style="width: 70%"></div>
                    </div>
                    <button class="btn btn-dark w-100 mt-4 rounded-pill fw-bold">تأكيد إنهاء التطوع</button>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h6 class="fw-bold mb-4 text-danger"><i class="bi bi-clock-history ms-2"></i>سجل الحضور المعتمد</h6>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>التاريخ</th>
                                <th>عدد الساعات</th>
                                <th>الملاحظة المسجلة</th>
                                <th>الحالة</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2026-03-10</td>
                                <td>4 ساعات</td>
                                <td>التزام ممتاز بالمهام</td>
                                <td><span class="badge bg-success-subtle text-success">تم الاعتماد</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>