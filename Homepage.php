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
        //include __DIR__ . "/Inclusions/navbar.php";
        include __DIR__ . "/Classes/Dbh.Class.php";
        include __DIR__ . "/Classes/ItemsView.Class.php";

        $itemsView = new ItemsView();
        $USER_ID = $_SESSION['USER_ID'];
        $pendingCount = $itemsView->viewPendingCount($USER_ID);
        $outofstockCount = $itemsView->viewOutOfStockCount($USER_ID);
        $lowstockCount = $itemsView->viewLowStockCount($USER_ID);
    ?>

    <!--Main Body for Homepage Page-->
    <div id="BodyDiv" class="w-full min-h-screen flex bg-[171921] text-[922D34]">

        <!--Sidebar-->
        <div class="w-1/6 border-r bg-white shadow-sm">
            <?php include "./Inclusions/sidebar.php"; ?>
        </div>

        <!--Home Content-->
        <div class="flex-1">

            <!--NavBar-->
            <div class="mb-15">
                <?php include __DIR__ . "/Inclusions/navbar.php";?>
            </div>

            <!--User Header-->
            <div class="w-full flex flex-col items-center mb-10">
                <h1 class="text-4xl font-bold tracking-wide">
                    <?php echo $_SESSION['NAME']; ?>
                </h1>
                <p class="text-md mt-2">
                    Welcome back! Here’s today’s activity summary.
                </p>
            </div>

            <!--Status Cards Grid-->
            <div class="grid grid-cols-1 md:grid-cols-3 ms-7 mb-10 place-self-center gap-6">

                <!--Pendings-->
                <div class="w-fit h-30 bg-[202231] rounded-sm shadow-sm flex">
                    <div class="w-70 flex justify-center items-center">
                        <p class="text-2xl">Pendings</p>
                    </div>
                    <div class="flex justify-center items-center w-1/2">
                        <p class="text-4xl font-bold"><?php echo $pendingCount ?></p>
                    </div>
                </div>

                <!--Low Stock-->
                <div class="w-fit h-30 bg-[202231] rounded-sm shadow-sm flex">
                    <div class="w-70 flex justify-center items-center">
                        <p class="text-2xl">Low Stock <br> Products</p>
                    </div>
                    <div class="flex justify-center items-center w-1/2">
                        <p class="text-4xl font-bold"><?php echo $lowstockCount; ?></p>
                    </div>
                </div>

                <!--Out of stock-->
                <div class="w-fit h-30 bg-[202231] rounded-sm shadow-sm flex">
                    <div class="w-70 flex justify-center items-center">
                        <p class="text-2xl">Out of Stock <br> Products</p>
                    </div>
                    <div class="flex justify-center items-center w-1/2">
                        <p class="text-4xl font-bold"><?php echo $outofstockCount; ?></p>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!--Scripts-->
    <?php 
        include __DIR__ . '/Scripts/mainScript.php';
    ?>
</body>
