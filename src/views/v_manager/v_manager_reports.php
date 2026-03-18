<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>التقارير والإحصائيات - EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .report-card { border-right: 4px solid #dc3545 !important; }
        .bg-gradient-red { background: linear-gradient(45deg, #dc3545, #ff4d5a); }
    </style>
</head>
<body class="bg-light text-end">
    <?php require_once '../layout/header.php'; ?>

    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-1">تقارير النشاط التطوعي</h4>
                <p class="text-muted small">ملخص الأداء العام وساعات التطوع المنجزة</p>
            </div>
            <button class="btn btn-danger rounded-pill px-4 shadow-sm">
                <i class="bi bi-file-earmark-pdf me-2"></i> تصدير تقرير PDF
            </button>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 report-card">
                    <small class="text-muted d-block mb-1">إجمالي المتطوعين</small>
                    <h3 class="fw-bold text-dark mb-0">12</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 report-card">
                    <small class="text-muted d-block mb-1">ساعات بانتظار الاعتماد</small>
                    <h3 class="fw-bold text-warning mb-0">45</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 report-card">
                    <small class="text-muted d-block mb-1">ساعات تم اعتمادها</small>
                    <h3 class="fw-bold text-success mb-0">210</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 report-card">
                    <small class="text-muted d-block mb-1">متطوعون أتموا الساعات</small>
                    <h3 class="fw-bold text-danger mb-0">3</h3>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white py-3 border-0">
                <h6 class="fw-bold mb-0"><i class="bi bi-graph-up-arrow text-danger ms-2"></i>تحليل أداء المتطوعين</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary small">
                        <tr>
                            <th class="px-4 py-3">المتطوع</th>
                            <th class="text-center">الساعات الكلية</th>
                            <th class="text-center">الساعات المعتمدة</th>
                            <th class="text-center">آخر ملاحظة مسجلة</th>
                            <th class="text-center">الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white">
                            <td class="px-4 py-3">
                                <span class="fw-bold text-dark">أنس جابر القواسمي</span>
                                <div class="text-muted extra-small">221143</div>
                            </td>
                            <td class="text-center">50</td>
                            <td class="text-center text-danger fw-bold">35</td>
                            <td class="text-center small text-muted">ملتزم جداً بالمواعيد</td>
                            <td class="text-center">
                                <span class="badge bg-warning-subtle text-warning rounded-pill px-3">قيد التنفيذ</span>
                            </td>
                        </tr>
                        <tr class="bg-white">
                            <td class="px-4 py-3">
                                <span class="fw-bold text-dark">تامر القاضي</span>
                                <div class="text-muted extra-small">221144</div>
                            </td>
                            <td class="text-center">50</td>
                            <td class="text-center text-success fw-bold">50</td>
                            <td class="text-center small text-muted">أنهى جميع المهام المطلوبة</td>
                            <td class="text-center">
                                <span class="badge bg-success-subtle text-success rounded-pill px-3">مكتمل</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>