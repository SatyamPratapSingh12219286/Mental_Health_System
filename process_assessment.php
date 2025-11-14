<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $assessment_type = isset($_POST['assessment_type']) ? $_POST['assessment_type'] : '';
    $answers = isset($_POST['answers']) ? $_POST['answers'] : [];
    
    // Validate input
    if (empty($assessment_type) || empty($answers)) {
        $_SESSION['error'] = 'Invalid assessment data. Please try again.';
        header('Location: index.php?page=home');
        exit();
    }
    
    // Convert answers to integers and calculate score
    $answers = array_map('intval', $answers);
    $total_score = array_sum($answers);
    
    // Calculate results based on assessment type
    if ($assessment_type === 'phq9') {
        $result = calculate_phq9_score($answers);
        $severity = $result['severity'];
        $recommendation = $result['recommendation'];
        $assessment_name = 'PHQ-9 Depression Assessment';
    } else { // gad7
        $result = calculate_gad7_score($answers);
        $severity = $result['severity'];
        $recommendation = $result['recommendation'];
        $assessment_name = 'GAD-7 Anxiety Assessment';
    }
    
    // Store results in session for display
    $_SESSION['assessment_results'] = [
        'assessment_name' => $assessment_name,
        'total_score' => $total_score,
        'severity' => $severity,
        'recommendation' => $recommendation,
        'timestamp' => date('Y-m-d H:i:s')
    ];
    
    // Store in database if user is logged in
    if (is_logged_in()) {
        try {
            $user_id = $_SESSION['user_id'];
            $stmt = $pdo->prepare("
                INSERT INTO assessment_results 
                (user_id, assessment_type, score, severity, recommendation, created_at) 
                VALUES (?, ?, ?, ?, ?, NOW())
            ");
            
            $stmt->execute([
                $user_id,
                $assessment_type,
                $total_score,
                $severity,
                $recommendation
            ]);
            
        } catch (PDOException $e) {
            // Log error but continue to show results
            $error_message = "Error saving assessment results: " . $e->getMessage();
            error_log($error_message);
        }
    }
    
    // Redirect to results page
    header('Location: index.php?page=results');
    exit();
    
}  else {
    // If someone tries to access this page directly without submitting the form
    header('Location: index.php?page=home');
    exit();
}
?>
