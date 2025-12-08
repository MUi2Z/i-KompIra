<?php include '../src/components/header.php'; ?>
<?php include '../src/components/navbar.php'; ?>

<div class="flex flex-col lg:flex-row min-h-screen">
        <?php include '../src/components/sidebar_admin.php'; ?>

        <main class="flex-1 p-6 lg:p-12 flex flex-col items-center">
            <div class="w-full max-w-lg flex flex-col items-center">
                <h1 class="text-3xl font-bold text-gray-800 mb-8">AKAUN PENYELIA</h1>
                
                <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center border-4 border-white shadow-md">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                
                <button class="bg-[#6A8D73] hover:bg-[#6A8D9F] text-white font-bold py-2 px-8 rounded-md shadow-md transition mt-4 mb-10">EDIT</button>

                <div class="w-full space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-2">
                        <p class="font-semibold text-gray-700 sm:text-right sm:col-span-1">EMAIL :</p>
                        <p class="display-field-bg border border-gray-400 rounded-md p-2 shadow-inner w-full truncate sm:col-span-2"><?php echo 'lyv4memusic@gmail.com' /* email */ ?></p>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-2">
                        <p class="font-semibold text-gray-700 sm:text-right sm:col-span-1">KATA LALUAN :</p>
                        <p class="display-field-bg border border-gray-400 rounded-md p-2 shadow-inner w-full sm:col-span-2"><?php echo '**********' /* password */ ?></p>
                    </div>
                </div>
            </div>
        </main>
    </div>

<?php include '../src/components/footer.php'; ?>