<?php
session_start(); 

if(!isset($_SESSION['USER_ID'])){
    header('Location: ./index.php');
    exit();
}   
?>
<body>
    <!--Important import files-->
    <?php
        include __DIR__ . "/Inclusions/Head.php";
        include __DIR__ . "/Inclusions/navbar.php";
    ?>

    <!--Main Body for Homepage Page-->
    <div id="BodyDiv" class="w-full min-h-screen flex bg-gray-50">

        <!--Sidebar-->
        <div class="w-1/6 border-r bg-white shadow-sm">
            <?php include "./Inclusions/sidebar.php"; ?>
        </div>

        <!--Home Content-->
        <div class="flex-1 p-10">

            <!--User Header-->
            <div class="w-full flex flex-col items-center mb-10">
                <h1 class="text-5xl font-bold tracking-wide text-gray-800">
                    <?php echo $_SESSION['NAME']; ?>
                </h1>
                <p class="text-lg text-gray-600 mt-2">
                    Welcome back! Here’s today’s activity summary.
                </p>
            </div>

            <!--Status Cards Grid-->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

                <!--Pending-->
                <div class="bg-blue-200 rounded-md shadow-md p-6 flex flex-col justify-between">
                    <p class="text-2xl font-semibold">Pending Requests</p>
                    <p class="text-5xl font-bold mt-4 text-center">0</p>
                </div>

                <!--Denied-->
                <div class="bg-blue-200 rounded-md shadow-md p-6 flex flex-col justify-between">
                    <p class="text-2xl font-semibold">Denied Requests</p>
                    <p class="text-5xl font-bold mt-4 text-center">0</p>
                </div>

                <!--Completed-->
                <div class="bg-blue-200 rounded-md shadow-md p-6 flex flex-col justify-between">
                    <p class="text-2xl font-semibold">Completed Requests</p>
                    <p class="text-5xl font-bold mt-4 text-center">0</p>
                </div>

            </div>

            <!--Second Row of Cards-->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!--Duplicated-->
                <div class="bg-blue-200 rounded-md shadow-md p-6 flex flex-col justify-between">
                    <p class="text-2xl font-semibold">Duplicated Requests</p>
                    <p class="text-5xl font-bold mt-4 text-center">0</p>
                </div>

                <!--Out of Stock-->
                <div class="bg-blue-200 rounded-md shadow-md p-6 flex flex-col justify-between">
                    <p class="text-2xl font-semibold">Out of Stocks</p>
                    <p class="text-5xl font-bold mt-4 text-center">0</p>
                </div>

                <!--Price Increase-->
                <div class="bg-blue-200 rounded-md shadow-md p-6 flex flex-col justify-between">
                    <p class="text-2xl font-semibold">Product Price Increase</p>
                    <p class="text-5xl font-bold mt-4 text-center">0</p>
                </div>

            </div>

        </div>
    </div>

    <!--Scripts-->
    <?php 
        include './Scripts/mainScript.php';
    ?>
</body>
