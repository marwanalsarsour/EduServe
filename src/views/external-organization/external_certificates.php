<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>إصدار الشهادات</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/src/public/images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php require_once '../layout/header.php'; ?>
    <div class="container my-4">
        <!-- العنوان -->
        <div class="card shadow-sm mb-4">
            <div class="card-body p-4">
                <h4 class="fw-bold mb-1">
                    <i class="bi bi-award ms-1"></i>
                    إصدار الشهادات وخطابات التوصية
                </h4>
                <p class="text-muted mb-0">
                    يمكنك إصدار شهادة أو خطاب توصية للطلاب
                </p>
            </div>
        </div>
        <!-- فورم اصدار الشهادة و خطاب التوصية -->
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form method="POST" action="/certificates/create" enctype="multipart/form-data">
                    <div class="row g-3">
                        <!-- الطالب -->
                        <div class="col-md-6">
                            <label class="form-label">اختيار الطالب</label>
                            <select class="form-select" name="student_id" required>
                                <option value="">اختر الطالب</option>
                                <option value="1">أحمد محمد</option>
                            </select>
                        </div>
                        <!-- النوع -->
                        <div class="col-md-6">
                            <label class="form-label">نوع المستند</label>
                            <select class="form-select" name="type" id="typeSelect" required>
                                <option value="">اختر النوع</option>
                                <option value="training">شهادة التدريب الميداني</option>
                                <option value="volunteer">شهادة العمل التطوعي</option>
                                <option value="recommendation">خطاب التوصية</option>
                            </select>
                        </div>
                        <!-- المؤسسة -->
                        <div class="col-md-6">
                            <label class="form-label">اسم المؤسسة</label>
                            <input type="text" name="organization" class="form-control" required>
                        </div>
                        <!-- الساعات -->
                        <div class="col-md-6">
                            <label class="form-label">عدد الساعات</label>
                            <input type="number" name="hours" class="form-control">
                        </div>
                        <!-- التاريخ -->
                        <div class="col-md-6">
                            <label class="form-label">تاريخ الإصدار</label>
                            <input type="date" name="issue_date" class="form-control" required>
                        </div>
                        <!-- المدرب -->
                        <div class="col-md-6">
                            <label class="form-label">اسم المدرب</label>
                            <input type="text" name="trainer_name" class="form-control">
                        </div>
                        <!-- النص -->
                        <div class="col-12">
                            <label class="form-label">نص المستند</label>
                            <textarea id="contentField" name="content" class="form-control" rows="8"></textarea>
                        </div>
                        <!-- توقيع -->
                        <div class="col-md-6">
                            <label class="form-label">رفع التوقيع</label>
                            <input type="file" name="signature" id="signatureInput" class="form-control"
                                accept="image/*">
                        </div>
                        <!-- ختم -->
                        <div class="col-md-6">
                            <label class="form-label">رفع الختم</label>
                            <input type="file" name="stamp" id="stampInput" class="form-control" accept="image/*">
                        </div>
                    </div>

                    <!-- أزرار -->
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            إصدار
                        </button>
                        <button type="button" class="btn btn-outline-primary" onclick="openPreview()">
                            معاينة
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal الشهادة -->
    <div class="modal fade" id="certificatePreviewModal">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">معاينة الشهادة</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="border p-4">
                        <!-- النص -->
                        <div id="previewCertificateText" style="white-space: pre-line;"></div>

                        <hr class="my-4">

                        <!-- التوقيع والختم -->
                        <div class="row text-center">
                            <!-- الختم -->
                            <div class="col-6">
                                <img id="previewStamp" style="max-height:100px; display:none;">
                                <div class="mt-2">الختم الرسمي</div>
                            </div>
                            <!-- التوقيع -->
                            <div class="col-6">
                                <img id="previewSignature" style="max-height:100px; display:none;">
                                <div class="mt-2">التوقيع</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal التوصية -->
    <div class="modal fade" id="recommendationPreviewModal">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">معاينة خطاب التوصية</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="border p-4">
                        <p id="previewRecommendationText" style="white-space: pre-line;"></p>

                        <hr>

                        <img id="previewSignatureRec" style="max-height:80px; display:none;">
                        <div>التوقيع</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>