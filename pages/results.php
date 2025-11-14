<?php
// Check if we have results to display
if (!isset($_SESSION['assessment_results'])) {
    header('Location: index.php?page=home');
    exit();
}

$results = $_SESSION['assessment_results'];
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h2 class="h4 mb-0">Assessment Results</h2>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h3><?php echo htmlspecialchars($results['assessment_name']); ?></h3>
                        <p class="text-muted">Completed on <?php echo date('F j, Y, g:i a', strtotime($results['timestamp'])); ?></p>
                    </div>
                    
                    <div class="result-summary text-center p-4 mb-4 rounded" style="background-color: #f8f9fa;">
                        <h4>Your Score: <strong><?php echo $results['total_score']; ?></strong></h4>
                        <div class="mt-3">
                            <span class="badge bg-<?php 
                                echo strpos(strtolower($results['severity']), 'severe') !== false ? 'danger' : 
                                    (strpos(strtolower($results['severity']), 'moderate') !== false ? 'warning' : 'success'); 
                            ?> p-3 fs-5">
                                <?php echo htmlspecialchars($results['severity']); ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="recommendation p-4 mb-4 rounded" style="background-color: #e7f5ff;">
                        <h5><i class="bi bi-lightbulb"></i> Recommendation</h5>
                        <p class="mb-0"><?php echo nl2br(htmlspecialchars($results['recommendation'])); ?></p>
                    </div>
                    
                    <div class="interpretation mb-4">
                        <h5>What This Means</h5>
                        <p>
                            Your score suggests that you may be experiencing 
                            <strong><?php echo strtolower($results['severity']); ?></strong> 
                            based on the <?php echo htmlspecialchars($results['assessment_name']); ?>.
                        </p>
                        
                        <?php if ($results['assessment_name'] === 'PHQ-9 Depression Assessment'): ?>
                            <p>
                                The PHQ-9 is a multipurpose instrument for screening, diagnosing, monitoring, and measuring 
                                the severity of depression. It's important to note that this is not a diagnosis, but a 
                                screening tool that can indicate whether you might need professional help.
                            </p>
                        <?php else: ?>
                            <p>
                                The GAD-7 is a brief self-report scale used to screen for and measure the severity of 
                                generalized anxiety disorder. While it's a useful screening tool, it's not a substitute 
                                for a professional diagnosis.
                            </p>
                        <?php endif; ?>
                    </div>
                    
                    <div class="next-steps">
                        <h5>Next Steps</h5>
                        <ul class="list-group mb-4">
                            <?php if (strpos(strtolower($results['severity']), 'severe') !== false || 
                                     strpos(strtolower($results['severity']), 'moderate') !== false): ?>
                                <li class="list-group-item list-group-item-danger">
                                    <strong>Consider seeking professional help:</strong> Your results suggest that you may benefit from 
                                    speaking with a mental health professional. They can provide a proper assessment and 
                                    discuss treatment options with you.
                                </li>
                            <?php endif; ?>
                            
                            <li class="list-group-item">
                                <strong>Monitor your symptoms:</strong> Keep track of how you're feeling over time. 
                                Consider taking this assessment again in a few weeks to see if there are any changes.
                            </li>
                            
                            <li class="list-group-item">
                                <strong>Explore self-help resources:</strong> Visit our 
                                <a href="index.php?page=resources">resources page</a> for information and tools that 
                                may help you manage your mental health.
                            </li>
                            
                            <?php if (!is_logged_in()): ?>
                                <li class="list-group-item">
                                    <strong>Create an account:</strong> 
                                    <a href="index.php?page=register">Register</a> to save your assessment results 
                                    and track your progress over time.
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    
                    <div class="disclaimer alert alert-warning">
                        <h6>Important Disclaimer</h6>
                        <p class="mb-0">
                            This assessment is not a substitute for professional medical advice, diagnosis, or treatment. 
                            If you're in crisis or think you may have a medical emergency, call your doctor or your local 
                            emergency number immediately.
                        </p>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4">
                        <a href="index.php?page=home" class="btn btn-outline-secondary">
                            <i class="bi bi-house-door"></i> Return Home
                        </a>
                        <div>
                            <a href="index.php?page=assessment&type=<?php 
                                echo $results['assessment_name'] === 'PHQ-9 Depression Assessment' ? 'phq9' : 'gad7'; 
                            ?>" class="btn btn-outline-primary me-2">
                                <i class="bi bi-arrow-clockwise"></i> Retake Assessment
                            </a>
                            <a href="index.php?page=resources" class="btn btn-primary">
                                <i class="bi bi-book"></i> View Resources
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Clear the results from session so they're not shown again on page refresh
unset($_SESSION['assessment_results']);
?>
