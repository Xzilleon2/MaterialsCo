<body>
    <!--Important import files-->
    <?php
        include "./Inclusions/Head.php";
        include "./Inclusions/navbar.php";
    ?>

    <!--Main Body for Homepage Page, 2 Columns-->
    <div id="BodyDiv" class="w-full h-full flex">

        <div class="w-1/7">
            <!--Sidebar from import-->
            <?php
                include "./Inclusions/sidebar.php";
            ?>
        </div>

        <!--Home Page Contents-->
        <div class="w-full py-35 px-18 grid grid-row-2 gap-5">

            <!--Request Status-->
            <div class="w-full flex flex-col gap-15">

                <!--owner Info-->
                <div class="w-full px-30 flex flex-col justify-center items-center gap-10">
                    <h1 class="text-5xl font-bold">John Lemon</h1>
                </div>
                
                <!--Stocks Status-->
                <div class="flex justify-center w-full h-45 gap-5">

                    <!--Request Status-->
                    <div class="w-1/4 h-40 bg-blue-200 rounded-sm shadow-sm flex">
                        <div class="w-70 flex justify-center items-center">
                            <p class="text-3xl">Empty <br> Stocks</p>
                        </div>
                        <div class="flex justify-center items-center w-1/2">
                            <p class="text-4xl font-bold">1</p>
                        </div>
                    </div>

                    <!--Request Status-->
                    <div class="w-1/4 h-40 bg-blue-200 rounded-sm shadow-sm flex">
                        <div class="w-70 flex justify-center items-center">
                            <p class="text-3xl">Low <br> Stocks</p>
                        </div>
                        <div class="flex justify-center items-center w-1/2">
                            <p class="text-4xl font-bold">1</p>
                        </div>
                    </div>

                    <!--Request Status-->
                    <div class="w-1/4 h-40 bg-blue-200 rounded-sm shadow-sm flex">
                        <div class="w-70 flex justify-center items-center">
                            <p class="text-3xl">Delievered <br> Requests</p>
                        </div>
                        <div class="flex justify-center items-center w-1/2">
                            <p class="text-4xl font-bold">1</p>
                        </div>
                    </div>
                </div>

                <!--Payment Status-->
                <div class="flex justify-center w-full gap-5">

                    <!--Payment Status-->
                    <div class="w-1/4 h-40 bg-blue-200 rounded-sm shadow-sm flex">
                        <div class="w-70 flex justify-center items-center">
                            <p class="text-3xl">Delievered <br> Requests</p>
                        </div>
                        <div class="flex justify-center items-center w-1/2">
                            <p class="text-4xl font-bold">1</p>
                        </div>
                    </div> 

                    <!--Payment Status-->
                    <div class="w-1/4 h-40 bg-blue-200 rounded-sm shadow-sm flex">
                        <div class="w-70 flex justify-center items-center">
                            <p class="text-3xl">Delievered <br> Requests</p>
                        </div>
                        <div class="flex justify-center items-center w-1/2">
                            <p class="text-4xl font-bold">1</p>
                        </div>
                    </div>

                    <!--Payment Status-->
                    <div class="w-1/4 h-40 bg-blue-200 rounded-sm shadow-sm flex">
                        <div class="w-70 flex justify-center items-center">
                            <p class="text-3xl">Delievered <br> Requests</p>
                        </div>
                        <div class="flex justify-center items-center w-1/2">
                            <p class="text-4xl font-bold">1</p>
                        </div>
                    </div>

                </div>

            </div>
        </div>


    </div>

    <!--Script import for functionalities-->
    <?php

    ?>

</body>
