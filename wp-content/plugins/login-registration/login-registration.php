<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://https://avologypro.com/
 * @since             1.0.0
 * @package           Login_Registration
 *
 * @wordpress-plugin
 * Plugin Name:       login-registration
 * Plugin URI:        https://http://login-registration.com
 * Description:       This is a description of the plugin.
 * Version:           1.0.0
 * Author:            Abhishek Anand
 * Author URI:        https://https://avologypro.com//
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       login-registration
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('LOGIN_REGISTRATION_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-login-registration-activator.php
 */
function activate_login_registration()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-login-registration-activator.php';
    Login_Registration_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-login-registration-deactivator.php
 */
function deactivate_login_registration()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-login-registration-deactivator.php';
    Login_Registration_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_login_registration');
register_deactivation_hook(__FILE__, 'deactivate_login_registration');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-login-registration.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_login_registration()
{

    $plugin = new Login_Registration();
    $plugin->run();
}
run_login_registration(); ?>


<?php // In your main plugin file or any other appropriate file

function enqueue_custom_plugin_style()
{

    wp_enqueue_style('custom-plugin-style', plugins_url('login-registration-admin.css', __FILE__), array(), '1.0', 'all');
}

add_action('admin_enqueue_scripts', 'enqueue_custom_plugin_style');
?>
<?php
function enqueue_custom_stylesheets()
{
    // Enqueue the custom stylesheet for login and registration forms
    wp_enqueue_style('login-registration-admin-style', plugins_url('login-registration.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_stylesheets');
?>


<?php add_action('admin_menu', 'my_custom_menu_setup');

function my_custom_menu_setup()
{

    // Add a top-level menu item
    add_menu_page(
        NULL, // Page title
        'Login-Registration', // Menu title (empty string)
        'manage_options', // Capability
        'custom-menu-slug', // Menu slug
        'my_custom_menu_page', // Callback function
        'dashicons-admin-generic', // Icon URL
        6 // Position
    );

    // Add sub-menu items under the top-level menu
    // add_submenu_page(
    //     'custom-menu-slug', // Parent slug
    //     'Registration', // Page title
    //     'Registration', // Menu title
    //     'manage_options', // Capability
    //     'registration-submenu-slug', // Menu slug
    //     'my_registration_submenu_page' // Callback function
    // );

    // add_submenu_page(
    //     'custom-menu-slug', // Parent slug
    //     'Login', // Page title
    //     'Login', // Menu title
    //     'manage_options', // Capability
    //     'login-submenu-slug', // Menu slug
    //     'my_login_submenu_page' // Callback function
    // );
}


function my_custom_menu_page()
{
    // Display the header and introduction


    // Check if the form is submitted to update user data
    if (isset($_POST['action']) && $_POST['action'] === 'update') {
        update_user_data($_POST);
    }

    // Display the list of all users
    display_all_users();
}

function display_all_users()
{
    global $wpdb;

    // Pagination
    $per_page = 10; // Number of users per page
    $current_page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
    $offset = ($current_page - 1) * $per_page;

    // Fetch users for the current page
    $users = $wpdb->get_results($wpdb->prepare(
        "SELECT ID, user_login, user_email FROM {$wpdb->users} LIMIT %d, %d",
        $offset,
        $per_page
    ));

    if ($users) {
        echo '<div style="text-align: center;">'; // Add a div with center alignment
        echo '<h2>All Registered Users</h2>';
        echo '<div style="display: inline-block; width: 80%; max-width: 800px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9; margin-top: 30px;">'; // Add a div to center the table with specified styles
        echo '<style>
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }
            table, th, td {
                border: 1px solid #ddd;
            }
            th, td {
                padding: 8px;
                text-align: left;
            }
            th {
                background-color: #f2f2f2;
            }
            </style>';
        echo '<table>';
        echo '<tr><th>ID</th><th>Username</th><th>Email</th><th>First Name</th><th>Last Name</th></tr>';

        // Loop through each user and display their information
        foreach ($users as $user) {
            $first_name = get_user_meta($user->ID, 'first_name', true);
            $last_name = get_user_meta($user->ID, 'last_name', true);
            $mobile_no = get_user_meta($user->ID, 'mobile_no', true); // Assuming 'mobile_no' is the correct meta key

            // Debugging output to check if mobile_no is being fetched correctly
            if (empty($mobile_no)) {
                error_log('Mobile number not found for user ID: ' . $user->ID);
            }

            echo '<tr>';
            echo '<td>' . esc_html($user->ID) . '</td>';
            echo '<td>' . esc_html($user->user_login) . '</td>';
            echo '<td>' . esc_html($user->user_email) . '</td>';
            echo '<td>' . esc_html($first_name) . '</td>';
            echo '<td>' . esc_html($last_name) . '</td>';
            //echo '<td>' . esc_html($mobile_no) . '</td>';
            echo '</tr>';
        }

        echo '</table>';
        echo '</div>'; // Close the div for centering the table

        // Pagination links
        $total_users = $wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->users}");
        $total_pages = ceil($total_users / $per_page);

        if ($total_pages > 1) {
            $pagination_args = array(
                'base' => add_query_arg('paged', '%#%'),
                'format' => '',
                'total' => $total_pages,
                'current' => $current_page,
                'prev_text' => __('&laquo; Previous'),
                'next_text' => __('Next &raquo;'),
            );

            echo '<div class="pagination">';
            echo paginate_links($pagination_args);
            echo '</div>';
        }

        echo '</div>'; // Close the div for center alignment
        echo '</div>'; // Close the div for center alignment
    } else {
        echo '<p>No users found.</p>';
    }
}
function custom_registration_form_shortcode()
{


    ob_start();

    // Check if registration is successful
    $registration_successful = false;
    $errors = array();

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register']) && check_admin_referer('custom_registration_form', 'custom_registration_nonce')) {
        // Sanitize and validate input fields
        $first_name = sanitize_text_field($_POST['first_name']);
        if (!preg_match('/^[a-zA-Z]{3,}(?:[a-zA-Z ]*)$/', $first_name)) {
            $errors[] = 'First name must be at least 4 characters long and may contain spaces.';
        }

        $last_name = sanitize_text_field($_POST['last_name']);
        if (strlen($last_name) < 4 || !ctype_alpha($last_name)) {
            $errors[] = 'Last name must be at least 4 alphabetic characters.';
        }

        $mobile_no = sanitize_text_field($_POST['mobile_no']);
        if (!preg_match('/^\d{10}$/', $mobile_no)) {
            $errors[] = 'Mobile number must be 10 digits.';
        }

        $email = sanitize_email($_POST['email']);
        if (!is_email($email)) {
            $errors[] = 'Invalid email address.';
        }

        $password = sanitize_text_field($_POST['password']);
        if (strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters long.';
        }

        if (empty($errors)) {
            // Check if the user is already logged in
            if (is_user_logged_in()) {
                // Redirect logged-in users to the specific URL
                // wp_redirect('http://localhost/registration-login/index.php/home-page/');
                // exit;
            }

            // Check if the email already exists
            if (email_exists($email)) {
                $errors[] = 'A user with this email address already exists.'; ?>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const form = document.getElementById('registration-forms');
                        form.style.display = 'none';
                    });
                </script>
        <?php
            } else {
                // Create new user
                $user_id = wp_insert_user(array(
                    'user_login' => $email,
                    'user_email' => $email,
                    'user_pass' => $password,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'role' => 'subscriber'
                ));

                if (!is_wp_error($user_id)) {
                    $registration_successful = true;
                } else {
                    $errors[] = $user_id->get_error_message();
                }
            }
        }
    }

    if ($registration_successful) {
        echo '<p class="success-message" style="margin-bottom: 34px; text-align: center; font-size: 26px; color: green;">Registration successful!</p>';
    }

    if (!$registration_successful) {
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo '<p class="error-message">' . esc_html($error) . '</p>';
            }
        }
        ?>
        <div class="registration-form-container" id="registration-forms">
            <div class="registration-form" >
                <h1>Registration Page</h1>
                <form id="registration-form" method="POST">
                    <?php wp_nonce_field('custom_registration_form', 'custom_registration_nonce'); ?>
                    <p><label for="first_name">First Name: </label><input type="text" name="first_name" id="first_name" required><span class="error-message" id="first_name_error"></span></p>
                    <p><label for="last_name">Last Name: </label><input type="text" name="last_name" id="last_name" required><span class="error-message" id="last_name_error"></span></p>
                    <p><label for="mobile_no">Mobile No: </label><input type="text" name="mobile_no" id="mobile_no" required><span class="error-message" id="mobile_no_error"></span></p>
                    <p><label for="email">Email: </label><input type="email" name="email" id="email" required><span class="error-message" id="email_error"></span></p>
                    <p><label for="password">Password: </label><input type="password" name="password" id="password" required><span class="error-message" id="password_error"></span></p>
                    <p><input type="submit" name="register" value="Register"></p>
                </form>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('registration-form');

                function validateInput(input, regex, errorMessage, errorSpanId) {
                    const errorSpan = document.getElementById(errorSpanId);
                    if (!regex.test(input.value)) {
                        errorSpan.textContent = errorMessage;
                        return false;
                    } else {
                        errorSpan.textContent = '';
                        return true;
                    }
                }

                form.first_name.addEventListener('input', function() {
                    validateInput(this, /^[a-zA-Z]{3,}(?:[a-zA-Z ]*)$/, 'First name must be at least 4 characters long and may contain spaces.', 'first_name_error');
                });

                form.last_name.addEventListener('input', function() {
                    validateInput(this, /^[a-zA-Z]{4,}$/, 'Last name must be at least 4 alphabetic characters.', 'last_name_error');
                });

                form.mobile_no.addEventListener('input', function() {
                    validateInput(this, /^\d{10}$/, 'Mobile number must be 10 digits.', 'mobile_no_error');
                });

                form.email.addEventListener('input', function() {
                    validateInput(this, /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/, 'Invalid email address.', 'email_error');
                });

                form.password.addEventListener('input', function() {
                    validateInput(this, /.{6,}/, 'Password must be at least 6 characters long.', 'password_error');
                });

                form.addEventListener('submit', function(event) {
                    const isFirstNameValid = validateInput(form.first_name, /^[a-zA-Z]{3,}(?:[a-zA-Z ]*)$/, 'First name must be at least 4 characters long and may contain spaces.', 'first_name_error');
                    const isLastNameValid = validateInput(form.last_name, /^[a-zA-Z]{4,}$/, 'Last name must be at least 4 alphabetic characters.', 'last_name_error');
                    const isMobileNoValid = validateInput(form.mobile_no, /^\d{10}$/, 'Mobile number must be 10 digits.', 'mobile_no_error');
                    const isEmailValid = validateInput(form.email, /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/, 'Invalid email address.', 'email_error');
                    const isPasswordValid = validateInput(form.password, /.{6,}/, 'Password must be at least 6 characters long.', 'password_error');

                    if (!isFirstNameValid || !isLastNameValid || !isMobileNoValid || !isEmailValid || !isPasswordValid) {
                        event.preventDefault();
                    }
                });
            });
        </script>
    <?php
    }

    return ob_get_clean();
}
add_shortcode('custom_registration_form', 'custom_registration_form_shortcode');


function custom_login_form_shortcode()
{
    ob_start();

    $login_success = false;

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
        $email = sanitize_email($_POST['email']);
        $password = sanitize_text_field($_POST['password']);

        $user = get_user_by('email', $email);

        if ($user && wp_check_password($password, $user->data->user_pass)) {
            $login_success = true;
            wp_set_current_user($user->ID);
            // wp_set_auth_cookie($user->ID); // Uncommented this line
            wp_redirect('http://localhost/registration-login/index.php/home-page/'); // Redirect to home page
            exit;
        } else {
            echo '<p style="color: red; margin-bottom: 20px; text-align: center;">Email or password is incorrect.</p>';
        }
    }

    if ($login_success) : ?>
        <p style="color: green; text-align: center; margin-bottom: 20px; font-size: 26px;">Login successfully!</p>
    <?php endif;
    ?>
    <div class="login-form-wrapper">
        <h2 style="text-align:center;">Login Page</h2>

        <form method="POST">
            <p><label for="email">Email: </label><input type="email" name="email" required></p>
            <p><label for="password">Password: </label><input type="password" name="password" required></p>
            <p><input type="submit" name="login" value="Login" class="login-button"></p>
        </form>
        <p style="text-align: center; margin-top: 20px;">
            Don't have an account? <a href="http://localhost/registration-login/index.php/registration-page/">Register</a>
        </p>
    </div>
<?php

    return ob_get_clean();
}
add_shortcode('custom_login_form', 'custom_login_form_shortcode');


// Create a shortcode for signout
function custom_signout_shortcode()
{
    if (isset($_GET['signout']) && $_GET['signout'] == 'true') {
        // wp_logout(); // Log the user out
        wp_redirect('http://localhost/registration-login/index.php/login-page/'); // Redirect to the login page
        exit; // Ensure the script stops executing after the redirect
    }

    ob_start();
?>
    <div style="text-align: center; margin-top: 20px;">
        <a href="?signout=true">Signout</a>
    </div>
<?php
    return ob_get_clean();
}
add_shortcode('custom_signout', 'custom_signout_shortcode');
