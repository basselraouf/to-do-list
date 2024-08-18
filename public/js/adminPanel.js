document.addEventListener('DOMContentLoaded', function() {
    const editUserModal = document.getElementById('editUserModal');

    if (editUserModal) {
        editUserModal.addEventListener('show.bs.modal', (event) => {
            const button = event.relatedTarget; // Button that triggered the modal
            const userId = button.getAttribute('data-id'); // Extract user ID from data attribute
            const userName = button.getAttribute('data-name'); // Extract user name from data attribute
            const userEmail = button.getAttribute('data-email'); // Extract user email from data attribute
            const userRole = button.getAttribute('data-role'); // Extract user role from data attribute

            // Update the form action URL with the actual user ID
            const form = editUserModal.querySelector('#editUserForm');
            const originalAction = form.getAttribute('action');
            const updatedAction = originalAction.replace('userIdPlaceholder', userId);
            form.setAttribute('action', updatedAction);

            // Populate the form fields
            form.querySelector('#userId').value = userId;
            form.querySelector('#userName').value = userName;
            form.querySelector('#userEmail').value = userEmail;

            // Set the role dropdown
            const roleSelect = form.querySelector('#userRole');
            roleSelect.value = userRole;

            // Debug: Log values to console to verify they are correct
            console.log('Updated Form Action:', updatedAction);
            console.log('User ID:', userId);
            console.log('User Name:', userName);
            console.log('User Email:', userEmail);
            console.log('User Role:', userRole);
        });
    }
});

// function confirmDelete(userId) {
//     var form = document.getElementById('deleteUserForm');
//     form.action = `/users/${userId}`; // Set the action URL to the correct route
//     var myModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
//     myModal.show();
// }

$(document).ready(function() {
    $('.deleteUserBtn').click(function () {
        var userId = $(this).data('id');
        var deleteUserUrl = "{{ route('users.destroy', ':id') }}".replace(':id', userId);
        $('#deleteUserForm').attr('action', deleteUserUrl);
        $('#deleteModal').modal('show');
    });
});

