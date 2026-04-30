<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>اعتماد الساعات والتقييم | EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php require_once BASE_PATH . '/views/layout/header.php'; ?>

<div class="container py-5">
    <h3 class="fw-bold mb-4 text-primary">اعتماد الساعات والتقييم النهائي</h3>

    <?php if(isset($_GET['status']) && $_GET['status'] == 'success'): ?>
        <div class="alert alert-success">تم اعتماد البيانات بنجاح!</div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="table-responsive">
            <table class="table mb-0 align-middle text-center">
                <thead class="bg-dark text-white">
                    <tr>
                        <th class="py-3">اسم الطالب</th>
                        <th>الفرصة</th>
                        <th>الحضور الميداني</th>
                        <th>اعتماد الساعات</th>
                        <th>التقييم</th>
                        <th>حفظ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($students)): ?>
                        <?php foreach($students as $student): ?>
                        <tr>
                            <form action="/volunteer_save_approval" method="POST">
                                <input type="hidden" name="application_id" value="<?= $student['application_id'] ?>">
                                <td class="fw-bold"><?= htmlspecialchars($student['student_name']) ?></td>
                                <td><?= htmlspecialchars($student['opportunity_title']) ?></td>
                                <td><span class="text-success small fw-bold">مؤكد من المؤسسة</span></td>
                                <td>
                                    <input type="number" name="final_hours" class="form-control form-control-sm mx-auto" 
                                           style="width: 80px;" value="<?= $student['confirmed_hours'] ?: 0 ?>">
                                </td>
                                <td>
                                    <select name="evaluation" class="form-select form-select-sm mx-auto" style="width: 120px;">
                                        <option value="ناجح">ناجح</option>
                                        <option value="راسب">راسب</option>
                                    </select>
                                </td>
                                <td><button type="submit" class="btn btn-sm btn-success px-3">اعتماد</button></td>
                            </form>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="py-4 text-muted">لا يوجد طلاب بانتظار الاعتماد حالياً.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>