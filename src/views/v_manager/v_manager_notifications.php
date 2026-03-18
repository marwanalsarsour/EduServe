<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مركز الإشعارات - مسؤول النشاط</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100 bg-light text-start">
    <?php 
    require_once '../layout/header.php'; 
    
    // ملاحظة للبرمجة: هنا يتم جلب البيانات من الداتابيز
    // $notifications = $db->query("SELECT * FROM notifications WHERE user_id = ...")->fetchAll();
    
    // مصفوفة تجريبية لاختبار التصميم (Simulation)
    $notifications = [
        [
            'id' => 1,
            'title' => 'اعتماد ساعات متطوع',
            'message' => 'قام المشرف الأكاديمي باعتماد الساعات للطالب أنس جابر.',
            'time_ago' => 'منذ ساعتين',
            'is_read' => false
        ],
        [
            'id' => 2,
            'title' => 'طلب مراجعة',
            'message' => 'يوجد ملاحظة من الجامعة بخصوص حضور الطالب خالد العبد.',
            'time_ago' => 'منذ 5 ساعات',
            'is_read' => true
        ]
    ];
    ?>

    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">الإشعارات الواردة</h4>
            <?php if(!empty($notifications)): ?>
                <button class="btn btn-sm btn-outline-danger rounded-pill px-3">تحديد الكل كمقروء</button>
            <?php endif; ?>
        </div>

        <div class="card shadow-sm border-0 overflow-hidden rounded-4">
            <div class="list-group list-group-flush">
                <?php if(!empty($notifications)): ?>
                    <?php foreach($notifications as $notif): ?>
                        <div class="list-group-item list-group-item-action p-3 border-0 mb-1 <?= $notif['is_read'] ? 'bg-white opacity-75' : 'bg-white border-right-danger shadow-sm' ?>" 
                             style="<?= !$notif['is_read'] ? 'border-right: 5px solid #dc3545 !important;' : '' ?>">
                            
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <h6 class="mb-1 fw-bold text-dark"><?= htmlspecialchars($notif['title']) ?></h6>
                                <small class="text-muted" style="font-size: 0.75rem;"><?= $notif['time_ago'] ?></small>
                            </div>
                            
                            <p class="mb-1 text-secondary small text-start"><?= htmlspecialchars($notif['message']) ?></p>
                            
                            <?php if(!$notif['is_read']): ?>
                                <span class="badge rounded-pill bg-danger-subtle text-danger p-1 px-2 mt-1" style="font-size: 0.65rem;">جديد</span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="p-5 text-center text-muted bg-white">
                        <i class="bi bi-bell-slash fs-1 d-block mb-3 text-light"></i>
                        <p class="mb-0">لا توجد إشعارات حالياً.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>