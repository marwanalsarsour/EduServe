<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الفرص بانتظار الموافقة</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h2 class="card-title mb-4 text-primary fw-bold">
                <i class="bi bi-clipboard-check"></i> الفرص بانتظار الموافقة
            </h2>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>عنوان الفرصة</th>
                            <th>النوع</th>
                            <th class="text-center">الإجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($data['opportunities'])): ?>
                            <tr><td colspan="3" class="text-center py-4 text-muted">لا توجد فرص بانتظار الموافقة</td></tr>
                        <?php else: ?>
                            <?php foreach($data['opportunities'] as $opp): ?>
                            <tr>
                                <td class="fw-semibold"><?= htmlspecialchars($opp['title']) ?></td>
                                <td><span class="badge bg-primary"><?= htmlspecialchars($opp['type']) ?></span></td>
                                <td class="text-center">
                                    <form action="/pending/approve" method="POST" style="display:inline;">
                                        <input type="hidden" name="opportunity_id" value="<?= $opp['opportunityID'] ?>">
                                        <button type="submit" class="btn btn-success btn-sm px-3">
                                            <i class="bi bi-check-lg"></i> موافقة
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>