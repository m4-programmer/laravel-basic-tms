<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <!-- Include jQuery UI CSS for drag-and-drop -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Task Management System</h1>
    <div class="alert alert-success d-none">
        <span id="successMessage"></span>
    </div>
    <div class="alert alert-danger d-none">
    </div>


    <!-- Button to create a new task -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createTaskModal">Create New Task</button>
    <!-- Table to display tasks with drag-and-drop -->
    <table id="taskTable" class="table table-bordered table-striped" >
        <thead>
        <tr>
            <th colspan="20%">Project</th>
            <th style="display: none">Project Id</th>
            <th colspan="20%">Task Name</th>
            <th colspan="20%">Priority</th>
            <th colspan="20%">Timestamp</th>
            <th colspan="20%">Actions</th>
        </tr>
        </thead>
        <tbody>
                @foreach($tasks as $data)
                    <tr>
                        <td>{{$data->project_name}}</td>
                        <td data-project-id="{{$data->project_id}}" style="display: none;"></td>
                        <td>{{$data->name}}</td>
                        <td>
                            @php
                                $badgeClass = '';
                                switch($data->priority) {
                                    case 'High':
                                        $badgeClass = 'bg-danger';
                                        break;
                                    case 'Medium':
                                        $badgeClass = 'bg-warning';
                                        break;
                                    case 'Low':
                                        $badgeClass = 'bg-success';
                                        break;
                                    default:
                                        $badgeClass = 'bg-primary';
                                }
                            @endphp
                            <span class="badge {{$badgeClass}}">{{$data->priority}}</span>
                        </td>
                        <td>{{$data->timestamp}}</td>
                        <td>
                            <button class="btn btn-sm btn-primary edit-task-btn" data-bs-toggle="modal" data-bs-target="#editTaskModal">Edit</button>
                            <button class="btn btn-sm btn-danger delete-btn" data-task-id="{{$data->id}}" data-task-name="{{$data->name}}">Delete</button>
                        </td>
                    </tr>
                @endforeach

        </tbody>
    </table>
</div>

<!-- Create Task Modal -->
<div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createTaskModalLabel">Create Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form  id="createTaskForm" >
                @csrf
                <div class="modal-body">
                        <div class="mb-3">
                            <label for="tastProject" class="form-label">Select Project</label>
                            <select class="form-select" name="project_id" id="tastProject">
                                @foreach($projects as $data)
                                    <option value="{{$data->id}}">{{$data->title}}</option>
                                @endforeach
                            </select>
                            <p class="text-danger project-error"></p>
                        </div>
                        <div class="mb-3">
                            <label for="taskName" class="form-label">Task Name</label>
                            <input type="text" name="name" class="form-control" id="taskName">
                            <p class="text-danger name-error"></p>
                        </div>
                        <div class="mb-3">
                            <label for="taskPriority" class="form-label">Priority</label>
                            <select class="form-select" name="priority" id="taskPriority">
                                <option value="High">High</option>
                                <option value="Medium">Medium</option>
                                <option value="Low">Low</option>
                            </select>
                            <p class="text-danger priority-error"></p>
                        </div>
                        <div class="mb-3">
                            <label for="taskTimestamp" class="form-label">Timestamp</label>
                            <input type="datetime-local" name="timestamp" class="form-control" id="taskTimestamp">
                            <p class="text-danger timestamp-error" ></p>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="createTaskBtn">Create Task</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Task Modal -->
<div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateTaskForm">
                @csrf
                <div class="modal-body">
                        <div class="mb-3">
                            <label for="taskPriority" class="form-label">Select Project</label>
                            <select class="form-select" name="project_id" id="ediTaskProject">
                                @foreach($projects as $data)
                                    <option value="{{$data->id}}">{{$data->title}}</option>
                                @endforeach
                            </select>
                            <p class="text-danger priority-error"></p>
                        </div>
                        <div class="mb-3">
                            <label for="editTaskName" class="form-label">Task Name</label>
                            <input type="text" class="form-control" name="name" id="editTaskName">
                            <p class="text-danger name-error"></p>
                        </div>
                        <div class="mb-3">
                            <label for="editTaskPriority" class="form-label">Priority</label>
                            <select class="form-select" name="priority" id="editTaskPriority">
                                <option value="High">High</option>
                                <option value="Medium">Medium</option>
                                <option value="Low">Low</option>
                            </select>
                            <p class="text-danger priority-error"></p>
                        </div>
                        <div class="mb-3">
                            <label for="editTaskTimestamp" class="form-label">Timestamp</label>
                            <input type="datetime-local" name="timestamp" class="form-control" id="editTaskTimestamp">
                            <p class="text-danger timestamp-error"></p>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateTaskBtn">Update Task</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Include Bootstrap and DataTables JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<!-- Include jQuery UI for drag-and-drop -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    // Initialize DataTable
    $(document).ready(function() {
        $('#taskTable tbody').sortable({
            update: function (event, ui) {
                // Handle task reordering here (you may need to update task priorities)
                console.log(ui)
                console.log(event)
            }
        }).disableSelection();

        $('#taskTable').DataTable();
    });

    $("#createTaskForm").submit(function (e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "/tasks",
            data: $(this).serialize(),
            success: function (response) {
                // Task created successfully
                var successMessage = response.message;
                $("#successMessage").text(successMessage);
                $(".alert-success").removeClass("d-none");

                $("#createTaskModal").modal("hide");

                setTimeout(function () {
                    $(".alert-success").addClass("d-none");
                    // Reload the current page
                    location.reload();
                }, 500);
            },
            error: function (xhr, status, error) {
                // Error occurred
                if (xhr.status === 422) {
                    // Validation errors, display them
                    var errors = JSON.parse(xhr.responseText).errors;
                    $(".name-error").text("");
                    $(".priority-error").text("");
                    $(".timestamp-error").text("");

                    // Display errors in corresponding paragraphs
                    if (errors.name) {
                        $(".name-error").text(errors.name);
                    }
                    if (errors.priority) {
                        $(".priority-error").text(errors.priority);
                    }
                    if (errors.timestamp) {
                        $(".timestamp-error").text(errors.timestamp);
                    }
                } else {
                    // Other types of errors, handle them accordingly
                }
            }
        });
    });

    //update tasks
    $("#updateTaskForm").submit(function (e) {
        e.preventDefault();

        $.ajax({
            type: "PUT",
            url: "/tasks",
            data: $(this).serialize(),
            success: function (response) {
                // Task updated successfully
                var successMessage = response.message;
                $("#successMessage").text(successMessage);
                $(".alert-success").removeClass("d-none");
                $("#createTaskModal").modal("hide");

                setTimeout(function () {
                    $(".alert-success").addClass("d-none");
                }, 3000);
            },
            error: function (xhr, status, error) {
                // Error occurred
                if (xhr.status === 422) {
                    // Validation errors, display them
                    var errors = JSON.parse(xhr.responseText).errors;
                    $(".name-error").text("");
                    $(".priority-error").text("");
                    $(".timestamp-error").text("");

                    // Display errors in corresponding paragraphs
                    if (errors.name) {
                        $(".name-error").text(errors.name);
                    }
                    if (errors.priority) {
                        $(".priority-error").text(errors.priority);
                    }
                    if (errors.timestamp) {
                        $(".timestamp-error").text(errors.timestamp);
                    }
                } else {
                    // Other types of errors, handle them accordingly
                }
            }
        });
    });




    // Edit task when the "Edit" button is clicked
    $(".edit-task-btn").click(function () {
        // Get the task details for editing
        const taskItem = $(this).closest("tr");
        const taskProject = taskItem.find("td:eq(0)").text().trim();
        const taskProjectId = taskItem.find("td:eq(1)").data("project-id");
        const taskName = taskItem.find("td:eq(2)").text().trim();
        const taskPriority = taskItem.find("td:eq(3) span").text().trim();
        const taskTimestamp = taskItem.find("td:eq(4)").text().trim();
        // Populate the "Edit Task" modal form fields
        $("#editTaskName").val(taskName);
        $("#ediTaskProject option").removeAttr("selected"); // Clear previous selections
        $("#ediTaskProject option[value='" + taskProjectId + "']").attr("selected", "selected");
        $("#editTaskPriority option").removeAttr("selected"); // Clear previous selections
        $("#editTaskPriority option[value='" + taskPriority + "']").attr("selected", "selected");
        $("#editTaskTimestamp").val(taskTimestamp);
    });

    // Handle updating the task when the "Update Task" button is clicked
    $("#updateTaskBtn").click(function () {
        // Retrieve and update the task details here
        // Close the edit modal when done
        $("#editTaskModal").modal("hide");
    });

    $(document).ready(function () {
        $(".delete-btn").click(function () {
            var taskId = $(this).data("task-id");
            var taskName = $(this).data("task-name");

            if (confirm("Are you sure you want to delete the task '" + taskName + "'?")) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "DELETE",
                    url: "/tasks/" + taskId,
                    success: function (response) {
                        console.log(response)
                        // Task deleted successfully
                        var successMessage = "Task '" + taskName + "' has been deleted.";
                        displaySuccessMessage(successMessage);
                        // Reload the page after 30 seconds
                        setTimeout(function () {
                            location.reload();
                        }, 500); // 30 seconds
                    },
                    error: function (xhr, status, error) {
                        // Error handling
                        var errors = JSON.parse(xhr.responseText)
                        console.log(errors)
                        console.log(status)
                    }
                });
            }
        });

        function displaySuccessMessage(message) {
            // Display success message
            var successAlert = $(".alert-success");
            successAlert.text(message);
            successAlert.removeClass("d-none");
            // Hide the success message after 5 seconds
            setTimeout(function () {
                successAlert.addClass("d-none");
            }, 500);
        }
    });

</script>
</body>
</html>
