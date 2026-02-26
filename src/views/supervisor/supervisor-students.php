<?php
// بيانات تجريبية (Dummy Data) لضمان عمل الواجهة بشكل مثالي أثناء العرض
if (!isset($data)) {
    $data['students'] = [
        [
            'id' => 1, 
            'name' => 'تامر زيدان القاضي', 
            'major' => 'علم الحاسوب', 
            'company' => 'شركة عسقلان للبرمجيات', 
            'completed_hours' => 45, 
            'required_hours' => 90, 
            'status' => 'نشط', 
            'status_class' => 'success',
            'has_alert' => true // لديه تنبيه (تأخر في التقرير)
        ],
        [
            'id' => 2, 
            'name' => 'عبد العزيز الحداد', 
            'major' => 'تكنولوجيا المعلومات', 
            'company' => 'بلدية الخليل - قسم IT', 
            'completed_hours' => 90, 
            'required_hours' => 90, 
            'status' => 'مكتمل', 
            'status_class' => 'primary',
            'has_alert' => false
        ],
        [
            'id' => 3, 
            'name' => 'مروان الصرصور', 
            'major' => 'علم الحاسوب', 
            'company' => 'بندار للاتصالات', 
            'completed_hours' => 15, 
            'required_hours' => 90, 
            'status' => 'متعثر', 
            'status_class' => 'danger',
            'has_alert' => false
        ],
    ];
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الطلاب - المشرف</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .filter-btn.active { background-color: #0d6efd; color: white; }
        .alert-dot { width: 10px; height: 10px; background-color: red; border-radius: 50%; display: inline-block; margin-left: 5px; animation: pulse 1.5s infinite; }
        @keyframes pulse { 0% { opacity: 1; } 50% { opacity: 0.3; } 100% { opacity: 1; } }
    </style>
</head>

<body class="bg-light d-flex flex-column min-vh-100">
<?php require_once '../layout/header.php'; ?>

<div class="container my-5">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h4 class="fw-bold"><i class="bi bi-person-video3 ms-2 text-primary"></i>قائمة الطلاب المتابعين</h4>
            <p class="text-muted small">إدارة ومتابعة تقدم الطلاب في التدريب الميداني</p>
        </div>
        
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control border-start-0" placeholder="ابحث بالاسم، الرقم الجامعي، أو جهة التدريب...">
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100">بحث</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">الطالب</th>
                            <th>جهة التدريب</th>
                            <th>الإنجاز</th>
                            <th>الحالة</th>
                            <th class="text-center">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($data['students'])): ?>
                        <?php foreach($data['students'] as $student): ?>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-3 bg-soft-primary rounded-circle"></div>
                                    <div>
                                        <div class="fw-bold">
                                            <?= $student['name'] ?>
                                            <?php if($student['has_alert']): ?>
                                                <span class="alert-dot" title="تأخر في تسليم التقرير"></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="text-muted small"><?= $student['major'] ?></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="small"><i class="bi bi-building ms-1"></i><?= $student['company'] ?></div>
                            </td>
                            <td style="width: 200px;">
                                <?php $percent = ($student['completed_hours'] / $student['required_hours']) * 100; ?>
                                <div class="d-flex align-items-center">
                                    <div class="progress flex-grow-1" style="height: 6px;">
                                        <div class="progress-bar bg-<?= $student['status_class'] ?>" style="width: <?= $percent ?>%"></div>
                                    </div>
                                    <span class="ms-2 small fw-bold"><?= (int)$percent ?>%</span>
                                </div>
                                <div class="text-muted" style="font-size: 11px;"><?= $student['completed_hours'] ?> من أصل <?= $student['required_hours'] ?> ساعة</div>
                            </td>
                            <td>
                                <span class="badge rounded-pill bg-<?= $student['status_class'] ?> bg-opacity-10 text-<?= $student['status_class'] ?> px-3">
                                    <?= $student['status'] ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="supervisor-student-details.php?id=<?= $student['id'] ?>" class="btn btn-sm btn-outline-primary shadow-sm">
                                    <i class="bi bi-folder2-open ms-1"></i> الملف الكامل
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="bi bi-people text-muted fs-1 d-block mb-3"></i>
                                لا يوجد طلاب لمتابعتهم حالياً.
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>