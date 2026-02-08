<?php 
    session_start();
    include '../config/connection.php';
    include '../src/components/header.php';
    include '../src/components/navbar.php';

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        // Jika bukan admin, tendang ke login atau home
        header("Location: ../public/login.php"); exit(); 
    }

    // Get statistics
    $stats = [];

    // Count pending member requests
    $pending_query = "SELECT COUNT(*) as count FROM members WHERE status = 'pending'";
    $pending_result = $conn->query($pending_query);
    $stats['pending_requests'] = $pending_result->fetch_assoc()['count'];

    // Count total members
    $members_query = "SELECT COUNT(*) as count FROM members WHERE status = 'active'";
    $members_result = $conn->query($members_query);
    $stats['total_members'] = $members_result->fetch_assoc()['count'];

    // Count total users
    $users_query = "SELECT COUNT(*) as count FROM users";
    $users_result = $conn->query($users_query);
    $stats['total_users'] = $users_result->fetch_assoc()['count'];

    // Count unread notifications
    $notif_query = "SELECT COUNT(*) as count FROM admin_notifications WHERE is_read = 0";
    $notif_result = $conn->query($notif_query);
    $stats['unread_notifications'] = $notif_result->fetch_assoc()['count'];

    // Get latest pending requests
    $latest_requests_query = "SELECT m.*, u.email 
                              FROM members m 
                              JOIN users u ON m.userID = u.userID 
                              WHERE m.status = 'pending' 
                              ORDER BY m.applied_at DESC 
                              LIMIT 5";
    $latest_requests = $conn->query($latest_requests_query);

    // Get latest notifications JOIN with members to get fullName
    $latest_notif_query = "SELECT n.*, m.fullName 
                           FROM admin_notifications n 
                           LEFT JOIN members m ON n.userID = m.userID 
                           ORDER BY n.created_at DESC 
                           LIMIT 5";
    $latest_notifications = $conn->query($latest_notif_query);

    // Get ongoing activities
    $activities_query = "SELECT a.*, COUNT(pa.userID) as participants 
                        FROM activities a 
                        LEFT JOIN participations pa ON a.activityID = pa.activityID 
                        WHERE a.status = 'ongoing' 
                        GROUP BY a.activityID 
                        ORDER BY a.trainDate DESC 
                        LIMIT 5";
    $ongoing_activities = $conn->query($activities_query);

    // Gantikan bahagian LEFT JOIN dalam query chart anda:
    $participation_query = "SELECT 
                        COUNT(DISTINCT CASE WHEN u.role = 'member' THEN pa.userID END) as member_participants,
                        COUNT(DISTINCT CASE WHEN u.role = 'user' THEN pa.userID END) as user_participants,
                        DATE_FORMAT(a.trainDate, '%Y-%m') as month
                        FROM activities a
                        LEFT JOIN participations pa ON a.activityID = pa.activityID
                        LEFT JOIN users u ON pa.userID = u.userID
                        WHERE a.trainDate >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
                        GROUP BY DATE_FORMAT(a.trainDate, '%Y-%m')
                        ORDER BY month";
    $participation_data = $conn->query($participation_query);

    // Prepare data for chart
    $chart_labels = [];
    $member_data = [];
    $user_data = [];

    while ($row = $participation_data->fetch_assoc()) {
        $chart_labels[] = date('M Y', strtotime($row['month'] . '-01'));
        $member_data[] = $row['member_participants'] ?? 0;
        $user_data[] = $row['user_participants'] ?? 0;
    }
?>

<div class="flex min-h-screen">
    <?php include '../src/components/sidebar_admin.php'; ?>
    <div class="flex-1 lg:flex-row min-h-screen">
    
        <main class="flex-1 py-2 px-4 lg:p-8">
            <!-- Profile Header -->
            <div class="my-4 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex flex-col lg:flex-row items-center gap-6">
                    <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center border-4 border-white shadow-md">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    
                    <div class="flex-1">
                        <div class="text-center lg:text-left">
                            <h2 class="text-xl font-bold text-gray-800">Admin Dashboard</h2>
                            <p class="text-gray-600 mt-1">Sistem Pengurusan i-KompIra</p>
                            
                            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-2">
                                    <p class="font-semibold text-gray-700 sm:text-right sm:col-span-1">EMAIL :</p>
                                    <p class="display-field-bg border border-gray-300 rounded-md p-2 shadow-inner w-full truncate sm:col-span-2">
                                        <?php echo $_SESSION['email'] ?? 'admin@i-kompira.com'; ?>
                                    </p>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-2">
                                    <p class="font-semibold text-gray-700 sm:text-right sm:col-span-1">STATUS :</p>
                                    <p class="display-field-bg border border-gray-300 rounded-md p-2 shadow-inner w-full sm:col-span-2">
                                        <span class="px-3 py-1 bg-green-100 text-green-700 text-sm rounded-full">Admin Aktif</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <button onclick="location.href='edit_profile.php'" 
                                class="bg-[#6A8D73] hover:bg-[#5a7d63] text-white font-bold py-2 px-6 rounded-md shadow-md transition">
                            EDIT PROFIL
                        </button>
                    </div>
                </div>
            </div>
    
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Permohonan Tertunda</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1"><?php echo $stats['pending_requests']; ?></p>
                        </div>
                        <div class="bg-yellow-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
    
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Ahli Aktif</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1"><?php echo $stats['total_members']; ?></p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
    
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Pengguna</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1"><?php echo $stats['total_users']; ?></p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0c-.83.63-1.873 1-3 1s-2.17-.37-3-1"/>
                            </svg>
                        </div>
                    </div>
                </div>
    
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Notifikasi Baru</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1"><?php echo $stats['unread_notifications']; ?></p>
                        </div>
                        <div class="bg-red-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Left Column -->
                <div class="space-y-8">
                    <!-- User Requests Section -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                            <h2 class="text-lg font-semibold text-gray-800">Permohonan Ahli Baru</h2>
                            <a href="members.php" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
                        </div>
                        <div class="p-6">
                            <?php if ($latest_requests->num_rows > 0): ?>
                                <div class="space-y-4">
                                    <?php while ($request = $latest_requests->fetch_assoc()): ?>
                                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                            <div>
                                                <p class="font-medium text-gray-800"><?php echo htmlspecialchars($request['fullName']); ?></p>
                                                <p class="text-sm text-gray-500"><?php echo htmlspecialchars($request['email']); ?></p>
                                                <p class="text-xs text-gray-400 mt-1">
                                                    Dihantar: <?php echo date('d/m/Y H:i', strtotime($request['applied_at'])); ?>
                                                </p>
                                            </div>
                                            <!-- <a href="review_request.php?id=<?php // echo $request['profileID']; ?>" 
                                               class="px-3 py-1 bg-[#6A8D73] text-white text-sm rounded-md hover:bg-[#5a7d63] transition">
                                                Semak
                                            </a> -->
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            <?php else: ?>
                                <p class="text-gray-500 text-center py-8">Tiada permohonan terkini</p>
                            <?php endif; ?>
                        </div>
                    </div>
    
                    <!-- Ongoing Activities Section -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                            <h2 class="text-lg font-semibold text-gray-800">Aktiviti Berlangsung</h2>
                            <a href="activities.php" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
                        </div>
                        <div class="p-6">
                            <?php if ($ongoing_activities && $ongoing_activities->num_rows > 0): ?>
                                <div class="space-y-4">
                                    <?php while ($activity = $ongoing_activities->fetch_assoc()): ?>
                                        <div class="p-4 border border-gray-200 rounded-lg">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <h3 class="font-medium text-gray-800"><?php echo htmlspecialchars($activity['activityTitle']); ?></h3>
                                                    <p class="text-sm text-gray-600 mt-1"><?php echo htmlspecialchars($activity['activityDesc'] ?? 'Tiada deskripsi'); ?></p>
                                                </div>
                                                <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full">
                                                    <?php echo $activity['participants'] ?? 0; ?> Peserta
                                                </span>
                                            </div>
                                            <div class="mt-3 flex items-center text-sm text-gray-500">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                <?php echo date('d/m/Y', strtotime($activity['trainDate'])); ?>
                                            </div>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            <?php else: ?>
                                <p class="text-gray-500 text-center py-8">Tiada aktiviti berlangsung</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
    
                <!-- Right Column -->
                <div class="space-y-8">
                    <!-- Notifications Section -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                            <h2 class="text-lg font-semibold text-gray-800">Notifikasi Terkini</h2>
                            <!-- <a href="notifications.php" class="text-sm text-blue-600 hover:underline">Lihat Semua</a> -->
                        </div>
                        <div class="p-6">
                            <?php if ($latest_notifications->num_rows > 0): ?>
                                <div class="space-y-4">
                                    <?php while ($notif = $latest_notifications->fetch_assoc()): ?>
                                        <div class="p-4 <?php echo $notif['is_read'] ? 'bg-white' : 'bg-blue-50'; ?> border border-gray-200 rounded-lg">
                                            <div class="flex justify-between items-start">
                                                <div class="flex-1">
                                                    <div class="flex items-center gap-2 mb-2">
                                                        <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">
                                                            <?php echo htmlspecialchars($notif['type']); ?>
                                                        </span>
                                                        <?php if (!$notif['is_read']): ?>
                                                            <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded">BARU</span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <p class="text-gray-700"><?php echo htmlspecialchars($notif['message']); ?></p>
                                                    <p class="text-xs text-gray-400 mt-2">
                                                        <?php echo date('d/m/Y H:i', strtotime($notif['created_at'])); ?>
                                                        <?php if ($notif['fullName']): ?>
                                                            • Dari: <?php echo htmlspecialchars($notif['fullName']); ?>
                                                        <?php endif; ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            <?php else: ?>
                                <p class="text-gray-500 text-center py-8">Tiada notifikasi</p>
                            <?php endif; ?>
                        </div>
                    </div>
    
                    <!-- Participation Chart Section -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-100">
                            <h2 class="text-lg font-semibold text-gray-800">Penyertaan Aktiviti (6 Bulan)</h2>
                        </div>
                        <div class="p-6">
                            <div class="h-64">
                                <canvas id="participationChart"></canvas>
                            </div>
                            <div class="flex justify-center gap-6 mt-6">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                                    <span class="text-sm text-gray-600">Ahli</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                                    <span class="text-sm text-gray-600">Pengguna</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
        </main>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Participation Chart
const ctx = document.getElementById('participationChart').getContext('2d');
const participationChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($chart_labels); ?>,
        datasets: [
            {
                label: 'Ahli',
                data: <?php echo json_encode($member_data); ?>,
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true
            },
            {
                label: 'Pengguna',
                data: <?php echo json_encode($user_data); ?>,
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.4,
                fill: true
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                mode: 'index',
                intersect: false
            }
        },
        scales: {
            x: {
                grid: {
                    display: false
                }
            },
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});
</script>

<?php include '../src/components/footer.php'; ?>