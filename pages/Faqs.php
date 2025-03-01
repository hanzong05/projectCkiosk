
 <section id="faqs" class="content-section remove-padding-sm bg-light py-5">
        <div class="section-heading text-center borderYellow">
            <h1><br><em>FREQUENTLY ASKED QUESTIONS</em></h1>
        </div>
        <div class="container py-5">
            <div class="row">
                <!-- Left Column: Illustration -->
                <div class="col-lg-6">
                    <div class="faq-image">
                        <img src="img/faq-img-1.png" alt="Illustration" class="img-fluid">
                    </div>
                </div>

                <!-- Right Column: FAQ Section -->
                <div class="col-lg-5">
                    <div class="faq-header text-center">
                      <h1 style="color: black;">How can we help you?</h1>

                        <p class="lead">
                            We hope you have found an answer to your question. If you need any help, please search your query on our Support Center or contact us via email.
                        </p>
                    </div>
     <!-- Search Bar -->
                <div class="my-5">
                    <input 
                        type="text" 
                        id="faqSearch" 
                        class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        placeholder="Search FAQs..."
                        onkeyup="filterFAQs()">
                </div>

                    <div class="accordion accordion-flush" id="faqsAccordion">
                        <?php if (!empty($showfaqs) && is_array($showfaqs)): ?>
                            <?php foreach ($showfaqs as $index => $faq): ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading<?php echo $index; ?>">
                                        <button class="accordion-button <?php echo $index == 0 ? '' : 'collapsed'; ?>" 
                                                type="button" 
                                                data-bs-toggle="collapse" 
                                                data-bs-target="#collapse<?php echo $index; ?>" 
                                                aria-expanded="<?php echo $index == 0 ? 'true' : 'false'; ?>" 
                                                aria-controls="collapse<?php echo $index; ?>" 
                                                style="background-color: #e7f1ff; color: #004085; position: relative;">
                                            <?php echo htmlspecialchars(strip_tags($faq['faqs_question'])); ?>
                                            <!-- Drop-down/up icon -->
                                            <i class="fas fa-chevron-down ms-auto faq-toggle-icon" style="position: absolute; right: 10px;"></i>
                                        </button>
                                    </h2>
                                    <div id="collapse<?php echo $index; ?>" 
                                        class="accordion-collapse collapse <?php echo $index == 0 ? 'show' : ''; ?>" 
                                        aria-labelledby="heading<?php echo $index; ?>" 
                                        data-bs-parent="#faqsAccordion">
                                        <div class="accordion-body">
                                            <?php echo nl2br(htmlspecialchars(strip_tags($faq['faqs_answer']))); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-center">No FAQs available at the moment.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

<script>
    function filterFAQs() {
        const searchInput = document.getElementById('faqSearch').value.toLowerCase();
        const faqItems = document.querySelectorAll('.accordion-item'); // Select all FAQ items

        faqItems.forEach(item => {
            const question = item.querySelector('.accordion-button').textContent.toLowerCase();
            const answer = item.querySelector('.accordion-body').textContent.toLowerCase();
            
            // Check if the search term matches either the question or the answer
            if (question.includes(searchInput) || answer.includes(searchInput)) {
                item.style.display = ''; // Show matching items
            } else {
                item.style.display = 'none'; // Hide non-matching items
            }
        });
    }
</script>



