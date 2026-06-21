<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADULTVIBE - Premium</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
 /*
-----------------------------------------------
AdultVibe Blogger Template
Name		: AdultVibe
Version		: 2
Designer	: LuxTechZone 
URL			: luxtechzone.blogspot.co
-----------------------------------------------
*/ :root {
            --bg-primary: #0A0A0A;
            --bg-secondary: #1C1C1C;
            --text-primary: #E0E0E0;
            --text-secondary: #8A8A8A;
            --accent: #E50914;
            --border: #333333;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            margin: 0;
            padding: 0;
            line-height: 1.6;
            overflow-x: hidden;
        }
        .navbar {
            background-color: var(--bg-primary);
            border-bottom: 1px solid var(--border);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }
        .logo {
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--accent);
            letter-spacing: -1px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }
        .search-input {
            background-color: var(--bg-secondary);
            border: 1px solid var(--border);
            color: var(--text-primary);
            padding: 0.75rem 1.5rem;
            border-radius: 9999px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.5);
            transition: all 0.3s ease;
        }
        .search-input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 2px rgba(229, 9, 20, 0.5);
        }
        .video-card {
            background-color: var(--bg-secondary);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .video-thumbnail-container {
            position: relative;
            width: 100%;
            padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
            background-color: #000;
        }
        .video-thumbnail {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .play-icon-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }
        .video-card:hover .play-icon-overlay {
            opacity: 0.8;
        }
        .video-title {
            font-weight: 600;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.4;
            color: var(--text-primary);
        }
        .channel-info {
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin-top: 4px;
        }
        .age-gate {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: var(--bg-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            flex-direction: column;
        }
        .age-gate-content {
            max-width: 500px;
            text-align: center;
            padding: 3rem;
            background-color: var(--bg-secondary);
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.5);
        }
        /* New Category Menu Styles */
        .category-menu {
            position: fixed;
            top: 0;
            left: 0;
            width: 280px; /* Fixed width */
            height: 100%;
            background-color: #0f0f0f;
            z-index: 10000;
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
            overflow-y: auto;
            border-right: 1px solid var(--border);
        }
        .category-menu.open {
            transform: translateX(0);
        }
        .category-menu a {
            display: flex;
            align-items: center;
            padding: 12px 24px;
            color: var(--text-primary);
            font-size: 1rem;
            font-weight: 500;
            border-radius: 8px;
            margin: 4px 12px;
            transition: background-color 0.2s ease;
        }
        .category-menu a:hover {
            background-color: var(--bg-secondary);
        }
        .category-menu a i {
            width: 24px;
            margin-right: 20px;
            text-align: center;
            color: var(--text-secondary);
        }
        .category-menu .divider {
            height: 1px;
            background-color: var(--border);
            margin: 12px 0;
        }
        .premium-btn {
            background-color: var(--bg-secondary);
            color: var(--text-secondary);
            border-radius: 9999px;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
        }
        .premium-btn:hover {
            background-color: #333333;
            color: var(--text-primary);
        }
        .premium-btn.active {
            color: var(--accent);
        }
        .search-container {
            background-color: var(--bg-primary);
            position: sticky;
            top: 69px;
            z-index: 49;
            padding: 1rem;
            border-bottom: 1px solid var(--border);
        }

        /* Skeleton Loader Styles */
        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }
        .skeleton-loader {
            background: linear-gradient(to right, var(--bg-secondary) 8%, #333 18%, var(--bg-secondary) 33%);
            background-size: 2000px 100%;
            animation: shimmer 2s infinite linear;
        }
        .skeleton-card {
            background-color: var(--bg-secondary);
            border-radius: 12px;
            overflow: hidden;
        }
        .skeleton-thumbnail {
            width: 100%;
            padding-bottom: 56.25%;
        }
        .skeleton-text {
            height: 20px;
            border-radius: 4px;
            margin-top: 10px;
        }
        .skeleton-text-sm {
            height: 14px;
            width: 60%;
            border-radius: 4px;
            margin-top: 8px;
        }
    </style>
</head>
<body>
    
    <div id="LuxTechZone"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // HTML content ko ek variable mein store karein
            const htmlContent = `
                <div class="age-gate" id="ageGate">
                    <div class="age-gate-content">
                        <h1 class="text-3xl font-bold mb-4 text-white">
                            <i class="fas fa-exclamation-triangle mr-2 text-red-500"></i>Adult Content Warning
                        </h1>
                        <p class="mb-6 text-gray-400">This website contains adult content and is only suitable for those 18 years of age or older. By entering, you confirm that you are at least 18 years old.</p>
                        <div class="flex flex-col space-y-3">
                            <button onclick="verifyAge(true)" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-full transition-colors duration-300 flex items-center justify-center">
                                <i class="fas fa-check-circle mr-2"></i> I am 18 or older - Enter
                            </button>
                            <button onclick="verifyAge(false)" class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-full transition-colors duration-300 flex items-center justify-center">
                                <i class="fas fa-times-circle mr-2"></i> I am under 18 - Exit
                            </button>
                        </div>
                    </div>
                </div>

                <div class="category-menu" id="categoryMenu">
                    <div class="p-4">
                        <div class="flex justify-end">
                            <button onclick="toggleCategoryMenu()" class="text-gray-400 hover:text-white transition-colors text-2xl p-2">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div id="category-list" class="mt-4"></div>
                    </div>
                </div>

                <div id="mainContent" class="hidden">
                    <nav class="navbar sticky top-0 z-50 px-4 py-4 shadow-lg">
                        <div class="container mx-auto flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <button onclick="toggleCategoryMenu()" class="text-gray-400 hover:text-white transition-colors duration-200 text-2xl">
                                    <i class="fas fa-bars"></i>
                                </button>
                                <div class="logo">
                                    <a href="?">ADULTVIBE</a>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <button class="bg-gray-800 hover:bg-gray-700 text-white py-2 px-6 rounded-full text-sm font-medium transition-colors duration-200 hidden md:block">
                                    <i class="fas fa-user-circle mr-2"></i> Sign In
                                </button>
                            </div>
                        </div>
                    </nav>

                    <div class="search-container">
                        <div class="container mx-auto flex justify-center px-4">
                            <form id="searchForm" class="relative w-full max-w-lg md:max-w-xl">
                                <input type="text" id="searchInput" placeholder="Search for movies, actors..." class="search-input w-full pl-6 pr-12">
                                <i class="fas fa-search absolute right-6 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            </form>
                        </div>
                    </div>

                    <main class="container mx-auto px-4 py-8">
                        <div id="app">
                            <!-- Content will be injected here -->
                        </div>
                    </main>

                    <footer class="bg-bg-primary py-8 mt-12 border-t border-border">
                        <div class="container mx-auto px-4 text-center text-text-secondary text-sm">
                            <p>&copy; 2024 ADULTVIBE. All rights reserved.</p>
                            <div class="flex justify-center space-x-6 mt-4 text-xl">
                                <a href="#" class="hover:text-white transition-colors duration-200"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="hover:text-white transition-colors duration-200"><i class="fab fa-instagram"></i></a>
                                <a href="#" class="hover:text-white transition-colors duration-200"><i class="fab fa-tiktok"></i></a>
                            </div>
                        </div>
                    </footer>
                </div>
            `;

            // HTML content ko 'LuxTechZone' ID wale div mein inject karein
            document.getElementById('LuxTechZone').innerHTML = htmlContent;

            // Ab original script ke logic ko yahan execute karein
            runOriginalScriptLogic();
        });

        function runOriginalScriptLogic() {
            // --- Global Constants and DOM Elements ---
            const BASE_URL = "https://xvidapi.com/api.php/provide/vod?ac=detail";
            const API_DETAIL_URL = "https://xvidapi.com/api.php/provide/vod?ac=detail&ids=";
            const CATEGORIES = {
                'Xvidapi': 1, 'AI': 7, 'Amateur': 8, 'Anal': 9, 'Arab': 10, 'Asian': 11,
                'ASMR': 12, 'Ass': 13, 'Babe': 14, 'BBW': 15, 'BDSM': 16, 'Big Ass': 17,
                'Big Tits': 18, 'Bisexual': 19, 'Blonde': 20, 'Blowjob': 21, 'Brazilian': 22,
                'British': 23, 'Brunette': 24, 'Bukkake': 25, 'Cartoon': 26, 'Celebrity': 27,
                'College': 28, 'Cosplay': 29, 'Creampie': 30, 'Cumshot': 31, 'Czech': 32,
                'Double Penetration': 33, 'Ebony': 34, 'European': 35, 'Family Strokes': 36,
                'Fetish': 37, 'Fingering': 38, 'French': 39, 'Funny': 40, 'Gangbang': 41,
                'German': 42, 'Japanese': 43, 'Latina': 44, 'Lesbian': 45, 'Lingerie': 46,
                'Massage': 47, 'Masturbation': 48, 'MILF': 49, 'Mom': 50, 'Nurse': 51,
                'Office': 52, 'Old/Young': 53, 'Party': 54, 'Pornstar': 55, 'POV': 56,
                'Public': 57, 'Redhead': 58, 'Russian': 59, 'School': 60, 'Solo': 61,
                'Squirt': 62, 'Step Fantasy': 63, 'Teacher': 64, 'Teen': 65, 'Threesome': 66,
                'Toys': 67, 'Webcam': 68, 'Hentai': 69
            };
            const CATEGORY_ICONS = {
                'Xvidapi': 'fa-play-circle', 'AI': 'fa-robot', 'Amateur': 'fa-camera', 'Anal': 'fa-ring', 'Arab': 'fa-moon', 'Asian': 'fa-fan',
                'ASMR': 'fa-headphones', 'Ass': 'fa-peach', 'Babe': 'fa-heart', 'BBW': 'fa-weight-hanging', 'BDSM': 'fa-link', 'Big Ass': 'fa-ruler-horizontal',
                'Big Tits': 'fa-ruler-vertical', 'Bisexual': 'fa-venus-mars', 'Blonde': 'fa-user-tag', 'Blowjob': 'fa-wind', 'Brazilian': 'fa-flag',
                'British': 'fa-crown', 'Brunette': 'fa-user-tag', 'Bukkake': 'fa-spray-can', 'Cartoon': 'fa-paint-brush', 'Celebrity': 'fa-star',
                'College': 'fa-graduation-cap', 'Cosplay': 'fa-mask', 'Creampie': 'fa-cookie-bite', 'Cumshot': 'fa-tint', 'Czech': 'fa-beer',
                'Double Penetration': 'fa-arrows-alt-h', 'Ebony': 'fa-gem', 'European': 'fa-globe-europe', 'Family Strokes': 'fa-home',
                'Fetish': 'fa-shoe-prints', 'Fingering': 'fa-hand-point-up', 'French': 'fa-wine-glass', 'Funny': 'fa-laugh', 'Gangbang': 'fa-users',
                'German': 'fa-car', 'Japanese': 'fa-torii-gate', 'Latina': 'fa-pepper-hot', 'Lesbian': 'fa-venus-double', 'Lingerie': 'fa-tshirt',
                'Massage': 'fa-spa', 'Masturbation': 'fa-hand-paper', 'MILF': 'fa-female', 'Mom': 'fa-child', 'Nurse': 'fa-user-nurse',
                'Office': 'fa-briefcase', 'Old/Young': 'fa-history', 'Party': 'fa-cocktail', 'Pornstar': 'fa-video', 'POV': 'fa-eye',
                'Public': 'fa-building', 'Redhead': 'fa-fire', 'Russian': 'fa-snowflake', 'School': 'fa-school', 'Solo': 'fa-user',

                'Squirt': 'fa-water', 'Step Fantasy': 'fa-walking', 'Teacher': 'fa-chalkboard-teacher', 'Teen': 'fa-child-reaching', 'Threesome': 'fa-users',
                'Toys': 'fa-gamepad', 'Webcam': 'fa-desktop', 'Hentai': 'fa-dragon'
            };

            const app = document.getElementById('app');
            const ageGate = document.getElementById('ageGate');
            const mainContent = document.getElementById('mainContent');
            const categoryMenu = document.getElementById('categoryMenu');
            const categoryListContainer = document.getElementById('category-list');
            const searchForm = document.getElementById('searchForm');
            const searchInput = document.getElementById('searchInput');

            // --- Watch History Functions ---
            window.getWatchHistory = function() {
                const history = localStorage.getItem('watchHistory');
                return history ? JSON.parse(history) : [];
            }

            window.saveToWatchHistory = function(movie) {
                let history = getWatchHistory();
                history = history.filter(item => item.id !== movie.id);
                history.unshift({
                    id: movie.id,
                    name: movie.name,
                    poster_url: movie.poster_url,
                    director: movie.director,
                    year: movie.year,
                    lastWatched: new Date().toISOString()
                });
                if (history.length > 100) {
                    history = history.slice(0, 100);
                }
                localStorage.setItem('watchHistory', JSON.stringify(history));
            }

            window.clearWatchHistory = function() {
                localStorage.removeItem('watchHistory');
                renderHistoryPage();
            }

            // --- Core Functions ---
            async function fetchData(url) {
                try {
                    const response = await fetch(url);
                    if (!response.ok) {
                        throw new Error(`Network response was not ok: ${response.statusText}`);
                    }
                    return await response.json();
                } catch (error) {
                    console.error("API Fetch Error:", error);
                    app.innerHTML = `<p class="text-red-400 text-center text-xl mt-10"><i class="fas fa-exclamation-triangle mr-2"></i>There was a problem loading data. Please check your network connection or the API status.</p>`;
                    return null;
                }
            }

            // --- HTML Generation Functions ---
            function createVideoGridHTML(videos) {
                if (!videos || videos.length === 0) {
                    return '<p class="text-gray-400 text-center text-xl mt-10"><i class="fas fa-video-slash mr-2"></i>No videos found in this section.</p>';
                }
                const videoCards = videos.map(movie => `
                    <a href="?id=${movie.id}" class="block video-card">
                        <div class="video-thumbnail-container">
                            <img src="${movie.poster_url}" alt="${movie.name}" class="video-thumbnail" onerror="this.onerror=null;this.src='https://placehold.co/400x225/1e1e1e/b0b0b0?text=Image+Missing';">
                            <div class="play-icon-overlay">
                                <i class="fas fa-play-circle text-white text-6xl" style="text-shadow: 0 0 10px rgba(0,0,0,0.7);"></i>
                            </div>
                        </div>
                        <div class="p-4">
                            <h2 class="video-title text-base font-semibold text-text-primary">${movie.name}</h2>
                            <p class="channel-info mt-1">${(movie.director && movie.director.join(", ")) || "Unknown"}</p>
                            <p class="channel-info">${movie.year}</p>
                        </div>
                    </a>
                `).join("");
                return `<div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">${videoCards}</div>`;
            }

            function createPaginationHTML(currentPage, listLength, params) {
                const createLink = (page) => {
                    const newParams = new URLSearchParams(params);
                    newParams.set('page', page);
                    return `?${newParams.toString()}`;
                };
                const prevButton = currentPage > 1 ? `<a href="${createLink(currentPage - 1)}" class="px-6 py-3 bg-gray-700 rounded-full hover:bg-gray-600 text-white font-semibold transition-colors duration-200 shadow-md"><i class="fas fa-arrow-left mr-2"></i>Prev</a>` : '<span></span>';
                const nextButton = listLength === 30 ? `<a href="${createLink(currentPage + 1)}" class="px-6 py-3 bg-gray-700 rounded-full hover:bg-gray-600 text-white font-semibold transition-colors duration-200 shadow-md">Next<i class="fas fa-arrow-right ml-2"></i></a>` : '<span></span>';
                return `<div class="flex justify-between mt-8">${prevButton}${nextButton}</div>`;
            }

            function createSkeletonGridHTML(count = 10) {
                let skeletonHTML = '';
                for (let i = 0; i < count; i++) {
                    skeletonHTML += `
                        <div class="skeleton-card">
                            <div class="skeleton-thumbnail skeleton-loader"></div>
                            <div class="p-4">
                                <div class="skeleton-text skeleton-loader"></div>
                                <div class="skeleton-text-sm skeleton-loader"></div>
                            </div>
                        </div>
                    `;
                }
                return `<div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">${skeletonHTML}</div>`;
            }

            function createMovieDetailSkeletonHTML() {
                return `
                    <div class="flex flex-col lg:flex-row gap-8 animate-pulse">
                        <div class="lg:w-3/4">
                            <div class="aspect-w-16 aspect-h-9 mb-6 rounded-lg bg-gray-700 skeleton-loader"></div>
                            <div class="h-8 w-3/4 bg-gray-700 rounded skeleton-loader mb-2"></div>
                            <div class="h-5 w-1/2 bg-gray-700 rounded skeleton-loader mb-4"></div>
                            <div class="bg-bg-secondary rounded-lg p-4 mt-6">
                                <div class="h-4 w-1/4 bg-gray-700 rounded skeleton-loader mb-2"></div>
                                <div class="h-4 w-full bg-gray-700 rounded skeleton-loader mb-2"></div>
                                <div class="h-4 w-full bg-gray-700 rounded skeleton-loader"></div>
                            </div>
                        </div>
                        <div class="lg:w-1/4">
                            <div class="h-6 w-1/2 bg-gray-700 rounded skeleton-loader mb-4"></div>
                            <div class="space-y-4">
                                ${[...Array(5)].map(() => `
                                    <div class="flex items-center space-x-3">
                                        <div class="w-24 h-16 bg-gray-700 rounded-lg skeleton-loader"></div>
                                        <div class="flex-1 space-y-2">
                                            <div class="h-4 bg-gray-700 rounded skeleton-loader"></div>
                                            <div class="h-4 w-1/2 bg-gray-700 rounded skeleton-loader"></div>
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    </div>
                `;
            }

            // --- Page Rendering Functions ---
            async function renderHomepage() {
                app.innerHTML = `<h2 class="text-2xl font-bold mb-6">All Videos</h2>${createSkeletonGridHTML()}`;
                const initialData = await fetchData(`${BASE_URL}&pg=1&limit=30&at=json`);
                if (!initialData) return;
                const pageCount = initialData.page_count || 50;
                const randomPage = Math.floor(Math.random() * pageCount) + 1;
                const data = await fetchData(`${BASE_URL}&pg=${randomPage}&limit=30&at=json`);
                if (!data || !data.list) {
                    app.innerHTML = `<h2 class="text-2xl font-bold mb-6">All Videos</h2><p class="text-red-400 text-center text-xl mt-10">Could not load videos. Please try again later.</p>`;
                    return;
                }
                const videoGridHTML = createVideoGridHTML(data.list);
                app.innerHTML = `
                    <h2 class="text-2xl font-bold mb-6">All Videos</h2>
                    ${videoGridHTML}
                    <div class="text-center mt-8">
                        <a href="?" class="px-6 py-3 bg-red-600 rounded-full hover:bg-red-700 text-white font-semibold transition-colors duration-200 shadow-md inline-flex items-center">
                            <i class="fas fa-sync-alt mr-2"></i>Load More Videos
                        </a>
                    </div>
                `;
            }

            async function renderCategoryPage(catId, page) {
                const catName = Object.keys(CATEGORIES).find(key => CATEGORIES[key] == catId) || 'Unknown';
                const heading = `Category: ${catName}`;
                app.innerHTML = `<h2 class="text-2xl font-bold mb-6">${heading}</h2>${createSkeletonGridHTML()}`;
                const data = await fetchData(`${BASE_URL}&t=${catId}&pg=${page}&limit=30&at=json`);
                if (!data) return;
                const videoGridHTML = createVideoGridHTML(data.list);
                const paginationHTML = createPaginationHTML(page, data.list.length, { cat: catId });
                app.innerHTML = `<h2 class="text-2xl font-bold mb-6">${heading}</h2>${videoGridHTML}${paginationHTML}`;
            }

            async function renderSearchPage(query, page) {
                const heading = `Search Results for "${query}"`;
                app.innerHTML = `<h2 class="text-2xl font-bold mb-6">${heading}</h2>${createSkeletonGridHTML()}`;
                const data = await fetchData(`${BASE_URL}&wd=${encodeURIComponent(query)}&pg=${page}&limit=30&at=json`);
                if (!data) return;
                const videoGridHTML = createVideoGridHTML(data.list);
                const paginationHTML = createPaginationHTML(page, data.list.length, { wd: query });
                app.innerHTML = `<h2 class="text-2xl font-bold mb-6">${heading}</h2>${videoGridHTML}${paginationHTML}`;
            }

            async function renderMovieDetailPage(movieId) {
                app.innerHTML = createMovieDetailSkeletonHTML();
                const data = await fetchData(`${API_DETAIL_URL}${movieId}&at=json`);
                if (!data || !data.list || data.list.length === 0) {
                    app.innerHTML = `<p class="text-red-400 text-center text-xl mt-10"><i class="fas fa-exclamation-circle mr-2"></i>Movie not found.</p>`;
                    return;
                }
                const movie = data.list[0];
                saveToWatchHistory(movie);

                const embed = movie.episodes?.server_data?.Full?.link_embed || "";
                const actorDetails = movie.actor?.length ? movie.actor.map(a => `<span class="px-3 py-1 bg-gray-700 text-gray-300 rounded-full text-sm">${a}</span>`).join(" ") : "Not available";
                const tagsHTML = movie.tag?.split(',').map(tag => `<span class="px-3 py-1 bg-gray-800 rounded-full text-xs text-text-secondary">${tag.trim()}</span>`).join("") || "N/A";
                
                app.innerHTML = `
                    <div class="flex flex-col lg:flex-row gap-8">
                        <div class="lg:w-3/4">
                            <div class="aspect-w-16 aspect-h-9 mb-6 rounded-lg overflow-hidden bg-black">
                                <iframe src="${embed}" class="w-full h-full rounded-lg" frameborder="0" allowfullscreen></iframe>
                            </div>
                            <h1 class="text-2xl md:text-3xl font-bold text-text-primary mb-2">${movie.name}</h1>
                            <div class="flex items-center justify-between mb-4 flex-wrap gap-4">
                                <div class="flex items-center space-x-2 text-sm text-text-secondary">
                                    <span><i class="fas fa-calendar-alt mr-1"></i>${movie.year}</span> • <span><i class="fas fa-film mr-1"></i>${movie.quality}</span> • <span><i class="fas fa-info-circle mr-1"></i>${movie.status}</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <button onclick="toggleLike(this)" class="premium-btn" data-action="like"><i class="far fa-thumbs-up mr-2"></i> Like</button>
                                    <button onclick="toggleLike(this)" class="premium-btn" data-action="dislike"><i class="far fa-thumbs-down mr-2"></i> Dislike</button>
                                    <button class="premium-btn hidden md:flex items-center"><i class="far fa-share-square mr-2"></i> Share</button>
                                </div>
                            </div>
                            <div class="bg-bg-secondary rounded-lg p-4 mt-6">
                                <p class="text-text-primary text-sm font-semibold mb-2">Description</p>
                                <p class="text-text-secondary whitespace-pre-wrap">${movie.description || "No description available."}</p>
                            </div>
                            <div class="bg-bg-secondary rounded-lg p-4 mt-4">
                                <div class="flex flex-wrap items-center gap-3 mb-2">
                                    <b class="text-text-primary text-sm"><i class="fas fa-users mr-2"></i>Actors:</b> <div class="flex flex-wrap gap-2">${actorDetails}</div>
                                </div>
                                <div class="flex flex-wrap items-center gap-3">
                                    <b class="text-text-primary text-sm"><i class="fas fa-tags mr-2"></i>Tags:</b> <div class="flex flex-wrap gap-2">${tagsHTML}</div>
                                </div>
                            </div>
                        </div>
                        <div class="lg:w-1/4">
                            <h3 class="text-xl font-bold mb-4">Related Videos</h3>
                            <div id="related-videos-container" class="flex flex-col space-y-4">
                                <p class="text-gray-400 text-sm">Loading related videos...</p>
                            </div>
                        </div>
                    </div>
                `;
                loadRelatedVideos();
            }

            function renderHistoryPage() {
                const history = getWatchHistory();
                let content;
                if (history.length === 0) {
                    content = '<p class="text-gray-400 text-center text-xl mt-10"><i class="fas fa-history mr-2"></i>Your watch history is empty.</p>';
                } else {
                    content = createVideoGridHTML(history);
                }
                app.innerHTML = `
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Watch History</h2>
                        ${history.length > 0 ? '<button id="clearHistoryBtn" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full transition-colors duration-300 text-sm flex items-center"><i class="fas fa-trash mr-2"></i>Clear History</button>' : ''}
                    </div>
                    ${content}
                `;

                if (history.length > 0) {
                    document.getElementById('clearHistoryBtn').addEventListener('click', clearWatchHistory);
                }
            }

            async function loadRelatedVideos() {
                const container = document.getElementById('related-videos-container');
                const initialData = await fetchData(`${BASE_URL}&pg=1&limit=10&at=json`);
                if (!initialData) {
                    container.innerHTML = '<p class="text-gray-400 text-sm">Could not load related videos.</p>';
                    return;
                }
                const pageCount = initialData.page_count || 50;
                const randomPage = Math.floor(Math.random() * pageCount) + 1;
                const data = await fetchData(`${BASE_URL}&pg=${randomPage}&limit=10&at=json`);
                if (!data || !data.list || data.list.length === 0) {
                    container.innerHTML = '<p class="text-gray-400 text-sm">No related videos found.</p>';
                    return;
                }
                container.innerHTML = data.list.map(video => `
                    <a href="?id=${video.id}" class="related-video-card bg-bg-secondary rounded-lg overflow-hidden flex space-x-3 p-2 transition-colors hover:bg-gray-700">
                        <div class="w-24 h-16 rounded-lg overflow-hidden flex-shrink-0">
                            <img src="${video.poster_url}" alt="${video.name}" class="w-full h-full object-cover" onerror="this.onerror=null;this.src='https://placehold.co/100x60/1e1e1e/b0b0b0?text=Img';">
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-white line-clamp-2">${video.name}</p>
                            <p class="text-xs text-gray-400 mt-1">${video.year}</p>
                        </div>
                    </a>
                `).join('');
            }

            // --- UI, Event Handlers, and Routing ---
            async function router() {
                const params = new URLSearchParams(window.location.search);
                const movieId = params.get("id");
                const categoryId = params.get("cat");
                const searchQuery = params.get("wd");
                const view = params.get("view");
                const page = parseInt(params.get("page")) || 1;
                
                if (movieId) {
                    await renderMovieDetailPage(movieId);
                    sessionStorage.removeItem('scrollPosition');
                } else if (categoryId) {
                    await renderCategoryPage(categoryId, page);
                } else if (searchQuery) {
                    await renderSearchPage(searchQuery, page);
                } else if (view === 'history') {
                    renderHistoryPage();
                } else {
                    await renderHomepage();
                }
                
                if (!movieId) {
                    const savedPosition = sessionStorage.getItem('scrollPosition');
                    if (savedPosition) {
                        setTimeout(() => {
                            window.scrollTo(0, parseInt(savedPosition, 10));
                            sessionStorage.removeItem('scrollPosition');
                        }, 100);
                    }
                }
            }

            function setupEventListeners() {
                searchForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    const query = searchInput.value.trim();
                    if (query) {
                        const url = new URL(window.location);
                        url.search = `wd=${encodeURIComponent(query)}`;
                        history.pushState({}, '', url);
                        router(); 
                    }
                });

                app.addEventListener('click', (e) => {
                    const cardLink = e.target.closest('a.video-card, a.related-video-card');
                    if (cardLink) {
                        sessionStorage.setItem('scrollPosition', window.scrollY);
                    }
                });

                window.addEventListener('popstate', router);
            }

            // --- App Initialization ---
            if (localStorage.getItem('ageVerified') === 'true') {
                ageGate.classList.add('hidden');
                mainContent.classList.remove('hidden');
            }
            
            let categoryHTML = Object.entries(CATEGORIES).map(([name, id]) => {
                const icon = CATEGORY_ICONS[name] || 'fa-film';
                return `<a href="?cat=${id}" onclick="toggleCategoryMenu()"><i class="fas ${icon}"></i><span>${name}</span></a>`;
            }).join('');
            
            categoryHTML += `<div class="divider"></div>`;
            categoryHTML += `<a href="?view=history" onclick="toggleCategoryMenu()"><i class="fas fa-history"></i><span>Watch History</span></a>`;

            categoryListContainer.innerHTML = categoryHTML;
            
            setupEventListeners();
            router();
        }

        // --- Other UI Functions (Global scope mein move karein) ---
        window.verifyAge = function(isAdult) {
            const ageGate = document.getElementById('ageGate');
            const mainContent = document.getElementById('mainContent');
            if (isAdult) {
                localStorage.setItem('ageVerified', 'true');
                ageGate.classList.add('hidden');
                mainContent.classList.remove('hidden');
            } else {
                window.location.href = "https://www.google.com";
            }
        }

        window.toggleCategoryMenu = function() {
            const categoryMenu = document.getElementById('categoryMenu');
            categoryMenu.classList.toggle('open');
        }

        window.toggleLike = function(button) {
            const parent = button.closest('div');
            const likeBtn = parent.querySelector('[data-action="like"]');
            const dislikeBtn = parent.querySelector('[data-action="dislike"]');
            const action = button.dataset.action;
            if (action === 'like') {
                likeBtn.classList.toggle('active');
                dislikeBtn.classList.remove('active');
            } else {
                dislikeBtn.classList.toggle('active');
                likeBtn.classList.remove('active');
            }
        }
    </script>
</body>
</html>
