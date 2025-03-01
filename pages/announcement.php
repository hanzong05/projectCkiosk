
        <section id="announcement" class="content-section bg-light py-5">
            <div class="section-heading text-center">
                <h1 class="pt-16 pb-8">
                    <em class="text-4xl font-bold text-gray-800">Announcements</em>
                </h1>
            </div>

            <!-- Filters Container -->
            <div class="filters-container">
                <div class="filters-grid">
                    <div class="search-container">
                        <i class="fas fa-search search-icon"></i>
                        <input 
                            type="text" 
                            id="announcement-search" 
                            class="filter-input search-input"
                            placeholder="Search announcements...">
                    </div>

                    <div>
                        <select id="category-filter" class="filter-input">
                            <option value="all">All Categories</option>
                            <option value="academic">Academic</option>
                            <option value="event">Events</option>
                            <option value="org">Organizations</option>
                            <option value="general">General</option>
                        </select>
                    </div>

                    <div>
                        <input 
                            type="date" 
                            id="date-from" 
                            class="filter-input"
                            placeholder="From date">
                    </div>
                    <div>
                        <input 
                            type="date" 
                            id="date-to" 
                            class="filter-input"
                            placeholder="To date">
                    </div>

                    <button 
                        id="clear-filters" 
                        class="filter-input">
                        <i class="fas fa-times"></i> Clear Filters
                    </button>
                </div>
            </div>

            <!-- Announcements Container -->
            <div id="announcement-container" class="announcement-container mx-auto">
                <div class="grid grid-cols-1 gap-4">
                    <!-- Dynamic content will be inserted here -->
                </div>
            </div>
        </section>

        <!-- Image Modal -->
        <div id="imageModal" class="modal">
            <span class="close-modal">&times;</span>
            <img class="modal-img" src="" alt="Image preview">
        </div>
    </div>

