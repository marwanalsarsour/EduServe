<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>توثيق الحضور</title>
    <link rel="icon" type="image/png" href="/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light d-flex flex-column min-vh-100">
<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
    <div class="flex-grow-1">
        <div class="container py-4">

            <h4 class="fw-bold mb-4">
                <i class="bi bi-calendar-check ms-2"></i>
                توثيق ساعات الحضور
            </h4>
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-body">
                    <!-- هاي عشان نعرف اذا هو تدريب او عمل تطوعي -->
                    <h5 id="opportunityType" class="fw-bold text-primary mb-2">
                        -
                    </h5>

                    <h6 id="organizationName" class="text-muted">
                        <!-- هون اسم الشركة --> -
                    </h6>

                </div>
            </div>

            <div id="attendanceMsg" class="alert d-none"></div>

            <div class="card shadow-sm border-0">
                <div class="card-body table-responsive">

                    <table class="table table-bordered text-center align-middle">

                        <thead class="table-light">
                            <tr>
                                <th>التاريخ</th>
                                <th>اليوم</th>
                                <th>ساعة القدوم</th>
                                <th>ساعة المغادرة</th>
                                <th>مجموع الساعات</th>
                                <th>توقيع الطالب</th>
                                <th>توقيع المشرف</th>
                            </tr>
                        </thead>

                        <tbody id="attendanceTableBody"></tbody>

                    </table>

                </div>
            </div>

            <!-- هون لازم تضبط اديش عدد الساعات المقطوعه عن طريق ال اي دي تاعها -->
            <div class="card mt-3 shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-center">

                    <h6 class="mb-0 fw-bold">
                        إجمالي الساعات الكلي:
                        <span id="totalHours" class="text-primary">0 ساعة</span>
                    </h6>

                    <button class="btn btn-success" onclick="saveChanges()">
                        <i class="bi bi-save ms-1"></i>
                        حفظ التغييرات
                    </button>

                </div>
            </div>

        </div>
    </div>


    <footer class="mt-5 py-3 bg-primary text-white text-center">
        <div class="container">
            <small>
                © 2026 EduServe - جامعة بوليتكنك فلسطين
            </small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"> </script>

</body>

</html>