<?php
session_start();
require_once '../config/connection.php';

// Check if user is admin
if (!isset($_SESSION['userID']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../public/login.php");
    exit();
}

$moduleID = $_GET['id'] ?? 0;

// Fetch module details
$sql = "SELECT * FROM modules WHERE moduleID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $moduleID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: modules.php?status=error&message=Modul tidak ditemui");
    exit();
}

$module = $result->fetch_assoc();

include '../src/components/admin_header.php';
include '../src/components/admin_navbar.php';
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Modul - i-KompIra</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    
    <div class="flex">
        <?php include '../src/components/sidebar_admin.php'; ?>
        
        <main class="flex-1 p-6 lg:p-10">
            <div class="mb-6">
                <a href="module_list.php" class="text-[#D4A259] hover:text-[#b88a4a] flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Senarai Modul
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-md overflow-hidden max-w-4xl mx-auto">
                <!-- Module Header -->
                <div class="bg-[#D4A259] text-white p-6">
                    <h1 class="text-2xl font-bold"><?php echo htmlspecialchars($module['moduleName']); ?></h1>
                    <p class="text-white/90 mt-2">ID Modul: <?php echo htmlspecialchars($module['moduleID']); ?></p>
                </div>
                
                <!-- Module Content -->
                <div class="p-8">
                    <div class="mb-8">
                        <h2 class="text-lg font-bold text-gray-800 mb-3">Penerangan Modul</h2>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-700 whitespace-pre-line"><?php echo nl2br(htmlspecialchars($module['moduleDesc'])); ?></p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-2">Tarikh Dibuat</h3>
                            <p class="text-gray-800"><?php echo date('d M Y, h:i A', strtotime($module['created_at'])); ?></p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-2">Tarikh Dikemaskini</h3>
                            <p class="text-gray-800">
                                <?php echo isset($module['updated_at']) ? date('d M Y, h:i A', strtotime($module['updated_at'])) : 'Tiada kemaskini'; ?>
                            </p>
                        </div>
                    </div>
                    
                    <!-- Content Sections (if any) -->
                    <div>
                        <h2 class="text-lg font-bold text-gray-800 mb-4">Kandungan Modul</h2>
                        <?php
                        // Check if module has content
                        $content_sql = "SELECT * FROM module_content WHERE moduleID = ? ORDER BY contentOrder";
                        $content_stmt = $conn->prepare($content_sql);
                        $content_stmt->bind_param("i", $moduleID);
                        $content_stmt->execute();
                        $content_result = $content_stmt->get_result();
                        
                        if ($content_result->num_rows > 0): ?>
                            <div class="space-y-4">
                                <?php while ($content = $content_result->fetch_assoc()): ?>
                                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="font-medium text-gray-800"><?php echo htmlspecialchars($content['contentTitle']); ?></h3>
                                                <p class="text-sm text-gray-500 mt-1"><?php echo htmlspecialchars($content['contentType']); ?></p>
                                            </div>
                                            <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">
                                                Bahagian <?php echo htmlspecialchars($content['contentOrder']); ?>
                                            </span>
                                        </div>
                                        <?php if (!empty($content['contentDesc'])): ?>
                                            <p class="text-gray-600 text-sm mt-2"><?php echo nl2br(htmlspecialchars($content['contentDesc'])); ?></p>
                                        <?php endif; ?>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php else: ?>
                            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-lg">
                                <p>Tiada kandungan ditambah untuk modul ini.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="bg-gray-50 px-8 py-6 border-t">
                    <div class="flex justify-end space-x-3">
                        <a href="edit_module.php?id=<?php echo htmlspecialchars($module['moduleID']); ?>" 
                           class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 transition">
                            Edit Modul
                        </a>
                        <a href="add_content.php?module_id=<?php echo htmlspecialchars($module['moduleID']); ?>" 
                           class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                            Tambah Kandungan
                        </a>
                        <a href="modules.php" 
                           class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition">
                            Kembali ke Senarai
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function deleteModule(moduleID) {
            if (confirm('Adakah anda pasti ingin memadam modul ini?')) {
                window.location.href = 'delete_module.php?id=' + moduleID;
            }
        }
    </script>

    <?php include '../src/components/footer.php'; ?>
</body>
</html>