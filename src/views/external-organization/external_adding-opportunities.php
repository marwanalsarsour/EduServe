<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة الفرص</title>
    <link rel="icon" href="/src/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php require_once '../layout/header.php'; ?>
    <div class="flex-grow-1">
        <div class="container my-4">
            <form id="opportunityForm">
                <div class="row g-4 my-4">

                    <div class="col-12 col-lg-8">
                        <div class="card shadow-sm">
                            <div class="card-body p-4">
                                <h4 class="fw-bold mb-4">إضافة فرصة جديدة</h4>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">اسم الفرصة</label>
                                        <input type="text" class="form-control" name="title"
                                            placeholder="مثال: تدريب في تطوير الويب" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">الموقع</label>
                                        <input type="text" class="form-control" name="location" placeholder="الخليل"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">نوع الفرصة</label>
                                        <select class="form-select" name="type" required>
                                            <option value="">اختر النوع</option>
                                            <option value="internship">التدريب الميداني</option>
                                            <option value="volunteer">العمل التطوعي</option>
                                            <option value="part-time">وظيفة جزئية</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">الحالة</label>
                                        <select class="form-select" name="status" required>
                                            <option value="">اختر الحالة</option>
                                            <option value="open">مفتوحة</option>
                                            <option value="closed">مغلقة</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">المدة</label>
                                        <input type="text" class="form-control" name="duration" placeholder="مثال: شهرين" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">تاريخ البدء</label>
                                        <input type="date" class="form-control" name="start_date" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">آخر موعد للتقديم</label>
                                        <input type="date" class="form-control" name="deadline" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">عدد المقاعد</label>
                                        <input type="number" class="form-control" name="seats" min="1" required>
                                    </div>
                                </div>
                                <h5 class="mt-4 fw-bold">الوصف</h5>
                                <textarea class="form-control" name="description" rows="4" required></textarea>
                                <h5 class="mt-4 fw-bold">المتطلبات الأساسية</h5>
                                <textarea class="form-control" name="requirements" rows="4" required></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- الإجراءات -->
                    <div class="col-12 col-lg-4">
                        <div class="card shadow-sm mt-3 mb-4">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-3">معلومات التواصل</h6>
                                <div class="mb-3">
                                    <label class="form-label">البريد الإلكتروني</label>
                                    <input type="email" class="form-control" name="contact_email" placeholder="example@email.com" required>
                                </div>
                                <div>
                                    <label class="form-label">رقم الهاتف</label>
                                    <input type="text" class="form-control" name="contact_phone" placeholder="+970" required>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-3">الإجراءات</h5>
                                <button id="publishBtn" type="submit" class="btn btn-success w-100 mb-2">
                                    <i class="bi bi-check-circle ms-1"></i>
                                    نشر الفرصة
                                </button>
                                <button id="cancelBtn" type="reset" class="btn btn-outline-danger w-100">
                                    <i class="bi bi-x-circle"></i>
                                    إلغاء
                                </button>
                                <div id="successMsg" class="alert alert-success mt-3 d-none">
                                    <i class="bi bi-check-circle"></i>
                                    تمت العملية بنجاح
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>