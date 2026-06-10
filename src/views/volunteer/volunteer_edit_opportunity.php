<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تعديل فرصة تطوع | EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100 bg-light">

<div class="container mt-5">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/volunteer_opportunities">إدارة الفرص</a>
            </li>
            <li class="breadcrumb-item active">
                تعديل فرصة
            </li>
        </ol>
    </nav>

    <div class="card border-0 shadow-sm mx-auto" style="max-width: 850px;">

        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0 fw-bold">
                <i class="bi bi-pencil-square ms-2"></i>
                تعديل بيانات الفرصة
            </h5>
        </div>

        <div class="card-body p-4">

            <form action="/volunteer_update_opportunity" method="POST">

                <input type="hidden"
                       name="opportunity_id"
                       value="<?= htmlspecialchars($opportunity['opportunityID'] ?? '') ?>">

                <div class="mb-3 text-end">
                    <label class="form-label fw-bold">عنوان الفرصة</label>

                    <input type="text"
                           name="title"
                           class="form-control"
                           value="<?= htmlspecialchars($opportunity['title'] ?? '') ?>"
                           required>
                </div>

                <div class="row">

                    <div class="col-md-6 mb-3 text-end">
                        <label class="form-label fw-bold">نوع الفرصة</label>

                        <input type="text"
                               name="type"
                               class="form-control"
                               value="<?= htmlspecialchars($opportunity['type'] ?? '') ?>">
                    </div>

                    <div class="col-md-6 mb-3 text-end">
                        <label class="form-label fw-bold">عدد المقاعد</label>

                        <input type="number"
                               name="seats"
                               class="form-control"
                               value="<?= htmlspecialchars($opportunity['seats'] ?? '') ?>">
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6 mb-3 text-end">
                        <label class="form-label fw-bold">الجهة الخارجية</label>

                        <input type="text"
                               class="form-control"
                               value="<?= htmlspecialchars($opportunity['entity_name'] ?? '') ?>"
                               readonly>
                    </div>

                    <div class="col-md-6 mb-3 text-end">
                        <label class="form-label fw-bold">مشرف التطوع</label>

                        <input type="text"
                               class="form-control"
                               value="<?= htmlspecialchars($opportunity['supervisor_name'] ?? '') ?>"
                               readonly>
                    </div>

                </div>

                <div class="mb-3 text-end">
                    <label class="form-label fw-bold">شروط الفرصة</label>

                    <textarea name="conditions"
                              class="form-control"
                              rows="4"><?= htmlspecialchars($opportunity['conditions'] ?? '') ?></textarea>
                </div>

                <div class="mb-3 text-end">
                    <label class="form-label fw-bold">وصف الفرصة</label>

                    <textarea name="description"
                              class="form-control"
                              rows="5"><?= htmlspecialchars($opportunity['description'] ?? '') ?></textarea>
                </div>

                <?php $status = $opportunity['status'] ?? ''; ?>

                <div class="row">

                    <div class="col-md-6 mb-3 text-end">
                        <label class="form-label fw-bold">حالة الفرصة</label>

                        <select name="status" class="form-select">
                            <option value="نشط" <?= $status == 'نشط' ? 'selected' : '' ?>>
                                نشطة
                            </option>

                            <option value="مغلق" <?= $status == 'مغلق' ? 'selected' : '' ?>>
                                مغلقة
                            </option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3 text-end">
                        <label class="form-label fw-bold">حالة الموافقة</label>

                        <input type="text"
                               class="form-control"
                               value="<?= ($opportunity['isApproved'] ?? 0) ? 'تمت الموافقة' : 'بانتظار الموافقة' ?>"
                               readonly>
                    </div>

                </div>

                <div class="mb-3 text-end">
                    <label class="form-label fw-bold">تاريخ الإنشاء</label>

                    <input type="text"
                           class="form-control"
                           value="<?= htmlspecialchars($opportunity['createdAt'] ?? '') ?>"
                           readonly>
                </div>

                <hr>

                <div class="d-flex justify-content-end gap-2">
                    <a href="/volunteer_opportunities" class="btn btn-secondary">
                        إلغاء
                    </a>

                    <button type="submit"
                            name="update_opp"
                            class="btn btn-primary">
                        حفظ التعديلات
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>