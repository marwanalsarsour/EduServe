<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة معايير التقييم - EduServe</title>

    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">
            <i class="bi bi-clipboard-check"></i>
            إدارة معايير التقييم
        </h3>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            إضافة معيار جديد
        </div>

        <div class="card-body">

            <form method="POST" action="/supervisor_evaluation_criteria/add">

                <div class="row g-3">

                    <div class="col-md-6">
                        <input
                            type="text"
                            name="criterionName"
                            class="form-control"
                            placeholder="اسم المعيار"
                            required>
                    </div>

                    <div class="col-md-4">
                        <input
                            type="number"
                            name="maxScore"
                            class="form-control"
                            placeholder="الدرجة القصوى"
                            required>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-plus-circle"></i>
                            إضافة
                        </button>
                    </div>

                </div>

            </form>

        </div>
    </div>

    <div class="card shadow-sm">

        <div class="card-header bg-dark text-white">
            قائمة المعايير
        </div>

        <div class="card-body p-0">

            <table class="table table-bordered table-hover align-middle text-center mb-0">

                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>اسم المعيار</th>
                        <th>الدرجة القصوى</th>
                        <th style="width: 220px;">الإجراءات</th>
                    </tr>
                </thead>

                <tbody>

                <?php if (!empty($criteria)): ?>

                    <?php foreach ($criteria as $item): ?>

                        <tr>

                            <form method="POST" action="/supervisor_evaluation_criteria/update">

                                <td>
                                    <?= $item['criterionID']; ?>
                                    <input
                                        type="hidden"
                                        name="criterionID"
                                        value="<?= $item['criterionID']; ?>">
                                </td>

                                <td>
                                    <input
                                        type="text"
                                        name="criterionName"
                                        class="form-control"
                                        value="<?= htmlspecialchars($item['criterionName']); ?>"
                                        required>
                                </td>

                                <td>
                                    <input
                                        type="number"
                                        name="maxScore"
                                        class="form-control"
                                        value="<?= $item['maxScore']; ?>"
                                        required>
                                </td>

                                <td>

                                    <div class="d-flex justify-content-center gap-2">

                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="bi bi-save"></i>
                                            حفظ
                                        </button>

                                        <a
                                             href="/supervisor_evaluation_criteria/delete?id=<?= $item['criterionID']; ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('هل أنت متأكد من حذف هذا المعيار؟');">

                                            <i class="bi bi-trash"></i>
                                            حذف

                                        </a>

                                    </div>

                                </td>

                            </form>

                        </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="4" class="py-4 text-muted">
                            لا توجد معايير تقييم مضافة حالياً
                        </td>
                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>