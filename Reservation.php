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
        $materials = $itemsView->viewReservations();
        $inventoryMaterials = $itemsView->viewInventory();
    ?>

    <!--Main Body for Reservation Page, 2 Columns-->
    <div id="BodyDiv" class="w-full h-full flex">

        <div class="w-1/6">
            <!--Sidebar from import-->
            <?php
                include __DIR__ . "/Inclusions/sidebar.php";
            ?>
        </div>

        <!--Parts Reservation-->
        <div class="w-full py-10 px-18 flex flex-col gap-5">

            <!--Message Panel-->
            <?php renderFlashBox(); ?>

            <div class="w-full h-20 my-5 text-5xl font-bold flex justify-center items-center">
                <h1>Material Reservation</h1>
            </div>

            <!--Indicators-->
            <div class="flex justify-center gap-5">

                
                <!--Reservation Status-->
                <div class="w-1/4 h-30 bg-blue-200 rounded-sm shadow-sm flex">
                    <div class="w-70 flex justify-center items-center">
                        <p class="text-2xl">Pending <br> Reservations</p>
                    </div>
                    <div class="flex justify-center items-center w-1/2">
                        <p class="text-4xl font-bold">0</p>
                    </div>
                </div>

                <!--Reservation Status-->
                <div class="w-1/4 h-30 bg-blue-200 rounded-sm shadow-sm flex">
                    <div class="w-70 flex justify-center items-center">
                        <p class="text-2xl">Duplicate <br> Requests</p>
                    </div>
                    <div class="flex justify-center items-center w-1/2">
                        <p class="text-4xl font-bold">0</p>
                    </div>
                </div>

                <!-- Reservation Box -->
                <div id="showReservation" 
                    class="w-1/5 h-28 bg-blue-200 mt-1 rounded-sm shadow-sm flex justify-center items-center cursor-pointer">
                    <div class="flex flex-col justify-center items-center gap-2">
                        <img src="./Assets/Icons/note.png" alt="noteIcon">
                        <p class="text-xl text-center">Make a <br>Reservation</p>
                    </div>
                </div>

                <!-- Reservation Entry Modal -->
                <dialog id="reservationModal" 
                        class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[36rem] max-w-full p-6 rounded-lg shadow-xl border border-gray-300 backdrop:bg-black/40 open:animate-fadeIn">

                    <form method="POST" action="./Process/ReservationProcess/addItem.php" class="space-y-6">

                        <!-- Modal Title -->
                        <h1 class="text-2xl font-bold text-gray-800">🛠 Make a Material Reservation</h1>

                        <!-- Material Dropdown -->
                        <div class="space-y-2">
                            <label class="block text-lg font-medium text-gray-700">Material</label>
                            <select name="material_id" class="w-full p-3 text-lg bg-gray-100 border border-gray-300 rounded-md" required>
                                <option disabled selected>Select a Material</option>
                                <?php foreach ($inventoryMaterials as $material): ?>
                                    <option value="<?= htmlspecialchars($material['MATERIAL_ID']) ?>">
                                        <?= htmlspecialchars($material['MATERIAL_ID']) ?> - <?= htmlspecialchars($material['MATERIAL_NAME']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <!-- Quantity -->
                        <div class="space-y-2">
                            <label class="block text-lg font-medium text-gray-700">Quantity</label>
                            <input type="number" value="1" name="quantity" class="w-full p-3 text-lg border border-gray-300 rounded-md" required />
                        </div>

                        <!-- Claim Date -->
                        <div class="space-y-2">
                            <label class="block text-lg font-medium text-gray-700">Date to Claim</label>
                            <input type="date" name="claimDate" class="w-full p-3 text-lg border border-gray-300 rounded-md" required />
                        </div>

                        <!-- Requestor -->
                        <div class="space-y-2">
                            <label class="block text-lg font-semibold text-gray-700">Requestor</label>
                            <input type="text" name="requestor" class="w-full p-3 text-lg border border-gray-300 rounded-md" required />
                        </div>

                        <!-- Remarks -->
                        <div class="space-y-2">
                            <label class="block text-lg font-semibold text-gray-700">Remarks (optional)</label>
                            <textarea name="remarks" rows="3" class="w-full p-3 text-lg border border-gray-300 rounded-md resize-none"></textarea>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                            <button type="button" 
                                    onclick="document.getElementById('reservationModal').close()" 
                                    class="px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded hover:bg-gray-300">
                                Cancel
                            </button>
                            <button type="submit" name="reserveBtn" 
                                    class="px-4 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600">
                                Save
                            </button>
                        </div>

                    </form>
                </dialog>

            </div>

            <!--Reservation Table-->
            <div class="h-full w-full">

                <table id="inventoryTable" class="table-auto border-separate border h-fit max-h-full">
                    <thead>
                        <tr class="text-xl">
                            <th class="w-md ">RESERVATION ID</th>
                            <th class="w-md ">MATERIAL ID</th>
                            <th class="w-md ">QUANTITY</th>
                            <th class="w-lg ">REQUESTOR</th>
                            <th class="w-lg ">PURPOSE</th>
                            <th class="w-md ">RESERVATION DATE</th>
                            <th class="w-md ">CLAIMING DATE</th>
                            <th class="w-md ">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($materials as $row): ?>
                            <tr class="odd:bg-blue-100 even:bg-blue-200 h-10">
                                <td class="text-end"><?= htmlspecialchars($row['RESERVATION_ID']) ?></td>
                                <td><?= htmlspecialchars($row['MATERIAL_ID']) ?></td>
                                <td class="text-end"><?= htmlspecialchars($row['QUANTITY']) ?></td>
                                <td class="text-end"><?= htmlspecialchars($row['REQUESTOR']) ?></td>
                                <td><?= htmlspecialchars($row['PURPOSE']) ?></td>
                                <td><?= htmlspecialchars(date('F j, Y', strtotime($row['RESERVATION_DATE']))) ?></td>
                                <td><?= htmlspecialchars(date('F j, Y', strtotime($row['CLAIMING_DATE']))) ?></td>
                                <td>
                                    <div class="flex gap-5">
                                        <div class="cursor-pointer" onclick="document.getElementById('updateModal<?= $row['RESERVATION_ID'] ?>').showModal()">
                                            <img src="./Assets/Icons/update.png" alt="update">
                                        </div>
                                        <div class="cursor-pointer" onclick="document.getElementById('deleteModal<?= $row['RESERVATION_ID'] ?>').showModal()">
                                            <img src="./Assets/Icons/delete.png" alt="delete">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Delete Modal -->
                            <dialog id="deleteModal<?= $row['RESERVATION_ID'] ?>" 
                                class="fixed w-sm h-xl p-5 top-1/3 left-1/2 transform -translate-x-1/2 -translate-y-1/2 rounded-md border border-gray-100 shadow-md bg-white backdrop:bg-black/40 open:animate-fadeIn">

                                <form method="POST" action="./Process/ReservationProcess/deleteItem.php" class="space-y-6">

                                    <!-- Modal Title -->
                                    <div class="text-xl text-red-600 font-semibold mb-5">
                                        🗑 Delete Inventory Item
                                    </div>

                                    <!-- Confirmation Text -->
                                    <p class="text-gray-800 mb-5">
                                        Are you sure you want to cancel this reservation?
                                        This action cannot be undone.
                                    </p>

                                    <!-- Hidden Reservation ID -->
                                    <input type="hidden" name="reservationId" value="<?= htmlspecialchars($row['RESERVATION_ID'])?>">

                                    <!-- Action Buttons -->
                                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                                        <button type="button" 
                                                onclick="document.getElementById('deleteModal<?= $row['RESERVATION_ID'] ?>').close()" 
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
                            <dialog id="updateModal<?= $row['RESERVATION_ID'] ?>" 
                                class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[36rem] max-w-full p-6 rounded-lg shadow-xl border border-gray-300 backdrop:bg-black/40 open:animate-fadeIn">

                                <form method="POST" action="./Process/ReservationProcess/updateStatus.php" class="space-y-6">
                                    <!-- Modal Title -->
                                    <h1 class="text-2xl font-bold text-gray-800">✏️ Update Reservation Information</h1>

                                    <!-- Material ID -->
                                    <div class="space-y-2">
                                        <label class="block text-lg font-medium text-gray-700">Material</label>
                                        <input disabled type="text" name="materialId" value="<?= htmlspecialchars($row['MATERIAL_ID'])?>" 
                                            class="w-full p-3 text-lg bg-gray-100 border border-gray-300 rounded-md" />
                                    </div>
                                    
                                    <!-- Quantity -->
                                    <div class="space-y-2">
                                        <label class="block text-lg font-medium text-gray-700">Quantity</label>
                                        <input type="number" min="1" name="quantity" value="<?= $row['QUANTITY'] ?>" 
                                            class="w-full p-3 text-lg border border-gray-300 rounded-md" required />
                                    </div>
                                    
                                    <!-- Requestor -->
                                    <div class="space-y-2">
                                        <label class="block text-lg font-medium text-gray-700">Requestor</label>
                                        <input type="text" name="requestor" value="<?= $row['REQUESTOR'] ?>" 
                                            class="w-full p-3 text-lg border border-gray-300 rounded-md" />
                                    </div>

                                    <!-- Claiming Date -->
                                    <div class="space-y-2">
                                        <label class="block text-lg font-medium text-gray-700">Claming Date</label>
                                        <input type="date" name="claimingDate" value="<?= $row['CLAIMING_DATE'] ?>" 
                                            class="w-full p-3 text-lg border border-gray-300 rounded-md" />
                                    </div>

                                    <!-- Remarks -->
                                    <div class="space-y-2">
                                        <label class="block text-lg font-medium text-gray-700">Remarks</label>
                                        <textarea name="remarks" rows="3" class="w-full p-3 text-lg border border-gray-300 rounded-md resize-none"><?= htmlspecialchars($row['PURPOSE']) ?></textarea>
                                    </div>
                                    
                                    <!-- Hidden Material ID -->
                                    <input type="hidden" name="reservationId" value="<?= htmlspecialchars($row['RESERVATION_ID'])?>">

                                    <!-- Action Buttons -->
                                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                                        <button type="button" onclick="document.getElementById('updateModal<?= $row['RESERVATION_ID'] ?>').close()" 
                                            class="px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded hover:bg-gray-300">Cancel</button>
                                        <button type="submit" name="updateBtn" 
                                            class="px-4 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600">Save</button>
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
