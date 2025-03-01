
    

</section>
    <section id="schoolcalendar" class="content-section bg-light remove-padding-sm py-5 flowbite">
        <div class="section-heading text-center borderYellow">
            <h1><em>SCHOOL CALENDAR</em></h1>
        </div>

        <?php 
        // Get the events data by month
        $allEvent = $obj->show_eventsByMonth();
        $todayDate = date('Y-m-d');

        // Separate today's and upcoming events
        $eventsToday = [];
        $upcomingEvents = [];
        foreach ($allEvent as $monthYear => $events) {
            foreach ($events as $event) {
                $eventDate = date('Y-m-d', strtotime($event['calendar_start_date']));
                if ($eventDate == $todayDate) {
                    $eventsToday[] = $event;
                } elseif ($eventDate > $todayDate) {
                    $upcomingEvents[] = $event;
                }
            }
        }
        ?>

        <!-- Today's Events Section -->
        <div class="bg-white rounded-lg border shadow-sm mb-6">
            <div class="px-6 py-4 border-b">
                <h2 class="text-lg font-semibold text-emerald-600">Happening Today</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <?php if (empty($eventsToday)): ?>
                        <p class="text-center text-gray-500">No events scheduled for today.</p>
                    <?php else: ?>
                        <?php foreach ($eventsToday as $event): ?>
                            <div class="group hover:bg-blue-50 transition-colors duration-200 rounded-lg p-4 cursor-pointer">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gold-900"><?= date('F j, Y', strtotime($event['calendar_start_date'])); ?> - <?= date('F j, Y', strtotime($event['calendar_end_date'])); ?></p>
                                        <p class="text-sm text-white-500 mt-1"><?= strip_tags($event['calendar_details']); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Upcoming Events Section -->
        <div class="bg-white rounded-lg border shadow-sm mb-6">
            <div class="px-6 py-4 border-b">
                <h2 class="text-lg font-semibold text-blue-600">Upcoming Events</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <?php if (empty($upcomingEvents)): ?>
                        <p class="text-center text-gray-500">No upcoming events.</p>
                    <?php else: ?>
                        <?php foreach ($upcomingEvents as $event): ?>
                            <div class="group hover:bg-blue-50 transition-colors duration-200 rounded-lg p-4 cursor-pointer">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gold-900"><?= date('F j, Y', strtotime($event['calendar_start_date'])); ?> - <?= date('F j, Y', strtotime($event['calendar_end_date'])); ?></p>
                                        <p class="text-sm text-white-500 mt-1"><?= strip_tags($event['calendar_details']); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- No Events Section -->
        <?php if (empty($eventsToday) && empty($upcomingEvents)): ?>
            <div class="bg-white rounded-lg border shadow-sm">
                <div class="flex flex-col items-center justify-center p-12">
                    <svg class="h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900">No Events Scheduled</h3>
                    <p class="text-gray-500 mt-2">Check back later for upcoming events</p>
                </div>
            </div>
        <?php endif; ?>
    </section>
