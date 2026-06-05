<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إصدار وتوقيع الشهادات رقمياً - الجهة الخارجية</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .text-custom-black { color: black; }
        .text-custom-blue { color: blue; }
        .btn-custom-blue { background-color: blue; color: white; border: none; }
        .btn-custom-blue:hover { background-color: darkblue; color: white; }
        
        .certificate-frame {
            border: 8px double blue;
            padding: 30px;
            background-color: white;
            position: relative;
            border-radius: 4px;
        }
        .signature-stamp-box {
            border: 2px dashed blue;
            color: blue;
            padding: 6px 12px;
            font-family: 'Segoe UI', Tahoma, Geneva, sans-serif;
            display: inline-block;
            transform: rotate(-2deg);
            font-size: 0.85rem;
            line-height: 1.4;
            background-color: white;
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
                تم إصدار وتوقيع المستند وحفظ الشهادة الرقمية بنجاح! كود التحقق الرقمي المعتمد: <strong><?= htmlspecialchars($_GET['code'] ?? '') ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 small mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill ms-2"></i>
                خطأ: فشل في معالجة وحفظ الشهادة الرقمية بالنظام، يرجى التحقق من الحقول المطلوبة.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="mb-4">
            <h4 class="fw-bold text-custom-black mb-1">منصة اعتماد وإصدار الشهادات الإلكترونية</h4>
            <p class="text-muted small">توقيع واعتماد مستندات الطلاب والمتدربين الذين أتموا الفترات العملية في منشأتكم رقمياً.</p>
        </div>

        <div class="row g-4">
            <div class="col-12 col-lg-5">
                <div class="card p-4 border-0 shadow-sm rounded-4 bg-white h-100">
                    <h6 class="fw-bold text-custom-black mb-3"><i class="bi bi-patch-check text-custom-blue ms-2"></i>منشئ المستندات الرقمية</h6>
                    
                    <form action="/external/certificates/store" method="POST" class="mt-2">
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-custom-black">تحديد الطالب المستحق</label>
                            <select name="student_id" id="studentSelect" class="form-select bg-light border-0" required>
                                <option value="" disabled selected>-- اختر طالب مقبول مسبقاً --</option>
                                <?php if (!empty($students) && is_array($students)): ?>
                                    <?php foreach ($students as $student): ?>
                                        <option value="<?= $student['userID'] ?>"><?= htmlspecialchars($student['fullName'] ?? '') ?></option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="" disabled>لا يوجد طلاب مقبولين في الكيان حالياً</option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-custom-black">نوع ومسمى الشهادة</label>
                            <input type="text" name="cert_title" id="certTitleInput" class="form-control bg-light border-0" value="شهادة إتمام وتدريب ميداني معتمدة" required>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold text-custom-black">عدد الساعات المنجزة</label>
                                <input type="number" name="hours" id="certHoursInput" class="form-control bg-light border-0" placeholder="مثال: 90" value="90">
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold text-custom-black">تاريخ الاعتماد</label>
                                <input type="date" name="issue_date" class="form-control bg-light border-0" required value="<?= date('Y-m-d') ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-custom-black">اسم المسؤول / المدرب المباشر</label>
                            <input type="text" name="trainer_name" class="form-control bg-light border-0" placeholder="مثال: م. أحمد الخبير" value="<?= htmlspecialchars($orgData['trainer_name'] ?? '') ?>" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-custom-black">صيغة المحتوى المكتوب</label>
                            <textarea name="content" id="contentInput" class="form-control bg-light border-0" rows="5" required>يشهد كياننا المعتمد بأن الطالب المذكور أعلاه قد أتم بنجاح فترة العمل التدريبي والعملي الموكلة إليه بكفاءة عالية والالتزام بضوابط الجودة العامة للمنصة.</textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-custom-blue w-100 fw-bold py-2 rounded-3" <?= empty($students) ? 'disabled' : '' ?>>
                            <i class="bi bi-file-earmark-lock ms-1"></i> إصدار وحفظ الشهادة الرقمية فوراً
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-12 col-lg-7">
                <div class="card p-4 border-0 shadow-sm rounded-4 bg-white h-100 d-flex flex-column justify-content-between">
                    <h6 class="fw-bold text-custom-black mb-3">معاينة المستند الحي وتوقيع الجهة المعتمدة</h6>
                    
                    <div class="certificate-frame text-center shadow-sm my-auto">
                        <h4 class="fw-bold text-custom-blue mb-3" id="liveCertTitle">شهادة إتمـام وتدريب ميداني معتمدة</h4>
                        
                        <p class="mb-2 small">تشهد إدارة الكيان والجهة التدريبية الخارجية المسجلة بنظام EduServe بأن الطالب:</p>
                        
                        <h5 class="fw-bold text-dark my-3" id="liveStudentName">[ سيظهر اسم الطالب المختار تلقائياً ]</h5>
                        
                        <p class="small text-muted px-2 mb-2" id="liveContentText">يشهد كياننا المعتمد بأن الطالب المذكور أعلاه قد أتم بنجاح فترة العمل التدريبي والعملي الموكلة إليه بكفاءة عالية والالتزام بضوابط الجودة العامة للمنصة.</p>
                        
                        <div class="small fw-bold text-dark mb-3">
                            إجمالي الساعات المسجلة: (<span id="liveHours" class="text-primary">90</span>) ساعة تدريبية معتمدة.
                        </div>

                        <div class="d-flex justify-content-between align-items-end mt-4 pt-2">
                            <div class="text-start small text-muted extra-small">
                                <span>معرف التوثيق بالمنصة: <br> 
                                <span class="text-secondary" id="liveVerifyCode"><?= isset($_GET['code']) ? htmlspecialchars($_GET['code']) : 'EDU-VERIFY-PENDING' ?></span></span>
                            </div>
                            
                            <div class="signature-stamp-box fw-bold text-center">
                                <i class="bi bi-patch-check-fill text-primary"></i> موقع ومؤكد بواسطة <br>
                                <span class="text-dark" id="liveOrgName"><?= htmlspecialchars($orgData['name'] ?? 'الجهة التدريبية الخارجية') ?></span> <br>
                                <small style="font-size: 0.65rem; font-weight: normal; color: gray;">ختم الكيان والمنشأة المعتمدة</small>
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
        const certHoursInput = document.getElementById('certHoursInput');
        const contentInput = document.getElementById('contentInput');

        const liveStudentName = document.getElementById('liveStudentName');
        const liveCertTitle = document.getElementById('liveCertTitle');
        const liveHours = document.getElementById('liveHours');
        const liveContentText = document.getElementById('liveContentText');

        studentSelect.addEventListener('change', function() {
            liveStudentName.textContent = this.options[this.selectedIndex].text;
        });

        certTitleInput.addEventListener('input', function() {
            liveCertTitle.textContent = this.value.trim() !== "" ? this.value : "شهادة رقمية معتمدة";
        });

        certHoursInput.addEventListener('input', function() {
            liveHours.textContent = this.value.trim() !== "" ? this.value : "0";
        });

        contentInput.addEventListener('input', function() {
            liveContentText.textContent = this.value.trim() !== "" ? this.value : "...";
        });
    </script>
</body>
</html>