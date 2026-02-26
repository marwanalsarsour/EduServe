<?php
//هاد بينشال بس عشان تبين الصفحة منيحة بدون اخطاء
if (!isset($data)) {
    $data = [
        'student' => [
            'name' => 'تامر زيدان القاضي',
            'university_id' => '221144',
            'major' => 'علم الحاسوب',
            'email' => 'tamer@example.com',
            'phone' => '0599000000',
            'portfolio_link' => 'https://github.com/tamer',
            'transcript_file' => 'transcript.pdf',
            'hours_approved' => 45,
            'reports_count' => 3
        ],
        'student_reports' => [
            ['title' => 'تقرير الأسبوع الأول', 'status' => 'مقبول', 'status_color' => 'success'],
            ['title' => 'تقرير الأسبوع الثاني', 'status' => 'قيد المراجعة', 'status_color' => 'warning'],
        ]
    ];
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ملف الطالب الأكاديمي</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100">
    <?php 
    require_once '../layout/header.php'; 
    ?>

    <div class="container my-4">
        <div class="row">
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 text-center p-4 mb-4">
                    <div class="mb-3">
                        <i class="bi bi-person-circle display-1 text-secondary"></i>
                    </div>
                    <h4 class="fw-bold"><?= $data['student']['name'] ?></h4>
                    <p class="text-muted">الرقم الجامعي: <?= $data['student']['university_id'] ?></p>
                    <span class="badge bg-info p-2 text-dark"><?= $data['student']['major'] ?></span>
                </div>

                <div class="card shadow-sm border-0 p-3">
                    <h6 class="fw-bold border-bottom pb-2">معلومات التواصل</h6>
                    <p class="small mb-1"><i class="bi bi-envelope ms-2"></i><?= $data['student']['email'] ?></p>
                    <p class="small mb-0"><i class="bi bi-telephone ms-2"></i><?= $data['student']['phone'] ?></p>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h5 class="fw-bold mb-4">الملف الرقمي والوثائق (Portfolio)</h5>
                        
                        <div class="mb-4">
                            <label class="text-muted small">رابط أعمال الطالب / LinkedIn:</label>
                            <div class="mt-2">
                                <a href="<?= $data['student']['portfolio_link'] ?>" target="_blank" class="btn btn-outline-primary w-100 text-start">
                                    <i class="bi bi-link-45deg ms-2"></i> زيارة رابط الملف الشخصي
                                </a>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="text-muted small">السجل الأكاديمي (PDF):</label>
                            <div class="d-flex align-items-center p-3 border rounded mt-2 bg-white">
                                <i class="bi bi-file-earmark-pdf text-danger fs-3 ms-3"></i>
                                <div class="flex-grow-1">
                                    <div class="fw-bold small">academic_transcript.pdf</div>
                                    <div class="text-muted" style="font-size: 10px;">تم الرفع بتاريخ: 2025/12/20</div>
                                </div>
                                <a href="#" class="btn btn-sm btn-dark">عرض الملف</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white fw-bold">آخر التقارير المرفوعة</div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <?php foreach($data['student_reports'] as $report): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <?= $report['title'] ?>
                                <span class="badge bg-<?= $report['status_color'] ?>"><?= $report['status'] ?></span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>