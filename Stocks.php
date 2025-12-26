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
        include __DIR__ . "/Inclusions/Methods.php";
        include __DIR__ . "/Classes/Dbh.Class.php";
        include __DIR__ . "/Classes/ItemsView.Class.php";

        $itemsView = new ItemsView();
        $USER_ID = $_SESSION['USER_ID'];
        $Stocks = $itemsView->viewStocks($USER_ID);
    ?>

    <!--Main Body for Sales Page, 2 Columns-->
    <div id="BodyDiv" class="w-full h-full flex">

        <div class="w-1/6">
            <!--Sidebar from import-->
            <?php
                include __DIR__ . "/Inclusions/sidebar.php";
            ?>
        </div>

        <!--Parts Stocks Log-->
        <div class="w-full py-10 px-18 flex flex-col gap-5">

            <div class="w-full h-20 my-5 text-5xl font-bold flex justify-center items-center">
                <h1>Monthly Sales Record</h1>
            </div>

            <!--Indicators-->
            <div class="flex justify-center gap-5">

                
                <!--Stocks Log Status-->
                <div class="w-1/4 h-30 bg-blue-200 rounded-sm shadow-sm flex">
                    <div class="w-70 flex justify-center items-center">
                        <p class="text-2xl">Out of Stock <br> Products</p>
                    </div>
                    <div class="flex justify-center items-center w-1/2">
                        <p class="text-4xl font-bold">0</p>
                    </div>
                </div>

                <!--Stocks Log Status-->
                <div class="w-1/4 h-30 bg-blue-200 rounded-sm shadow-sm flex">
                    <div class="w-70 flex justify-center items-center">
                        <p class="text-2xl">Product Price <br> Increase</p>
                    </div>
                    <div class="flex justify-center items-center w-1/2">
                        <p class="text-4xl font-bold">0</p>
                    </div>
                </div>

            </div>

            <!--Stocks Log Table-->
            <div class="h-full w-full">

                <table id="stocksTable" class="table-auto border-separate border h-fit max-h-full">
                    <thead>
                        <tr class="text-lg">
                            <th class="w-md ">LOG ID</th>
                            <th class="w-md ">MATERIAL NAME</th>
                            <th class="w-md ">SOURCE TABLE</th>
                            <th class="w-md ">SOURCE ID</th>
                            <th class="w-md ">QUANTITY</th>
                            <th class="w-lg ">TRANSACTION TYPE</th>
                            <th class="w-md ">TIME AND DATE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($Stocks) > 0): ?>
                            <?php foreach ($Stocks as $stock): ?>
                                <tr class="odd:bg-blue-50 even:bg-blue-100 hover:bg-blue-200 transition">
                                    <!-- STOCKS ID -->
                                    <td class="px-4 py-2 text-end"><?= htmlspecialchars($stock['STOCKS_ID']) ?></td>

                                    <!-- MATERIAL NAME -->
                                    <td class="px-4 py-2"><?= htmlspecialchars($stock['MATERIAL_NAME']) ?></td>

                                    <!-- SOURCE TABLE -->
                                    <td class="px-4 py-2"><?= htmlspecialchars($stock['SOURCE_TABLE']) ?></td>

                                    <!-- SOURCE ID -->
                                    <td class="px-4 py-2"><?= htmlspecialchars($stock['SOURCE_ID']) ?></td>

                                    <!-- QUANTITY -->
                                    <td class="px-4 py-2 text-end"><?= number_format($stock['QUANTITY']) ?></td>

                                    <!-- TRANSACTION TYPE -->
                                    <td class="px-4 py-2"><?= htmlspecialchars($stock['TRANSACTION_TYPE']) ?></td>

                                    <!-- TIME AND DATE -->
                                    <td class="px-4 py-2"><?= date("F j, Y - g:i A", strtotime($stock['TIME_AND_DATE'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-5 text-gray-500">No stock records found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <!--Script import for functionalities-->
    <?php 
        include __DIR__ . '/Scripts/mainScript.php';
    ?>

</body>
