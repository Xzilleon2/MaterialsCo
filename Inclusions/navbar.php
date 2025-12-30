<div class="w-full h-sm py-5 px-18 shadow-md bg-blue-200 flex justify-between sticky top-0 z-3">
    <h1 class="text-xl">MaterialsCo</h1>
    <div class="flex">
        <div class="flex gap-2"><img class="w=sm h-6" src="../MaterialsCo/Assets/Icons/userIcon.png" alt="UserIcon"><h1><?php echo $_SESSION['NAME'] ?></h1></div>
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