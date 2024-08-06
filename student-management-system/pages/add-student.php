<style>
    /* Card layout style */
    .card {
        max-width: 500px;
        margin: 40px auto 0;
        padding: 40px 60px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #f9f9f9;
        font-family: Arial, sans-serif;
    }

    .card h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    /* Form input style */
    .form-group {
        margin-bottom: 15px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        color: #333;
        font-weight: bold;
    }

    input[type="text"],
    input[type="email"],
    input[type="tel"],
    select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="tel"]:focus,
    select:focus {
        outline: none;
        border-color: #6cb2eb;
        box-shadow: 0 0 5px rgba(108, 178, 235, 0.5);
    }

    /* Submit button style */
    .btn {
        background-color: #4caf50;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        width: 100%;
        transition: background-color 0.3s;
    }

    .btn:hover {
        background-color: #45a049;
    }
</style>

<div class="card">

    <?php
    if (isset($action) && $action == 'edit') {
        echo "<h2>Update Student {$student['name']}</h2>";
    } elseif (isset($action) && $action == 'view') {
        echo "<h2>Student {$student['name']} Details</h2>";
    } else {
        $nonce = wp_create_nonce("wp_nonce_add_student");
        echo "<h2>Add Student</h2>";
    }
    ?>
    <?php
    if (!empty($FormMsg) && $FormStatus) {
    ?>
        <div class="display-success">
            <?php echo $FormMsg; ?>
        </div>
    <?php
    }
    if (!empty($FormMsg) && !$FormStatus) {
    ?>
        <div class="display-error">
            <?php echo $FormMsg; ?>
        </div>
    <?php
    }
    ?>
    <form action="<?php if (isset($action) && $action == 'edit') {
                        echo $_SERVER['PHP_SELF']; ?>?page=student-system&action=edit&sid= <?php echo $student['id'];
                                                                                        } else {
                                                                                            echo $_SERVER['PHP_SELF']; ?>?page=add-student <?php } ?>" method="post" class="add-student-form">
        <input type="hidden" name="wp_nonce_add_student" value="<?php echo $nonce; ?>">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required <?php if (isset($action) && $action == 'view') {
                                                                    echo "readonly='readonly'";
                                                                } ?> class="form-conrol" value="<?php if (isset($student['name'])) {
                                                                                                    echo $student['name'];
                                                                                                } ?>">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required <?php if (isset($action) && $action == 'view') {
                                                                        echo "readonly='readonly'";
                                                                    } ?> class="form-conrol" value="<?php if (isset($student['email'])) {
                                                                                                        echo $student['email'];
                                                                                                    } ?>">
        </div>
        <div class=" form-group">
            <label for="phone">Phone</label>
            <input type="tel" id="phone" name="phone" required <?php if (isset($action) && $action == 'view') {
                                                                    echo "readonly='readonly'";
                                                                } ?> class="form-conrol" value="<?php if (isset($student['phone'])) {
                                                                                                    echo $student['phone'];
                                                                                                } ?>">
        </div>
        <div class=" form-group">
            <input type="text" name="profile_url" id="profile_url" readonly>
            <button id="btn-upload-profile">Upload Profile Image</button>
        </div>
        <div class=" form-group">
            <label for="gender">Gender</label>
            <select name="gender" id="gender" <?php if (isset($action) && $action == 'view') {
                                                    echo "disabled";
                                                } ?>>
                <option value="">Select Gender</option>
                <option <?php if (isset($student['gender']) && $student['gender'] == 'male') {
                            echo 'selected';
                        } ?> value="male">Male</option>
                <option <?php if (isset($student['gender']) && $student['gender'] == 'female') {
                            echo 'selected';
                        } ?> value="female">Female</option>
                <option <?php if (isset($student['gender']) && $student['gender'] == 'other') {
                            echo 'selected';
                        } ?> value="other">Other</option>
            </select>
        </div>
        <div class="form-group">
            <label for="designation">Designation</label>
            <input type="text" id="designation" name="designation" required <?php if (isset($action) && $action == 'view') {
                                                                                echo "readonly='readonly'";
                                                                            } ?> class="form-conrol" value="<?php if (isset($student['designation'])) {
                                                                                                                echo $student['designation'];
                                                                                                            } ?>">
        </div>
        <?php
        if (isset($action) && $action == 'edit') {
            echo '<button class="btn" type="submit" name="form_submit">Update Student</button>';
            echo '<a class="btn" href="' . $_SERVER['PHP_SELF'] . '?page=student-system">Back to List</a>';
        } elseif (isset($action) && $action == 'view') {
            echo '<a class="btn" href="' . $_SERVER['PHP_SELF'] . '?page=student-system">Back to List</a>';
        } else {
            echo '<button class="btn" type="submit" name="form_submit">Submit</button>';
        }
        ?>

    </form>
</div>