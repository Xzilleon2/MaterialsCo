<body>
    <!--Important import files-->
    <?php
        include "./Inclusions/Head.php";
        include "./Inclusions/navbar.php";
        include "./Inclusions/Methods.php";
        include "./Inclusions/Connection.php";
        include "./Process/InventoryProcess/getItems.php";
    ?>

    <!--Main Body for Inventory Page, 2 Columns-->
    <div id="BodyDiv" class="w-full h-full flex">

        <div class="w-1/6">
            <!--Sidebar from import-->
            <?php
                include "./Inclusions/sidebar.php";
            ?>
        </div>

        <!--Parts Distribution-->
        <div class="w-full py-10 px-18 flex flex-col gap-5">

            <!--Message Panel-->
            <?php renderFlashBox(); ?>

            <div class="w-full h-20 my-5 text-5xl font-bold flex justify-center items-center">
                <h1>Material Inventory</h1>
            </div>

            <!--Indicators-->
            <div class="flex justify-center gap-5">

                
                <!--Inventory Status-->
                <div class="w-1/4 h-30 bg-blue-200 rounded-sm shadow-sm flex">
                    <div class="w-70 flex justify-center items-center">
                        <p class="text-2xl">High Price <br> Products</p>
                    </div>
                    <div class="flex justify-center items-center w-1/2">
                        <p class="text-4xl font-bold">1</p>
                    </div>
                </div>

                <!--Inventory Status-->
                <div class="w-1/4 h-30 bg-blue-200 rounded-sm shadow-sm flex">
                    <div class="w-70 flex justify-center items-center">
                        <p class="text-2xl">Duplicated <br> Products</p>
                    </div>
                    <div class="flex justify-center items-center w-1/2">
                        <p class="text-4xl font-bold">1</p>
                    </div>
                </div>

                <!--Inventory Status-->
                <div id="showInventory" class="w-1/5 h-20 my-5 bg-blue-200 rounded-sm shadow-sm flex">
                    <div class="w-70 flex justify-center items-center gap-3 hover:cursor-pointer">
                        <img src="./Assets/Icons/note.png" alt="noteIcon">
                        <p class="text-xl">Record an Item</p>
                    </div>
                </div>

                <!-- Inventory Entry Modal -->
                <dialog id="inventoryEntry" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[36rem] max-w-full p-6 rounded-lg shadow-xl border border-gray-300 backdrop:bg-black/40 open:animate-fadeIn">
                    <form method="POST" action="./Process/InventoryProcess/addItem.php" class="space-y-6">

                        <!-- Modal Title -->
                        <h1 class="text-2xl font-bold text-gray-800">🛠 Manage Inventory Information</h1>

                        <!-- Material Name -->
                        <div class="space-y-2">
                        <label class="block text-lg font-medium text-gray-700">Material</label>
                        <input type="text" class="w-full p-3 text-lg bg-gray-100 border border-gray-300 rounded-md" name="materialName"/>
                        </div>

                        <!-- Quantity -->
                        <div class="space-y-2">
                        <label class="block text-lg font-medium text-gray-700">Quantity</label>
                        <input type="number" value="1" class="w-full p-3 text-lg border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" 
                         name="materialQuantity"/>
                        </div>

                        <!-- Price -->
                        <div class="space-y-2">
                        <label class="block text-lg font-medium text-gray-700">Price</label>
                        <input type="number" value="100" class="w-full p-3 text-lg border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                         name="materialPrice" />
                        </div>

                        <!-- Size/Weight -->
                        <div class="space-y-2">
                        <label class="block text-lg font-medium text-gray-700">Size/Weight</label>
                        <input type="text" value="1m" class="w-full p-3 text-lg border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" 
                         name="materialSizeWeight"/>
                        </div>

                        <!-- Model -->
                        <div class="space-y-2">
                        <label class="block text-lg font-medium text-gray-700">Model</label>
                        <input type="text" class="w-full p-3 text-lg border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" 
                         name="materialModel"/>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                        <button type="button" onclick="document.getElementById('inventoryEntry').close()" class="px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded hover:bg-gray-300">Cancel</button>
                        <button type="submit" name="addBtn" class="px-4 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600">Save</button>
                        </div>
                        
                    </form>
                </dialog>

            </div>

            <!--Inventory Table-->
            <div class="h-full w-full">

                <table id="inventoryTable" class="table-auto border-separate border h-fit max-h-full">
                    <thead>
                        <tr class="text-xl">
                            <th class="w-md ">Material Code</th>
                            <th class="w-md ">Name</th>
                            <th class="w-md ">Quantity</th>
                            <th class="w-lg ">Item Price</th>
                            <th class="w-lg ">Size/Weight</th>
                            <th class="w-md ">Model</th>
                            <th class="w-md ">Date Added</th>
                            <th class="w-md ">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $getMaterials->fetch_assoc()): ?>
                            <tr class="odd:bg-blue-100 even:bg-blue-200 h-10">
                                <td><?= htmlspecialchars($row['MATERIAL_ID']) ?></td>
                                <td><?= htmlspecialchars($row['MATERIAL_NAME']) ?></td>
                                <td class="text-end"><?= htmlspecialchars($row['QUANTITY']) ?></td>
                                <td><?= htmlspecialchars($row['PRICE']) ?></td>
                                <td><?= htmlspecialchars($row['SIZE']) ?></td>
                                <td><?= htmlspecialchars($row['MODEL']) ?></td>
                                <td><?= htmlspecialchars(date('F j, Y', strtotime($row['DATE_ADDED']))) ?></td>
                                <td>
                                    <div class="flex gap-5">
                                        <div class="cursor-pointer" onclick="document.getElementById('updateModal<?= $row['MATERIAL_ID'] ?>').showModal()">
                                            <img src="./Assets/Icons/update.png" alt="update">
                                        </div>
                                        <div class="cursor-pointer" onclick="document.getElementById('deleteModal<?= $row['MATERIAL_ID'] ?>').showModal()">
                                            <img src="./Assets/Icons/delete.png" alt="delete">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            
                            <!--Delete Modal-->
                            <dialog id="deleteModal<?= $row['MATERIAL_ID'] ?>" class="fixed w-sm h-xl p-5 top-1/3 left-1/2 rounded-md border border-gray-100 shadow-md">
                                    <form class="grid grid-rows-2" method="POST" action="">

                                        <!--Delete Modal Information-->
                                        <div class="text-xl mb-3 p-5 text-red-500">
                                            <h1>Are you sure you want to delete this reservation?</h1>
                                        </div>
                                        <div class="flex justify-end gap-2">
                                            <button type="submit" name="deleteBtn" class="bg-blue-200 px-4 py-2 rounded font-bold">Confirm</button>
                                            <button type="button" onclick="document.getElementById('deleteModal<?= $row['MATERIAL_ID'] ?>').close()" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                                        </div>
                                        
                                    </form>
                            </dialog>

                            <!--Update Modal-->
                            <dialog id="updateModal<?= $row['MATERIAL_ID'] ?>" class="fixed w-sm h-xl p-5 top-1/3 left-1/2 rounded-md border border-gray-100 shadow-md">
                                    <form class="grid grid-rows-2" method="POST" action="">

                                        <!--Update Form Information-->
                                        <h1 class="font-bold text-2xl mb-5">Manage Information</h1>
                                        <div class="flex flex-col gap-3 mb-5">
                                            <!--Material & Quantity-->
                                            <div class="flex flex-col gap-2 items-center">
                                                <Label class="font-semibold text-xl">Neon Steel Kat</Label>
                                                <input class="text-xl rounded-md p-3 h-10 w-1/4 ml-10 focus:outline-none" type="number" value="10">
                                            </div>
                                            <!--Location & Remarks-->
                                            <Label>Location</Label>
                                            <input class="border rounded-md p-3 h-13" type="text">
                                            <Label>Remarks</Label>
                                            <input class="border rounded-md p-3 h-20" type="text">
                                        </div>
                                        <div class="flex justify-end gap-2">
                                            <button type="submit" name="updateBtn" class="bg-blue-200 px-4 py-2 rounded font-bold">Save</button>
                                            <button type="button" onclick="document.getElementById('updateModal<?= $row['MATERIAL_ID'] ?>').close()" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                                        </div>

                                    </form>
                            </dialog>
                        <?php endwhile; ?>
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
