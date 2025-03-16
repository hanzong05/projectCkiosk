<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us & FAQs | Your Company</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-gray-800 font-sans">
    <!-- Header -->
    <header class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white py-12 px-4">
        <div class="max-w-6xl mx-auto text-center">
            <h1 class="text-4xl font-bold mb-4">About Us</h1>
            <p class="text-xl">Learn more about our company and get answers to your questions</p>
        </div>
    </header>

    <!-- Navigation -->
    <nav class="bg-white shadow sticky top-0 z-50">
        <div class="max-w-6xl mx-auto">
            <ul class="flex justify-center py-4 space-x-8">
                <li><a href="#about" class="text-gray-700 hover:text-blue-500 font-medium transition-colors">About Us</a></li>
                <li><a href="#mission" class="text-gray-700 hover:text-blue-500 font-medium transition-colors">Our Mission</a></li>
                <li><a href="#team" class="text-gray-700 hover:text-blue-500 font-medium transition-colors">Our Team</a></li>
                <li><a href="#faqs" class="text-gray-700 hover:text-blue-500 font-medium transition-colors">FAQs</a></li>
                <li><a href="#feedback" class="text-gray-700 hover:text-blue-500 font-medium transition-colors">Feedback</a></li>
            </ul>
        </div>
    </nav>

    <!-- About Section -->
    <section id="about" class="py-16 px-4">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl font-bold text-center text-blue-600 mb-12">About Our Company</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-gray-50 rounded-lg p-8 shadow-sm hover:shadow-lg transition-shadow hover:-translate-y-1 transform transition-transform">
                    <h3 class="text-xl font-semibold text-indigo-600 mb-4">Our Story</h3>
                    <p class="text-gray-700">Founded in 2015, we began with a simple vision: to create innovative solutions that make a difference. Since then, we've grown into a team of passionate experts dedicated to excellence in every project we undertake.</p>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-8 shadow-sm hover:shadow-lg transition-shadow hover:-translate-y-1 transform transition-transform">
                    <h3 class="text-xl font-semibold text-indigo-600 mb-4">Our Approach</h3>
                    <p class="text-gray-700">We believe in collaboration, innovation, and quality. Our client-centered approach ensures that we deliver solutions tailored to your specific needs, with attention to detail and commitment to excellence.</p>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-8 shadow-sm hover:shadow-lg transition-shadow hover:-translate-y-1 transform transition-transform">
                    <h3 class="text-xl font-semibold text-indigo-600 mb-4">Our Values</h3>
                    <p class="text-gray-700">Integrity, transparency, and dedication form the foundation of everything we do. We're committed to building lasting relationships with our clients based on trust and mutual respect.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission Section -->
    <section id="mission" class="py-16 px-4 bg-gray-50">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl font-bold text-center text-blue-600 mb-12">Our Mission</h2>
            
            <div class="flex flex-col md:flex-row items-center gap-8">
                <div class="md:w-1/2">
                    <img src="/api/placeholder/600/400" alt="Our mission" class="rounded-lg shadow-md w-full">
                </div>
                <div class="md:w-1/2">
                    <h3 class="text-2xl font-semibold text-indigo-600 mb-4">Empowering Through Innovation</h3>
                    <p class="text-gray-700 mb-4">Our mission is to provide cutting-edge solutions that empower businesses to thrive in an ever-changing digital landscape. We're dedicated to helping our clients achieve their goals through technology, strategy, and creativity.</p>
                    <p class="text-gray-700">We strive to be not just service providers, but trusted partners in your journey toward success. Our commitment to excellence drives us to continuously innovate and improve, ensuring that we deliver the highest quality solutions that make a real difference.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section id="team" class="py-16 px-4">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl font-bold text-center text-blue-600 mb-12">Meet Our Team</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-40 h-40 mx-auto mb-4 rounded-full border-4 border-blue-500 overflow-hidden">
                        <img src="/api/placeholder/200/200" alt="Team member" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-semibold">Sarah Johnson</h3>
                    <p class="text-blue-600">CEO & Founder</p>
                </div>
                
                <div class="text-center">
                    <div class="w-40 h-40 mx-auto mb-4 rounded-full border-4 border-blue-500 overflow-hidden">
                        <img src="/api/placeholder/200/200" alt="Team member" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-semibold">Michael Chen</h3>
                    <p class="text-blue-600">CTO</p>
                </div>
                
                <div class="text-center">
                    <div class="w-40 h-40 mx-auto mb-4 rounded-full border-4 border-blue-500 overflow-hidden">
                        <img src="/api/placeholder/200/200" alt="Team member" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-semibold">Emily Rodriguez</h3>
                    <p class="text-blue-600">Head of Design</p>
                </div>
                
                <div class="text-center">
                    <div class="w-40 h-40 mx-auto mb-4 rounded-full border-4 border-blue-500 overflow-hidden">
                        <img src="/api/placeholder/200/200" alt="Team member" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-semibold">David Park</h3>
                    <p class="text-blue-600">Lead Developer</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQs Section -->
    <section id="faqs" class="py-16 px-4 bg-gray-50">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-3xl font-bold text-center text-blue-600 mb-12">Frequently Asked Questions</h2>
            
            <div class="space-y-6">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-xl font-semibold text-indigo-600 mb-2">What services do you offer?</h3>
                    <p class="text-gray-700">We offer a comprehensive range of services including web development, mobile app development, UI/UX design, digital marketing, and strategic consulting. Each service is tailored to meet your specific needs and goals.</p>
                </div>
                
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-xl font-semibold text-indigo-600 mb-2">How long does a typical project take?</h3>
                    <p class="text-gray-700">Project timelines vary depending on scope, complexity, and specific requirements. A simple website might take 4-6 weeks, while more complex applications can take 3-6 months. During our initial consultation, we'll provide a detailed timeline based on your project needs.</p>
                </div>
                
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-xl font-semibold text-indigo-600 mb-2">How much do your services cost?</h3>
                    <p class="text-gray-700">We provide customized solutions, so pricing depends on your specific requirements. We offer competitive rates and flexible payment options. Contact us for a free consultation and quote tailored to your project needs.</p>
                </div>
                
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-xl font-semibold text-indigo-600 mb-2">Do you provide ongoing support?</h3>
                    <p class="text-gray-700">Yes, we offer various support and maintenance packages to ensure your solution continues to perform optimally. Our team is always available to address any issues, implement updates, or make enhancements as your business evolves.</p>
                </div>
                
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-xl font-semibold text-indigo-600 mb-2">How do we get started?</h3>
                    <p class="text-gray-700">Getting started is easy! Simply fill out our contact form or give us a call. We'll schedule an initial consultation to discuss your project, understand your requirements, and outline how we can help you achieve your goals.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Feedback Section -->
    <section id="feedback" class="py-16 px-4">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-3xl font-bold text-center text-blue-600 mb-12">Share Your Feedback</h2>
            
            <div class="bg-gray-50 rounded-lg shadow-sm p-8">
                <form class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" id="name" name="name" class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" name="email" class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="feedback-type" class="block text-sm font-medium text-gray-700 mb-1">Feedback Type</label>
                        <select id="feedback-type" name="feedback-type" class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="general">General Feedback</option>
                            <option value="suggestion">Suggestion</option>
                            <option value="compliment">Compliment</option>
                            <option value="complaint">Complaint</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Your Feedback</label>
                        <textarea id="message" name="message" rows="5" class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                    
                    <div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-md transition-colors">Submit Feedback</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12 px-4">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-semibold mb-4">Your Company</h3>
                    <p class="text-gray-300 mb-4">Providing innovative solutions since 2015</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-white hover:text-blue-400 transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-white hover:text-blue-400 transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                            </svg>
                        </a>
                        <a href="#" class="text-white hover:text-blue-400 transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                        <a href="#" class="text-white hover:text-blue-400 transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-xl font-semibold mb-4">Contact Us</h3>
                    <p class="text-gray-300 mb-2">123 Business Street</p>
                    <p class="text-gray-300 mb-2">City, State 12345</p>
                    <p class="text-gray-300 mb-2">Email: info@yourcompany.com</p>
                    <p class="text-gray-300 mb-2">Phone: (123) 456-7890</p>
                </div>
                
                <div>
                    <h3 class="text-xl font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Home</a></li>
                        <li><a href="#about" class="text-gray-300 hover:text-white transition-colors">About Us</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Services</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Projects</a></li>
                        <li><a href="#faqs" class="text-gray-300 hover:text-white transition-colors">FAQs</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-12 pt-8 text-center">
                <p class="text-gray-400">© 2025 Your Company. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>