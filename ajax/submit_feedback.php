<?php
require_once '../class/connection.php';
header('Content-Type: application/json');

// Utility function for logging errors
function logError($error, $context = []) {
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[{$timestamp}] ERROR: " . $error->getMessage() . PHP_EOL;
    $logMessage .= "File: " . $error->getFile() . " (Line: " . $error->getLine() . ")" . PHP_EOL;
    
    if (!empty($_POST)) {
        $sanitizedPost = array_map(function($value) {
            return is_string($value) ? htmlspecialchars($value) : $value;
        }, $_POST);
        $logMessage .= "POST Data (sanitized):" . PHP_EOL;
        $logMessage .= json_encode($sanitizedPost, JSON_PRETTY_PRINT) . PHP_EOL;
    }

    $logMessage .= str_repeat('-', 80) . PHP_EOL;
    error_log($logMessage, 3, __DIR__ . '/feedback_errors.log');
}

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    if (!isset($_POST['feedback_category'])) {
        throw new Exception('Feedback category is required');
    }

    $connect->beginTransaction();

    switch ($_POST['feedback_category']) {
        case 'office':
            // Validate office feedback required fields
            $requiredOfficeFields = [
                'client_type',
                'date',
                'age',
                'sex',
                'office',
                'service',
                'cc_awareness',
                'cc_visibility',    // Added new CC field
                'cc_helpfulness',   // Added new CC field
                'sqd0',
                'sqd1',
                'sqd2',
                'sqd3',
                'sqd4',
                'sqd5',
                'sqd6',
                'sqd7',
                'sqd8'
            ];
            foreach ($requiredOfficeFields as $field) {
                if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
                    throw new Exception("Missing required field: $field");
                }
            }

            // Insert office feedback
            $query = "INSERT INTO office_feedback (
                client_type, feedback_date, age, sex, office_name, service_name,
                cc_awareness, cc_visibility, cc_helpfulness, sqd0_satisfaction, sqd1_time, sqd2_requirements,
                sqd3_steps, sqd4_information, sqd5_value, sqd6_security,
                sqd7_support, sqd8_outcome, improvements, email, name
            ) VALUES (
                :client_type, :feedback_date, :age, :sex, :office_name, :service_name,
                :cc_awareness, :cc_visibility, :cc_helpfulness, :sqd0, :sqd1, :sqd2, :sqd3, :sqd4, :sqd5, :sqd6,
                :sqd7, :sqd8, :improvements, :email, :name
            )";
            
            $stmt = $connect->prepare($query);
            $params = [
                ':client_type' => htmlspecialchars($_POST['client_type']),
                ':feedback_date' => date('Y-m-d', strtotime($_POST['date'])),
                ':age' => filter_var($_POST['age'], FILTER_VALIDATE_INT),
                ':sex' => htmlspecialchars($_POST['sex']),
                ':office_name' => htmlspecialchars($_POST['office']),
                ':service_name' => htmlspecialchars($_POST['service']),
                ':cc_awareness' => htmlspecialchars($_POST['cc_awareness']),
                ':cc_visibility' => htmlspecialchars($_POST['cc_visibility']),    // Added new CC parameter
                ':cc_helpfulness' => htmlspecialchars($_POST['cc_helpfulness']),  // Added new CC parameter
                ':sqd0' => filter_var($_POST['sqd0'], FILTER_VALIDATE_INT),
                ':sqd1' => filter_var($_POST['sqd1'], FILTER_VALIDATE_INT),
                ':sqd2' => filter_var($_POST['sqd2'], FILTER_VALIDATE_INT),
                ':sqd3' => filter_var($_POST['sqd3'], FILTER_VALIDATE_INT),
                ':sqd4' => filter_var($_POST['sqd4'], FILTER_VALIDATE_INT),
                ':sqd5' => filter_var($_POST['sqd5'], FILTER_VALIDATE_INT),
                ':sqd6' => filter_var($_POST['sqd6'], FILTER_VALIDATE_INT),
                ':sqd7' => filter_var($_POST['sqd7'], FILTER_VALIDATE_INT),
                ':sqd8' => filter_var($_POST['sqd8'], FILTER_VALIDATE_INT),
                ':improvements' => htmlspecialchars($_POST['improvements'] ?? ''),
                ':email' => filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL),
                ':name' => htmlspecialchars($_POST['name'] ?? '')
            ];

            if (!$stmt->execute($params)) {
                throw new Exception("Error saving office feedback");
            }

            $connect->commit();
            echo json_encode([
                'success' => true,
                'message' => 'Office feedback submitted successfully'
            ]);
            break;

        case 'org':
            // Validate required org feedback fields first
            $requiredOrgFields = [
                'organization',
                'event_quality',
                'org_communication',
                'inclusivity',
                'leadership',
                'skill_dev',
                'impact'
            ];

            foreach ($requiredOrgFields as $field) {
                if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
                    throw new Exception("Missing required field: $field");
                }
            }

            // Check if event evaluation is included
            $isEventEvaluation = isset($_POST['evaluate_event']) && $_POST['evaluate_event'] === '1';

            // If event evaluation is checked, validate event fields
            if ($isEventEvaluation) {
                $requiredEventFields = [
                    'activity_title',
                    'activity_date',
                    'student_org',
                    'video_quality',
                    'audio_quality',
                    'mastery_rating',
                    'time_management',
                    'methodologies',
                    'conduct',
                    'topic_informative',
                    'activity_relevance',
                    'comments_suggestions'
                ];

                foreach ($requiredEventFields as $field) {
                    if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
                        throw new Exception("Missing required event field: $field");
                    }
                }
            }

            // Insert organization feedback
            $orgQuery = "INSERT INTO org_feedback (
                org_id,
                event_quality_rating,
                communication_rating,
                inclusivity_rating,
                leadership_rating,
                skill_dev_rating,
                impact_rating,
                improvements,
                email,
                name
            ) VALUES (
                :org_id,
                :event_quality,
                :communication,
                :inclusivity,
                :leadership,
                :skill_dev,
                :impact,
                :improvements,
                :email,
                :name
            )";

            $stmt = $connect->prepare($orgQuery);
            $orgParams = [
                ':org_id' => filter_var($_POST['organization'], FILTER_VALIDATE_INT),
                ':event_quality' => filter_var($_POST['event_quality'], FILTER_VALIDATE_INT),
                ':communication' => filter_var($_POST['org_communication'], FILTER_VALIDATE_INT),
                ':inclusivity' => filter_var($_POST['inclusivity'], FILTER_VALIDATE_INT),
                ':leadership' => filter_var($_POST['leadership'], FILTER_VALIDATE_INT),
                ':skill_dev' => filter_var($_POST['skill_dev'], FILTER_VALIDATE_INT),
                ':impact' => filter_var($_POST['impact'], FILTER_VALIDATE_INT),
                ':improvements' => $_POST['improvements'] ?? null,
                ':email' => filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL),
                ':name' => $_POST['name'] ?? null
            ];

            if (!$stmt->execute($orgParams)) {
                throw new Exception("Error saving organization feedback");
            }

            $orgFeedbackId = $connect->lastInsertId();

            // If event evaluation is checked, save event feedback
            if ($isEventEvaluation) {
                $eventQuery = "INSERT INTO event_feedback (
                    organization_id,
                    activity_title,
                    activity_date,
                    venue,
                    participant_name,
                    participant_email,
                    student_org,
                    position,
                    video_quality,
                    audio_quality,
                    mastery_rating,
                    time_management,
                    methodologies,
                    conduct,
                    topic_informative,
                    activity_relevance,
                    comments_suggestions
                ) VALUES (
                    :organization_id,
                    :activity_title,
                    :activity_date,
                    :venue,
                    :participant_name,
                    :participant_email,
                    :student_org,
                    :position,
                    :video_quality,
                    :audio_quality,
                    :mastery_rating,
                    :time_management,
                    :methodologies,
                    :conduct,
                    :topic_informative,
                    :activity_relevance,
                    :comments_suggestions
                )";

                $stmt = $connect->prepare($eventQuery);
                $eventParams = [
                    ':organization_id' => filter_var($_POST['organization'], FILTER_VALIDATE_INT),
                    ':activity_title' => $_POST['activity_title'],
                    ':activity_date' => $_POST['activity_date'],
                    ':venue' => $_POST['venue'] ?? null,
                    ':participant_name' => $_POST['name'] ?? null,
                    ':participant_email' => filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL),
                    ':student_org' => $_POST['student_org'],
                    ':position' => $_POST['position'] ?? null,
                    ':video_quality' => filter_var($_POST['video_quality'], FILTER_VALIDATE_INT),
                    ':audio_quality' => filter_var($_POST['audio_quality'], FILTER_VALIDATE_INT),
                    ':mastery_rating' => filter_var($_POST['mastery_rating'], FILTER_VALIDATE_INT),
                    ':time_management' => filter_var($_POST['time_management'], FILTER_VALIDATE_INT),
                    ':methodologies' => $_POST['methodologies'],
                    ':conduct' => filter_var($_POST['conduct'], FILTER_VALIDATE_INT),
                    ':topic_informative' => filter_var($_POST['topic_informative'], FILTER_VALIDATE_INT),
                    ':activity_relevance' => filter_var($_POST['activity_relevance'], FILTER_VALIDATE_INT),
                    ':comments_suggestions' => $_POST['comments_suggestions']
                ];

                if (!$stmt->execute($eventParams)) {
                    throw new Exception("Error saving event feedback");
                }
            }

            $connect->commit();
            echo json_encode([
                'success' => true,
                'message' => 'Feedback submitted successfully',
                'org_feedback_id' => $orgFeedbackId,
                'has_event_feedback' => $isEventEvaluation
            ]);
            break;

        default:
            throw new Exception('Invalid feedback category');
    }

} catch (Exception $e) {
    if ($connect && $connect->inTransaction()) {
        $connect->rollBack();
    }

    logError($e, 'Feedback submission error');

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}