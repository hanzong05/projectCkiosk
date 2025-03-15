
<section id="feed" class="feedback-section remove-padding-sm content-section bg-light py-5">   
    <div class="section-heading text-center borderYellow">
        <h1 class="pt-16 pb-8">
            <em class="text-4xl font-bold text-gray-800">FEEDBACKS</em>
        </h1>
        <div class="w-24 h-1 bg-yellow-400 mx-auto mb-12"></div>
    </div>  
    <br>  
    <div class="feedback-container">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">👥</div>
                <div class="stat-info">
                    <h3>Organization Feedbacks</h3>
                    <p id="total-feedback">0</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🏢</div>
                <div class="stat-info">
                    <h3>Office Feedbacks</h3>
                    <p id="average-rating">0</p>
                </div>
            </div>
        </div>
        <div class="main-card">
            <div class="card-header">
                <button class="submit-btn" data-bs-toggle="modal" data-bs-target="#feedbackModal">
                    ✉️ Submit Feedback
                </button>
            </div>
        </div>
    </div>
</section>

        

<style>
        .progress-steps {
            display: flex;
            justify-content: center;
            gap: 2rem;
            padding: 1rem;
            background: #f8f9fa;
        }

        .step-indicator {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #dee2e6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        .step-indicator.active {
            background: #0d6efd;
        }

        .step {
            display: none;
        }

        .step.active {
            display: block;
        }

        .feedback-category-card {
            cursor: pointer;
            transition: transform 0.2s;
            border: 2px solid transparent;
        }

        .feedback-category-card:hover {
            transform: translateY(-5px);
        }

        .feedback-category-card.selected {
            border-color: #0d6efd;
        }

        .rating-group {
            display: flex;
            justify-content: space-between;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 0.5rem;
            margin: 0.5rem 0;
        }

        .rating-option {
            text-align: center;
        }

        .rating-option input[type="radio"] {
            display: none;
        }

        .rating-option label {
            display: block;
            padding: 0.5rem 1rem;
            cursor: pointer;
            border-radius: 0.25rem;
            transition: background-color 0.2s;
        }

        .rating-option input[type="radio"]:checked + label {
            background-color: #0d6efd;
            color: white;
        }

        .question-block {
            margin-bottom: 2rem;
            padding: 1rem;
            border-radius: 0.5rem;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .modal-body {
            max-height: 70vh;
            overflow-y: auto;
        }
    </style>

    <div class="modal fade" id="feedbackModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h3 class="modal-title">Share Your Feedback</h3>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="progress-steps">
                    <div class="step-indicator active">1</div>
                    <div class="step-indicator">2</div>
                    <div class="step-indicator">3</div>
                </div>

                <div class="modal-body">
                    <form id="feedbackForm">
                        <!-- Step 1: Category Selection -->
                        <div class="step active" id="step1">
                            <h4 class="text-center mb-4">What would you like to give feedback about?</h4>
                            <div class="d-flex justify-content-center gap-4">
                                <div class="card feedback-category-card" data-category="office">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Office Processes</h5>
                                        <p class="card-text">Administrative and school-related processes</p>
                                        <input type="radio" name="feedback_category" value="office" class="btn-check" id="officeBtn">
                                        <label class="btn btn-outline-primary w-100" for="officeBtn">Select</label>
                                    </div>
                                </div>
                                <div class="card feedback-category-card" data-category="org">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Student Organizations</h5>
                                        <p class="card-text">Feedback for student organizations</p>
                                        <input type="radio" name="feedback_category" value="org" class="btn-check" id="orgBtn">
                                        <label class="btn btn-outline-primary w-100" for="orgBtn">Select</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Category-Specific Questions -->
                        <div class="step" id="step2">
                            <!-- Office Processes Questions -->
                            <div id="officeQuestions" style="display: none;">
                                <h4 class="text-center mb-4">Campus Office Processes Evaluation</h4>
                                
                                <!-- Question 1: Efficiency -->
                                <div class="question-block">
                                    <h5>1. Efficiency</h5>
                                    <p class="text-muted">How quickly were your requests handled?</p>
                                    <div class="rating-group">
                                        <div class="rating-option">
                                            <input type="radio" name="efficiency" id="eff1" value="1">
                                            <label for="eff1">1<br>Poor</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="efficiency" id="eff2" value="2">
                                            <label for="eff2">2<br>Fair</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="efficiency" id="eff3" value="3">
                                            <label for="eff3">3<br>Good</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="efficiency" id="eff4" value="4">
                                            <label for="eff4">4<br>Very Good</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="efficiency" id="eff5" value="5">
                                            <label for="eff5">5<br>Excellent</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 2: Communication -->
                                <div class="question-block">
                                    <h5>2. Clarity of Communication</h5>
                                    <p class="text-muted">How clear and helpful was the information provided by office staff?</p>
                                    <div class="rating-group">
                                        <div class="rating-option">
                                            <input type="radio" name="communication" id="com1" value="1">
                                            <label for="com1">1<br>Poor</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="communication" id="com2" value="2">
                                            <label for="com2">2<br>Fair</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="communication" id="com3" value="3">
                                            <label for="com3">3<br>Good</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="communication" id="com4" value="4">
                                            <label for="com4">4<br>Very Good</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="communication" id="com5" value="5">
                                            <label for="com5">5<br>Excellent</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 3: Professionalism -->
                                <div class="question-block">
                                    <h5>3. Professionalism</h5>
                                    <p class="text-muted">How professional and courteous was the office staff?</p>
                                    <div class="rating-group">
                                        <div class="rating-option">
                                            <input type="radio" name="professionalism" id="prof1" value="1">
                                            <label for="prof1">1<br>Poor</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="professionalism" id="prof2" value="2">
                                            <label for="prof2">2<br>Fair</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="professionalism" id="prof3" value="3">
                                            <label for="prof3">3<br>Good</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="professionalism" id="prof4" value="4">
                                            <label for="prof4">4<br>Very Good</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="professionalism" id="prof5" value="5">
                                            <label for="prof5">5<br>Excellent</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 4: Accessibility -->
                                <div class="question-block">
                                    <h5>4. Accessibility</h5>
                                    <p class="text-muted">How easy was it to reach the office (online, phone, or in person)?</p>
                                    <div class="rating-group">
                                        <div class="rating-option">
                                            <input type="radio" name="accessibility" id="acc1" value="1">
                                            <label for="acc1">1<br>Poor</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="accessibility" id="acc2" value="2">
                                            <label for="acc2">2<br>Fair</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="accessibility" id="acc3" value="3">
                                            <label for="acc3">3<br>Good</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="accessibility" id="acc4" value="4">
                                            <label for="acc4">4<br>Very Good</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="accessibility" id="acc5" value="5">
                                            <label for="acc5">5<br>Excellent</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 5: Problem Resolution -->
                                <div class="question-block">
                                    <h5>5. Problem Resolution</h5>
                                    <p class="text-muted">How effectively did the office resolve your issue or address your needs?</p>
                                    <div class="rating-group">
                                        <div class="rating-option">
                                            <input type="radio" name="resolution" id="res1" value="1">
                                            <label for="res1">1<br>Poor</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="resolution" id="res2" value="2">
                                            <label for="res2">2<br>Fair</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="resolution" id="res3" value="3">
                                            <label for="res3">3<br>Good</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="resolution" id="res4" value="4">
                                            <label for="res4">4<br>Very Good</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="resolution" id="res5" value="5">
                                            <label for="res5">5<br>Excellent</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Student Organizations Questions -->
                            <div id="orgQuestions" style="display: none;">
                                <h4 class="text-center mb-4">Student Organization Evaluation</h4>
                                
                                <div class="form-group mb-4">
                                    <label class="form-label">Select Organization</label>
                                    <select class="form-select" name="organization" required>
                                        <option value="">Choose an organization...</option>
                                    </select>
                                    <div id="orgImage" class="mt-3 text-center" style="display: none;">
                                        <img src="" alt="Organization Image" class="img-fluid rounded" style="max-height: 150px;">
                                    </div>
                                </div>

                                <!-- Question 1: Event Quality -->
                                <div class="question-block">
                                    <h5>1. Event Quality</h5>
                                    <p class="text-muted">How engaging and well-organized were the events?</p>
                                    <div class="rating-group">
                                        <div class="rating-option">
                                            <input type="radio" name="event_quality" id="eq1" value="1">
                                            <label for="eq1">1<br>Poor</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="event_quality" id="eq2" value="2">
                                            <label for="eq2">2<br>Fair</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="event_quality" id="eq3" value="3">
                                            <label for="eq3">3<br>Good</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="event_quality" id="eq4" value="4">
                                            <label for="eq4">4<br>Very Good</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="event_quality" id="eq5" value="5">
                                            <label for="eq5">5<br>Excellent</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 2: Communication -->
                                <div class="question-block">
                                    <h5>2. Communication</h5>
                                    <p class="text-muted"><p class="text-muted">How effective was the organization in communicating event details and announcements?</p>
                                    <div class="rating-group">
                                        <div class="rating-option">
                                            <input type="radio" name="org_communication" id="orgcom1" value="1">
                                            <label for="orgcom1">1<br>Poor</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="org_communication" id="orgcom2" value="2">
                                            <label for="orgcom2">2<br>Fair</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="org_communication" id="orgcom3" value="3">
                                            <label for="orgcom3">3<br>Good</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="org_communication" id="orgcom4" value="4">
                                            <label for="orgcom4">4<br>Very Good</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="org_communication" id="orgcom5" value="5">
                                            <label for="orgcom5">5<br>Excellent</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 3: Inclusivity -->
                                <div class="question-block">
                                    <h5>3. Inclusivity</h5>
                                    <p class="text-muted">How welcoming and inclusive was the organization to all members?</p>
                                    <div class="rating-group">
                                        <div class="rating-option">
                                            <input type="radio" name="inclusivity" id="inc1" value="1">
                                            <label for="inc1">1<br>Poor</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="inclusivity" id="inc2" value="2">
                                            <label for="inc2">2<br>Fair</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="inclusivity" id="inc3" value="3">
                                            <label for="inc3">3<br>Good</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="inclusivity" id="inc4" value="4">
                                            <label for="inc4">4<br>Very Good</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="inclusivity" id="inc5" value="5">
                                            <label for="inc5">5<br>Excellent</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 4: Leadership -->
                                <div class="question-block">
                                    <h5>4. Leadership</h5>
                                    <p class="text-muted">How effective and approachable was the leadership team?</p>
                                    <div class="rating-group">
                                        <div class="rating-option">
                                            <input type="radio" name="leadership" id="lead1" value="1">
                                            <label for="lead1">1<br>Poor</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="leadership" id="lead2" value="2">
                                            <label for="lead2">2<br>Fair</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="leadership" id="lead3" value="3">
                                            <label for="lead3">3<br>Good</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="leadership" id="lead4" value="4">
                                            <label for="lead4">4<br>Very Good</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="leadership" id="lead5" value="5">
                                            <label for="lead5">5<br>Excellent</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 5: Skill Development -->
                                <div class="question-block">
                                    <h5>5. Skill Development</h5>
                                    <p class="text-muted">How well did the organization provide opportunities for personal growth?</p>
                                    <div class="rating-group">
                                        <div class="rating-option">
                                            <input type="radio" name="skill_dev" id="skill1" value="1">
                                            <label for="skill1">1<br>Poor</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="skill_dev" id="skill2" value="2">
                                            <label for="skill2">2<br>Fair</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="skill_dev" id="skill3" value="3">
                                            <label for="skill3">3<br>Good</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="skill_dev" id="skill4" value="4">
                                            <label for="skill4">4<br>Very Good</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="skill_dev" id="skill5" value="5">
                                            <label for="skill5">5<br>Excellent</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 6: Impact -->
                                <div class="question-block">
                                    <h5>6. Impact</h5>
                                    <p class="text-muted">How much did the organization positively contribute to your campus experience?</p>
                                    <div class="rating-group">
                                        <div class="rating-option">
                                            <input type="radio" name="impact" id="imp1" value="1">
                                            <label for="imp1">1<br>Poor</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="impact" id="imp2" value="2">
                                            <label for="imp2">2<br>Fair</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="impact" id="imp3" value="3">
                                            <label for="imp3">3<br>Good</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="impact" id="imp4" value="4">
                                            <label for="imp4">4<br>Very Good</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="impact" id="imp5" value="5">
                                            <label for="imp5">5<br>Excellent</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Additional Information -->
                        <div class="step" id="step3">
                            <h4 class="text-center mb-4">Additional Information</h4>
                            
                            <div class="mb-4">
                                <label class="form-label">What improvements would you suggest?</label>
                                <textarea class="form-control" name="improvements" rows="4" placeholder="Share your thoughts on how we can improve..."></textarea>
                            </div>

                            <div class="row">
                            <div class="col-md-6 mb-3">
                            <label class="form-label">Email (Optional)</label>
                            <input class="form-control" 
                                name="email" 
                                placeholder="your@email.com">
                        </div>
                                                        
                        <div class="col-md-6 mb-3">
                                    <label class="form-label">Name (Optional)</label>
                                    <input type="text" class="form-control" name="name" placeholder="Your Name">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="prevBtn" disabled>Previous</button>
                    <button type="button" class="btn btn-primary" id="nextBtn">Next</button>
                    <button type="submit" class="btn btn-success" id="submitBtn" form="feedbackForm" style="display:none;">Submit Feedback</button>
                </div>
            </div>
        </div>
    </div>