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
        include __DIR__ . "/Inclusions/Methods.php";
        include __DIR__ . "/Classes/Dbh.Class.php";
        include __DIR__ . "/Classes/ItemsView.Class.php";

        $itemsView = new ItemsView();
        $USER_ID = $_SESSION['USER_ID'];
        $Stocks = $itemsView->viewStocks($USER_ID);
    ?>

    <!--Main Body for Sales Page, 2 Columns-->
    <div id="BodyDiv" class="w-full h-full flex bg-[171921] text-[922D34]">

        <div class="w-1/5">
            <!--Sidebar from import-->
            <?php
                include __DIR__ . "/Inclusions/sidebar.php";
            ?>
        </div>

        <!--Parts Stocks Log-->
        <div class="w-full flex flex-col gap-5">

            <!--NavBar-->
            <div>
                <?php include __DIR__ . "/Inclusions/navbar.php";?>
            </div>

            <div class="w-full px-5 h-20 my-2 text-3xl font-bold flex items-center">
                <h1>Monthly Sales Records</h1>
            </div>


            <!--Stocks Log Table-->
            <div class="h-full w-full px-5">

                <table id="stocksTable" class="table-auto border-separate border bg-[#202231] h-fit max-h-full">
                    <thead>
                        <tr class="text-md">
                            <th class="w-md text-[922D34]">LOG ID</th>
                            <th class="w-md text-[922D34]">MATERIAL NAME</th>
                            <th class="w-md text-[922D34]">SOURCE TABLE</th>
                            <th class="w-md text-[922D34]">SOURCE ID</th>
                            <th class="w-md text-[922D34]">QUANTITY</th>
                            <th class="w-md text-[922D34]">TRANSACTION TYPE</th>
                            <th class="w-md text-[922D34]">TIME AND DATE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($Stocks) > 0): ?>
                            <?php foreach ($Stocks as $stock): ?>
                                <tr class="odd:bg-[#202231] even:bg-[#202333] border-0 text-[#922D34] h-10 text-sm hover:bg-[#2a2a3a] transition">
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
                                <td colspan="7" class="text-center py-5 text-[#922D34]">No stock records found.</td>
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
