<style>
    /* Card layout style */
    .card {
        max-width: 1000px;
        margin: 40px auto 0;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #f9f9f9;
        font-family: Arial, sans-serif;
    }

    .card h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    /* Table style */
    .table-container {
        overflow-x: auto;
        width: 100%;
        /* Adjust as needed */
        padding: 10px;
    }

    .student-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 16px;
    }

    .student-table th,
    .student-table td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .student-table th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    /* Button style */
    .btn-edit,
    .btn-delete,
    .btn-view {
        display: inline-block;
        padding: 8px 16px;
        margin: 4px;
        text-decoration: none;
        border-radius: 5px;
        color: #fff;
        cursor: pointer;
        transition: background-color 0.3s;
        border: none;
        font-weight: bold;
        text-transform: uppercase;
        outline: none;
    }

    .btn-edit {
        background-color: #28a745;
    }

    .btn-delete {
        background-color: #dc3545;
    }

    .btn-view {
        background-color: #007bff;
    }

    .btn-edit:hover,
    .btn-delete:hover,
    .btn-view:hover {
        opacity: 0.8;
    }
</style>
<div class="card">
    <h2>List students</h2>
    <?php
    if (!empty($FormMsg)) {
    ?>
        <div class="display-success">
            <?php echo $FormMsg; ?>
        </div>
    <?php
    }
    ?>
    <div class="table-container">
        <div class="employee-table">
            <table class="" id="list_student">
                <thead>
                    <th>#ID</th>
                    <th>#Name</th>
                    <th>#Email</th>
                    <th>#Phone</th>
                    <th>#Gender</th>
                    <th>#Designation</th>
                    <th>#Actions</th>
                </thead>
                <tbody>
                    <?php
                    if ($list_data > 0) {
                        foreach ($list_data as $student) {
                    ?>
                            <tr>
                                <td><?php echo $student['id']; ?></td>
                                <td><?php echo $student['name']; ?></td>
                                <td><?php echo $student['email']; ?></td>
                                <td><?php echo $student['phone']; ?></td>
                                <td><?php echo $student['gender']; ?></td>
                                <td><?php echo $student['designation']; ?></td>
                                <td><a href="admin.php?page=student-system&action=edit&sid=<?php echo $student['id']; ?>" class="btn-edit">Edit</a>
                                    <a href="admin.php?page=student-system&action=view&sid=<?php echo $student['id']; ?>" class="btn-view">View</a>
                                    <a href="admin.php?page=student-system&action=delete&sid=<?php echo $student['id']; ?>" class="btn-delete" onclick="return confirm('are you sure want to delete?');">Delete</a>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>