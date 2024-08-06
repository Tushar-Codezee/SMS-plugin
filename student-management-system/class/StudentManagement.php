<?php

class StudentManagement
{
    private $message;
    private $status;
    private $action;
    // Constructor
    public function __construct()
    {
        add_action("admin_menu", array($this, "addAdminMenu"));

        add_action("admin_enqueue_scripts", array($this, "AddAdminScripts"));
    }

    // Add Student plugin menus and sub menus
    public function addAdminMenu()
    {
        // Add menu Main
        add_menu_page("Student System", "Student System", "manage_options", "student-system", "", "dashicons-admin-home");

        // Add sub menu
        add_submenu_page("student-system", "List Studentes", "List Studentes", "manage_options", "student-system", array($this, "ListStudentsCallback"));
        add_submenu_page("student-system", "Add Studentes", "Add Studentes", "manage_options", "add-student", array($this, "AddStudentsCallback"));
    }

    // Student lists
    public function ListStudentsCallback()
    {
        global $wpdb;
        $prefix = $wpdb->prefix;
        if (isset($_GET['action']) && $_GET['action'] == 'edit') {
            $student_id = $_GET['sid'];
            $this->action = $_GET['action'];

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['form_submit'])) {
                global $wpdb;
                $name = sanitize_text_field($_POST['name']);
                $email = sanitize_text_field($_POST['email']);
                $phone = sanitize_text_field($_POST['phone']);
                $gender = sanitize_text_field($_POST['gender']);
                $designation = sanitize_text_field($_POST['designation']);

                $prefix = $wpdb->prefix;
                $wpdb->update("{$prefix}sms_table", array(
                    "name" => $name,
                    "email" => $email,
                    "phone" => $phone,
                    "gender" => $gender,
                    "designation" => $designation,
                ), array(
                    "id" => $student_id
                ));
                $this->message = "Record Updated Successfully";
            }

            $student = $this->SingleStudentData($student_id);
            $action = $this->action;
            $FormMsg = $this->message;
            include_once(SMS_PLUGIN_PATH . 'pages/add-student.php');
        } elseif (isset($_GET['action']) && $_GET['action'] == 'view') {
            $this->action = $_GET['action'];
            $student_id = $_GET['sid'];
            $action = $this->action;
            $student = $this->SingleStudentData($student_id);
            include_once(SMS_PLUGIN_PATH . 'pages/add-student.php');
        } else {
            if (isset($_GET['action']) && $_GET['action'] == 'delete') {
                if (isset($_GET['sid']) && is_numeric($_GET['sid'])) {
                    $id = intval($_GET['sid']);

                    $result = $wpdb->delete("{$prefix}sms_table", array("id" => $id));

                    if ($result !== false && $result > 0) {
                        $this->message = "Record Deleted Successfully";
                    } else {
                        $this->message = "Failed to Delete Record";
                    }
                } else {
                    $this->message = "No valid record ID provided";
                }
            }


            $FormMsg = $this->message;
            $list_data = $wpdb->get_results("SELECT * FROM {$prefix}sms_table", ARRAY_A);
            include_once(SMS_PLUGIN_PATH . 'pages/list-student.php');
        }
    }

    // Add Student
    public function AddStudentsCallback()
    {
        // Form Submission
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['form_submit'])) {
            if (isset($_POST['wp_nonce_add_student']) && wp_verify_nonce($_POST['wp_nonce_add_student'], "wp_nonce_add_student")) {
                $this->SaveFormData();
            } else {
                $this->message = "Verification failed";
                $this->status = 0;
            }
        }
        $FormMsg = $this->message;
        $FormStatus = $this->status;

        // Include add student file
        include_once(SMS_PLUGIN_PATH . 'pages/add-student.php');
    }

    // Get Single Student Record
    public function SingleStudentData($student_id)
    {
        global $wpdb;
        $prefix = $wpdb->prefix;
        $student = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM {$prefix}sms_table WHERE id = %d", $student_id),
            ARRAY_A
        );
        return $student;
    }

    private function SaveFormData()
    {
        global $wpdb;
        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_text_field($_POST['email']);
        $phone = sanitize_text_field($_POST['phone']);
        $gender = sanitize_text_field($_POST['gender']);
        $designation = sanitize_text_field($_POST['designation']);

        $prefix = $wpdb->prefix;
        $wpdb->insert("{$prefix}sms_table", array(
            "name" => $name,
            "email" => $email,
            "phone" => $phone,
            "gender" => $gender,
            "designation" => $designation,
        ));

        $student_id = $wpdb->insert_id;

        if ($student_id > 0) {
            $this->message = "Student Saved successfully";
            $this->status = 1;
        } else {
            $this->message = "Failed to save";
            $this->status = 0;
        }
    }

    public function CreateStudentTable()
    {
        global $wpdb;
        $prefix = $wpdb->prefix;
        $sql = "
             	CREATE TABLE `{$prefix}sms_table` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `name` varchar(50) NOT NULL,
                    `email` varchar(50) NOT NULL,
                    `phone` varchar(25) DEFAULT NULL,
                    `gender` enum('male','female','other') DEFAULT NULL,
                    `designation` varchar(80) DEFAULT NULL,
                    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                    PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci
        ";

        include_once(ABSPATH . "./wp-admin/includes/upgrade.php");
        dbDelta($sql);
    }

    public function DropStudentTable()
    {
        global $wpdb;
        $prefix = $wpdb->prefix;
        $sql = "DROP TABLE IF EXISTS {$prefix}sms_table";
        $wpdb->query($sql);
    }

    public function AddAdminScripts()
    {
        wp_enqueue_style("sms-datatable-css", SMS_PLUGIN_URL . '/assets/css/dataTables.dataTables.min.css', array(), "1.0", "all");
        wp_enqueue_style("sms-custom-css", SMS_PLUGIN_URL . '/assets/css/custom.css', array(), "1.0", "all");

        wp_enqueue_script("sms-datatable-js", SMS_PLUGIN_URL . '/assets/js/dataTables.min.js', array('jquery'), "1.0");
        wp_enqueue_script("sms-custom-js", SMS_PLUGIN_URL . '/assets/js/custom.js', array('jquery'), "1.0");
    }
}
