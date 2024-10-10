<?php
session_start();
include_once ("class/mainclass.php");
$obj = new mainClass();
$allAnnouncement = $obj->show_announcement2();
$allEvent = $obj->show_eventsByMonth();
$allIt = $obj->show_allIt();
$allCs = $obj->show_allCs();
$allIs = $obj->show_allIs();
$allOrg = $obj->show_org();
$allMit = $obj->show_allMit();

$allItHeads = $obj->show_allItHeads();
$allCsHeads = $obj->show_allCsHeads();
$allIsHeads = $obj->show_allIsHeads();
$allMitHeads = $obj->show_allMitHeads();
$allDean = $obj->show_allDeanHeads();
$showfaqs = $obj->show_allFAQS();


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Modal Example</title>
    <!-- Bootstrap CSS -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/light-box.css">
    <link rel="stylesheet" href="css/owl-carousel.css">
    <link rel="stylesheet" href="css/templatemo-style.css">

    <!-- Modernizr for browser feature detection -->
    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
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
        .selected {
        color: gold; /* Change color to indicate selection */
        transform: scale(1.5); /* Scale up the selected emoji for emphasis */
        }
        .avatar {
                width: 30px; /* Set the width */
                height: 30px; /* Set the height */
                object-fit: cover; /* Cover ensures the image fills the circle without distorting */
                border-radius: 50%; /* Make it circular */
            }
    </style>
</head>
<body>

<div class="page-content">
    
<section id="campusorgs" class="content-section">
    <div class="section-heading text-center borderYellow">
        <!-- Optional Section Heading -->
    </div>
    <div class="section-content section-content-orgs">
        <div class="row">
            <?php foreach ($allOrg as $row): ?>
                <div class="col-md-4">
                    <div class="faculty-card">
                        <div class="faculty-image">
                            <a href="#" 
                               data-bs-toggle="modal"
                               data-bs-target="#newsModal"
                               data-orgid="<?= htmlspecialchars($row['org_id']) ?>" 
                               data-title="<?= htmlspecialchars($row['org_name']) ?>"
                               data-image="uploaded/orgUploaded/<?= htmlspecialchars($row['org_image']) ?>"
                               data-profilephoto="uploaded/orgUploaded/<?= htmlspecialchars($row['org_image']) ?>"
                               data-author="<?= htmlspecialchars($row['org_name']) ?>">
                                <img src="uploaded/orgUploaded/<?= htmlspecialchars($row['org_image']) ?>"
                                     alt="<?= htmlspecialchars($row['org_name']) ?>"
                                     class="orgimage">
                            </a>
                        </div>
                    </div>
                    <div class="faculty-info">
                        <h6><?= htmlspecialchars($row['org_name']) ?></h6>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="newsModal" tabindex="-1" aria-labelledby="newsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="newsModalTitle">News Feed</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="newsFeedContent" class="news-feed"></div>
                    </div>
                    <div class="modal-footer">
                        <!-- Optional footer buttons -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


    <script>
        window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')
    </script>

    <!-- Bootstrap JS with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom JS and Plugins -->
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
    <script>
        // Hide Header on on scroll down
        var didScroll;
        var lastScrollTop = 0;
        var delta = 5;
        var navbarHeight = $('header').outerHeight();

        $(window).scroll(function (event) {
            didScroll = true;
        });

        setInterval(function () {
            if (didScroll) {
                hasScrolled();
                didScroll = false;
            }
        }, 250);

        function hasScrolled() {
            var st = $(this).scrollTop();

            // Make sure they scroll more than delta
            if (Math.abs(lastScrollTop - st) <= delta)
                return;

            // If they scrolled down and are past the navbar, add class .nav-up.
            // This is necessary so you never see what is "behind" the navbar.
            if (st > lastScrollTop && st > navbarHeight) {
                // Scroll Down
                $('header').removeClass('nav-down').addClass('nav-up');
            } else {
                // Scroll Up
                if (st + $(window).height() < $(document).height()) {
                    $('header').removeClass('nav-up').addClass('nav-down');
                }
            }

            lastScrollTop = st;
        }

       
    </script>
   <script>function toggleAnswer(faqId) {
    var answerDiv = document.getElementById('answer-' + faqId);
    if (answerDiv.style.display === 'none') {
        answerDiv.style.display = 'block';
    } else {
        answerDiv.style.display = 'none';
    }
}
function filterFAQs() {
    var input, filter, faqItems, questionText, i;
    input = document.getElementById('faq-search');
    filter = input.value.toLowerCase();
    faqItems = document.getElementsByClassName('faq-item');

    for (i = 0; i < faqItems.length; i++) {
        questionText = faqItems[i].getAttribute('data-question');
        if (questionText.includes(filter)) {
            faqItems[i].style.display = '';
        } else {
            faqItems[i].style.display = 'none';
        }
    }
}
</script>


<script>
    $(document).ready(function () {
        // Handle modal show event
        $('#newsModal').on('show.bs.modal', function (e) {
            const orgId = $(e.relatedTarget).data('orgid');
            const profilePhoto = $(e.relatedTarget).data('profilephoto');
            const authorName = $(e.relatedTarget).data('author');

            // Fetch announcements
            fetchAnnouncements(orgId, profilePhoto, authorName);
        });

        // Fetch announcements
        function fetchAnnouncements(orgId, profilePhoto, authorName) {
            $.ajax({
                url: 'ajax/fetch_announcement.php',
                type: 'POST',
                dataType: 'json',
                data: { org_id: orgId },
                success: function (response) {
                    let content = `
                        <div class="news-feed-item">
                            <div class="news-feed-header d-flex align-items-center mb-3">
                                <img src="${profilePhoto}" alt="Profile Photo" class="img-fluid rounded-circle profile-photo" style="width: 50px; height: 50px; margin-right: 10px;">
                                <h5 class="font-weight-bold mb-0">${authorName}</h5>
                                <button type="button" class="btn btn-secondary show-members-btn" data-orgid="${orgId}">
                                    Show Members
                                </button>
                            </div>
                    `;

                    if (response.announcements && response.announcements.length > 0) {
                        content += '<div class="announcement-details">';
                        response.announcements.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

                        response.announcements.forEach(function (announcement) {
                            const createdAt = new Date(announcement.created_at);
                            const timeAgo = formatRelativeTime(createdAt);
                            const sanitizedDetails = removeColorTags(announcement.announcement_details);

                            content += `
                                <p class="announcement-date mb-2"><strong>Created:</strong> ${timeAgo}</p>
                                <div class="announcement-item mb-3 p-3 border rounded announcement-item-bg">
                                    <p class="announcement-details mb-1">${sanitizedDetails}</p>
                                    ${announcement.announcement_image ? `<img src="uploaded/annUploaded/${announcement.announcement_image}" class="img-fluid mb-2 announcement-image">` : ''}
                                </div>`;
                        });
                        content += '</div>';
                    } else {
                        content += '<p>No announcements found.</p>';
                    }

                    content += '</div>';
                    $('#newsFeedContent').html(content);
                },
                error: function (xhr, status, error) {
                    $('#newsFeedContent').html('<p>An error occurred while fetching announcements. Please try again later.</p>');
                }
            });
        }

        // Fetch members based on org ID
        $(document).on('click', '.show-members-btn', function () {
            const orgId = $(this).data('orgid');
            fetchMembers(orgId);
        });

        function fetchMembers(orgId) {
            $.ajax({
                url: 'ajax/fetch_members.php', // Update with the correct URL for fetching members
                type: 'POST',
                dataType: 'json',
                data: { org_id: orgId },
                success: function (response) {
                    let membersContent = `
                        <div class="members-list">
                            <h5>Members:</h5>
                            <div class="feedback-list">`;

                    if (response.members && response.members.length > 0) {
                        response.members.forEach(member => {
                            membersContent += `
                                <div class="member-item d-flex align-items-center mb-2">
                                    <img src="uploaded/members/${member.photo}" class="avatar" alt="${member.name}">
                                    <span class="ms-2">${member.name}</span>
                                </div>`;
                        });
                    } else {
                        membersContent += '<p>No members found.</p>';
                    }
                    membersContent += `
                            </div>
                        </div>`;

                    Swal.fire({
                        title: 'Members',
                        html: membersContent,
                        showCloseButton: true,
                        showCancelButton: false,
                        focusConfirm: false,
                        confirmButtonText: 'Close'
                    });
                },
                error: function (xhr, status, error) {
                    Swal.fire('Error', 'Unable to fetch members. Please try again later.', 'error');
                }
            });
        }

        function formatRelativeTime(date) {
            const now = new Date();
            const seconds = Math.floor((now - date) / 1000);
            const minutes = Math.floor(seconds / 60);
            const hours = Math.floor(minutes / 60);
            const days = Math.floor(hours / 24);

            if (seconds < 60) return `${seconds} seconds ago`;
            if (minutes < 60) return `${minutes} minutes ago`;
            if (hours < 24) return `${hours} hours ago`;
            return `${days} days ago`;
        }

        function removeColorTags(str) {
            return str.replace(/<\/?span[^>]*>/g, ''); // Remove <span> tags
        }
    });
</script>

</body>
</html>
