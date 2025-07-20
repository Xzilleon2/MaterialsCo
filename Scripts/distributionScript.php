<!--Script import for functionalities-->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const dTable = document.querySelector("#distributionTable");
    new simpleDatatables.DataTable(dTable);
});

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
</script>