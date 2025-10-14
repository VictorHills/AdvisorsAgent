<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeadVista - Student Journey Tracker</title>
    <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.ne<t/npm/vanta@latest/dist/vanta.globe.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4361ee',
                        secondary: '#3a0ca3',
                        accent: '#f72585',
                        dark: '#1a1a2e',
                        light: '#f8f9fa'
                    }
                }
            }
        }
    </script>
    <style>
        .data-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        #vanta-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .green-badge {
            background-color: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .orange-badge {
            background-color: rgba(249, 115, 22, 0.1);
            color: #f97316;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">
<div id="vanta-bg"></div>

<div class="relative z-10">
    <!-- Navigation -->
    <nav class="bg-white bg-opacity-90 backdrop-blur-md shadow-sm fixed w-full z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <i data-feather="globe" class="text-primary h-6 w-6"></i>
                        <span class="ml-2 text-xl font-bold text-primary">LeadVista</span>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="index.html"
                           class="border-primary text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Dashboard</a>
                        <a href="students.html"
                           class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Students</a>
                        <a href="analytics.html"
                           class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Analytics</a>
                        <a href="teams.html"
                           class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Teams</a>
                    </div>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                    <button
                        class="bg-primary hover:bg-secondary px-4 py-2 rounded-md text-sm font-medium text-white transition duration-150 ease-in-out">
                        Export Data
                    </button>
                    <div class="ml-3 relative">
                        <div>
                            <button type="button"
                                    class="bg-gray-100 rounded-full flex text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                                    id="user-menu" aria-expanded="false" aria-haspopup="true">
                                <span class="sr-only">Open user menu</span>
                                <img class="h-8 w-8 rounded-full" src="http://static.photos/people/200x200/42" alt="">
                            </button>
                        </div>
                    </div>
                </div>
                <div class="-mr-2 flex items-center sm:hidden">
                    <button type="button"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary"
                            aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <i data-feather="menu" class="block h-6 w-6"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on menu state. -->
        <div class="sm:hidden" id="mobile-menu">
            <div class="pt-2 pb-3 space-y-1">
                <a href="index.html"
                   class="bg-primary bg-opacity-10 border-primary text-primary block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Dashboard</a>
                <a href="students.html"
                   class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Students</a>
                <a href="analytics.html"
                   class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Analytics</a>
                <a href="teams.html"
                   class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Teams</a>
            </div>
            <div class="pt-4 pb-3 border-t border-gray-200">
                <div class="flex items-center px-4">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full" src="http://static.photos/people/200x200/42" alt="">
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-gray-800">Admin User</div>
                        <div class="text-sm font-medium text-gray-500">admin@leadvista.com</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1">
                    <a href="#"
                       class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Your
                        Profile</a>
                    <a href="#"
                       class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Settings</a>
                    <a href="#"
                       class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Sign
                        out</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-24 pb-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Student Journey Dashboard</h1>
                    <p class="mt-2 text-gray-600">Visualize and track student application progress across
                        institutions</p>
                </div>
                <div class="mt-4 md:mt-0 flex space-x-3">
                    <div class="relative">
                        <select
                            class="appearance-none bg-white border border-gray-300 rounded-md pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary sm:text-sm">
                            <option>Last 30 days</option>
                            <option>Last 90 days</option>
                            <option>This year</option>
                            <option>All time</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                            <i data-feather="chevron-down" class="h-4 w-4 text-gray-400"></i>
                        </div>
                    </div>
                    <button type="button"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        <i data-feather="filter" class="mr-2 h-4 w-4"></i>
                        Filters
                    </button>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
                <div class="bg-white overflow-hidden shadow rounded-lg data-card transition duration-300 ease-in-out">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded-full">
                                <i data-feather="users" class="text-primary h-6 w-6"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Students</dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900">86</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg data-card transition duration-300 ease-in-out">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-100 p-3 rounded-full">
                                <i data-feather="check-circle" class="text-green-600 h-6 w-6"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Green Rating</dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900">54</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg data-card transition duration-300 ease-in-out">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-orange-100 p-3 rounded-full">
                                <i data-feather="alert-circle" class="text-orange-600 h-6 w-6"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Orange Rating</dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900">32</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg data-card transition duration-300 ease-in-out">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-100 p-3 rounded-full">
                                <i data-feather="dollar-sign" class="text-purple-600 h-6 w-6"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Payment Pending</dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900">72</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-medium text-gray-900">Lead Status Distribution</h2>
                        <div class="relative">
                            <select
                                class="appearance-none bg-white border border-gray-300 rounded-md pl-3 pr-8 py-1 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary text-sm">
                                <option>By Status</option>
                                <option>By Institution</option>
                                <option>By Team</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                <i data-feather="chevron-down" class="h-4 w-4 text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    <div class="h-80">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-medium text-gray-900">Student Timeline</h2>
                        <div class="relative">
                            <select
                                class="appearance-none bg-white border border-gray-300 rounded-md pl-3 pr-8 py-1 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary text-sm">
                                <option>Last 30 days</option>
                                <option>Last 90 days</option>
                                <option>This year</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                <i data-feather="chevron-down" class="h-4 w-4 text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    <div class="h-80">
                        <canvas id="timelineChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white shadow rounded-lg overflow-hidden mb-8">
                <div class="px-6 py-5 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Recent Student Activity</h3>
                        <button class="text-primary hover:text-secondary text-sm font-medium">View all</button>
                    </div>
                </div>
                <div class="divide-y divide-gray-200">
                    <div class="px-6 py-4 hover:bg-gray-50 transition duration-150 ease-in-out">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full" src="http://static.photos/people/200x200/1" alt="">
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-primary">Emmanuel Forson</p>
                                    <p class="text-sm text-gray-500">1h ago</p>
                                </div>
                                <div class="mt-1 flex items-center">
                                    <span class="status-badge green-badge">GREEN</span>
                                    <p class="ml-2 text-sm text-gray-500">University of Plymouth; UPIC</p>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Status changed to "Payment of School Fees"</p>
                            </div>
                            <div class="ml-4">
                                <i data-feather="chevron-right" class="h-5 w-5 text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-4 hover:bg-gray-50 transition duration-150 ease-in-out">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full" src="http://static.photos/people/200x200/2" alt="">
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-primary">Antoinette Sedinam Afi Dewortor</p>
                                    <p class="text-sm text-gray-500">2h ago</p>
                                </div>
                                <div class="mt-1 flex items-center">
                                    <span class="status-badge green-badge">GREEN</span>
                                    <p class="ml-2 text-sm text-gray-500">University of Sunderland</p>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Uploaded bank statement</p>
                            </div>
                            <div class="ml-4">
                                <i data-feather="chevron-right" class="h-5 w-5 text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-4 hover:bg-gray-50 transition duration-150 ease-in-out">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full" src="http://static.photos/people/200x200/3" alt="">
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-primary">Bosede Fayokemi Adekimi</p>
                                    <p class="text-sm text-gray-500">4h ago</p>
                                </div>
                                <div class="mt-1 flex items-center">
                                    <span class="status-badge orange-badge">ORANGE</span>
                                    <p class="ml-2 text-sm text-gray-500">Ulster-QA</p>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Application pending review</p>
                            </div>
                            <div class="ml-4">
                                <i data-feather="chevron-right" class="h-5 w-5 text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-4 hover:bg-gray-50 transition duration-150 ease-in-out">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full" src="http://static.photos/people/200x200/4" alt="">
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-primary">Felix Olorunsomo Olaosebikan</p>
                                    <p class="text-sm text-gray-500">6h ago</p>
                                </div>
                                <div class="mt-1 flex items-center">
                                    <span class="status-badge orange-badge">ORANGE</span>
                                    <p class="ml-2 text-sm text-gray-500">Northumbria QA</p>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Awaiting CAS issuance</p>
                            </div>
                            <div class="ml-4">
                                <i data-feather="chevron-right" class="h-5 w-5 text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    // Initialize Vanta.js globe background
    VANTA.GLOBE({
        el: "#vanta-bg",
        mouseControls: true,
        touchControls: true,
        gyroControls: false,
        minHeight: 200.00,
        minWidth: 200.00,
        scale: 1.00,
        scaleMobile: 1.00,
        color: 0x4361ee,
        size: 1.00,
        backgroundColor: 0xf8f9fa
    });

    // Initialize charts
    document.addEventListener('DOMContentLoaded', function () {
        // Status Distribution Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        const statusChart = new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Payment of School Fees', 'CAS Arrived', 'Visa Granted', 'Application Pending'],
                datasets: [{
                    data: [72, 8, 4, 2],
                    backgroundColor: [
                        '#4361ee',
                        '#3a0ca3',
                        '#f72585',
                        '#4cc9f0'
                    ],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'right',
                    }
                }
            }
        });

        // Timeline Chart
        const timelineCtx = document.getElementById('timelineChart').getContext('2d');
        const timelineChart = new Chart(timelineCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
                datasets: [
                    {
                        label: 'New Applications',
                        data: [12, 19, 15, 22, 18, 14, 21, 25, 18],
                        borderColor: '#4361ee',
                        backgroundColor: 'rgba(67, 97, 238, 0.05)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Completed',
                        data: [8, 12, 10, 15, 14, 10, 16, 18, 14],
                        borderColor: '#f72585',
                        backgroundColor: 'rgba(247, 37, 133, 0.05)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });
    });

    // Initialize feather icons
    feather.replace();
</script>
</body>
</html>
