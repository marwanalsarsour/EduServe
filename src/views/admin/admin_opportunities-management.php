<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة الفرص</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/EduServe/src/public/images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php require_once '../layout/header.php'; ?>
    <div class="container my-4">
        <!-- العنوان -->
        <div class="card shadow-sm mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold mb-1">
                        <i class="bi bi-briefcase ms-1"></i>
                        إدارة الفرص
                    </h4>
                    <p class="text-muted mb-0">
                        إدارة جميع فرص التدريب الميداني والعمل التطوعي المتاحة الطلاب
                    </p>
                </div>
                <button class="btn btn-primary" onclick="showAddForm()">
                    <i class="bi bi-plus-lg ms-1"></i>
                    إضافة فرصة
                </button>
            </div>
        </div>

        <!-- البحث -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="searchInput" placeholder="ابحث عن فرصة">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="statusFilter">
                            <option value="">كل الحالات</option>
                            <option value="open">مفتوحة</option>
                            <option value="closed">مغلقة</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-outline-primary w-100" onclick="searchOpportunities()">
                            <i class="bi bi-search"></i>
                            بحث
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- كرت الإضافة / التعديل -->
        <div class="card shadow-sm mb-4 d-none" id="formCard">

            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">

                    <h5 id="formTitle">إضافة فرصة</h5>

                    <button class="btn btn-sm btn-outline-danger" onclick="hideForm()">
                        إغلاق
                    </button>

                </div>

                <form id="formData">
                    <input type="hidden" id="opportunityId">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">اسم الفرصة</label>
                            <input type="text" class="form-control" id="title" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">الجهة</label>
                            <input type="text" class="form-control" id="company" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">عدد الساعات</label>
                            <input type="number" class="form-control" id="hours" min="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">الحالة</label>
                            <select class="form-select" id="status">
                                <option value="open">مفتوحة</option>
                                <option value="closed">مغلقة</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">الوصف</label>
                            <textarea class="form-control" rows="3" id="description"></textarea>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            حفظ
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="hideForm()">
                            إلغاء
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- جدول الفرص -->
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>الفرصة</th>
                            <th>الجهة</th>
                            <th>الساعات</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>

                    <tbody id="tableBody">

                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-3 border-top">
                <nav>
                    <ul class="pagination justify-content-center mb-0" id="pagination"></ul>
                </nav>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>