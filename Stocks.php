<body>
    <!--Important import files-->
    <?php
        include "./Inclusions/Head.php";
        include "./Inclusions/navbar.php";
        include "./Inclusions/Connection.php";
        include "./Process/StockProcess/getItems.php";
    ?>

    <!--Main Body for Sales Page, 2 Columns-->
    <div id="BodyDiv" class="w-full h-full flex">

        <div class="w-1/6">
            <!--Sidebar from import-->
            <?php
                include "./Inclusions/sidebar.php";
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
                        <p class="text-4xl font-bold">1</p>
                    </div>
                </div>

                <!--Stocks Log Status-->
                <div class="w-1/4 h-30 bg-blue-200 rounded-sm shadow-sm flex">
                    <div class="w-70 flex justify-center items-center">
                        <p class="text-2xl">Product Price <br> Increase</p>
                    </div>
                    <div class="flex justify-center items-center w-1/2">
                        <p class="text-4xl font-bold">1</p>
                    </div>
                </div>

            </div>

            <!--Stocks Log Table-->
            <div class="h-full w-full">

                <table id="stocksTable" class="table-auto border-separate border h-fit max-h-full">
                    <thead>
                        <tr class="text-xl">
                            <th class="w-md ">Material Code</th>
                            <th class="w-md ">Material Name</th>
                            <th class="w-md ">Quantity</th>
                            <th class="w-lg ">Total Price</th>
                            <th class="w-lg ">Transaction Type</th>
                            <th class="w-md ">Remarks</th>
                            <th class="w-md ">Time and Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($getStocks->num_rows > 0): ?>
                            <?php while ($row = $getStocks->fetch_assoc()): ?>
                                <tr class="odd:bg-blue-50 even:bg-blue-100 hover:bg-blue-200 transition">
                                    <!-- MATERIAL CODE -->
                                    <td class="px-4 py-2 text-end"><?= htmlspecialchars($row['MATERIAL_ID']) ?></td>

                                    <!-- MATERIAL NAME -->
                                    <td class="px-4 py-2"><?= htmlspecialchars($row['MATERIAL_NAME']) ?></td>

                                    <!-- QUANTITY -->
                                    <td class="px-4 py-2 text-end"><?= number_format($row['QUANTITY']) ?></td>

                                    <!-- TOTAL PRICE -->
                                    <td class="px-4 py-2 text-end">P<?= htmlspecialchars($row['TOTAL_PRICE']) ?></td>

                                    <!-- TRANSACTION TYPE -->
                                    <td class="px-4 py-2"><?= htmlspecialchars($row['TRANSACTION_TYPE']) ?></td>

                                    <!-- REMARKS -->
                                    <td class="px-4 py-2">
                                        <?= !empty($row['REMARKS']) ? htmlspecialchars($row['REMARKS']) : '—'; ?>
                                    </td>

                                    <!-- TIME AND DATE -->
                                    <td class="px-4 py-2"><?= date("F j, Y - g:i A", strtotime($row['TIME_AND_DATE'])) ?></td>
                                </tr>
                            <?php endwhile; ?>
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
        include './Scripts/mainScript.php';
    ?>

</body>
