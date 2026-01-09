<?php
    session_start();
?>
<body>
    <!--Important import files-->
    <?php
        include __DIR__ ."/Inclusions/Head.php";
        include __DIR__ ."/Inclusions/Methods.php";
    ?>

    <!--Main Body for Sign in Page, 2 Columns-->
    <div id="BodyDiv" class="w-full min-h-screen bg-gray-100 flex font-sans justify-center items-center bg-cover bg-center bg-no-repeat p-6" style="background-image: url('./Assets/Images/cyber.gif');">

            <!--SignIn and SignUp panel-->
            <div class="w-full md:w-2/3 h-full bg-gray-100 flex items-center justify-center bg-transparent px-2 md:px-0">
                
                <!--SignIn form-->
                <div id="SignInForm" class="max-w-md w-full rounded-md shadow-md bg-[#202231] text-[#922D34] flex flex-col items-center text-center p-6 sm:p-10 gap-3">
                    <h1 class="text-2xl sm:text-3xl mb-7"><b>Welcome Back!</b></h1>
                    <?php
                         flashError('Logmessage');                      
                    ?>
                    <form class="text-start w-full" action="./Process/Authentecation.php" method="POST">
                        <label class="my-2" for=""><b>Email</b></label> <br>
                        <input class="border rounded-md w-full h-10 my-2 p-3" type="email" name="email">
                        <label class="my-2" for=""><b>Password</b></label> <br>
                        <input class="border rounded-md w-full h-10 my-2 p-3" type="password" name="password">
                        <input name="signIn" class="rounded-md w-full h-10 my-2 bg-blue-600 text-white hover:bg-blue-700 cursor-pointer" type="submit" value="Sign In">
                    </form>
                    <p class="my-2">Doesn't have an account yet? <button id="showSignUp" class="text-white hover:cursor-pointer" >Create Now!</button></p>
                </div>

                <!--SignUp form-->
                <div id="SignUpForm" class="hidden max-w-md w-full rounded-md shadow-md bg-[#202231] text-[#922D34] flex flex-col items-center text-center p-6 sm:p-10">
                    <h1 class="text-2xl sm:text-3xl mb-7"><b>Glad to Have you!</b></h1>
                    <?php 
                        flashError('LogmessageReg'); 
                        flashSuccess('LogmessageRegSuccess'); 
                    ?>
                    <form class="text-start w-full" action="./Process/Register.php" method="POST">
                        <label class="my-2" for=""><b>NAME</b></label> <br>
                        <input class="border rounded-md w-full h-10 my-2 p-3" type="text" name="signupName">
                        <label class="my-2" for=""><b>Email</b></label> <br>
                        <input class="border rounded-md w-full h-10 my-2 p-3" type="email" name="signupEmail" required>
                        <label class="my-2" for=""><b>Password</b></label> <br>
                        <input class="border rounded-md w-full h-10 my-2 p-3" type="password" name="signupPassword">
                        <label class="my-2" for=""><b>Confirm Password</b></label> <br>
                        <input class="border rounded-md w-full h-10 my-2 p-3" type="password" name="confirmPassword">
                        <input name="signUp" class="rounded-md w-full h-10 my-2 bg-blue-600 text-white hover:bg-blue-700 cursor-pointer" type="submit" value="Create Account">
                    </form>
                        <p class="my-2">Already got an account? <button id="showSignIn" class="text-white hover:cursor-pointer">Sign-In!</button></p>
                </div>

            </div>
    </div>

    <?php 
        //Scripts
        include __DIR__ ."/Scripts/indexScript.php";
    ?>

</body>
