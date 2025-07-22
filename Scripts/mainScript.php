<!--Script import for functionalities-->
<script>

    //Tables Scripts
    document.addEventListener('DOMContentLoaded', function () {
        
        const rTable = document.querySelector("#reservationTable");
        if (rTable) new simpleDatatables.DataTable(rTable);

        const dTable = document.querySelector("#distributionTable");
        if (dTable) new simpleDatatables.DataTable(dTable);

        const iTable = document.querySelector("#inventoryTable");
        if (iTable) new simpleDatatables.DataTable(iTable);

        const sTable = document.querySelector("#stocksTable");
        if (sTable) new simpleDatatables.DataTable(sTable);

        //Modal Functions Scripts
        const showUpdate = document.getElementById('showUpdateModal');
        const updateModal = document.getElementById('updateModal');
        const showDelete = document.getElementById('showDeleteModal');
        const deleteModal = document.getElementById('deleteModal');

        showUpdate.addEventListener('click', ()=> {
            updateModal.showModal();
        } );

        showDelete.addEventListener('click', ()=> {
            deleteModal.showModal();
        } );

    });



</script>