<?php

class StudentCalendarController extends Controller {

    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') { 
            header('Location: /login'); 
            exit(); 
        }

        $studentId = $_SESSION['user_id'];
        
        
        $studentModel = $this->model('StudentModel');
        $eventsData = $studentModel->getCalendarEvents($studentId);

        $formattedEvents = [];
        foreach ($eventsData as $event) {
            
            
            $color = 'grey'; 
            
            if ($event['type'] == 'attendance') {
               
                $status = $event['Status'] ?? $event['status'] ?? '';
                
                
                $color = ($status == 'Present') ? 'green' : 'red';
                
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

        
        $this->view('student/student_interactive-calendar', [
            'eventsJson' => json_encode($formattedEvents)
        ]);
    }
}