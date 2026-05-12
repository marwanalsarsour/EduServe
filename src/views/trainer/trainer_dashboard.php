<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لوحة تحكم المدرب الميداني</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php require_once '../layout/header.php'; ?>
    <div class="container py-5">
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-4 text-center">
                    <i class="bi bi-people text-primary fs-1 mb-2"></i>
                    <h6 class="text-muted">الطلاب المعينين</h6>
                    <h3 class="fw-bold">5</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-4 text-center border-start border-4 border-warning">
                    <i class="bi bi-clock-history text-warning fs-1 mb-2"></i>
                    <h6 class="text-muted">بانتظار تأكيد الحضور</h6>
                    <h3 class="fw-bold">3</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-4 text-center border-start border-4 border-success">
                    <i class="bi bi-file-earmark-check text-success fs-1 mb-2"></i>
                    <h6 class="text-muted">تقارير مكتملة</h6>
                    <h3 class="fw-bold">12</h3>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm p-4">
            <h5 class="fw-bold mb-4">قائمة الطلاب الحالية</h5>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>اسم الطالب</th>
                            <th>التخصص</th>
                            <th>ساعات الإنجاز</th>
                            <th>الإجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-bold">سارة أحمد</td>
                            <td>هندسة برمجيات</td>
                            <td>80 / 120 ساعة</td>
                            <td><a href="trainer_student_details.php" class="btn btn-sm btn-primary">عرض الملف</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>