<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قائمة المتطوعين - EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body class="bg-light text-start">


    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="fw-bold text-dark"><i class="bi bi-people-fill text-danger ms-2"></i>إدارة المتطوعين</h4>
                <p class="text-muted small">استعراض ومتابعة سجلات المتطوعين داخل المؤسسة</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-3">
                <form action="/v_manager/volunteers" method="GET" class="row g-2">
                    <div class="col-md-10">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" name="search" value="<?= htmlspecialchars($data['search']) ?>" class="form-control bg-light border-0 shadow-none" placeholder="ابحث باسم المتطوع أو الرقم الجامعي...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-danger w-100 rounded-3 fw-bold">بحث</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-white border-bottom text-secondary small">
                        <tr>
                            <th class="py-3 px-4">المتطوع</th>
                            <th class="py-3 text-center">التقدم الدراسي</th>
                            <th class="py-3 text-center">الساعات المنجزة</th>
                            <th class="py-3 text-center">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($data['volunteers'])): ?>
                            <?php foreach($data['volunteers'] as $v): ?>
                                <tr class="bg-white border-bottom">
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-danger-subtle text-danger rounded-circle p-2 ms-3">
                                                <i class="bi bi-person-fill"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark"><?= htmlspecialchars($v['name']) ?></div>
                                                <div class="text-muted extra-small"><?= htmlspecialchars($v['major']) ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center" style="width: 200px;">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <span class="small me-2"><?= $v['progress_percent'] ?>%</span>
                                            <div class="progress w-100 rounded-pill" style="height: 6px;">
                                                <div class="progress-bar bg-danger" style="width: <?= $v['progress_percent'] ?>%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-danger fw-bold rounded-pill px-3 py-2 border">
                                            <?= $v['completed_hours'] ?> / <?= $v['required_limit'] ?> س
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="/v_manager/student-details?id=<?= $v['id'] ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3 shadow-sm">
                                            <i class="bi bi-eye-fill ms-1"></i> عرض التفاصيل
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">لم يتم العثور على متطوعين.</td>
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