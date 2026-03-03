<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تقارير جهات التدريب</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100">
    <?php require_once '../layout/header.php'; ?>

    <div class="container my-5">
        <h4 class="fw-bold mb-4"><i class="bi bi-building-check ms-2 text-primary"></i>تقارير أداء الطلاب من الشركات</h4>
        
        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>اسم الطالب</th>
                            <th>الشركة</th>
                            <th>تقييم المدرب</th>
                            <th>ملاحظات المدرب</th>
                            <th>تاريخ التقرير</th>
                            <th>الإجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-bold">تامر زيدان القاضي</td>
                            <td>شركة عسقلان</td>
                            <td>
                                <div class="text-warning">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                                    <span class="text-dark small ms-1">(4.5)</span>
                                </div>
                            </td>
                            <td class="text-muted">طالب مجتهد وملتزم بمواعيد الدوام..</td>
                            <td>2024/05/25</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary">تفاصيل كاملة</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>