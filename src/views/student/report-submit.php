<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رفع تقرير</title>
    <link rel="icon" type="image/png" href="../../assets/img/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light d-flex flex-column min-vh-100">

    <div class="container py-4 ">

        <h4 class="fw-bold mb-4 mt-4">
            <i class="bi bi-upload ms-2"></i>
            رفع تقرير
        </h4>

        <div id="submitMsg" class="alert d-none"></div>

        <div class="card shadow-sm border-0">
            <div class="card-body">

                <form id="reportForm">

                    <div class="mb-3">
                        <label class="form-label">عنوان التقرير</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">رفع الملف</label>
                        <input type="file" class="form-control" name="file" accept=".pdf,.doc,.docx" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ملاحظات إضافية</label>
                        <textarea class="form-control" name="notes" rows="4"
                            placeholder="اكتب ملاحظاتك هنا..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-send ms-1"></i>
                        إرسال التقرير
                    </button>

                    <a href="reports.html" class="btn btn-primary">
                        <i class="bi bi-box-arrow-left"></i> رجوع
                    </a>

                </form>

            </div>
        </div>

    </div>

</body>

</html>