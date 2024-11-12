<!DOCTYPE html>
<html>
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <style>
        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .modal-header {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 1.5rem;
        }

        .modal-title {
            font-weight: 600;
            margin: 0;
        }

        .progress-steps {
            display: flex;
            justify-content: center;
            padding: 1.5rem 0;
            background-color: #f8f9fa;
        }

        .step-indicator {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 1rem;
            position: relative;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .step-indicator.active {
            background-color: #6366f1;
            color: white;
        }

        .step-indicator:not(:last-child)::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 3px;
            background-color: #e9ecef;
            right: -100%;
            top: 50%;
            transform: translateY(-50%);
        }

        .emoji-rating {
            display: flex;
            justify-content: space-around;
            padding: 2rem 0;
        }

        .emoji-select {
            font-size: 2.5rem;
            cursor: pointer;
            transition: transform 0.2s;
            opacity: 0.5;
        }

        .emoji-select:hover {
            transform: scale(1.2);
            opacity: 1;
        }

        .emoji-select.selected {
            opacity: 1;
            transform: scale(1.1);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 500;
            color: #4b5563;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border-radius: 8px;
            padding: 0.75rem;
            border: 1px solid #e5e7eb;
        }

        .form-control:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .radio-group {
            display: grid;
            gap: 0.75rem;
            padding: 0.5rem 0;
        }

        .radio-option {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            border-radius: 8px;
            background-color: #f8f9fa;
            cursor: pointer;
            transition: all 0.2s;
        }

        .radio-option:hover {
            background-color: #e9ecef;
        }

        .radio-option input {
            margin-right: 0.75rem;
        }

        .step {
            display: none;
            animation: fadeIn 0.5s ease;
        }

        .step.active {
            display: block;
        }

        .modal-footer {
            border-top: 1px solid #e5e7eb;
            padding: 1.25rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-primary {
            background-color: #6366f1;
            border-color: #6366f1;
        }

        .btn-primary:hover {
            background-color: #4f46e5;
            border-color: #4f46e5;
        }

        .btn-success {
            background-color: #10b981;
            border-color: #10b981;
        }

        .btn-success:hover {
            background-color: #059669;
            border-color: #059669;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary m-3" data-bs-toggle="modal" data-bs-target="#feedbackModal">
        Open Feedback Form
    </button>

    <!-- Feedback Modal -->
    <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Share Your Feedback</h3>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="progress-steps">
                    <div class="step-indicator active">1</div>
                    <div class="step-indicator">2</div>
                    <div class="step-indicator">3</div>
                </div>

                <div class="modal-body">
                    <form id="feedbackForm" enctype="multipart/form-data">
                        <div class="step active" id="step1">
                            <h4 class="text-center mb-4">How would you rate your experience?</h4>
                            <div class="emoji-rating">
                                <span class="emoji-select" data-value="1" title="Very Dissatisfied">😠</span>
                                <span class="emoji-select" data-value="2" title="Dissatisfied">😞</span>
                                <span class="emoji-select" data-value="3" title="Neutral">😐</span>
                                <span class="emoji-select" data-value="4" title="Satisfied">😊</span>
                                <span class="emoji-select" data-value="5" title="Very Satisfied">😍</span>
                            </div>
                        </div>

                        <div class="step" id="step2">
                            <div class="form-group">
                                <label class="form-label">Email address *</label>
                                <input type="email" class="form-control" required placeholder="Enter your email">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Name (optional)</label>
                                <input type="text" class="form-control" placeholder="Enter your name">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Course *</label>
                                <div class="radio-group">
                                    <label class="radio-option">
                                        <input type="radio" name="course" value="is" required>
                                        Information Systems
                                    </label>
                                    <label class="radio-option">
                                        <input type="radio" name="course" value="it">
                                        Information Technology
                                    </label>
                                    <label class="radio-option">
                                        <input type="radio" name="course" value="cs">
                                        Computer Science
                                    </label>
                                    <label class="radio-option">
                                        <input type="radio" name="course" value="other">
                                        Other / From Other College
                                    </label>
                                </div>
                            </div>

                            <div class="form-group mb-0">
                                <label class="form-label">Year Level *</label>
                                <div class="radio-group">
                                    <label class="radio-option">
                                        <input type="radio" name="year" value="1" required>
                                        1st Year
                                    </label>
                                    <label class="radio-option">
                                        <input type="radio" name="year" value="2">
                                        2nd Year
                                    </label>
                                    <label class="radio-option">
                                        <input type="radio" name="year" value="3">
                                        3rd Year
                                    </label>
                                    <label class="radio-option">
                                        <input type="radio" name="year" value="4">
                                        4th Year
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="step" id="step3">
                            <div class="form-group">
                                <label class="form-label">Attach Screenshot (optional)</label>
                                <input type="file" class="form-control" accept="image/*">
                            </div>

                            <div class="form-group mb-0">
                                <label class="form-label">Additional Comments</label>
                                <textarea class="form-control" rows="4" placeholder="Share your thoughts with us..."></textarea>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="previousBtn" disabled>Previous</button>
                    <button type="button" class="btn btn-primary" id="nextBtn">Next</button>
                    <button type="submit" class="btn btn-success" id="submitBtn" style="display:none;">Submit Feedback</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const steps = document.querySelectorAll('.step');
            const indicators = document.querySelectorAll('.step-indicator');
            const nextBtn = document.getElementById('nextBtn');
            const prevBtn = document.getElementById('previousBtn');
            const submitBtn = document.getElementById('submitBtn');
            const emojis = document.querySelectorAll('.emoji-select');
            let currentStep = 0;

            // Emoji selection
            emojis.forEach(emoji => {
                emoji.addEventListener('click', function() {
                    emojis.forEach(e => e.classList.remove('selected'));
                    this.classList.add('selected');
                });
            });

            // Navigation
            function updateSteps() {
                steps.forEach((step, index) => {
                    step.classList.toggle('active', index === currentStep);
                });
                
                indicators.forEach((indicator, index) => {
                    indicator.classList.toggle('active', index <= currentStep);
                });

                prevBtn.disabled = currentStep === 0;
                
                if (currentStep === steps.length - 1) {
                    nextBtn.style.display = 'none';
                    submitBtn.style.display = 'block';
                } else {
                    nextBtn.style.display = 'block';
                    submitBtn.style.display = 'none';
                }
            }

            nextBtn.addEventListener('click', () => {
                if (currentStep < steps.length - 1) {
                    currentStep++;
                    updateSteps();
                }
            });

            prevBtn.addEventListener('click', () => {
                if (currentStep > 0) {
                    currentStep--;
                    updateSteps();
                }
            });

            // Form submission
            submitBtn.addEventListener('click', (e) => {
                e.preventDefault();
                // Add your form submission logic here
                alert('Thank you for your feedback!');
                const modal = bootstrap.Modal.getInstance(document.getElementById('feedbackModal'));
                modal.hide();
            });
        });
    </script>
</body>
</html>