<body>
    <!--Important import files-->
    <?php
        include "./Inclusions/Head.php";
        include "./Inclusions/navbar.php";
    ?>

    <!--Main Body for Reservation Page, 2 Columns-->
    <div id="BodyDiv" class="w-full h-full flex">

        <div class="w-1/7">
            <!--Sidebar from import-->
            <?php
                include "./Inclusions/sidebar.php";
            ?>
        </div>

        <!--Parts Distribution-->
        <div class="w-full py-10 px-18 flex flex-col gap-5">

            <div class="w-full h-20 my-5 text-5xl font-bold flex justify-center items-center">
                <h1>Material Reservation</h1>
            </div>

            <!--Indicators-->
            <div class="flex justify-center gap-5">

                
                <!--Distribution Status-->
                <div class="w-1/4 h-30 bg-blue-200 rounded-sm shadow-sm flex">
                    <div class="w-70 flex justify-center items-center">
                        <p class="text-2xl">Pending <br> Requests</p>
                    </div>
                    <div class="flex justify-center items-center w-1/2">
                        <p class="text-4xl font-bold">1</p>
                    </div>
                </div>

                <!--Distribution Status-->
                <div class="w-1/4 h-30 bg-blue-200 rounded-sm shadow-sm flex">
                    <div class="w-70 flex justify-center items-center">
                        <p class="text-2xl">Duplicate <br> Requests</p>
                    </div>
                    <div class="flex justify-center items-center w-1/2">
                        <p class="text-4xl font-bold">1</p>
                    </div>
                </div>

                <!--Distribution Status-->
                <div class="w-1/5 h-20 my-5 bg-blue-200 rounded-sm shadow-sm flex">
                    <div class="w-70 flex justify-center items-center gap-3 hover:cursor-pointer">
                        <img src="./Assets/Icons/note.png" alt="noteIcon">
                        <p class="text-xl">Make a Reservation</p>
                    </div>
                </div>

            </div>

            <!--Distribution Table-->
            <div class="h-full w-full">

                <table id="distributionTable" class="table-auto border-separate border h-fit max-h-full">
                    <thead>
                        <tr class="text-xl">
                            <th class="w-md ">Material Code</th>
                            <th class="w-md ">Material Name</th>
                            <th class="w-md ">Quantity</th>
                            <th class="w-lg ">Total Price</th>
                            <th class="w-lg ">Requestor</th>
                            <th class="w-lg ">Remarks</th>
                            <th class="w-md ">Date Reserved</th>
                            <th class="w-md ">Claiming Date</th>
                            <th class="w-md ">Status</th>
                            <th class="w-md ">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="odd:bg-blue-100 even:bg-blue-200 h-10">
                            <td>MAT1002</td>
                            <td>Davis Elastic Paint Yellow</td>
                            <td class="text-end">20</td>
                            <td class="text-end">420</td>
                            <td >Jane Mayham</td>
                            <td >To be used for the construction of dog house.</td>
                            <td>June 1, 2025</td>
                            <td>June 29, 2025</td>
                            <td>Pending</td>
                            <td>
                                <div class="flex gap-5">
                                    <div><img src="./Assets/Icons/update.png" alt="update"></div>
                                    <div><img src="./Assets/Icons/delete.png" alt="delete"></div>
                                </div>
                            </td>
                    </tbody>
                </table>

            </div>

        </div>

    </div>

    <!--Script import for functionalities-->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const dtable = document.querySelector("#distributionTable");
        new simpleDatatables.DataTable(dtable);
    });
    </script>

</body>
