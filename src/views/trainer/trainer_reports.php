<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة التقارير والتقييم - EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body class="reports-page text-end bg-light"> 
    <?php require_once '../layout/header.php'; ?>

    <div class="container my-5">
        <div class="mb-5"> 
            <h2 class="fw-bold text-dark">إدارة تقارير المتدربين</h2>
            <p class="text-muted small">توثيق الأداء الدوري والتقييم النهائي الشامل للطالب.</p>
        </div>

        <ul class="nav nav-pills nav-fill mb-4 shadow-sm rounded-pill p-1 bg-white border" id="reportTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active rounded-pill fw-bold py-3" id="monthly-tab" data-bs-toggle="tab" data-bs-target="#monthly" type="button" role="tab">
                    <i class="bi bi-calendar-range ms-2"></i>التقارير الدورية
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill fw-bold py-3" id="final-tab" data-bs-toggle="tab" data-bs-target="#final" type="button" role="tab">
                    <i class="bi bi-mortarboard ms-2"></i>التقييم والتقرير النهائي
                </button>
            </li>
        </ul>

        <div class="tab-content" id="reportTabsContent">
            
            <div class="tab-pane fade show active" id="monthly" role="tabpanel">
                <form action="process_monthly.php" method="POST">
                    <div class="card shadow-sm rounded-4 border-0 p-4 border-start border-5 border-info bg-white">
                        <div class="d-flex align-items-center mb-4">
                            <div class="step-number bg-info text-white">1</div>
                            <h5 class="fw-bold mb-0 text-info">نموذج متابعة الأداء الدوري</h5>
                        </div>
                        <div class="row g-4 mb-4 px-md-4">
                            <div class="col-md-4">
                                <label class="small fw-bold text-secondary mb-2">اسم الطالب</label>
                                <select class="form-select bg-light border-0 shadow-sm py-2" required>
                                    <option value="">اختر الطالب...</option>
                                    <option>سارة أحمد</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold text-secondary mb-2">الفترة الزمنية</label>
                                <select class="form-select bg-light border-0 shadow-sm py-2" required>
                                    <option>الشهر الأول</option>
                                    <option>الشهر الثاني</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold text-secondary mb-2">التقييم العام</label>
                                <select class="form-select bg-light border-0 shadow-sm py-2">
                                    <option>ممتاز</option>
                                    <option>جيد جداً</option>
                                    <option>جيد</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4 px-md-4">
                            <label class="small fw-bold text-secondary mb-2">ملخص المهام المنجزة:</label>
                            <textarea class="form-control bg-light border-0 shadow-sm" rows="5" placeholder="اكتب ملاحظاتك..."></textarea>
                        </div>
                        <div class="text-start px-md-4">
                            <button type="submit" class="btn btn-info text-white fw-bold px-5 py-2 rounded-pill shadow-sm">إرسال التقرير الدوري</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="tab-pane fade" id="final" role="tabpanel">
                <form action="process_final.php" method="POST">
                    <div class="card shadow-sm rounded-4 mb-4 border-0 bg-white p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="step-number bg-primary text-white">1</div>
                            <h5 class="fw-bold mb-0 text-primary">تأكيد الطالب والساعات المنجزة</h5>
                        </div>
                        <div class="row g-4 px-md-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary">اسم الطالب المتربص</label>
                                <select class="form-select py-2 border-0 bg-light shadow-sm" required>
                                    <option value="">اختر الطالب...</option>
                                    <option>سارة أحمد</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary">إجمالي ساعات الحضور الفعلية</label>
                                <div class="input-group shadow-sm" dir="ltr"> 
                                    <span class="input-group-text bg-white border-0 fw-bold">ساعة</span>
                                    <input type="number" class="form-control py-2 border-0 bg-light text-end" placeholder="120" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm rounded-4 mb-4 border-0 bg-white p-4 border-right-primary">
                        <div class="d-flex align-items-center mb-4">
                            <div class="step-number bg-primary text-white">2</div>
                            <h5 class="fw-bold mb-0 text-primary">معايير التقييم الفني والسلوكي (درجات)</h5>
                        </div>
                        <div class="px-md-4">
                            <?php 
                            $eval_fields = ["الالتزام بالأنظمة والمواعيد", "سرعة التعلم والتطبيق", "مهارات التواصل والعمل الجماعي"];
                            foreach($eval_fields as $field): ?>
                                <div class="row align-items-center mb-3 p-2 bg-light rounded-3">
                                    <div class="col-md-8 fw-bold small"><?= $field ?></div>
                                    <div class="col-md-4">
                                        <select class="form-select border-0 shadow-sm small">
                                            <option>10/10 (ممتاز)</option>
                                            <option>8/10 (جيد جداً)</option>
                                            <option>5/10 (متوسط)</option>
                                        </select>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="card shadow-sm rounded-4 mb-4 border-0 bg-white p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="step-number bg-primary text-white">3</div>
                            <h5 class="fw-bold mb-0 text-primary">التقييم الكتابي الوصفي للمدرب</h5>
                        </div>
                        <div class="px-md-4">
                            <textarea class="form-control bg-light border-0 shadow-sm" rows="4" placeholder="اكتب رأيك العام في أداء الطالب ومستقبله المهني..."></textarea>
                        </div>
                    </div>

                    <div class="text-center mt-5 mb-5">
                         <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill fw-bold shadow-lg">اعتماد وإرسال التقييم النهائي للمشرف الأكاديمي</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>