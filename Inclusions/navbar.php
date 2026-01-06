<div class="w-full h-sm py-3 px-5 shadow-md bg-[202231] text-[922D34] flex justify-end sticky top-0 z-3">
    <div class="flex">
        <div class="flex justify-center items-center gap-2"><i class="fa fa-user"></i><h1><?php echo $_SESSION['NAME'] ?></h1></div>
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