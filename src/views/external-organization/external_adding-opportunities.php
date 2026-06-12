<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة الفرص | EduServe</title>
    <link class="icon" href="/src/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .form-label { font-weight: bold; color: black; }
        .card { border: 1px solid silver; }
        .btn-success { background-color: green !important; border-color: green !important; }
        .btn-outline-danger { color: red !important; border-color: red !important; }
        .btn-outline-danger:hover { background-color: red !important; color: white !important; }
        h4, h5 { color: blue; }
        input, select, textarea { border-color: gray !important; }
        
        .fade-field {
            opacity: 1;
            max-height: 500px;
            overflow: hidden;
            transition: opacity 0.4s ease, max-height 0.4s ease, margin 0.4s ease;
        }
        .fade-field.d-none-fade {
            opacity: 0;
            max-height: 0;
            margin-top: 0 !important;
            margin-bottom: 0 !important;
            pointer-events: none;
        }
    </style>
</head>

<body class="bg-light d-flex flex-column min-vh-100">

    <div class="flex-grow-1">
        <div class="container my-4">
            <form id="opportunityForm" action="/external/opportunities/store" method="POST">
                <div class="row g-4 my-4">
                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <h4 class="fw-bold mb-4"><i class="bi bi-plus-circle ms-2"></i>إضافة فرصة جديدة</h4>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">اسم الفرصة</label>
                                        <input type="text" class="form-control" name="title" placeholder="مثال: تدريب في تطوير الويب" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label">نوع الفرصة</label>
                                        <select class="form-select" id="opportunityType" name="type" required>
                                            <option value="تدريب">تدريب</option>
                                            <option value="تطوع">تطوع</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">الحالة</label>
                                        <select class="form-select" name="status" required>
                                            <option value="نشط">نشط</option>
                                            <option value="مغلق">مغلق</option>
                                        </select>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">عدد المقاعد</label>
                                        <input type="number" class="form-control" name="seats" min="1" required>
                                    </div>
                                </div>
                                
                                <h5 class="mt-4 fw-bold">الوصف</h5>
                                <textarea class="form-control" name="description" rows="4" placeholder="اكتب تفاصيل الفرصة هنا..." required></textarea>
                                
                                <div class="volunteer-hidden fade-field mt-4" id="conditionsWrapper">
                                    <h5 class="fw-bold">المتطلبات الأساسية</h5>
                                    <textarea class="form-control" id="requirementsInput" name="conditions" rows="4" placeholder="مثال: معرفة بـ PHP و MySQL"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-success w-100 mb-2">
                            <i class="bi bi-check-circle ms-1"></i> نشر الفرصة
                        </button>
                        <a href="/external/opportunities" class="btn btn-outline-danger w-100">
                            <i class="bi bi-x-circle ms-1"></i> إلغاء
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const typeSelect = document.getElementById('opportunityType');
            const conditionsWrapper = document.getElementById('conditionsWrapper');
            const requirementsInput = document.getElementById('requirementsInput');

            function handleTypeChange() {
                if (typeSelect.value === 'تطوع') {
                    conditionsWrapper.classList.add('d-none-fade');
                    requirementsInput.removeAttribute('required');
                    requirementsInput.value = ''; 
                } else {
                    conditionsWrapper.classList.remove('d-none-fade');
                    requirementsInput.setAttribute('required', 'required');
                }
            }

            typeSelect.addEventListener('change', handleTypeChange);
            handleTypeChange();
        });
    </script>
</body>
</html>