<body>
    <!--Important import files-->
    <?php
        include "./Inclusions/Head.php";
        include "./Inclusions/navbar.php";
        include "./Inclusions/Connection.php";
        include "./Inclusions/Methods.php";
        include "./Process/DistributionProcess/getItems.php";
        include "./Process/InventoryProcess/getItems.php";
    ?>

    <!--Main Body for Distribution Page, 2 Columns-->
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
                <h1>Material Distribution</h1>
            </div>

            <!--Indicators-->
            <div class="flex justify-center gap-5">

                
                <!--Distribution Status-->
                <div class="w-1/4 h-30 bg-blue-200 rounded-sm shadow-sm flex">
                    <div class="w-70 flex justify-center items-center">
                        <p class="text-2xl">Pending <br> Status</p>
                    </div>
                    <div class="flex justify-center items-center w-1/2">
                        <p class="text-4xl font-bold">0</p>
                    </div>
                </div>

                <!--Distribution Status-->
                <div class="w-1/4 h-30 bg-blue-200 rounded-sm shadow-sm flex">
                    <div class="w-70 flex justify-center items-center">
                        <p class="text-2xl">Duplicated <br> Distribution</p>
                    </div>
                    <div class="flex justify-center items-center w-1/2">
                        <p class="text-4xl font-bold">0</p>
                    </div>
                </div>

                <!--Distribution Status-->
                <div id="showDistribution" class="w-1/5 h-20 my-5 bg-blue-200 rounded-sm shadow-sm flex">
                    <div class="w-70 flex justify-center items-center gap-3 hover:cursor-pointer">
                        <img src="./Assets/Icons/note.png" alt="noteIcon">
                        <p class="text-xl">Note an entry</p>
                    </div>
                </div>

                <!-- Entry Modal -->
                <dialog id="distributionEntry" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[32rem] max-w-full rounded-xl border border-gray-300 shadow-xl backdrop:bg-black/50 p-6 open:animate-fadeIn">
                    <form method="POST" action="./Process/DistributionProcess/addItem.php" class="space-y-6">

                        <!-- Title -->
                        <h1 class="text-2xl font-bold text-gray-800">📦 Record Material Distribution</h1>

                        <!-- Material & Quantity -->
                        <div class="space-y-2">
                        <label class="block text-lg font-semibold text-gray-700">Material</label>
                        <select name="materialId" class="w-full p-3 text-lg bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                            <option value="" disabled selected>Select Material</option>
                            <?php while ($material = $getMaterials->fetch_assoc()): ?>
                                <option value="<?= $material['MATERIAL_ID'] ?>">
                                    <?= htmlspecialchars($material['MATERIAL_NAME']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                        </div>

                        <div class="space-y-2">
                        <label class="block text-lg font-semibold text-gray-700">Quantity</label>
                        <input type="number" value="10" name="quantity" class="w-full p-3 text-lg border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" />
                        </div>

                        <!-- Location -->
                        <div class="space-y-2">
                        <label class="block text-lg font-semibold text-gray-700">Location</label>
                        <input type="text" name="location" class="w-full p-3 text-lg border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" />
                        </div>

                        <!-- Remarks -->
                        <div class="space-y-2">
                        <label class="block text-lg font-semibold text-gray-700">Remarks</label>
                        <textarea name="remarks" rows="3" class="w-full p-3 text-lg border border-gray-300 rounded-md resize-none focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                        </div>
                        
                        <!-- Hidden Reservation ID if have one -->
                        <input type="hidden" name="reservationId" value="<?= isset($reservationId) ? $reservationId : '' ?>">

                        <!-- Buttons -->
                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                        <button type="button" onclick="document.getElementById('distributionEntry').close()" class="px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded hover:bg-gray-300">Cancel</button>
                        <button type="submit" name="addBtn" class="px-4 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600">Save</button>
                        </div>

                    </form>
                </dialog>


            </div>

            <!--Distribution Table-->
            <div class="h-full w-full">

                <table id="distributionTable" class="table-auto border-separate border h-fit max-h-full">
                    <thead>
                        <tr class="text-xl">
                            <th class="w-md ">Material Code</th>
                            <th class="w-md ">Material Name</th>
                            <th class="w-md ">Quantity</th>
                            <th class="w-lg ">Location</th>
                            <th class="w-md ">Remarks</th>
                            <th class="w-md ">Approved By</th>
                            <th class="w-md ">Date Released</th>
                            <th class="w-md ">Status</th>
                            <th class="w-md ">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $getDistribution->fetch_assoc()): ?>
                            <tr class="odd:bg-blue-100 even:bg-blue-200 h-10">
                                <td class="text-end"><?= htmlspecialchars($row['MATERIAL_ID']) ?></td>
                                <td><?= htmlspecialchars($row['MATERIAL_NAME']) ?></td>
                                <td class="text-end"><?= htmlspecialchars($row['QUANTITY']) ?></td>
                                <td><?= htmlspecialchars($row['LOCATION']) ?></td>
                                <td><?= htmlspecialchars($row['REMARKS']) ?></td>
                                <td><?= htmlspecialchars($row['APPROVED_BY']) ?></td>
                                <td><?= htmlspecialchars($row['DATE_RELEASED']) ?></td>
                                <td><?= htmlspecialchars($row['STATUS']) ?></td>
                                <td>
                                    <div class="flex gap-5">
                                        <div class="cursor-pointer" onclick="document.getElementById('updateModal<?= $row['DISTRIBUTION_ID'] ?>').showModal()">
                                            <img src="./Assets/Icons/update.png" alt="update">
                                        </div>
                                        <div class="cursor-pointer" onclick="document.getElementById('deleteModal<?= $row['DISTRIBUTION_ID'] ?>').showModal()">
                                            <img src="./Assets/Icons/delete.png" alt="delete">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Delete Modal -->
                            <dialog id="deleteModal<?= $row['DISTRIBUTION_ID'] ?>" class="fixed w-sm h-xl p-5 top-1/3 left-1/2 transform -translate-x-1/2 -translate-y-1/2 rounded-md border border-gray-100 shadow-md bg-white backdrop:bg-black/40 open:animate-fadeIn">
                                <form method="POST" action="./Process/DistributionProcess/deleteItem.php" class="space-y-6">
                                    <div class="text-xl text-red-600 font-semibold mb-5">🗑 Delete Distribution Record</div>
                                    <p class="text-gray-800 mb-5">
                                        Are you sure you want to delete <strong><?= htmlspecialchars($row['MATERIAL_NAME']) ?></strong> from distribution records? This action cannot be undone.
                                    </p>
                                    <input type="hidden" name="distributionId" value="<?= $row['DISTRIBUTION_ID'] ?>">
                                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                                        <button type="button" onclick="document.getElementById('deleteModal<?= $row['DISTRIBUTION_ID'] ?>').close()" class="px-4 py-2 bg-gray-300 text-gray-800 font-semibold rounded hover:bg-gray-400">Cancel</button>
                                        <button type="submit" name="deleteBtn" class="px-4 py-2 bg-red-500 text-white font-semibold rounded hover:bg-red-600">Confirm</button>
                                    </div>
                                </form>
                            </dialog>

                            <!-- Update Modal -->
                            <dialog id="updateModal<?= $row['DISTRIBUTION_ID'] ?>" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[36rem] max-w-full p-6 rounded-lg shadow-xl border border-gray-300 backdrop:bg-black/40 open:animate-fadeIn">
                                <form method="POST" action="./Process/DistributionProcess/updateStatus.php" class="space-y-6">

                                    <h1 class="text-2xl font-bold text-gray-800">🔁 Update Distribution Status</h1>

                                    <div class="space-y-2">
                                        <label class="block text-lg font-medium text-gray-700">Material Name</label>
                                        <input type="text" name="materialName" value="<?= htmlspecialchars($row['MATERIAL_NAME']) ?>" class="w-full p-3 text-lg bg-gray-100 border border-gray-300 rounded-md" readonly />
                                    </div>

                                    <div class="space-y-2">
                                        <label class="block text-lg font-medium text-gray-700">Quantity</label>
                                        <input type="number" name="quantity" value="<?= $row['QUANTITY'] ?>" class="w-full p-3 text-lg border border-gray-300 rounded-md" readonly />
                                    </div>

                                    <div class="space-y-2">
                                        <label class="block text-lg font-medium text-gray-700">Location</label>
                                        <input type="text" name="location" value="<?= htmlspecialchars($row['LOCATION']) ?>" class="w-full p-3 text-lg border border-gray-300 rounded-md" />
                                    </div>

                                    <div class="space-y-2">
                                        <label class="block text-lg font-medium text-gray-700">Remarks</label>
                                        <textarea name="remarks" rows="3" class="w-full p-3 text-lg border border-gray-300 rounded-md resize-none" readonly><?= htmlspecialchars($row['REMARKS']) ?></textarea>
                                    </div>

                                    <div class="space-y-2">
                                        <label class="block text-lg font-medium text-gray-700">Approved By</label>
                                        <input type="text" name="approvedBy" class="w-full p-3 text-lg border border-gray-300 rounded-md" required />
                                    </div>

                                    <!-- Hidden values -->
                                    <input type="hidden" name="materialId" value="<?= $row['MATERIAL_ID'] ?>" />
                                    <input type="hidden" name="distributionId" value="<?= $row['DISTRIBUTION_ID'] ?>" />

                                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                                        <button type="button" onclick="document.getElementById('updateModal<?= $row['DISTRIBUTION_ID'] ?>').close()" class="px-4 py-2 bg-gray-300 text-gray-800 font-semibold rounded hover:bg-gray-400">Cancel</button>
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
        include './Scripts/mainScript.php';
    ?>

</body>
