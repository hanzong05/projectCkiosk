<div x-data="{
        announcements: [],
        fetchAnnouncements() {
            fetch('ajax/callAnn.php')
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error(data.error);
                    } else {
                        this.announcements = data;
                        console.log('Fetched Announcements:', this.announcements);  // Debugging line
                    }
                })
                .catch(error => console.error('Error fetching announcements:', error));
        },
        formatTimeAgo(date) {
            const time = new Date(date);
            const now = new Date();
            const seconds = Math.floor((now - time) / 1000);
            const minutes = Math.floor(seconds / 60);
            const hours = Math.floor(minutes / 60);
            const days = Math.floor(hours / 24);

            if (days > 1) return `${days} days ago`;
            if (days === 1) return '1 day ago';
            if (hours > 1) return `${hours} hours ago`;
            if (hours === 1) return '1 hour ago';
            if (minutes > 1) return `${minutes} minutes ago`;
            return 'Just now';
        }
    }"
    x-init="fetchAnnouncements()">

    <!-- Loading State -->
    <template x-if="announcements.length === 0">
        <div class="text-center py-12">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-yellow-400 mx-auto"></div>
            <p class="mt-4 text-gray-500">Loading announcements...</p>
        </div>
    </template>

    <!-- Announcements List -->
    <template x-for="announcement in announcements" :key="announcement.announcement_id">
        <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-300 mb-6">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center">
                    <img :src="'uploaded/orgUploaded/' + announcement.org_image" 
                         :alt="announcement.org_name"
                         class="w-12 h-12 rounded-full object-cover border-2 border-gray-200">
                    <div class="ml-4">
                        <h3 class="font-semibold text-gray-900" x-text="announcement.org_name"></h3>
                        <p class="text-sm text-gray-500">
                            Posted by <span x-text="announcement.creator_name"></span>
                            <span class="mx-1">•</span>
                            <span x-text="formatTimeAgo(announcement.created_at_formatted)"></span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Announcement Images -->
            <template x-if="announcement.announcement_images && announcement.announcement_images.length > 0">
                <div class="relative">
                    <div class="aspect-w-16 aspect-h-9">
                        <img :src="'uploaded/annUploaded/' + announcement.announcement_images[0]"
                             class="w-full h-full object-cover"
                             @click="$dispatch('open-modal', { images: announcement.announcement_images })">
                    </div>
                    <template x-if="announcement.announcement_images.length > 1">
                        <div class="absolute bottom-2 right-2 bg-black bg-opacity-50 text-white px-2 py-1 rounded-md text-sm">
                            <span x-text="' + ' + (announcement.announcement_images.length - 1) + ' more'"></span>
                        </div>
                    </template>
                </div>
            </template>

            <!-- Announcement Content -->
            <div class="p-6">
                <div x-data="{ expanded: false }">
                    <p class="text-gray-700" 
                       :class="{ 'line-clamp-3': !expanded }"
                       x-text="announcement.announcement_details"></p>
                    <template x-if="announcement.announcement_details.length > 150">
                        <button @click="expanded = !expanded"
                                class="mt-2 text-yellow-600 hover:text-yellow-700 text-sm font-medium focus:outline-none">
                            <span x-text="expanded ? 'Show less' : 'Show more'"></span>
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </template>
</div>
