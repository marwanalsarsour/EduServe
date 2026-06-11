<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>مراجعة كشوف الحضور | EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary">مراجعة الحضور الميداني</h3>
        <span class="badge bg-warning text-dark px-3 py-2">بانتظار الاعتماد الأكاديمي</span>
    </div>

    <?php if(isset($_GET['status']) && $_GET['status'] == 'success'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            تم اعتماد سجل الحضور بنجاح.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm overflow-hidden text-center">
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead class="bg-dark text-white">
                    <tr>
                        <th class="text-start px-4">اسم الطالب</th>
                        <th>التاريخ</th>
                        <th>وقت الحضور</th>
                        <th>وقت الانصراف</th>
                        <th>عدد الساعات</th>
                        <th>حالة السجل</th>
                        <th>ملاحظات</th>
                        <th>الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($attendance_records)): ?>
                        <?php foreach($attendance_records as $record): ?>
                            <tr>
                                <td class="fw-bold text-start px-4"><?= htmlspecialchars($record['student_name']) ?></td>
                                <td><?= htmlspecialchars($record['date']) ?></td>
                                <td><?= !empty($record['checkIn']) ? date('h:i A', strtotime($record['checkIn'])) : '--:--' ?></td>
                                <td><?= !empty($record['checkOut']) ? date('h:i A', strtotime($record['checkOut'])) : '--:--' ?></td>
                                <td><?= htmlspecialchars($record['hours']) ?> ساعة</td>
                                <td>
                                    <?php if(($record['status'] ?? '') == 'approved'): ?>
                                        <span class="text-success fw-bold">
                                            <i class="bi bi-check-circle-fill ms-1"></i>
                                            معتمد
                                        </span>
                                    <?php else: ?>
                                        <span class="text-warning fw-bold">قيد المراجعة</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($record['notes'] ?? '--') ?></td>
                                <td>
                                    <form action="/volunteer_attendance_approve" method="POST">
                                        <input type="hidden" name="attendanceID" value="<?= $record['attendanceID'] ?>">
                                        <button type="submit" class="btn btn-sm btn-primary px-3 shadow-sm">اعتماد اليوم</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="py-5 text-muted">لا توجد سجلات حضور بانتظار الاعتماد حالياً.</td>
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