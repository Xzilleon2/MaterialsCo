<?php
    session_start();
?>
<body>
    <!--Important import files-->
    <?php
        include __DIR__ ."/Inclusions/Head.php";
        include __DIR__ ."/Inclusions/Methods.php";
        include __DIR__ ."/Inclusions/navbarIndex.php";
    ?>

    <!--Main Body for Sign in Page, 2 Columns-->
    <div id="BodyDiv" class="w-full min-h-screen bg-gray-100 flex font-sans justify-center items-center bg-cover bg-center bg-no-repeat p-6" style="background-image: url('./Assets/Images/subtle-background-white.jpg');">

            <!--SignIn and SignUp panel-->
            <div class="w-full md:w-2/3 h-full bg-gray-100 flex items-center justify-center bg-transparent px-2 md:px-0">
                
                <!--SignIn form-->
                <div id="SignInForm" class="max-w-md w-full rounded-md shadow-md bg-[C7CFBE] text-[1F2933] flex flex-col items-center text-center p-6 sm:p-10 gap-3 border">
                    <h1 class="text-2xl sm:text-3xl mb-7"><b>Welcome Back!</b></h1>
                    <?php
                         flashError('Logmessage');                      
                    ?>
                    <form class="text-start w-full" action="./Process/Authentecation.php" method="POST">
                        <label class="mt-2" for=""><b>Email</b></label> <br>
                        <input class="border rounded-md w-full h-10 my-2 p-3" type="email" name="email">
                        <label class="mt-2" for=""><b>Password</b></label> <br>
                        <input class="border rounded-md w-full h-10 my-2 p-3" type="password" name="password">
                        <input name="signIn" class="w-full mt-2 h-10 bg-gray-200 hover:bg-gray-500 rounded-md font-bold cursor-pointer transition-colors duration-200" type="submit" value="Sign In">
                    </form>
                    <p class="mt-2 text-sm">Doesn't have an account yet? <button id="showSignUp" class="text-gray-700 hover:text-gray-900 font-medium cursor-pointer" >Create Now!</button></p>
                </div>

                <!-- SignUp Form -->
                <div id="SignUpForm"
                    class="hidden max-w-md w-full rounded-md shadow-md bg-[#C7CFBE] text-[#1F2933] 
                            flex flex-col items-center text-center p-6 mt-15 sm:p-10 space-y-6 mx-auto border">

                    <!-- Title -->
                    <h1 class="text-2xl sm:text-3xl font-bold">Glad to Have You!</h1>

                    <!-- Flash messages -->
                    <?php 
                        flashError('LogmessageReg'); 
                        flashSuccess('LogmessageRegSuccess'); 
                    ?>

                    <!-- Form -->
                    <form class="w-full space-y-4 text-left" action="./Process/Register.php" method="POST">

                        <!-- Name -->
                        <div class="flex flex-col">
                            <label for="signupName" class="font-medium mb-1">Name</label>
                            <input id="signupName" name="signupName" type="text"
                                class="border rounded-md w-full h-10 p-3 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                        </div>

                        <!-- Email -->
                        <div class="flex flex-col">
                            <label for="signupEmail" class="font-medium mb-1">Email</label>
                            <input id="signupEmail" name="signupEmail" type="email" required
                                class="border rounded-md w-full h-10 p-3 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                        </div>

                        <!-- Password -->
                        <div class="flex flex-col">
                            <label for="signupPassword" class="font-medium mb-1">Password</label>
                            <input id="signupPassword" name="signupPassword" type="password"
                                class="border rounded-md w-full h-10 p-3 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="flex flex-col">
                            <label for="confirmPassword" class="font-medium mb-1">Confirm Password</label>
                            <input id="confirmPassword" name="confirmPassword" type="password"
                                class="border rounded-md w-full h-10 p-3 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                        </div>

                        <!-- Submit -->
                        <input type="submit" name="signUp" value="Create Account"
                            class="w-full h-10 bg-gray-200 hover:bg-gray-500 rounded-md font-bold cursor-pointer transition-colors duration-200" />
                    </form>

                    <!-- Sign-In Link -->
                    <p class="mt-2 text-sm">
                        Already have an account? 
                        <button id="showSignIn" class="text-gray-700 hover:text-gray-900 font-medium cursor-pointer">Sign-In!</button>
                    </p>
                </div>


            </div>
    </div>

    <?php 
        //Scripts
        include __DIR__ ."/Scripts/indexScript.php";
    ?>

</body>
