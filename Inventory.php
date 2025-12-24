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
        $materials = $itemsView->viewInventory();
    ?>

    <!--Main Body for Inventory Page, 2 Columns-->
    <div id="BodyDiv" class="w-full h-full flex">

        <div class="w-1/6">
            <!--Sidebar from import-->
            <?php
                include __DIR__ . "/Inclusions/sidebar.php";
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
                        <p class="text-4xl font-bold">0</p>
                    </div>
                </div>

                <!--Inventory Status-->
                <div class="w-1/4 h-30 bg-blue-200 rounded-sm shadow-sm flex">
                    <div class="w-70 flex justify-center items-center">
                        <p class="text-2xl">Duplicated <br> Products</p>
                    </div>
                    <div class="flex justify-center items-center w-1/2">
                        <p class="text-4xl font-bold">0</p>
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
                        <input required type="text" class="w-full p-3 text-lg bg-gray-100 border border-gray-300 rounded-md" name="materialName"/>
                        </div>

                        <!-- Quantity -->
                        <div class="space-y-2">
                        <label class="block text-lg font-medium text-gray-700">Quantity</label>
                        <input required type="number" value="1" min="1" class="w-full p-3 text-lg border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" 
                         name="materialQuantity"/>
                        </div>

                        <!-- Price -->
                        <div class="space-y-2">
                        <label class="block text-lg font-medium text-gray-700">Price</label>
                        <input required type="number" value="100" class="w-full p-3 text-lg border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
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
                        <label class="block text-lg font-medium text-gray-700">Model (Optional)</label>
                        <input required type="text" value="N/A" class="w-full p-3 text-lg border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" 
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
                            <th class="w-md ">MATERIAL CODE</th>
                            <th class="w-md ">NAME</th>
                            <th class="w-md ">QUANTITY</th>
                            <th class="w-lg ">ITEM PRICE</th>
                            <th class="w-lg ">SIZE/WEIGHT</th>
                            <th class="w-md ">MODEL</th>
                            <th class="w-md ">DATE ADDED</th>
                            <th class="w-md ">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($materials as $row): ?>
                            <tr class="odd:bg-blue-100 even:bg-blue-200 h-10">
                                <td class="text-end"><?= htmlspecialchars($row['MATERIAL_ID']) ?></td>
                                <td><?= htmlspecialchars($row['MATERIAL_NAME']) ?></td>
                                <td class="text-end"><?= htmlspecialchars($row['QUANTITY']) ?></td>
                                <td class="text-end">P<?= htmlspecialchars($row['PRICE']) ?></td>
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
                            
                            <!-- Delete Modal -->
                            <dialog id="deleteModal<?= $row['MATERIAL_ID'] ?>" 
                                class="fixed w-sm h-xl p-5 top-1/3 left-1/2 transform -translate-x-1/2 -translate-y-1/2 rounded-md border border-gray-100 shadow-md bg-white backdrop:bg-black/40 open:animate-fadeIn">

                                <form method="POST" action="./Process/InventoryProcess/deleteItem.php" class="space-y-6">

                                    <!-- Modal Title -->
                                    <div class="text-xl text-red-600 font-semibold mb-5">
                                        🗑 Delete Inventory Item
                                    </div>

                                    <!-- Confirmation Text -->
                                    <p class="text-gray-800 mb-5">
                                        Are you sure you want to delete <strong><?= htmlspecialchars($row['MATERIAL_NAME']) ?></strong> from inventory?
                                        This action cannot be undone.
                                    </p>

                                    <!-- Hidden Material ID -->
                                    <input type="hidden" name="materialId" value="<?= htmlspecialchars($row['MATERIAL_ID'])?>">

                                    <!-- Action Buttons -->
                                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                                        <button type="button" 
                                                onclick="document.getElementById('deleteModal<?= $row['MATERIAL_ID'] ?>').close()" 
                                                class="px-4 py-2 bg-gray-300 text-gray-800 font-semibold rounded hover:bg-gray-400">
                                            Cancel
                                        </button>
                                        <button type="submit" name="deleteBtn" 
                                                class="px-4 py-2 bg-red-500 text-white font-semibold rounded hover:bg-red-600">
                                            Confirm
                                        </button>
                                    </div>

                                </form>
                            </dialog>


                            <!-- Update Modal -->
                            <dialog id="updateModal<?= $row['MATERIAL_ID'] ?>" 
                                class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[36rem] max-w-full p-6 rounded-lg shadow-xl border border-gray-300 backdrop:bg-black/40 open:animate-fadeIn">

                                <form method="POST" action="./Process/InventoryProcess/updateItem.php" class="space-y-6">
                                    
                                    <!-- Modal Title -->
                                    <h1 class="text-2xl font-bold text-gray-800">✏️ Update Inventory Information</h1>

                                    <!-- Material Name -->
                                    <div class="space-y-2">
                                        <label class="block text-lg font-medium text-gray-700">Material</label>
                                        <input type="text" name="materialName" value="<?= htmlspecialchars($row['MATERIAL_NAME'])?>" 
                                            class="w-full p-3 text-lg bg-gray-100 border border-gray-300 rounded-md" />
                                    </div>

                                    <!-- Quantity -->
                                    <div class="space-y-2">
                                        <label class="block text-lg font-medium text-gray-700">Quantity</label>
                                        <input type="number" name="materialQuantity" value="<?= $row['QUANTITY'] ?>" 
                                            class="w-full p-3 text-lg border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required />
                                    </div>

                                    <!-- Price -->
                                    <div class="space-y-2">
                                        <label class="block text-lg font-medium text-gray-700">Price</label>
                                        <input type="number" name="materialPrice" value="<?= $row['PRICE'] ?>" 
                                            class="w-full p-3 text-lg border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" />
                                    </div>

                                    <!-- Size/Weight -->
                                    <div class="space-y-2">
                                        <label class="block text-lg font-medium text-gray-700">Size/Weight</label>
                                        <input type="text" name="materialSizeWeight" value="<?= htmlspecialchars($row['SIZE']) ?>" 
                                        class="w-full p-3 text-lg border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" />
                                    </div>

                                    <!-- Model -->
                                    <div class="space-y-2">
                                        <label class="block text-lg font-medium text-gray-700">Model</label>
                                        <input type="text" name="materialModel" value="<?= htmlspecialchars($row['MODEL']) ?>" 
                                            class="w-full p-3 text-lg border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" />
                                    </div>

                                    <!-- Hidden Material ID -->
                                    <input type="hidden" name="materialId" value="<?= htmlspecialchars($row['MATERIAL_ID'])?>">

                                    <!-- Action Buttons -->
                                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                                        <button type="button" 
                                            onclick="document.getElementById('updateModal<?= $row['MATERIAL_ID'] ?>').close()" 
                                            class="px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded hover:bg-gray-300">
                                            Cancel
                                        </button>
                                        <button type="submit" name="updateBtn" 
                                            class="px-4 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600">
                                            Save
                                        </button>
                                    </div>

                                </form>
                            </dialog>

                        <?php endforeach; ?>
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
