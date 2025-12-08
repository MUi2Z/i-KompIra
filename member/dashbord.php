<?php include '../src/components/header.php'; ?>
<?php include '../src/components/navbar.php'; ?>

    <div class="flex flex-col lg:flex-row min-h-screen">
        <?php include '../src/components/sidebar_member.php'; ?>
        <!-- <aside class="w-full lg:w-64 bg-white shadow-lg p-6 flex flex-col items-center text-center lg:items-start space-y-4">
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
        </aside> -->

        <main class="flex-1 p-6 lg:p-10">
            <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center lg:text-center">AKAUN AHLI</h1>

            <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto">
                <tbody class="bg-white divide-y divide-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                        <tr>
                            <td class="px-3 py-4 text-sm text-gray-900 tracking-wider">NAMA: </td>
                            <td class="px-3 py-4 text-sm text-gray-900 tracking-wider"><?php echo "PENGUSER" /* name */ ?></td>
                        </tr>
                        <tr>
                            <td class="px-3 py-4 text-sm text-gray-900 tracking-wider">EMAIL: </td>
                            <td class="px-3 py-4 text-sm text-gray-900 tracking-wider"><?php echo "literature5@gmail.com" /* email */ ?></td>
                        </tr>
                        <tr>
                            <td class="px-3 py-4 text-sm text-gray-900 tracking-wider">NO. KAD PENGENALAN: </td>
                            <td class="px-3 py-4 text-sm text-gray-900 tracking-wider"><?php echo "060030112323" /* icno */ ?></td>
                        </tr>
                        <tr>
                            <td class="px-3 py-4 text-sm text-gray-900 tracking-wider">KURSUS: </td>
                            <td class="px-3 py-4 text-sm text-gray-900 tracking-wider"><?php echo "KOMPUTER" /* course */ ?></td>
                        </tr>
                            <td class="px-3 py-4 text-sm text-gray-900 tracking-wider">ROLE KOMPANG</td>
                            <td class="px-3 py-4 text-sm text-gray-900 tracking-wider"><?php echo "MENYILANG" /* role */ ?></td>
                        </tr>
                    </tbody>
                </table>

                <div class="mt-6 text-center">
                    <button class="py-2 px-6 bg-green-600 text-white font-semibold rounded-md shadow-md hover:bg-green-700 transition duration-200">EDIT</button>
                </div>
            </div>
        </main>
    </div>

<?php include '../src/components/footer.php'; ?>