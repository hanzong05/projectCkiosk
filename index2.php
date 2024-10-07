<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Modal Example</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .feedback-list {
            max-height: 300px; /* Limit height of feedback list */
            overflow-y: auto; /* Enable scrolling if content exceeds height */
        }
        .emoji-select {
            cursor: pointer;
            font-size: 2rem;
            transition: transform 0.2s;
        }
        .emoji-select:hover {
            transform: scale(1.2);
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <!-- Heading -->
    <h2 class="section-heading">Feedback Modal Example</h2>

    <!-- Button to trigger modal -->
    <button type="button" class="btn btn-modern" data-bs-toggle="modal" data-bs-target="#feedbackModal">
        Add your feedback
    </button>

    <!-- Feedback Display Section -->
    <div class="row d-flex justify-content-center mt-4">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-0 border" style="background-color: #f0f2f5;">
                <div class="card-body p-4">
                    <div id="feedbackList" class="feedback-list">
                        <!-- Dynamically filled feedback items will go here -->
                    </div>

                    <!-- Average Ratings -->
                    <div class="total-ratings mt-4">
                        Average Rating: <span id="averageRatingText">No Ratings Yet</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for feedback -->
<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="feedbackModalLabel">Feedback Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="feedbackForm" enctype="multipart/form-data">
                    <!-- Step 1: Emoji Rating -->
                    <div class="step" id="step1">
                        <h4>Rate Your Experience</h4>
                        <div class="d-flex justify-content-around my-4">
                            <span class="emoji-select" data-value="1">😠</span>
                            <span class="emoji-select" data-value="2">😞</span>
                            <span class="emoji-select" data-value="3">😐</span>
                            <span class="emoji-select" data-value="4">😊</span>
                            <span class="emoji-select" data-value="5">😍</span>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                    </div>

                    <!-- Step 2: Personal Information -->
                    <div class="step" id="step2" style="display:none;">
                        <h4>Provide Your Information</h4>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address (required)</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name (optional)</label>
                            <input type="text" class="form-control" id="name">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address (optional)</label>
                            <input type="text" class="form-control" id="address">
                        </div>
                        <div class="mb-3">
                            <label for="college" class="form-label">College (optional)</label>
                            <input type="text" class="form-control" id="college">
                        </div>
                        <div class="mb-3">
                            <label for="year" class="form-label">Year (optional)</label>
                            <input type="number" class="form-control" id="year" min="1" max="4">
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                    </div>

                    <!-- Step 3: Feedback and Image Upload -->
                    <div class="step" id="step3" style="display:none;">
                        <h4>Leave Your Feedback</h4>
                        <div class="mb-3">
                            <label for="feedback" class="form-label">Your feedback</label>
                            <textarea class="form-control" id="feedback" rows="3" placeholder="Tell us more about your experience"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Upload an image (optional)</label>
                            <input class="form-control" type="file" id="image">
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let selectedRating; // To hold the selected rating
    let feedbackCount = 0; // To track the number of feedback submissions

    // Handle emoji selection
    document.querySelectorAll('.emoji-select').forEach(item => {
        item.addEventListener('click', function() {
            document.querySelectorAll('.emoji-select').forEach(emoji => emoji.classList.remove('selected'));
            this.classList.add('selected');
            selectedRating = this; // Set selected rating
        });
    });

    // Function to go to the next step
    function nextStep() {
        const currentStep = document.querySelector('.step:not([style*="display: none"])');
        if (currentStep.nextElementSibling) {
            currentStep.style.display = 'none';
            currentStep.nextElementSibling.style.display = 'block';
        }
    }

    // Function to go to the previous step
    function prevStep() {
        const currentStep = document.querySelector('.step:not([style*="display: none"])');
        if (currentStep.previousElementSibling) {
            currentStep.style.display = 'none';
            currentStep.previousElementSibling.style.display = 'block';
        }
    }

    let totalScore = 0; // To accumulate the total score
    let averageRatingText = document.getElementById('averageRatingText'); // Reference to average rating display

    // Event listener for feedback submission
   // Event listener for feedback submission
document.getElementById('feedbackForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission
    const feedbackInput = document.getElementById('feedback').value.trim();
    const emailInput = document.getElementById('email').value.trim();
    const nameInput = document.getElementById('name').value.trim();
    const addressInput = document.getElementById('address').value.trim();
    const collegeInput = document.getElementById('college').value.trim();
    const yearInput = document.getElementById('year').value.trim();
    const imageInput = document.getElementById('image').files[0];

    if (feedbackInput && selectedRating) {
        const formData = new FormData();
        formData.append('rating', selectedRating.getAttribute('data-value'));
        formData.append('feedback', feedbackInput);
        formData.append('email', emailInput);
        formData.append('name', nameInput);
        formData.append('address', addressInput);
        formData.append('college', collegeInput);
        formData.append('year', yearInput);
        if (imageInput) {
            formData.append('image', imageInput);
        }

        // Send data to PHP script via fetch
        fetch('ajax/submit_feedback.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            console.log('Response:', response); // Log the response
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.statusText);
            }
            return response.json(); // Parse response as JSON
        })
        .then(data => {
            console.log('Data received:', data); // Log the data received
            if (data.success) {
                // Create feedback card
                const feedbackCard = document.createElement('div');
                feedbackCard.className = 'card mb-4';
                feedbackCard.innerHTML = `
                    <div class="card-body">
                        <p><strong>Rating: ${selectedRating.textContent}</strong></p>
                        <p>${feedbackInput}</p>
                        <div class="d-flex justify-content-between">
                            <div class="d-flex flex-row align-items-center">
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(1).jpg" class="rounded-circle" height="30" alt="Avatar" />
                                <p class="small mb-0 ms-2">${nameInput || 'Anonymous'}</p>
                            </div>
                            <p class="small mb-0">${new Date().toLocaleString()}</p>
                        </div>
                    </div>
                `;

                // Append the new feedback card to the feedback list
                document.getElementById('feedbackList').prepend(feedbackCard);
                feedbackInput.value = ''; // Clear input
                document.querySelector('.btn-close').click(); // Close the modal

                // Update average rating
                totalScore += parseInt(selectedRating.getAttribute('data-value'));
                feedbackCount++;
                const averageRating = (totalScore / feedbackCount).toFixed(1);
                averageRatingText.textContent = averageRating;
            } else {
                alert('Error submitting feedback');
            }
        })
        .catch(error => {
            console.error('Error:', error); // Log the error
            alert('An error occurred: ' + error.message); // Optionally alert the user
        });
    }
});

</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
