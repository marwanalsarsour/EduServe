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
    <style>.step-number { width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 50%; margin-left: 10px; font-weight: bold; }</style>
</head>
<body class="reports-page text-end bg-light"> 
    <?php require_once '../src/views/layout/header.php'; ?>

    <div class="container my-5">
        <?php if(isset($_GET['success'])): ?>
            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">تم إرسال التقرير بنجاح!</div>
        <?php endif; ?>

        <div class="mb-5"> 
            <h2 class="fw-bold text-dark">إدارة تقارير المتدربين</h2>
            <p class="text-muted small">توثيق الأداء الدوري والتقييم النهائي الشامل للطالب.</p>
        </div>

        <ul class="nav nav-pills nav-fill mb-4 shadow-sm rounded-pill p-1 bg-white border" id="reportTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active rounded-pill fw-bold py-3" id="monthly-tab" data-bs-toggle="tab" data-bs-target="#monthly" type="button" role="tab">
                    <i class="bi bi-calendar-range ms-2"></i>التقارير الدورية
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link rounded-pill fw-bold py-3" id="final-tab" data-bs-toggle="tab" data-bs-target="#final" type="button" role="tab">
                    <i class="bi bi-mortarboard ms-2"></i>التقييم والتقرير النهائي
                </button>
            </li>
        </ul>

        <div class="tab-content" id="reportTabsContent">
            <div class="tab-pane fade show active" id="monthly" role="tabpanel">
                <form action="/trainer/reports/process-monthly" method="POST">
                    <div class="card shadow-sm rounded-4 border-0 p-4 border-start border-5 border-info bg-white">
                        <div class="d-flex align-items-center mb-4">
                            <div class="step-number bg-info text-white">1</div>
                            <h5 class="fw-bold mb-0 text-info">نموذج متابعة الأداء الدوري</h5>
                        </div>
                        <div class="row g-4 mb-4 px-md-4">
                            <div class="col-md-4">
                                <label class="small fw-bold text-secondary mb-2">اسم الطالب</label>
                                <select name="student_id" class="form-select bg-light border-0 shadow-sm py-2" required>
                                    <option value="">اختر الطالب...</option>
                                    <?php foreach($students as $s): ?>
                                        <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold text-secondary mb-2">الفترة الزمنية</label>
                                <select name="period" class="form-select bg-light border-0 shadow-sm py-2" required>
                                    <option>الشهر الأول</option>
                                    <option>الشهر الثاني</option>
                                    <option>الشهر الثالث</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold text-secondary mb-2">التقييم العام</label>
                                <select name="rating" class="form-select bg-light border-0 shadow-sm py-2">
                                    <option value="ممتاز">ممتاز</option>
                                    <option value="جيد جداً">جيد جداً</option>
                                    <option value="جيد">جيد</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4 px-md-4">
                            <label class="small fw-bold text-secondary mb-2">ملخص المهام المنجزة:</label>
                            <textarea name="summary" class="form-control bg-light border-0 shadow-sm" rows="5" placeholder="اكتب ملاحظاتك..." required></textarea>
                        </div>
                        <div class="text-start px-md-4">
                            <button type="submit" class="btn btn-info text-white fw-bold px-5 py-2 rounded-pill shadow-sm">إرسال التقرير الدوري</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="tab-pane fade" id="final" role="tabpanel">
                <form action="/trainer/reports/process-final" method="POST">
                    <div class="card shadow-sm rounded-4 mb-4 border-0 bg-white p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="step-number bg-primary text-white">1</div>
                            <h5 class="fw-bold mb-0 text-primary">تأكيد الطالب والساعات المنجزة</h5>
                        </div>
                        <div class="row g-4 px-md-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary">اسم الطالب المتربص</label>
                                <select name="student_id" class="form-select py-2 border-0 bg-light shadow-sm" required>
                                    <option value="">اختر الطالب...</option>
                                    <?php foreach($students as $s): ?>
                                        <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary">إجمالي ساعات الحضور الفعلية</label>
                                <div class="input-group shadow-sm" dir="ltr"> 
                                    <span class="input-group-text bg-white border-0 fw-bold">ساعة</span>
                                    <input type="number" name="total_hours" class="form-control py-2 border-0 bg-light text-end" placeholder="120" required>
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
                            $eval_fields = [
                                "crit_1" => "الالتزام بالأنظمة والمواعيد", 
                                "crit_2" => "سرعة التعلم والتطبيق", 
                                "crit_3" => "مهارات التواصل والعمل الجماعي"
                            ];
                            foreach($eval_fields as $key => $label): ?>
                                <div class="row align-items-center mb-3 p-2 bg-light rounded-3">
                                    <div class="col-md-8 fw-bold small"><?= $label ?></div>
                                    <div class="col-md-4">
                                        <select name="<?= $key ?>" class="form-select border-0 shadow-sm small">
                                            <option value="10">10/10 (ممتاز)</option>
                                            <option value="8">8/10 (جيد جداً)</option>
                                            <option value="5">5/10 (متوسط)</option>
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
                            <textarea name="feedback" class="form-control bg-light border-0 shadow-sm" rows="4" placeholder="اكتب رأيك العام..." required></textarea>
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