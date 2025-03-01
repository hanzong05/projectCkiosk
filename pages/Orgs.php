


    <section id="campusorgs" class="content-section remove-padding-sm bg-light py-5">
        <div class="section-heading text-center borderYellow">
            <h1 class="pt-16 pb-8">
                <em class="text-4xl font-bold text-gray-800">Student Organization</em>
            </h1>
            <div class="w-24 h-1 bg-yellow-400 mx-auto mb-12"></div>
        </div>
        <div class="container-fluid px-4">
            <!-- Row of cards with horizontal scroll on smaller screens -->
            <div class="row-container">
                <?php foreach ($allOrg as $row): ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 d-inline-block" style="max-width: 250px;">
                        <div class="card h-100 border-0 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300" style="min-width: 250px;">
                            <!-- Card Header -->
                            <div class="card-header position-relative p-0">
                                <a href="#" class="d-block" data-bs-toggle="modal" data-bs-target="#newsModal" 
                                data-orgid="<?= htmlspecialchars($row['org_id']) ?>" 
                                data-title="<?= htmlspecialchars($row['org_name']) ?>" 
                                data-image="uploaded/orgUploaded/<?= htmlspecialchars($row['org_image']) ?>" 
                                data-profilephoto="uploaded/orgUploaded/<?= htmlspecialchars($row['org_image']) ?>" 
                                data-author="<?= htmlspecialchars($row['org_name']) ?>">
                                    <!-- Card Image -->
                                    <div class="aspect-ratio-box position-relative overflow-hidden">
                                        <img src="uploaded/orgUploaded/<?= htmlspecialchars($row['org_image']) ?>" alt="<?= htmlspecialchars($row['org_name']) ?>" class="object-fit-cover">
                                        <!-- Overlay -->
                                        <div class="card-overlay position-absolute start-0 end-0 bottom-0 h-100 d-flex flex-column justify-content-end p-3 bg-gradient-dark opacity-0">
                                            <div class="text-white p-2 rounded bg-black bg-opacity-20 backdrop-blur-sm"></div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- Card Body -->
                        <div class="card-body p-3">
                            <h5 class="card-title mb-2 fw-bold text-dark fs-6 text-center">
                                
                                <?php 
                                    // Split the title into words
                                    $words = explode(' ', $row['org_name']);
                                    $formattedName = '';
                                    $lineLength = 0;

                                    // Loop through words, adding line breaks to avoid long lines
                                    foreach ($words as $word) {
                                        $formattedName .= htmlspecialchars($word) . ' ';
                                        $lineLength += strlen($word) + 1; // Account for the space

                                        // Add a line break if line exceeds a set character limit (e.g., 20 chars)
                                        if ($lineLength >= 20) { 
                                            $formattedName .= "\n";
                                            $lineLength = 0;
                                        }
                                    }

                                    echo nl2br($formattedName); // Display the formatted name with line breaks
                                ?>
                            </h5>
                            <div class="d-flex align-items-center">
                                <div class="indicator bg-warning rounded me-2" style="width: 3px; height: 20px;"></div>
                                <small class="text-muted text-xs">Student Organization</small>
                            </div>
                        </div>


                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <div class="modal fade" id="newsModal" tabindex="-1" aria-labelledby="newsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white border-0">
                    <h5 class="modal-title" id="newsModalLabel">Organization Feed</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <!-- Filter Section -->
                    <div class="p-3">
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <input type="text" 
                                   class="form-control form-control-sm" 
                                   style="width: 180px;"
                                   id="announcementSearch"
                                   placeholder="Search announcements...">
                            
                            <input type="text" 
                                   class="form-control form-control-sm"
                                   style="width: 150px;"
                                   id="dateFilter"
                                   placeholder="mm/dd/yyyy" 
                                   onfocus="(this.type='date')"
                                   onblur="(this.type='text')">
                            
                            <select class="form-select form-select-sm"
                                    style="width: 150px;"
                                    id="categoryFilter">
                                <option value="all">All Categories</option>
                                <option value="academic">Academic</option>
                                <option value="event">Events</option>
                                <option value="org">Organizations</option>
                                <option value="general">General</option>
                            </select>

                            <button class="btn btn-primary btn-sm px-3" id="clearFilters">Clear</button>
                        </div>
                    </div>

                    <!-- Tabs -->
                    <ul class="nav nav-tabs border-0 px-3">
                        <li class="nav-item">
                            <button class="nav-link active rounded" id="announcements-tab" data-bs-toggle="tab" data-bs-target="#announcements">
                                Announcements
                            </button>
                        </li>
                        <li class="nav-item ms-2">
                            <button class="nav-link rounded" id="members-tab" data-bs-toggle="tab" data-bs-target="#members">
                                Members
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content p-3">
                        <div class="tab-pane fade show active" id="announcements">
                            <div id="announcements-content">
                                <!-- Announcements content will load here -->
                            </div>
                        </div>
                        <div class="tab-pane fade" id="members">
                            <div id="members-content">
                                <!-- Members content will load here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
