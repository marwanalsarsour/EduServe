<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>التقييم النهائي</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
</head>
<body class="bg-light">
    <?php require_once '../layout/header.php'; ?>

    <div class="container my-5">
        <div class="card border-0 shadow-sm mx-auto" style="max-width: 600px;">
            <div class="card-header bg-dark text-white p-3">
                <h5 class="mb-0 fw-bold">التقييم الأكاديمي النهائي</h5>
            </div>
            <div class="card-body p-4 text-start">
                <form action="volunteer_process.php" method="POST">
                    <div class="mb-4">
                        <label class="form-label fw-bold">اختيار الطالب</label>
                        <select class="form-select border-primary shadow-sm"><option>محمد يوسف - 20211100</option></select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">الدرجة النهائية أو التقدير</label>
                        <input type="text" class="form-control" placeholder="ناجح / ممتاز / 100">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">توصيات المشرف الأكاديمي</label>
                        <textarea class="form-control" rows="3"></textarea>
                    </div>
                    <button class="btn btn-success w-100 py-2 fw-bold">اعتماد النتيجة النهائية</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>