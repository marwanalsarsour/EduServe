<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الحضور اليومي - EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body class="bg-light text-end">
    <?php 
    require_once '../layout/header.php'; 
    
    // فحص الوقت الحالي حسب قانون الجامعة (ممنوع بعد الساعة 5 مساءً)
    $current_hour = date('H');
    $is_locked = ($current_hour >= 17); 
    ?>

    <div class="container py-5">
        <?php if ($is_locked): ?>
            <div class="alert alert-danger border-0 shadow-sm rounded-4 d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-clock-history ms-3 fs-3"></i>
                <div>
                    <strong>نظام الرصد مغلق:</strong> حسب قوانين الجامعة، لا يمكن تعديل أو رصد الحضور بعد الساعة 05:00 مساءً. يرجى التواصل مع الشؤون الأكاديمية للحالات الطارئة.
                </div>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0 text-dark">
                <i class="bi bi-calendar-check ms-2 text-primary"></i>كشف حضور يوم: <?= date('Y-m-d') ?>
            </h4>
            <button class="btn btn-success shadow-sm rounded-pill px-4 fw-bold" <?= $is_locked ? 'disabled' : '' ?>>
                <i class="bi bi-check-all ms-1"></i>اعتماد الكشف النهائي
            </button>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden <?= $is_locked ? 'opacity-75' : '' ?>">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-white border-bottom">
                        <tr class="text-secondary small">
                            <th class="py-3 px-4">اسم الطالب</th>
                            <th class="py-3 text-center">وقت الحضور</th>
                            <th class="py-3 text-center">وقت الانصراف</th>
                            <th class="py-3 text-center">عدد الساعات</th>
                            <th class="py-3 text-center">الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white">
                            <td class="px-4">
                                <div class="fw-bold text-dark">أحمد محمد</div>
                                <div class="text-muted extra-small">تخصص هندسة أنظمة حاسوب</div>
                            </td>
                            <td class="text-center">
                                <input type="time" class="form-control form-control-sm border-0 bg-light shadow-sm mx-auto" 
                                       style="max-width: 120px;" value="08:00" <?= $is_locked ? 'disabled' : '' ?>>
                            </td>
                            <td class="text-center">
                                <input type="time" class="form-control form-control-sm border-0 bg-light shadow-sm mx-auto" 
                                       style="max-width: 120px;" value="14:00" <?= $is_locked ? 'disabled' : '' ?>>
                            </td>
                            <td class="text-center fw-bold text-primary">6 ساعات</td>
                            <td class="text-center">
                                <select class="form-select form-select-sm border-0 bg-light shadow-sm mx-auto" 
                                        style="max-width: 130px;" <?= $is_locked ? 'disabled' : '' ?>>
                                    <option class="text-success fw-bold">حاضر</option>
                                    <option class="text-danger">غائب</option>
                                    <option class="text-warning">إجازة رسمية</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
       <div class="mt-4 p-3 bg-white rounded-4 border-right-primary shadow-sm overflow-hidden">
    <div class="d-flex align-items-center">
        <div class="flex-shrink-0 bg-primary-subtle p-2 rounded-3">
            <i class="bi bi-shield-check text-primary fs-4"></i>
        </div>
        <div class="ms-3">
            <h6 class="fw-bold mb-1 text-dark">توجيهات اعتماد الحضور</h6>
            <p class="small text-muted mb-0">
                يرجى الالتزام برصد الساعات الفعلية قبل نهاية الدوام (الساعة 5 مساءً). 
            </p>
        </div>
    </div>
</div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>