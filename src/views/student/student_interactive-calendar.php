<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>التقويم التفاعلي | EduServe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/assets/img/logo.png">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    
    <style>
        body { 
            background-color: whitesmoke; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
        }
        
        #calendar { 
            background-color: white; 
            padding: 20px; 
            border-radius: 12px; 
            box-shadow: 0 4px 12px grey; 
            min-height: 600px;
        }

        .fc-event { 
            cursor: pointer; 
            border: none !important;
            padding: 2px 5px;
        }

        .fc-toolbar-title {
            font-size: 1.25rem !important;
            font-weight: bold;
            color: black;
        }

        #eventDetails {
            transition: all 0.3s ease;
            min-height: 150px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        
        .fc-button-primary {
            background-color: blue !important;
            border-color: blue !important;
        }
    </style>
</head>

<body>
<div class="container my-4">
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body p-4">
            <div class="d-flex align-items-center">
                <div class="bg-light p-3 rounded-3 me-3" style="border: 1px solid blue;">
                    <i class="bi bi-calendar-event fs-3" style="color: blue;"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-1" style="color: black;">التقويم التفاعلي</h4>
                    <p class="text-muted mb-0">تتبع سجلات الحضور، مواعيد تسليم التقارير، والفعاليات التدريبية.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-body">
                    <h6 class="fw-bold mb-3" style="color: black;"><i class="bi bi-funnel ms-2"></i>فلترة الأحداث</h6>
                    <select class="form-select" id="eventFilter">
                        <option value="all">كل الأحداث</option>
                        <option value="attendance">سجلات الحضور والغياب</option>
                        <option value="report">التقارير الميدانية</option>
                    </select>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold mb-3" style="color: black;"><i class="bi bi-info-circle ms-2"></i>تفاصيل الحدث</h6>
                    <div id="eventDetails" class="p-3 border rounded bg-white">
                        <div class="text-center text-muted">
                            <i class="bi bi-cursor-fill d-block fs-2 mb-2" style="color: grey;"></i>
                            <p class="small mb-0">اختر حدثاً من التقويم لعرض تفاصيله الكاملة هنا.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-3 px-2">
                <div class="d-flex align-items-center mb-2">
                    <span class="badge me-2" style="background-color: green; color: white;">&nbsp;</span> <small>حاضر (Present)</small>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <span class="badge me-2" style="background-color: red; color: white;">&nbsp;</span> <small>غائب (Absent)</small>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge me-2" style="background-color: blue; color: white;">&nbsp;</span> <small>تقرير (Report)</small>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div id="calendar"></div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var eventDetails = document.getElementById('eventDetails');
    
  
    var allEvents = <?php echo $eventsJson; ?>;

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'ar',
        direction: 'rtl',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek'
        },
        buttonText: {
            today: 'اليوم',
            month: 'شهر',
            week: 'أسبوع'
        },
        events: allEvents,
        
        
        eventClick: function(info) {
            var props = info.event.extendedProps;
            var eventColor = info.event.backgroundColor; 

            
            eventDetails.innerHTML = `
                <div>
                    <div class="d-flex align-items-center mb-2">
                        <div style="width: 5px; height: 20px; background-color: ${eventColor};" class="me-2 rounded"></div>
                        <h6 class="fw-bold mb-0" style="color: ${eventColor}">${info.event.title}</h6>
                    </div>
                    <p class="small mb-2" style="color: black;">
                        <i class="bi bi-clock me-1"></i> <b>التاريخ:</b> 
                        ${info.event.start.toLocaleDateString('ar-EG', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}
                    </p>
                    <div class="p-2 rounded bg-light" style="border: 1px solid grey;">
                        <small style="color: black;" class="d-block mb-1"><b>الوصف:</b></small>
                        <p class="small mb-0" style="color: black;">${props.description || 'لا توجد ملاحظات إضافية.'}</p>
                    </div>
                </div>
            `;
        }
    });

    calendar.render();

    document.getElementById('eventFilter').addEventListener('change', function() {
        var val = this.value;
        var filtered = (val === 'all') ? allEvents : allEvents.filter(e => e.extendedProps.type === val);
        
        calendar.removeAllEvents();
        calendar.addEventSource(filtered);
        
       
        eventDetails.innerHTML = `
            <div class="text-center text-muted">
                <i class="bi bi-cursor-fill d-block fs-2 mb-2" style="color: grey;"></i>
                <p class="small mb-0">اختر حدثاً من التقويم لعرض تفاصيله الكاملة هنا.</p>
            </div>
        `;
    });
});
</script>
</body>
</html>