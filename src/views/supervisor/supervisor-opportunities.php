<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الفرص - EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100 bg-light">
    <?php require_once '../layout/header.php'; ?>

    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">إدارة فرص التدريب</h4>
            <a href="/supervisor/add-opportunity" class="btn btn-primary rounded-pill shadow-sm">
                <i class="bi bi-plus-circle ms-1"></i> إضافة فرصة جديدة
            </a>
        </div>

        <div class="card shadow-sm border-0 rounded-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="p-3">عنوان الفرصة</th>
                            <th>المؤسسة / الجهة</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($data['opportunities'])): ?>
                            <?php foreach($data['opportunities'] as $opp): ?>
                                <tr>
                                    <td class="fw-bold"><?= htmlspecialchars($opp['title']) ?></td>
                                    <td><?= htmlspecialchars($opp['organization']) ?></td>
                                    <td>
                                        <?php 
                                            $statusClass = ($opp['status'] == 'active') ? 'bg-success' : 'bg-secondary';
                                            $statusText = ($opp['status'] == 'active') ? 'نشطة' : 'مغلقة';
                                        ?>
                                        <span class="badge <?= $statusClass ?> rounded-pill px-3">
                                            <?= $statusText ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="/supervisor/edit-opportunity?id=<?= $opp['id'] ?>" class="btn btn-outline-warning btn-sm border-0">
                                            <i class="bi bi-pencil-square"></i> تعديل
                                        </a>
                                        <button onclick="confirmDelete(<?= $opp['id'] ?>)" class="btn btn-outline-danger btn-sm border-0">
                                            <i class="bi bi-trash"></i> حذف
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="p-5 text-muted text-center">
                                    <i class="bi bi-folder2-open fs-1 d-block mb-2 opacity-50"></i>
                                    لا توجد فرص تدريبية مضافة حالياً.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            if (confirm('هل أنت متأكد من حذف هذه الفرصة؟ لا يمكن التراجع عن هذا الإجراء.')) {
                window.location.href = '/supervisor/delete-opportunity/' + id;
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>