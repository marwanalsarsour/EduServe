<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>التقييم النهائي | EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
</head>
<body class="bg-light">
    <?php require_once BASE_PATH . '/views/layout/header.php'; ?>

    <div class="container my-5">
        <div class="card border-0 shadow-sm mx-auto" style="max-width: 600px;">
            <div class="card-header bg-dark text-white p-3 text-center">
                <h5 class="mb-0 fw-bold">التقييم الأكاديمي النهائي</h5>
            </div>
            <div class="card-body p-4 text-end">
                <form action="/volunteer_submit_grading" method="POST">
                    <div class="mb-4">
                        <label class="form-label fw-bold">اختيار الطالب</label>
                        <select name="application_id" class="form-select border-primary shadow-sm" required>
                            <option value="">-- اختر الطالب --</option>
                            <?php foreach($students as $student): ?>
                                <option value="<?= $student['application_id'] ?>">
                                    <?= htmlspecialchars($student['student_name']) ?> - <?= $student['student_id_number'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">الدرجة النهائية أو التقدير</label>
                        <input type="text" name="grade" class="form-control" placeholder="ناجح / ممتاز / 100" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">توصيات المشرف الأكاديمي</label>
                        <textarea name="recommendations" class="form-control" rows="3" placeholder="اكتب توصياتك هنا..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-success w-100 py-2 fw-bold">اعتماد النتيجة النهائية</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>