<?php include '../src/components/header.php'; ?>
<?php include '../src/components/navbar.php'; ?>

    <div class="flex flex-col lg:flex-row min-h-screen">
        <?php include '../src/components/sidebar_admin.php'; ?>

        <main class="flex-1 p-6 lg:p-10">
            <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Senarai Aktiviti Kelab</h1>

            <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TAJUK AKTIVITI</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IMEJ KECIL</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TARIKH LATIHAN</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TARIKH PERSEMBAHAN</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">TINDAKAN</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php // Placeholder Data for Activities ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">Persembahan Tarian Zapin</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 hover:text-blue-800"><a href="#">zapin_thumb.jpg</a></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">2025-10-01</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">2025-10-15</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button class="py-2 px-4 bg-yellow-600 text-white rounded-md shadow-sm hover:bg-yellow-700 transition duration-200">SEMAK</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">Sesi Latihan Keroncong</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 hover:text-blue-800"><a href="#">keroncong_thumb.png</a></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">2025-11-05</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">N/A</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button class="py-2 px-4 bg-yellow-600 text-white rounded-md shadow-sm hover:bg-yellow-700 transition duration-200">SEMAK</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">Bengkel Alat Muzik Tradisional</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 hover:text-blue-800"><a href="#">bengkel_thumb.jpg</a></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">2026-01-20</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">2026-02-01</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button class="py-2 px-4 bg-yellow-600 text-white rounded-md shadow-sm hover:bg-yellow-700 transition duration-200">SEMAK</button>
                            </td>
                        </tr>
                        <?php // endfor; ?>
                    </tbody>
                </table>

                <div class="mt-6 text-center">
                    <button class="py-2 px-6 bg-green-600 text-white font-semibold rounded-md shadow-md hover:bg-green-700 transition duration-200">TAMBAH</button>
                </div>
            </div>
        </main>
    </div>

<?php include '../src/components/footer.php'; ?>