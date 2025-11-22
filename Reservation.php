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
        include __DIR__ . "/Inclusions/Connection.php";
        include __DIR__ . "/Inclusions/Methods.php";
        include __DIR__ . "/Process/InventoryProcess/getItems.php";
        include __DIR__ . "/Process/ReservationProcess/getItems.php";
    ?>

    <!--Main Body for Reservation Page, 2 Columns-->
    <div id="BodyDiv" class="w-full h-full flex">

        <div class="w-1/6">
            <!--Sidebar from import-->
            <?php
                include "./Inclusions/sidebar.php";
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

                <!--Reservation Status-->
                <div id="showReservation" class="w-1/5 h-20 my-5 bg-blue-200 rounded-sm shadow-sm flex">
                    <div class="w-70 flex justify-center items-center gap-3 hover:cursor-pointer">
                        <img src="./Assets/Icons/note.png" alt="noteIcon">
                        <p class="text-xl">Make a Reservation</p>
                    </div>
                </div>

                <!-- Reservation Entry Modal -->
                <dialog id="reservationEntry" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[36rem] max-w-full p-6 rounded-lg shadow-xl border border-gray-300 backdrop:bg-black/40 open:animate-fadeIn">
                    <form method="POST" action="./Process/ReservationProcess/addItem.php" class="space-y-6">

                        <!-- Modal Title -->
                        <h1 class="text-2xl font-bold text-gray-800">🛠 Manage Inventory Information</h1>

                        <!-- Material Dropdown -->
                        <div class="space-y-2">
                            <label class="block text-lg font-medium text-gray-700">Material</label>
                            <select name="material_id" class="w-full p-3 text-lg bg-gray-100 border border-gray-300 rounded-md">
                                <option disabled selected>Select a Material</option>
                                <?php while($row = $getMaterials->fetch_assoc()): ?>
                                    <option value="<?= $row['MATERIAL_ID'] ?>">
                                        <?= $row['MATERIAL_NAME'] ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>


                        <!-- Quantity -->
                        <div class="space-y-2">
                        <label class="block text-lg font-medium text-gray-700">Quantity</label>
                        <input type="number" value="1" name="quantity" class="w-full p-3 text-lg border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" />
                        </div>

                        <!-- Size/Weight -->
                        <div class="space-y-2">
                        <label class="block text-lg font-medium text-gray-700">Size/Weight</label>
                        <input type="text" value="1m" name="size" class="w-full p-3 text-lg border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" />
                        </div>

                        <!-- Claim Date -->
                        <div class="space-y-2">
                        <label class="block text-lg font-medium text-gray-700">Date to Claim</label>
                        <input type="date" name="claimDate" class="w-full p-3 text-lg border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" />
                        </div>

                        <!-- Requestor -->
                        <div class="space-y-2">
                        <label class="block text-lg font-semibold text-gray-700">Requestor</label>
                        <input type="text" name="requestor" class="w-full p-3 text-lg border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" />
                        </div>

                        <!-- Purpose -->
                        <div class="space-y-2">
                        <label class="block text-lg font-semibold text-gray-700">Remarks</label>
                        <textarea name="remarks" rows="3" class="w-full p-3 text-lg border border-gray-300 rounded-md resize-none focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                        </div>


                        <!-- Action Buttons -->
                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                        <button type="button" onclick="document.getElementById('reservationEntry').close()" class="px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded hover:bg-gray-300">Cancel</button>
                        <button type="submit" name="updateBtn" class="px-4 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600">Save</button>
                        </div>
                        
                    </form>
                </dialog>

            </div>

            <!--Reservation Table-->
            <div class="h-full w-full">

                <table id="reservationTable" class="table-auto border-separate border h-fit max-h-full">
                    <thead>
                        <tr class="text-xl">
                            <th class="w-md ">Material Code</th>
                            <th class="w-md ">Material Name</th>
                            <th class="w-md ">Quantity</th>
                            <th class="w-lg ">Size</th>
                            <th class="w-lg ">Requestor</th>
                            <th class="w-md ">Remarks</th>
                            <th class="w-md ">Reservation Date</th>
                            <th class="w-md ">Claiming Date</th>
                            <th class="w-md ">Status</th>
                            <th class="w-md ">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $getReservation->fetch_assoc()): ?>
                            <tr class="odd:bg-blue-100 even:bg-blue-200 h-10">
                                <td class="text-end"><?= htmlspecialchars($row['MATERIAL_ID']) ?></td>
                                <td><?= htmlspecialchars($row['MATERIAL_NAME']) ?></td>
                                <td class="text-end"><?= htmlspecialchars($row['QUANTITY']) ?></td>
                                <td><?= htmlspecialchars($row['SIZE']) ?></td>
                                <td><?= htmlspecialchars($row['REQUESTOR']) ?></td>
                                <td><?= htmlspecialchars($row['PURPOSE']) ?></td>
                                <td><?= htmlspecialchars($row['RESERVATION_DATE']) ?></td>
                                <td><?= htmlspecialchars($row['CLAIMING_DATE']) ?></td>
                                <td><?= htmlspecialchars($row['STATUS']) ?></td>
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
                            <dialog id="deleteModal<?= $row['RESERVATION_ID'] ?>" class="fixed w-sm h-xl p-5 top-1/3 left-1/2 transform -translate-x-1/2 -translate-y-1/2 rounded-md border border-gray-100 shadow-md bg-white backdrop:bg-black/40 open:animate-fadeIn">
                                <form method="POST" action="./Process/ReservationProcess/deleteItem.php" class="space-y-6">
                                    <div class="text-xl text-red-600 font-semibold mb-5">🗑 Delete Reservation Record</div>
                                    <p class="text-gray-800 mb-5">
                                        Are you sure you want to delete <strong><?= htmlspecialchars($row['MATERIAL_NAME']) ?></strong> from reservation records? This action cannot be undone.
                                    </p>
                                    <input type="hidden" name="reservationId" value="<?= $row['RESERVATION_ID'] ?>">
                                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                                        <button type="button" onclick="document.getElementById('deleteModal<?= $row['RESERVATION_ID'] ?>').close()" class="px-4 py-2 bg-gray-300 text-gray-800 font-semibold rounded hover:bg-gray-400">Cancel</button>
                                        <button type="submit" name="deleteBtn" class="px-4 py-2 bg-red-500 text-white font-semibold rounded hover:bg-red-600">Confirm</button>
                                    </div>
                                </form>
                            </dialog>

                            <!-- Update Modal -->
                            <dialog id="updateModal<?= $row['RESERVATION_ID'] ?>" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[36rem] max-w-full p-6 rounded-lg shadow-xl border border-gray-300 backdrop:bg-black/40 open:animate-fadeIn">
                                <form method="POST" action="./Process/ReservationProcess/updateStatus.php" class="space-y-6">
                                    <h1 class="text-2xl font-bold text-gray-800">🔁 Update Reservation Status</h1>

                                    <!-- Material Name -->
                                    <div class="space-y-2">
                                        <label class="block text-lg font-medium text-gray-700">Material Name</label>
                                        <input type="text" value="<?= htmlspecialchars($row['MATERIAL_NAME']) ?>" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-md" readonly>
                                    </div>

                                    <!-- Quantity -->
                                    <div class="space-y-2">
                                        <label class="block text-lg font-medium text-gray-700">Quantity</label>
                                        <input type="number" name="quantity" value="<?= $row['QUANTITY'] ?>" class="w-full p-3 border border-gray-300 rounded-md" readonly>
                                    </div>

                                    <!-- Size -->
                                    <div class="space-y-2">
                                        <label class="block text-lg font-medium text-gray-700">Size/Weight</label>
                                        <input type="text" name="size" value="<?= htmlspecialchars($row['SIZE']) ?>" class="w-full p-3 border border-gray-300 rounded-md" readonly>
                                    </div>

                                    <!-- Purpose -->
                                    <div class="space-y-2">
                                        <label class="block text-lg font-medium text-gray-700">Purpose</label>
                                        <input type="text" name="purpose" value="<?= htmlspecialchars($row['PURPOSE']) ?>" class="w-full p-3 border border-gray-300 rounded-md" readonly>
                                    </div>

                                    <!-- Claiming Date -->
                                    <div class="space-y-2">
                                        <label class="block text-lg font-medium text-gray-700">Claiming Date</label>
                                        <input type="date" name="claimDate" value="<?= $row['CLAIMING_DATE'] ?>" class="w-full p-3 border border-gray-300 rounded-md" readonly>
                                    </div>

                                    <!-- Requestor -->
                                    <div class="space-y-2">
                                        <label class="block text-lg font-medium text-gray-700">Requestor</label>
                                        <input type="text" name="requestor" value="<?= htmlspecialchars($row['REQUESTOR']) ?>" class="w-full p-3 border border-gray-300 rounded-md" readonly>
                                    </div>

                                    <!-- Remarks -->
                                    <div class="space-y-2">
                                        <label class="block text-lg font-medium text-gray-700">Remarks</label>
                                        <textarea name="remarks" rows="3" class="w-full p-3 border border-gray-300 rounded-md resize-none" readonly><?= htmlspecialchars($row['PURPOSE']) ?></textarea>
                                    </div>

                                    <!-- Hidden fields -->
                                    <input type="hidden" name="reservationId" value="<?= $row['RESERVATION_ID'] ?>">
                                    <input type="hidden" name="materialId" value="<?= $row['MATERIAL_ID'] ?>">

                                    <!-- Actions -->
                                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                                        <button type="button" onclick="document.getElementById('updateModal<?= $row['RESERVATION_ID'] ?>').close()" class="px-4 py-2 bg-gray-300 text-gray-800 font-semibold rounded hover:bg-gray-400">Cancel</button>
                                        <button type="submit" name="action" value="deny" class="px-4 py-2 bg-red-500 text-white font-semibold rounded hover:bg-red-600">Deny</button>
                                        <button type="submit" name="action" value="approve" class="px-4 py-2 bg-green-500 text-white font-semibold rounded hover:bg-green-600">Approve</button>
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
        include __DIR__ . '/Scripts/mainScript.php';
    ?>

</body>
