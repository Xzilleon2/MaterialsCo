<div class="w-full h-sm py-5 px-18 shadow-md bg-blue-200 flex justify-between sticky top-0">
    <h1 class="text-xl">MaterialsCo</h1>
    <div class="flex gap-5">
        <div class="flex gap-2"><img class="w=sm h-6" src="../MaterialsCo/Assets/Icons/userIcon.png" alt="UserIcon"><h1><?php echo $_SESSION['NAME'] ?></h1></div>
        <div class="flex flex-col">
            <img id="showNotif" class="w=sm h-6 cursor-pointer" src="../MaterialsCo/Assets/Icons/notificationIcon.png" alt="NotoficationIcon">
            <div id="notifPanel" class="hidden h-50 w-60 p-5 rounded-md shadow-xl absolute top-18 right-2 border border-gray-100 bg-white flex flex-col">
                <div class="w-full h-12 p-2 text-lg font-bold hover:bg-gray-100 cursor-pointer">
                    <h1>Low Stock Products!!</h1>
                </div>
            </div> 
        </div>
    </div>
</div>

<script>

    //Functionality for Panels of Signup and Signin 
    const showNotif = document.getElementById('showNotif');
    const notifPanel = document.getElementById('notifPanel');

    showNotif.addEventListener('click', () => {
        notifPanel.classList.toggle('hidden');
    });


</script>