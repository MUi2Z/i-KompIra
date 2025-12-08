<?php include '../src/components/header.php'; ?>
<?php include '../src/components/navbar.php'; ?>

<main>
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <div class="w-full md:mt-0 sm:max-w-md xl:p-0">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8 <?php echo $border ?>">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-center text-orange-900 md:text-2xl">
                    Log Masuk Admin
                </h1>
                <form class="space-y-4 md:space-y-6" action="#">
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-orange-900">Email</label>
                        <input type="email" name="email" id="email" class="bg-amber-100 border-none shadow text-orange-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="nama@email.com" required="">
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-orange-900">Kata Laluan</label>
                        <input type="password" name="password" id="password" placeholder="••••••••" class="bg-amber-100 border-none shadow text-orange-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required="">
                    </div>
                    <button onclick="window.location.href = '../admin/dashbord.php';" type="submit" class="bg-amber-100 border-none shadow text-orange-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-1/2 p-2.5 ml-auto">Log Masuk</button>
                    <div class="flex items-center justify-between">
                        <div class="flex items-start">
                            <a href="#" class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">Lupa kata laluan?</a>
                        </div>
                    </div>
                    <!-- <p class="text-sm font-light text-orange-800">
                        Belum sertai kelab? <a href="#" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Daftar permohonan</a>
                    </p> -->
                </form>
            </div>
        </div>
    </div>
</main>

<?php include '../src/components/footer.php'; ?>