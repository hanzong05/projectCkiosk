
            <section id="facultymembers" class="content-section bg-light py-5">
        <div class="section-content">
            <div class="section-heading text-center borderYellow">
                <h1><em>FACULTY MEMBERS</em></h1>
            </div>

            <!-- Faculty Members -->
            <div class="level1">
                        <?php foreach ($allDean as $head): ?>
                            <div class="member" data-name="<?= htmlspecialchars($head['faculty_name']) ?>"
                                data-specialization="<?= htmlspecialchars($head['specialization']) ?>"
                                data-consultation="<?= htmlspecialchars($head['consultation_time']) ?>"
                                data-image="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>">
                                <img src="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>" alt="Dean">
                                <p><strong><?= htmlspecialchars($head['faculty_name']) ?></strong><br>
                                    <?= implode(", ", $head['departments']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
            <div class="level2">
                        <?php foreach ($all2 as $head): ?>
                            <div class="member" data-name="<?= htmlspecialchars($head['faculty_name']) ?>"
                                data-specialization="<?= htmlspecialchars($head['specialization']) ?>"
                                data-consultation="<?= htmlspecialchars($head['consultation_time']) ?>"
                                data-image="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>">
                                <img src="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>" alt="Dean">
                                <p><strong><?= htmlspecialchars($head['faculty_name']) ?></strong><br>
                                    <?= implode(", ", $head['departments']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="level3">
                        <?php foreach ($all3 as $head): ?>
                            <div class="member" data-name="<?= htmlspecialchars($head['faculty_name']) ?>"
                                data-specialization="<?= htmlspecialchars($head['specialization']) ?>"
                                data-consultation="<?= htmlspecialchars($head['consultation_time']) ?>"
                                data-image="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>">
                                <img src="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>" alt="Dean">
                                <p><strong><?= htmlspecialchars($head['faculty_name']) ?></strong><br>
                                    <?= implode(", ", $head['departments']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>

            <!-- Department Buttons -->
            <div class="fclty-div">
                <button type="button" class="button-faculty-btn active" data-tab="tab1">IT Department</button>
                <button type="button" class="button-faculty-btn" data-tab="tab2">IS Department</button>
                <button type="button" class="button-faculty-btn" data-tab="tab3">CS Department</button>
                <button type="button" class="button-faculty-btn" data-tab="tab4">MIT</button>
            </div>

            <!-- IT Department Tab -->
            <div id="tab1" class="org-chart active">
                <div class="section-content">
                    <h3>IT CHAIRPERSON</h3>
                    <div class="level2">
                        <?php foreach ($allItHeads as $head): ?>
                            <div class="member" data-name="<?= htmlspecialchars($head['faculty_name']) ?>"
                                data-specialization="<?= htmlspecialchars($head['specialization']) ?>"
                                data-consultation="<?= htmlspecialchars($head['consultation_time']) ?>"
                                data-image="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>">
                                <img src="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>" alt="Dean">
                                <p><strong><?= htmlspecialchars($head['faculty_name']) ?></strong><br>
                                    <?= implode(", ", $head['departments']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <h3>Faculty Members</h3>
                    <div class="level3">
                        <?php foreach ($allIt as $faculty): ?>
                            <div class="member" data-name="<?= htmlspecialchars($faculty['faculty_name']) ?>"
                                data-specialization="<?= htmlspecialchars($faculty['specialization']) ?>"
                                data-consultation="<?= htmlspecialchars($faculty['consultation_time']) ?>"
                                data-image="uploaded/facultyUploaded/<?= htmlspecialchars($faculty['faculty_image']) ?>">
                                <img src="uploaded/facultyUploaded/<?= htmlspecialchars($faculty['faculty_image']) ?>" alt="Faculty Member">
                                <p><strong><?= htmlspecialchars($faculty['faculty_name']) ?></strong><br>
                                    <?= implode(", ", $faculty['departments']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- IS Department Tab -->
            <div id="tab2" class="org-chart">
                <div class="section-content">
                    <h3>IS CHAIRPERSON</h3>
                    <div class="level2">
                        <?php foreach ($allIsHeads as $head): ?>
                            <div class="member" data-name="<?= htmlspecialchars($head['faculty_name']) ?>"
                                data-specialization="<?= htmlspecialchars($head['specialization']) ?>"
                                data-consultation="<?= htmlspecialchars($head['consultation_time']) ?>"
                                data-image="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>">
                                <img src="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>" alt="Dean">
                                <p><strong><?= htmlspecialchars($head['faculty_name']) ?></strong><br>
                                    <?= implode(", ", $head['departments']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <h3>Faculty Members</h3>
                    <div class="level3">
                        <?php foreach ($allIs as $faculty): ?>
                            <div class="member" data-name="<?= htmlspecialchars($faculty['faculty_name']) ?>"
                                data-specialization="<?= htmlspecialchars($faculty['specialization']) ?>"
                                data-consultation="<?= htmlspecialchars($faculty['consultation_time']) ?>"
                                data-image="uploaded/facultyUploaded/<?= htmlspecialchars($faculty['faculty_image']) ?>">
                                <img src="uploaded/facultyUploaded/<?= htmlspecialchars($faculty['faculty_image']) ?>" alt="Faculty Member">
                                <p><strong><?= htmlspecialchars($faculty['faculty_name']) ?></strong><br>
                                    <?= implode(", ", $faculty['departments']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- CS Department Tab -->
            <div id="tab3" class="org-chart">
                <div class="section-content">
                    <h3>CS CHAIRPERSON</h3>
                    <div class="level2">
                        <?php foreach ($allCsHeads as $head): ?>
                            <div class="member" data-name="<?= htmlspecialchars($head['faculty_name']) ?>"
                                data-specialization="<?= htmlspecialchars($head['specialization']) ?>"
                                data-consultation="<?= htmlspecialchars($head['consultation_time']) ?>"
                                data-image="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>">
                                <img src="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>" alt="Dean">
                                <p><strong><?= htmlspecialchars($head['faculty_name']) ?></strong><br>
                                    <?= implode(", ", $head['departments']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <h3>Faculty Members</h3>
                    <div class="level3">
                        <?php foreach ($allCs as $faculty): ?>
                            <div class="member" data-name="<?= htmlspecialchars($faculty['faculty_name']) ?>"
                                data-specialization="<?= htmlspecialchars($faculty['specialization']) ?>"
                                data-consultation="<?= htmlspecialchars($faculty['consultation_time']) ?>"
                                data-image="uploaded/facultyUploaded/<?= htmlspecialchars($faculty['faculty_image']) ?>">
                                <img src="uploaded/facultyUploaded/<?= htmlspecialchars($faculty['faculty_image']) ?>" alt="Faculty Member">
                                <p><strong><?= htmlspecialchars($faculty['faculty_name']) ?></strong><br>
                                    <?= implode(", ", $faculty['departments']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- MIT Department Tab -->
            <div id="tab4" class="org-chart">
                <div class="section-content">
                    <h3>MIT CHAIRPERSON</h3>
                    <div class="level2">
                        <?php foreach ($allMitHeads as $head): ?>
                            <div class="member" data-name="<?= htmlspecialchars($head['faculty_name']) ?>"
                                data-specialization="<?= htmlspecialchars($head['specialization']) ?>"
                                data-consultation="<?= htmlspecialchars($head['consultation_time']) ?>"
                                data-image="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>">
                                <img src="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>" alt="Dean">
                                <p><strong><?= htmlspecialchars($head['faculty_name']) ?></strong><br>
                                    <?= implode(", ", $head['departments']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <h3>Faculty Members</h3>
                    <div class="level3">
                        <?php foreach ($allMit as $faculty): ?>
                            <div class="member" data-name="<?= htmlspecialchars($faculty['faculty_name']) ?>"
                                data-specialization="<?= htmlspecialchars($faculty['specialization']) ?>"
                                data-consultation="<?= htmlspecialchars($faculty['consultation_time']) ?>"
                                data-image="uploaded/facultyUploaded/<?= htmlspecialchars($faculty['faculty_image']) ?>">
                                <img src="uploaded/facultyUploaded/<?= htmlspecialchars($faculty['faculty_image']) ?>" alt="Faculty Member">
                                <p><strong><?= htmlspecialchars($faculty['faculty_name']) ?></strong><br>
                                    <?= implode(", ", $faculty['departments']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        </div>

        <!-- Profile Modal -->
        <div id="backdrop" class="backdrop" style="display: none;"></div>
        <div id="profileCard" class="card mb-4">
            <div class="card-body text-center">
                <img id="profileImage" src="" alt="Profile Picture" class="rounded-circle img-fluid" style="width: 150px;">
                <h5 class="my-3" id="profileName">Name</h5>
                <p class="text-muted mb-1" id="profileSpecialization">Specialization: <span class="specialization-value"></span></p>
                <p class="text-muted mb-4" id="profileConsultationTime">Consultation Time: <span class="consultation-value"></span></p>
            </div>
        </div>
    </section>
