<?php
// Redirect to a specific URL
function redirect($url) {
    header("Location: $url");
    exit();
}

// Sanitize user input
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Check if user is logged in
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Calculate PHQ-9 score (Depression assessment)
function calculate_phq9_score($answers) {
    $total = array_sum($answers);
    $result = [
        'score' => $total,
        'severity' => ''
    ];
    
    if ($total <= 4) {
        $result['severity'] = 'Minimal or no depression';
        $result['recommendation'] = 'Your score suggests minimal or no depression. Continue to monitor your mood.';
    } elseif ($total <= 9) {
        $result['severity'] = 'Mild depression';
        $result['recommendation'] = 'Your score suggests mild depression. Consider self-help strategies and monitor your symptoms.';
    } elseif ($total <= 14) {
        $result['severity'] = 'Moderate depression';
        $result['recommendation'] = 'Your score suggests moderate depression. Consider seeking professional help.';
    } elseif ($total <= 19) {
        $result['severity'] = 'Moderately severe depression';
        $result['recommendation'] = 'Your score suggests moderately severe depression. It is recommended to seek professional help.';
    } else {
        $result['severity'] = 'Severe depression';
        $result['recommendation'] = 'Your score suggests severe depression. It is strongly recommended to seek immediate professional help.';
    }
    
    return $result;
}

// Calculate GAD-7 score (Anxiety assessment)
function calculate_gad7_score($answers) {
    $total = array_sum($answers);
    $result = [
        'score' => $total,
        'severity' => ''
    ];
    
    if ($total <= 4) {
        $result['severity'] = 'Minimal anxiety';
        $result['recommendation'] = 'Your score suggests minimal anxiety.';
    } elseif ($total <= 9) {
        $result['severity'] = 'Mild anxiety';
        $result['recommendation'] = 'Your score suggests mild anxiety.';
    } elseif ($total <= 14) {
        $result['severity'] = 'Moderate anxiety';
        $result['recommendation'] = 'Your score suggests moderate anxiety. Consider seeking professional help.';
    } else {
        $result['severity'] = 'Severe anxiety';
        $result['recommendation'] = 'Your score suggests severe anxiety. It is recommended to seek professional help.';
    }
    
    return $result;
}
?>
