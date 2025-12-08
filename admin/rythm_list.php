<?php include '../src/components/header.php'; ?>
<?php include '../src/components/navbar.php'; ?>

    <div class="flex flex-col lg:flex-row min-h-screen">
        <?php include '../src/components/sidebar_admin.php'; ?>

        <main class="flex-1 p-6 lg:p-10">
            <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Pengurusan Irama Kompang</h1>

            <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TAJUK IRAMA</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">HURAIAN</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">BPM (KELAJUAN)</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">FAIL MIDI</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PENCIPTA</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">TINDAKAN</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php // Placeholder Data for Rhythms ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">Irama Melalu Standard</td>
                            <td class="px-6 py-4 text-sm text-gray-900 max-w-xs overflow-hidden text-ellipsis">Irama asas Melalu yang sesuai untuk majlis perkahwinan.</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">120</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="../rhythms/melalu_std.mid" target="_blank" class="text-indigo-600 hover:text-indigo-900">melalu\_std.mid</a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Ahmad Lutfi</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button class="py-2 px-4 bg-yellow-600 text-white rounded-md shadow-sm hover:bg-yellow-700 transition duration-200">EDIT</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">Gubahan Menyilang Cepat</td>
                            <td class="px-6 py-4 text-sm text-gray-900 max-w-xs overflow-hidden text-ellipsis">Versi Menyilang dengan tempo yang lebih pantas untuk persembahan moden.</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">145</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="../rhythms/menyilang_fast.mid" target="_blank" class="text-indigo-600 hover:text-indigo-900">menyilang\_fast.mid</a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Siti Hajar</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button class="py-2 px-4 bg-yellow-600 text-white rounded-md shadow-sm hover:bg-yellow-700 transition duration-200">EDIT</button>
                            </td>
                        </tr>
                        <?php // endfor; ?>
                    </tbody>
                </table>

                <div class="mt-6 text-center">
                    <button class="py-2 px-6 bg-green-600 text-white font-semibold rounded-md shadow-md hover:bg-green-700 transition duration-200">TAMBAH IRAMA</button>
                </div>
            </div>
        </main>
    </div>

<?php include '../src/components/footer.php'; ?>