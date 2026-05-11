<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>إصدار الشهادات - EduServe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/src/public/images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php require_once '../src/views/layout/header.php'; ?>

    <div class="container my-4">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm mb-4">
            <div class="card-body p-4">
                <h4 class="fw-bold mb-1">
                    <i class="bi bi-award ms-1"></i>
                    إصدار الشهادات وخطابات التوصية
                </h4>
                <p class="text-muted mb-0">
                    يمكنك إصدار شهادة رسمية أو خطاب توصية للطلاب المقبولين لديك.
                </p>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form method="POST" action="/external/certificates/store" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">اختيار الطالب</label>
                            <select class="form-select" name="student_id" required>
                                <option value="">اختر الطالب</option>
                                <?php if (!empty($students)): ?>
                                    <?php foreach ($students as $student): ?>
                                        <option value="<?= $student['id'] ?>"><?= htmlspecialchars($student['name']) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">نوع المستند</label>
                            <select class="form-select" name="type" id="typeSelect" required onchange="updateTextTemplate()">
                                <option value="">اختر النوع</option>
                                <option value="training">شهادة التدريب الميداني</option>
                                <option value="volunteer">شهادة العمل التطوعي</option>
                                <option value="recommendation">خطاب التوصية</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">اسم المؤسسة (يظهر في الشهادة)</label>
                            <input type="text" name="organization" id="orgName" class="form-control" required placeholder="مثال: شركة البرمجيات المتقدمة">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold">عدد الساعات</label>
                            <input type="number" name="hours" class="form-control" placeholder="0">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold">تاريخ الإصدار</label>
                            <input type="date" name="issue_date" class="form-control" required value="<?= date('Y-m-d') ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">اسم المسؤول / المدرب</label>
                            <input type="text" name="trainer_name" class="form-control" placeholder="الاسم الذي سيوقع على الشهادة">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">نص المستند</label>
                            <textarea id="contentField" name="content" class="form-control" rows="6" placeholder="اكتب نص الشهادة هنا..."></textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">رفع صورة التوقيع</label>
                            <input type="file" name="signature" id="signatureInput" class="form-control" accept="image/*" onchange="previewImage(this, 'previewSignatureImg')">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">رفع صورة الختم</label>
                            <input type="file" name="stamp" id="stampInput" class="form-control" accept="image/*" onchange="previewImage(this, 'previewStampImg')">
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-success px-4">
                            <i class="bi bi-check-circle me-1"></i> حفظ وإصدار
                        </button>
                        <button type="button" class="btn btn-outline-primary px-4" onclick="openPreview()">
                            <i class="bi bi-eye me-1"></i> معاينة الشهادة
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="previewModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">معاينة المستند</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="preview-box text-center" id="certificateFrame">
                        <h3 class="mb-4 text-primary" id="previewHeader">شهادة</h3>
                        <p id="previewText" style="white-space: pre-line; line-height: 1.8; font-size: 1.1rem;"></p>
                        
                        <div class="row mt-5">
                            <div class="col-6">
                                <img id="previewStampImg" src="#" alt="الختم" style="max-height: 100px; display: none;">
                                <div class="mt-2 fw-bold">الختم الرسمي</div>
                            </div>
                            <div class="col-6">
                                <img id="previewSignatureImg" src="#" alt="التوقيع" style="max-height: 80px; display: none;">
                                <div class="mt-2 fw-bold">التوقيع</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function updateTextTemplate() {
            const type = document.getElementById('typeSelect').value;
            const contentField = document.getElementById('contentField');
            
            const templates = {
                'training': "تشهد مؤسستنا بأن الطالب/ ....................\nقد أتم بنجاح برنامج التدريب الميداني في قسم ....................\nبواقع عدد ساعات تدريبية بلغت (....) ساعة.\nوذلك خلال الفترة من ........ إلى ........",
                'volunteer': "تقديراً لجهوده المتميزة، تمنح هذه الشهادة للطالب/ ....................\nمشاركةً منه في العمل التطوعي الخاص بـ ....................\nشاكرين له تفانيه وعطاءه.",
                'recommendation': "إلى من يهمه الأمر،،\nيسرنا أن نوصي بالطالب/ ....................\nبناءً على ما لمسناه منه من التزام واحترافية خلال فترة تعامله معنا..."
            };
            
            contentField.value = templates[type] || "";
        }

        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById(previewId);
                    img.src = e.target.result;
                    img.style.display = 'inline-block';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function openPreview() {
            const typeSelect = document.getElementById('typeSelect');
            const typeText = typeSelect.options[typeSelect.selectedIndex].text;
            const content = document.getElementById('contentField').value;
            
            document.getElementById('modalTitle').innerText = "معاينة " + (typeText !== "اختر النوع" ? typeText : "المستند");
            document.getElementById('previewHeader').innerText = typeText;
            document.getElementById('previewText').innerText = content;
            
            const modal = new bootstrap.Modal(document.getElementById('previewModal'));
            modal.show();
        }
    </script>
</body>
</html>