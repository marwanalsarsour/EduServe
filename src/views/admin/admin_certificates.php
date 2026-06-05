<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إصدار وتوقيع الشهادات رقمياً - إدارة الكلية</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .text-custom-black { color: black; }
        .text-custom-red { color: red; }
        .btn-custom-red { background-color: red; color: white; border: none; }
        .btn-custom-red:hover { background-color: darkred; color: white; }
        .bg-custom-white { background-color: white; }
        
        .certificate-frame {
            border: 8px double black;
            padding: 35px;
            background-color: white;
            position: relative;
        }
        .signature-stamp {
            border: 2px dashed red;
            color: red;
            padding: 6px 12px;
            font-family: 'Cairo', sans-serif, monospace;
            display: inline-block;
            transform: rotate(-3deg);
            font-size: 0.85rem;
            line-height: 1.4;
        }
        .extra-small {
            font-size: 0.75rem;
        }
    </style>
</head>
<body class="bg-light flex-column min-vh-100">


    <div class="container my-5">
        
        <?php if (isset($_GET['success']) && $_GET['success'] === 'issued'): ?>
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 small mb-4" role="alert">
                <i class="bi bi-check-circle-fill ms-2"></i>
                تم تشفير وتوقيع الشهادة الرقمية بنجاح وإدراجها بالنظام. كود التحقق المعتمد: <strong><?= htmlspecialchars($_GET['code']) ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 small mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill ms-2"></i>
                <?php
                    if ($_GET['error'] === 'already_exists') echo "خطأ: هذا الطالب يملك شهادة صادرة بنفس العنوان مسبقاً.";
                    elseif ($_GET['error'] === 'missing_fields') echo "خطأ: يرجى ملء جميع الحقول المطلوبة ومفتاح الأمان.";
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="mb-4">
            <h4 class="fw-bold text-custom-black mb-1">مركز إصدار وتوقيع الشهادات المعتمدة</h4>
            <p class="text-muted small">إصدار وتوقيع التقديرات إلكترونياً للطلاب الذين أتموا المتطلبات التدريبية والساعات الإلزامية.</p>
        </div>

        <div class="row g-4">
            <div class="col-12 col-lg-5">
                <div class="card p-4 border-0 shadow-sm rounded-4 bg-white h-100">
                    <h6 class="fw-bold text-custom-black mb-3"><i class="bi bi-shield-check text-custom-red ms-2"></i>معلومات التوقيع الرقمي</h6>
                    
                    <form action="/admin/process-signature" method="POST" class="mt-2">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-custom-black">تحديد الطالب المستحق</label>
                            <select name="student_id" id="studentSelect" class="form-select bg-light border-0" required>
                                <option value="" disabled selected>-- اختر طالب من القائمة --</option>
                                <?php if (!empty($students) && is_array($students)): ?>
                                    <?php foreach ($students as $student): ?>
                                        <option value="<?= $student['userID'] ?>"><?= htmlspecialchars($student['fullName']) ?></option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="" disabled>لا يوجد طلاب مسجلين بالنظام حالياً</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-custom-black">عنوان أو مسمى الشهادة الصادرة</label>
                            <input type="text" name="cert_title" id="certTitleInput" class="form-control bg-light border-0" value="شهادة إتمام في التدريب الميداني التكنولوجي" required>
                        </div>
                        
                        <button type="submit" class="btn btn-custom-red w-100 fw-bold py-2 rounded-3" <?= empty($students) ? 'disabled' : '' ?>>
                            <i class="bi bi-pencil-square ms-1"></i> تشفير وتوقيع الشهادة الرقمية فوراً
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-12 col-lg-7">
                <div class="card p-4 border-0 shadow-sm rounded-4 bg-white h-100 d-flex flex-column justify-content-between">
                    <h6 class="fw-bold text-custom-black mb-3">معاينة المستند الحي وتوقيع عمادة الكلية</h6>
                    
                    <div class="certificate-frame text-center shadow-sm my-auto">
                        <h4 class="fw-bold text-custom-black mb-3" id="liveCertTitle">شهادة إنجاز معتمدة رقمياً</h4>
                        
                        <p class="mb-2 small">تشهد إدارة كلية تكنولوجيا المعلومات وهندسة الحاسوب جامعة بوليتكنك فلسطين بأن الطالب:</p>
                        
                        <h5 class="fw-bold text-dark my-3" id="liveStudentName">[ سيظهر اسم الطالب المختار هنا ]</h5>
                        
                        <p class="small text-muted px-3">قد أتم بنجاح تام كافة المتطلبات التدريبية الميدانية والساعات والتقارير الدورية الموكلة إليه بكل كفاءة واقتدار وبناءً عليه منح هذه الشهادة الإلكترونية الموثقة.</p>
                        
                        <div class="d-flex justify-content-between align-items-end mt-4 pt-3">
                            <div class="text-start small text-muted extra-small">
                                <span>معرف التوثيق الرقمي: <br> 
                                <span id="liveVerifyCode"><?= isset($_GET['code']) ? htmlspecialchars($_GET['code']) : 'EDUSERVE-VERIFY-2026' ?></span></span>
                            </div>
                            
                            <div class="signature-stamp fw-bold text-center">
                                <i class="bi bi-patch-check-fill"></i> وقع رقمياً بواسطة <br>
                                <span>د. ليانا التميمي</span> <br>
                                <small style="font-size: 0.65rem; font-weight: normal;">عميدة الكلية</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        const studentSelect = document.getElementById('studentSelect');
        const certTitleInput = document.getElementById('certTitleInput');
        const liveStudentName = document.getElementById('liveStudentName');
        const liveCertTitle = document.getElementById('liveCertTitle');

        studentSelect.addEventListener('change', function() {
            const selectedText = this.options[this.selectedIndex].text;
            liveStudentName.textContent = selectedText;
        });

        certTitleInput.addEventListener('input', function() {
            if(this.value.trim() !== "") {
                liveCertTitle.textContent = this.value;
            } else {
                liveCertTitle.textContent = "شهادة إنجاز معتمدة رقمياً";
            }
        });
    </script>
</body>
</html>