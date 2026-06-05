<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة الفرص | EduServe</title>
    <link rel="icon" href="/src/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .form-label { font-weight: bold; color: black; }
        .card { border: 1px solid silver; }
        .btn-success { background-color: green !important; border-color: green !important; }
        .btn-outline-danger { color: red !important; border-color: red !important; }
        .btn-outline-danger:hover { background-color: red !important; color: white !important; }
        h4, h5, h6 { color: blue; }
        input, select, textarea { border-color: gray !important; }
        .fade-field {
            transition: all 0.3s ease-in-out;
        }
    </style>
</head>

<body class="bg-light d-flex flex-column min-vh-100">

    <div class="flex-grow-1">
        <div class="container my-4">
            <form id="opportunityForm" action="/external/opportunities/store" method="POST">
                <div class="row g-4 my-4">

                    <div class="col-12 col-lg-8">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <h4 class="fw-bold mb-4"><i class="bi bi-plus-circle ms-2"></i>إضافة فرصة جديدة</h4>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">اسم الفرصة</label>
                                        <input type="text" class="form-control" name="title" placeholder="مثال: تدريب في تطوير الويب" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">الموقع</label>
                                        <input type="text" class="form-control" name="location" placeholder="الخليل" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">نوع الفرصة</label>
                                        <select class="form-select" id="opportunityType" name="type" required>
                                            <option value="">اختر النوع</option>
                                            <option value="internship">التدريب الميداني</option>
                                            <option value="volunteer">العمل التطوعي</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">الحالة</label>
                                        <select class="form-select" name="status" required>
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
                                <textarea class="form-control" name="description" rows="4" placeholder="اكتب تفاصيل الفرصة هنا..." required></textarea>
                                
                                <div class="volunteer-hidden fade-field">
                                    <h5 class="mt-4 fw-bold">المتطلبات الأساسية</h5>
                                    <textarea class="form-control" id="requirementsInput" name="requirements" rows="4" placeholder="مثال: معرفة بـ PHP و MySQL" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="card shadow-sm mb-4 border-0">
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
                        
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-3">الإجراءات</h5>
                                <button type="submit" class="btn btn-success w-100 mb-2">
                                    <i class="bi bi-check-circle ms-1"></i> نشر الفرصة
                                </button>
                                <a href="/external/opportunities" class="btn btn-outline-danger w-100">
                                    <i class="bi bi-x-circle ms-1"></i> إلغاء
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const typeSelect = document.getElementById('opportunityType');
            const volunteerHiddenSection = document.querySelector('.volunteer-hidden');
            const requirementsInput = document.getElementById('requirementsInput');

            function handleTypeChange() {
                if (typeSelect.value === 'volunteer') {
                    volunteerHiddenSection.style.display = 'none';
                    requirementsInput.removeAttribute('required');
                } else {
                    volunteerHiddenSection.style.display = 'block';
                    requirementsInput.setAttribute('required', 'required');
                }
            }

            typeSelect.addEventListener('change', handleTypeChange);
            handleTypeChange();
        });
    </script>
</body>
</html>