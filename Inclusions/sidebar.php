<!-- Sidebar Container -->
<div class="w-1/6 h-screen px-5 py-2 shadow-md flex flex-col fixed overflow-y-auto bg-white">

    <!-- Dashboard -->
    <div class="my-3">
        <div class="flex items-center gap-3 p-2 rounded-md hover:bg-gray-200 transition-all duration-200 cursor-pointer">
            <img src="./Assets/Icons/dashboard.png" alt="Dashboard Icon" class="w-6 h-6">
            <a href="./homepage.php" class="text-gray-800 font-medium">Dashboard</a>
        </div>
    </div>

    <!-- Inventory Management -->
    <div class="my-3">
        <h1 class="my-3 font-bold text-gray-700">Inventory Management</h1>
        <div class="grid gap-2">
            <a href="./Distribution.php" class="flex items-center gap-3 p-2 rounded-md hover:bg-blue-100 hover:text-blue-700 transition-all duration-200">
                <img src="./Assets/Icons/orderIcon.png" alt="Distribution Icon" class="w-5 h-5">
                <span>Materials Distribution</span>
            </a>
            <a href="./Inventory.php" class="flex items-center gap-3 p-2 rounded-md hover:bg-blue-100 hover:text-blue-700 transition-all duration-200">
                <img src="./Assets/Icons/partsIcon.png" alt="Inventory Icon" class="w-5 h-5">
                <span>Material Inventory</span>
            </a>
            <a href="./Reservation.php" class="flex items-center gap-3 p-2 rounded-md hover:bg-blue-100 hover:text-blue-700 transition-all duration-200">
                <img src="./Assets/Icons/reserveIcon.png" alt="Reservation Icon" class="w-5 h-5">
                <span>Material Reservation</span>
            </a>
            <a href="./Stocks.php" class="flex items-center gap-3 p-2 rounded-md hover:bg-blue-100 hover:text-blue-700 transition-all duration-200">
                <img src="./Assets/Icons/stocksIcon.png" alt="Stocks Icon" class="w-5 h-5">
                <span>Stocks Log</span>
            </a>
        </div>
    </div>

    <!-- Other Services -->
    <div class="my-3">
        <h1 class="my-3 font-bold text-gray-700">Other Services</h1>
        <div class="grid gap-2">
            <div class="flex items-center gap-3 p-2 rounded-md hover:bg-gray-200 transition-all duration-200 cursor-pointer">
                <img src="./Assets/Icons/settingsIcon.png" alt="Settings Icon" class="w-5 h-5">
                <span>Settings</span>
            </div>
            <div class="flex items-center gap-3 p-2 rounded-md hover:bg-gray-200 transition-all duration-200 cursor-pointer">
                <img src="./Assets/Icons/customerService.png" alt="Customer Icon" class="w-5 h-5">
                <span>Customer Service</span>
            </div>
            <a href="./Process/Logout.php" class="flex items-center gap-3 p-2 rounded-md hover:bg-red-100 hover:text-red-600 transition-all duration-200 cursor-pointer">
                <img src="./Assets/Icons/logout.png" alt="Logout Icon" class="w-5 h-5">
                <span>Logout</span>
            </a>
        </div>
    </div>

</div>
