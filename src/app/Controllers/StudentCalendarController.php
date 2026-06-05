<?php

require_once __DIR__ . '/../Models/StudentModel.php'; 

class StudentCalendarController { 

    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'طالب') { 
            header('Location: /login'); 
            exit(); 
        }

        $studentId = $_SESSION['user_id'];
        
        global $db;
        $studentModel = new StudentModel($db);
        $eventsData = $studentModel->getCalendarEvents($studentId);

        $formattedEvents = [];
        foreach ($eventsData as $event) {
            $color = 'grey'; 
            
            if ($event['type'] == 'attendance') {
                $status = $event['Status'] ?? $event['status'] ?? '';
                $color = ($status == 'Present' || $status == 'حاضر') ? 'green' : 'red';
            } elseif ($event['type'] == 'report') {
                $color = 'blue';
            }

            $formattedEvents[] = [
                'title' => $event['title'],
                'start' => $event['event_date'],
                'backgroundColor' => $color,
                'borderColor' => $color,
                'textColor' => 'white', 
                'extendedProps' => [
                    'type' => $event['type'],
                    'description' => $event['description']
                ]
            ];
        }

        $eventsJson = json_encode($formattedEvents);

        require_once VIEW_PATH . '/student/student_interactive-calendar.php';
    }
}