<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>قائمة المتطوعين</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100">
    <?php require_once '../layout/header.php'; ?>

    <div class="container my-5">
        <h4 class="fw-bold mb-4 text-primary">إدارة الطلاب المتطوعين</h4>
        <div class="card shadow-sm border-0 overflow-hidden text-center">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="py-3 px-4 text-start">الطالب</th>
                            <th>الرقم الجامعي</th>
                            <th>الفرصة الحالية</th>
                            <th>الساعات المنجزة</th>
                            <th>الإجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="px-4 text-start fw-bold">عمر خالد ياسين</td>
                            <td>202210987</td>
                            <td><span class="badge bg-info-subtle text-info px-3">صيانة حاسوب</span></td>
                            <td>25 / 40 ساعة</td>
                            <td>
                                <a href="volunteer_student_details.php?id=1" class="btn btn-sm btn-outline-primary px-3">التفاصيل</a>
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