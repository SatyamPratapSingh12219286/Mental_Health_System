<?php
$assessment_type = isset($_GET['type']) ? $_GET['type'] : '';
$valid_types = ['phq9', 'gad7'];

if (!in_array($assessment_type, $valid_types)) {
    header('Location: index.php?page=home');
    exit();
}

$assessment_data = [];
$title = '';
$description = '';

if ($assessment_type === 'phq9') {
    $title = 'PHQ-9 Depression Assessment';
    $description = 'Over the last 2 weeks, how often have you been bothered by any of the following problems?';
    $questions = [
        'Little interest or pleasure in doing things',
        'Feeling down, depressed, or hopeless',
        'Trouble falling or staying asleep, or sleeping too much',
        'Feeling tired or having little energy',
        'Poor appetite or overeating',
        'Feeling bad about yourself - or that you are a failure or have let yourself or your family down',
        'Trouble concentrating on things, such as reading the newspaper or watching television',
        'Moving or speaking so slowly that other people could have noticed. Or the opposite - being so fidgety or restless that you have been moving around a lot more than usual',
        'Thoughts that you would be better off dead or of hurting yourself in some way'
    ];
} else {
    $title = 'GAD-7 Anxiety Assessment';
    $description = 'Over the last 2 weeks, how often have you been bothered by the following problems?';
    $questions = [
        'Feeling nervous, anxious, or on edge',
        'Not being able to stop or control worrying',
        'Worrying too much about different things',
        'Trouble relaxing',
        'Being so restless that it is hard to sit still',
        'Becoming easily annoyed or irritable',
        'Feeling afraid as if something awful might happen'
    ];
}
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="h4 mb-0"><?php echo htmlspecialchars($title); ?></h2>
                </div>
                <div class="card-body">
                    <p class="lead"><?php echo htmlspecialchars($description); ?></p>
                    <p class="text-muted">For each item, please indicate how often you have been bothered by that problem over the past 2 weeks.</p>
                    
                    <form id="assessmentForm" action="process_assessment.php" method="post">
                        <input type="hidden" name="assessment_type" value="<?php echo htmlspecialchars($assessment_type); ?>">
                        
                        <div class="questions-container">
                            <?php foreach ($questions as $index => $question): ?>
                                <div class="question-item mb-4 p-3 border rounded" data-question-index="<?php echo $index; ?>">
                                    <p class="question-text fw-bold"><?php echo ($index + 1) . '. ' . htmlspecialchars($question); ?></p>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="answers[<?php echo $index; ?>]" id="q<?php echo $index; ?>_0" value="0" required>
                                        <label class="form-check-label" for="q<?php echo $index; ?>_0">
                                            Not at all
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="answers[<?php echo $index; ?>]" id="q<?php echo $index; ?>_1" value="1">
                                        <label class="form-check-label" for="q<?php echo $index; ?>_1">
                                            Several days
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="answers[<?php echo $index; ?>]" id="q<?php echo $index; ?>_2" value="2">
                                        <label class="form-check-label" for="q<?php echo $index; ?>_2">
                                            More than half the days
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="answers[<?php echo $index; ?>]" id="q<?php echo $index; ?>_3" value="3">
                                        <label class="form-check-label" for="q<?php echo $index; ?>_3">
                                            Nearly every day
                                        </label>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Submit Assessment</button>
                            <a href="index.php?page=home" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('assessmentForm').addEventListener('submit', function(e) {
    // Additional client-side validation can be added here
    const allAnswered = Array.from(document.querySelectorAll('.question-item')).every(question => {
        return question.querySelector('input[type="radio"]:checked') !== null;
    });
    
    if (!allAnswered) {
        e.preventDefault();
        alert('Please answer all questions before submitting.');
    }
});
</script>
