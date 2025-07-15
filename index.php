<body>
    <!--Important import files-->
    <?php
        include "./Inclusions/Head.php";
    ?>

    <!--Main Body for Sign in Page, 2 Columns-->
    <div id="BodyDiv" class="w-full h-full  bg-blue-200 flex">

            <!--Image panel-->
            <div class="w-full h-full">

            </div>

            <!--SignIn and SignUp panel-->
            <div class="w-2/3 h-full bg-gray-100 flex items-center justify-center">
                
                <!--SignIn form-->
                <div id="SignInForm" class="w-md h-120 rounded-md shadow-md bg-white flex flex-col items-center text-center p-10 ">
                    <h1 class="text-2xl mb-10"><b>MaterialsCO</b></h1>
                    <form class="text-start w-full" action="">
                        <label class="my-2" for=""><b>Email</b></label> <br>
                        <input class="border rounded-md w-full h-10 my-2 p-3" type="email" id="email">
                        <label class="my-2" for=""><b>Password</b></label> <br>
                        <input class="border rounded-md w-full h-10 my-2 p-3" type="password" id="password">
                        <input class="rounded-md w-full h-10 my-2 text-white bg-blue-400 hover:bg-blue-500 cursor-pointer" type="submit">
                    </form>
                    <p class="my-2">Doesn't have an account yet? <button id="showSignUp" class="text-blue-500 hover:cursor-pointer" >Create Now!</button></p>
                </div>

                <!--SignUp form-->
                <div id="SignUpForm" class="hidden w-md h-120 rounded-md shadow-md bg-white flex flex-col items-center text-center p-10 ">
                    <h1 class="text-2xl mb-7"><b>MaterialsCO</b></h1>
                    <form class="text-start w-full" action="">
                        <label class="my-2" for=""><b>Email</b></label> <br>
                        <input class="border rounded-md w-full h-10 my-2 p-3" type="email" id="signupEmail">
                        <label class="my-2" for=""><b>Password</b></label> <br>
                        <input class="border rounded-md w-full h-10 my-2 p-3" type="password" id="signupPassword">
                        <label class="my-2" for=""><b>Confirm Password</b></label> <br>
                        <input class="border rounded-md w-full h-10 my-2" type="password" id="confirmPassword">
                        <input class="rounded-md w-full h-10 my-2 text-white bg-blue-400 hover:bg-blue-500 cursor-pointer" type="submit">
                    </form>
                        <p class="my-2">Already got an account? <button id="showSignIn" class="text-blue-500 hover:cursor-pointer">Sign-In!</button></p>
                </div>

            </div>
    </div>

    <!--Script import for functionalities-->
    <?php
        include "./Scripts/indexScript.php";
    ?>

</body>
