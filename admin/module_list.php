<?php include '../src/components/header.php'; ?>
<?php include '../src/components/navbar.php'; ?>

    <div class="flex flex-col lg:flex-row min-h-screen">
        <?php include '../src/components/sidebar_admin.php'; ?>

        <main class="flex-1 p-6 lg:p-10">
            <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Senarai Modul</h1>

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
                        <?php // for ($i = 0; $i < 4; $i++): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">23</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Husaini Rasydin</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">0708118283</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Melalu</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button class="py-2 px-4 bg-yellow-600 text-white rounded-md shadow-sm hover:bg-yellow-700 transition duration-200">SEMAK</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">24</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Imran Latif</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">060418109988</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Menyilang</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button class="py-2 px-4 bg-yellow-600 text-white rounded-md shadow-sm hover:bg-yellow-700 transition duration-200">SEMAK</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">26</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Firaz Mirza</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">061129102344</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Melalu</td>
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