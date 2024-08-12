window.onload = function () {
    // Ensure that bootlint is correctly loaded if used
    if (typeof bootlint !== 'undefined') {
        bootlint.showLintReportForCurrentDocument([], {
            hasProblems: false,
            problemFree: false
        });
    }

    // Initialize Bootstrap tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Date formatting function
    function formatDate(date) {
        return (
            date.getDate() +
            "/" +
            (date.getMonth() + 1) +
            "/" +
            date.getFullYear()
        );
    }

    var currentDate = formatDate(new Date());

    // Initialize datepicker
    $(".due-date-button").datepicker({
        format: "dd/mm/yyyy",
        autoclose: true,
        todayHighlight: true,
        startDate: currentDate,
        orientation: "bottom right"
    });

    // Show datepicker on button click and update label
    $(".due-date-button").on("click", function (event) {
        $(".due-date-button")
            .datepicker("show")
            .on("changeDate", function (dateChangeEvent) {
                $(".due-date-button").datepicker("hide");
                $(".due-date-label").text(formatDate(dateChangeEvent.date));
            });
    });


    // Event listener for Bootstrap modal
    const editTaskModal = document.getElementById('editTaskModal');

    if (editTaskModal) {
        editTaskModal.addEventListener('show.bs.modal', (event) => {
            const button = event.relatedTarget; // Button that triggered the modal
            const taskId = button.getAttribute('data-task-id'); // Extract task ID from data attribute
            const taskDescription = button.getAttribute('data-task-description'); // Extract task description from data attribute
            const isCompleted = button.getAttribute('data-task-completed') === 'true'; // Extract task completed status

            // Update the form action URL and inputs
            const form = editTaskModal.querySelector('#editTaskForm');
            form.action = form.action.replace('task_id_placeholder', taskId); // Replace 'task_id_placeholder' with actual task ID
            form.querySelector('#taskDescriptionInput').value = taskDescription;
            form.querySelector('#taskIdInput').value = taskId;

            // Update the checkbox
            const checkbox = form.querySelector('#flexSwitchCheckDefault');
            checkbox.checked = isCompleted;
        });
    }
};
