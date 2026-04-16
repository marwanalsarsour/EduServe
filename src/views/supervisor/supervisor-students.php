<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الطلاب - EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .alert-dot { 
            width: 10px; 
            height: 10px; 
            background-color: red; 
            border-radius: 50%; 
            display: inline-block; 
            margin-right: 5px; 
            animation: pulse 1.5s infinite; 
        }
        
        @keyframes pulse { 
            0% { transform: scale(0.95); opacity: 0.7; } 
            70% { transform: scale(1); opacity: 1; } 
            100% { transform: scale(0.95); opacity: 0.7; } 
        }
        
        .avatar-placeholder { 
            width: 40px; 
            height: 40px; 
            background: lightgray;
            display: flex; 
            align-items: center; 
            justify-content: center; 
            color: dimgray; 
        }
    </style>
</head>

<body class="bg-light d-flex flex-column min-vh-100">
<?php require_once '../layout/header.php'; ?>

<div class="container my-5 flex-grow-1">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h4 class="fw-bold"><i class="bi bi-person-video3 ms-2 text-primary"></i>قائمة الطلاب المتابعين</h4>
            <p class="text-muted small">متابعة الأداء الأكاديمي والتدريب الميداني لطلاب EduServe</p>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4 rounded-3">
        <div class="card-body">
            <form action="/supervisor/students" method="GET" class="row g-3">
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" 
                               value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" 
                               placeholder="ابحث بالاسم، الرقم الجامعي، أو التخصص...">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100 rounded-pill shadow-sm">بحث</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-center">
                <thead class="table-dark">
                    <tr>
                        <th class="text-start ps-4 p-3">الطالب</th>
                        <th>جهة التدريب</th>
                        <th>الإنجاز</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(!empty($data['students'])): ?>
                    <?php foreach($data['students'] as $student): ?>
                    <tr>
                        <td class="text-start ps-4">
                            <div class="d-flex align-items-center">
                                <div class="avatar-placeholder rounded-circle ms-3">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <div>
                                    <div class="fw-bold d-flex align-items-center">
                                        <?= htmlspecialchars($student['name']) ?>
                                        <?php if($student['has_alert']): ?>
                                            <span class="alert-dot" title="بانتظار مراجعة تقارير متأخرة"></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="text-muted" style="font-size: 11px;"><?= htmlspecialchars($student['major']) ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="small">
                            <i class="bi bi-building ms-1 text-muted"></i><?= htmlspecialchars($student['company']) ?>
                        </td>
                        <td style="width: 220px;">
                            <div class="d-flex align-items-center">
                                <div class="progress flex-grow-1" style="height: 7px; border-radius: 10px;">
                                    <div class="progress-bar bg-<?= $student['color'] ?>" style="width: <?= $student['percent'] ?>%"></div>
                                </div>
                                <span class="ms-2 small fw-bold text-<?= $student['color'] ?>"><?= $student['percent'] ?>%</span>
                            </div>
                            <div class="text-muted mt-1" style="font-size: 10px;">
                                <?= $student['completed_hours'] ?> / <?= $student['required_hours'] ?> ساعة
                            </div>
                        </td>
                        <td>
                            <span class="badge rounded-pill bg-<?= $student['color'] ?> bg-opacity-10 text-<?= $student['color'] ?> border border-<?= $student['color'] ?> px-3">
                                <?= $student['status'] ?>
                            </span>
                        </td>
                        <td>
                            <a href="/supervisor/student-profile/<?= $student['id'] ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3 shadow-sm">
                                <i class="bi bi-folder2-open ms-1"></i> الملف الكامل
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="py-5 text-muted">
                            <i class="bi bi-people fs-1 d-block mb-3 opacity-25"></i>
                            لا يوجد طلاب مسجلين تحت إشرافك حالياً.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>