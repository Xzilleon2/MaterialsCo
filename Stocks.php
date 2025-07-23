<body>
    <!--Important import files-->
    <?php
        include "./Inclusions/Head.php";
        include "./Inclusions/navbar.php";
        include "./Inclusions/Connection.php";
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
                            <th class="w-md ">In/Out Quantity</th>
                            <th class="w-lg ">Total Price</th>
                            <th class="w-lg ">Type</th>
                            <th class="w-md ">Remarks</th>
                            <th class="w-md ">Time and Date</th>
                            <th class="w-md ">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="odd:bg-blue-100 even:bg-blue-200 h-10">
                            <td>MAT1002</td>
                            <td>Davis Elastic Paint Yellow</td>
                            <td class="text-end">20</td>
                            <td class="text-end">420</td>
                            <td>Out</td>
                            <td>City Hardware, Bajada</td>
                            <td>June 15, 2005</td>
                            <td>
                                <div class="flex gap-5">
                                    <div id="showUpdateModal" class="cursor-pointer"><img src="./Assets/Icons/update.png" alt="update"></div>
                                    <div id="showDeleteModal" class="cursor-pointer"><img src="./Assets/Icons/delete.png" alt="delete"></div>
                                </div>
                            </td>
                    </tbody>
                    
                    <!--Delete Modal-->
                    <dialog id="deleteModal" class="fixed w-sm h-xl p-5 top-1/3 left-1/2 rounded-md border border-gray-100 shadow-md">
                            <form class="grid grid-rows-2" method="POST" action="">

                                <!--Delete Modal Information-->
                                <div class="text-xl mb-3 p-5 text-red-500">
                                    <h1>Are you sure you want to delete this reservation?</h1>
                                </div>
                                <div class="flex justify-end gap-2">
                                    <button type="submit" name="deleteBtn" class="bg-blue-200 px-4 py-2 rounded font-bold">Confirm</button>
                                    <button type="button" onclick="document.getElementById('deleteModal').close()" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                                </div>
                                
                            </form>
                    </dialog>

                    <!--Update Modal-->
                    <dialog id="updateModal" class="fixed w-sm h-xl p-5 top-1/3 left-1/2 rounded-md border border-gray-100 shadow-md">
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
                                    <button type="button" onclick="document.getElementById('updateModal').close()" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                                </div>

                            </form>
                    </dialog>
                </table>

            </div>

        </div>

    </div>

    <!--Script import for functionalities-->
    <?php 
        include './Scripts/mainScript.php';
    ?>

</body>
