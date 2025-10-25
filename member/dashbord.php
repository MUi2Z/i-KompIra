<?php include '../src/components/header.php'; ?>
<?php include '../src/components/navbar.php'; ?>

    <div class="flex flex-col lg:flex-row min-h-screen">
        <aside class="w-full lg:w-64 bg-white shadow-lg p-6 flex flex-col items-center text-center lg:items-start space-y-4">
            <div class="flex items-center space-x-2 mb-6">
                <div class="rounded-full bg-gray-200 h-16 w-16 flex items-center justify-center">
                    <svg class="h-10 w-10 text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <span class="text-xl font-semibold text-gray-800 hidden lg:block"><?php echo 'i-KompIra' ?></span>
            </div>

            <a href="#" class="w-full py-3 px-4 bg-orange-400 text-white font-semibold rounded-lg shadow hover:bg-orange-500 transition duration-200">DASHBOARD</a>
            <a href="#" class="w-full py-3 px-4 bg-orange-400 text-white font-semibold rounded-lg shadow hover:bg-orange-500 transition duration-200">URUS AHLI</a>
            <a href="#" class="w-full py-3 px-4 bg-orange-400 text-white font-semibold rounded-lg shadow hover:bg-orange-500 transition duration-200">URUS AKTIVITI</a>
            <a href="#" class="w-full py-3 px-4 bg-orange-400 text-white font-semibold rounded-lg shadow hover:bg-orange-500 transition duration-200">URUS MODUL</a>
            <a href="#" class="w-full py-3 px-4 bg-orange-400 text-white font-semibold rounded-lg shadow hover:bg-orange-500 transition duration-200">URUS IRAMA</a>
            <a href="#" class="w-full py-3 px-4 bg-red-500 text-white font-semibold rounded-lg shadow hover:bg-red-600 transition duration-200">DASHBOARD</a>
        </aside>

        <main class="flex-1 p-6 lg:p-10">
            <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center lg:text-left">AKAUN PENYELIA</h1>

            <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NAMA</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NO. KAD PENGENALAN</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">JENIS IRAMA</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">SEMAK</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php for ($i = 0; $i < 4; $i++): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button class="py-2 px-4 bg-yellow-600 text-white rounded-md shadow-sm hover:bg-yellow-700 transition duration-200">SEMAK</button>
                            </td>
                        </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>

                <div class="mt-6 text-center">
                    <button class="py-2 px-6 bg-green-600 text-white font-semibold rounded-md shadow-md hover:bg-green-700 transition duration-200">TAMBAH</button>
                </div>
            </div>
        </main>
    </div>

<?php include '../src/components/footer.php'; ?>