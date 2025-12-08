<?php include '../src/components/header.php'; ?>
<?php include '../src/components/navbar.php'; ?>

    <div class="flex flex-col lg:flex-row min-h-screen">
        <?php include '../src/components/sidebar_admin.php'; ?>

        <main class="flex-1 p-6 lg:p-10">
            <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Senarai Modul Kelab Kompang</h1>

            <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NAMA MODUL</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">HURAIAN</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IMEJ KECIL</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DOKUMEN</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">TINDAKAN</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php // Placeholder Data for Kompang Modules ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">Asas Paluan Kompang</td>
                            <td class="px-6 py-4 text-sm text-gray-900 max-w-xs overflow-hidden text-ellipsis">Pengenalan kepada teknik pukulan 'Buka' dan 'Tutup' serta irama asas.</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 hover:text-blue-800"><a href="#">asas_thumb.jpg</a></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="../docs/module_01_asas.pdf" target="_blank" class="text-indigo-600 hover:text-indigo-900">Lihat PDF</a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button class="py-2 px-4 bg-yellow-600 text-white rounded-md shadow-sm hover:bg-yellow-700 transition duration-200">KEMASKINI</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">Irama Menyilang & Melalu</td>
                            <td class="px-6 py-4 text-sm text-gray-900 max-w-xs overflow-hidden text-ellipsis">Pembelajaran irama tradisional 'Menyilang' dan 'Melalu' serta gubahan mudah.</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 hover:text-blue-800"><a href="#">irama_thumb.png</a></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="../docs/module_02_irama.pdf" target="_blank" class="text-indigo-600 hover:text-indigo-900">Lihat PDF</a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button class="py-2 px-4 bg-yellow-600 text-white rounded-md shadow-sm hover:bg-yellow-700 transition duration-200">KEMASKINI</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">Pengurusan Persembahan</td>
                            <td class="px-6 py-4 text-sm text-gray-900 max-w-xs overflow-hidden text-ellipsis">Garis panduan untuk penyediaan ahli, pakaian, dan susun atur Kompang untuk persembahan.</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 hover:text-blue-800"><a href="#">urus_thumb.jpg</a></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="../docs/module_03_persembahan.docx" target="_blank" class="text-indigo-600 hover:text-indigo-900">Lihat DOCX</a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button class="py-2 px-4 bg-yellow-600 text-white rounded-md shadow-sm hover:bg-yellow-700 transition duration-200">KEMASKINI</button>
                            </td>
                        </tr>
                        <?php // endfor; ?>
                    </tbody>
                </table>

                <div class="mt-6 text-center">
                    <button class="py-2 px-6 bg-green-600 text-white font-semibold rounded-md shadow-md hover:bg-green-700 transition duration-200">TAMBAH MODUL</button>
                </div>
            </div>
        </main>
    </div>

<?php include '../src/components/footer.php'; ?>