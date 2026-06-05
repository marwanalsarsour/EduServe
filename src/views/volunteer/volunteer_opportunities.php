<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة فرص التطوع | EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">


<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">التحكم بفرص التطوع</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addOppModal">
            <i class="bi bi-plus-lg ms-2"></i>إضافة فرصة تطوع
        </button>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden">
        <table class="table mb-0 align-middle">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="py-3 px-4">عنوان الفرصة</th>
                    <th>جهة التطوع</th>
                    <th>عدد الساعات</th>
                    <th>الحالة</th>
                    <th class="text-center">التحكم</th>
                </tr>
            </thead>
            <tbody>
    <?php if(!empty($opportunities)): ?>
        <?php foreach($opportunities as $opp): ?>
        <tr>
            <td class="px-4 fw-bold"><?= htmlspecialchars($opp['title'] ?? 'بدون عنوان') ?></td>
            
           <td><?= htmlspecialchars($opp['entity_name'] ?? 'جهة غير معروفة') ?></td>
            
            <td><?= ($opp['seats'] ?? 0) ?> مقاعد</td>
            
            <td>
                <span class="badge <?= ($opp['status'] ?? '') == 'نشط' ? 'bg-success' : 'bg-secondary' ?>">
                    <?= htmlspecialchars($opp['status'] ?? 'غير محدد') ?>
                </span>
            </td>
            
            <td class="text-center">
                <a href="/volunteer_edit_opportunity?id=<?= $opp['opportunityID'] ?>" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-pencil"></i>
                </a>
                <a href="/delete_opportunity?id=<?= $opp['opportunityID'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('هل أنت متأكد؟')">
                    <i class="bi bi-trash"></i>
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="5" class="text-center py-4">لا توجد فرص تطوع مضافة حالياً.</td></tr>
    <?php endif; ?>
</tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="addOppModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="fw-bold">إضافة فرصة تطوع جديدة</h5>
                <button type="button" class="btn-close ms-0" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 text-start">
                <form action="/store_opportunity" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">اسم الفرصة التطوعية</label>
                        <input type="text" name="title" class="form-control" placeholder="مثال: تنظيم فعاليات تقنية" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">المؤسسة المستضيفة</label>
                            <input type="text" name="org" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">عدد الساعات المطلوبة</label>
                            <input type="number" name="hours" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">وصف المهام</label>
                        <textarea name="description" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-5">نشر الفرصة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>