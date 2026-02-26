<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلباتي</title>
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">
                    طلباتي
                </h4>

                <a href="opportunities.html" class="btn btn-primary">
                    <i class="bi bi-plus-circle ms-1"></i>
                    التقديم على فرصة جديدة
                </a>
                <!-- احط هيك اشي تحت كلمة طلباتي؟؟؟ -->
                <!-- <p class="fw-semibold mb-2">حالات الطلب التي تم التقديم عليها</p> -->
            </div>

            <!-- لما يصير في خطأ في الصفحة تظهر رساله معينه يحددها الباك اند واذا بدنا بنلغيه -->
            <div id="applicationsMsg" class="alert d-none" role="alert"></div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">

                    <!-- لما يكون فش طلبات يعني لما يكون في طلبات يظهر الجدول فش تظهر هاي الرساله 
          وبنقدر نلغيها و نخلي الجدول فاضي(فارغ)-->
                    <div id="noApplications" class="text-center text-muted py-5 d-none">
                        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                        لا يوجد طلبات حتى الآن.
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle text-center mb-0" id="applicationsTable">
                            <thead class="table-light">
                                <tr>
                                    <th>الفرصة</th>
                                    <th>النوع</th>
                                    <th>الحالة</th>
                                </tr>
                            </thead>
                            <tbody id="applicationsBody">

                            </tbody>
                        </table>
                    </div>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>