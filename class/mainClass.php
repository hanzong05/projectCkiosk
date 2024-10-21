<?php

$account_type = isset($_SESSION['atype']) ? $_SESSION['atype'] : '2';
if ($account_type != '1' && $account_type != '2' && $account_type != '3') {
    // Destroy the session
    session_destroy();
    // Redirect to the login page
    header("Location: login.php");
    exit;

    
}

class mainClass
{
    private $connection;

    function __construct()
    {
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "";
        $dbname = "ckiosk";

        try {
            $this->connection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Connected successfully";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    
    public function admin_login($data)
    {
        $username = trim($data["username"]);
        $password = trim($data['password']);
        $log_msg = array();
    
        // Check for empty username and password
        if (empty($username)) {
            $log_msg['uname'] = "Username is empty";
        }
    
        if (empty($password)) {
            $log_msg['pwd'] = "Password is empty";
        }
    
        if (count($log_msg) <= 0) {
            $sql = "SELECT users_id, users_username, users_password, users_type FROM users_tbl WHERE users_username = :username";
            if ($stmt = $this->connection->prepare($sql)) {
                $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
                $param_username = $username;
                if ($stmt->execute()) {
                    if ($stmt->rowCount() == 1) {
                        if ($row = $stmt->fetch()) {
                            $stored_hash = $row["users_password"];
    
                            // Hash the input password with SHA-256
                            $input_hash = hash('sha256', $password);
    
                            if ($input_hash === $stored_hash) {
                                // Check user type
                                if ($row['users_type'] == 2) {
                                    // User type 2 - do not log in
                                    $log_msg['msg'] = "You are not an Admin.";
                                } else {
                                    // Successful login
                                    session_start();
                                    $_SESSION['aid'] = $row['users_id'];
                                    $_SESSION['auname'] = $row['users_username'];
                                    $_SESSION['atype'] = $row['users_type'];
                                    // Redirect to dashboard or appropriate page
                                    header('Location: dashboard.php');
                                    exit();
                                }
                            } else {
                                $log_msg['msg'] = "Invalid username or password.";
                            }
                        }
                    } else {
                        $log_msg['msg'] = "Invalid username or password.";
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
                unset($stmt);
            }
        }
    
        return $log_msg;
    }
    public function org_login($data)
{
    $username = trim($data["username"]);
    $password = trim($data['password']);
    $log_msg = array();

    // Check for empty username and password
    if (empty($username)) {
        $log_msg['uname'] = "Username is empty";
    }

    if (empty($password)) {
        $log_msg['pwd'] = "Password is empty";
    }

    if (count($log_msg) <= 0) {
        // Check in users_tbl first
        $sql = "SELECT users_id, users_username, users_password, users_type FROM users_tbl WHERE users_username = :username";
        if ($stmt = $this->connection->prepare($sql)) {
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $param_username = $username;

            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $stored_hash = $row["users_password"];

                        // Hash the input password with SHA-256
                        $input_hash = hash('sha256', $password);

                        if ($input_hash === $stored_hash) {
                            // Check user type
                            if ($row['users_type'] == 1) {
                                // User type 1 - do not log in as an organization
                                $log_msg['msg'] = "You are not an Organization.";
                            } else {
                                // Successful login for users_tbl
                                session_start();
                                $_SESSION['aid'] = $row['users_id'];
                                $_SESSION['auname'] = $row['users_username'];
                                $_SESSION['atype'] = $row['users_type'];
                                // Redirect to dashboard or appropriate page
                                header('Location: dashboard.php');
                                exit();
                            }
                        } else {
                            $log_msg['msg'] = "Invalid username or password.";
                        }
                    }
                }else {
                    // If user not found in users_tbl, check in orgmembers_tbl
                    $sql = "SELECT* FROM orgmembers_tbl WHERE username = :username";
                    
                    if ($stmt = $this->connection->prepare($sql)) {
                        $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
                        $param_username = $username;
                
                        if ($stmt->execute()) {
                            if ($stmt->rowCount() == 1) {
                                if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $stored_hash = $row["password"];
                                    
                                    // Hash the input password with SHA-256
                                    $input_hash = hash('sha256', $password);
                
                                    if ($input_hash === $stored_hash) {
                                        // Successful login for orgmembers_tbl
                                        session_start();
                                        $_SESSION['aid'] = $row['id']; // Set session ID from orgmembers_tbl
                                        $_SESSION['id'] = $row['id'];
                                        $_SESSION['auname'] = $row['username'];
                                        $_SESSION['atype'] = $row['users_type'];
                
                                        // Get the users_id from users_tbl based on org_type
                                        $org_type = $row['org_type']; // Get the organization type from the logged-in user
                                        $userSql = "SELECT users_id FROM users_tbl WHERE users_org = :org_type";
                                        $userStmt = $this->connection->prepare($userSql);
                                        $userStmt->bindParam(':org_type', $org_type, PDO::PARAM_INT);
                
                                        if ($userStmt->execute()) {
                                            if ($userRow = $userStmt->fetch(PDO::FETCH_ASSOC)) {
                                                $_SESSION['aid'] = $userRow['users_id']; // Update session ID to the corresponding users_id
                                            } else {
                                                // Handle case where no matching users_id is found
                                                $log_msg['msg'] = "No matching user ID found for the organization.";
                                            }
                                        } else {
                                            $log_msg['msg'] = "Error fetching users ID from users_tbl.";
                                        }
                
                                        // Redirect to dashboard or appropriate page
                                        header('Location: dashboard.php');
                                        exit();
                                    } else {
                                        $log_msg['msg'] = "Invalid username or password.";
                                    }
                                }
                            } else {
                                $log_msg['msg'] = "Invalid username or password.";
                            }
                        } else {
                            $log_msg['msg'] = "Error executing the query.";
                        }
                    } else {
                        $log_msg['msg'] = "Error preparing the SQL statement.";
                    }
                
                    return $log_msg; // Return log messages for feedback or debugging
                }
            }
        }
    }
}
    function add_announcement($data) {
        $uid = htmlspecialchars($data['uid'] ?? '', ENT_QUOTES, 'UTF-8');
        $details = htmlspecialchars($data['announcement_details'] ?? '', ENT_QUOTES, 'UTF-8');
    
        return '
            <script>
                Swal.fire({
                    title: "Are you sure?",
                    text: "Do you want to save this announcement?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, save it!",
                    cancelButtonText: "No, cancel!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = new FormData();
                        formData.append("type", "announcement");
                        formData.append("uid", "' . $uid . '");
                        formData.append("announcement_details", "' . $details . '");
                        var annImg = document.querySelector("input[name=ann_img]").files[0];
                        if (annImg) {
                            formData.append("ann_img", annImg);
                        }
    
                        fetch("../admin/ajax/createData.php", {
                            method: "POST",
                            body: formData
                        }).then(response => response.json())
                          .then(result => {
                              Swal.fire("Response", result.message, "info");
                              if (result.success) {
                                Swal.fire(
                                    "Saved!",
                                    "The announcement has been saved.",
                                    "success"
                                ).then(() => {
                                    document.location = "announcement.php";
                                });
                              } else {
                                  Swal.fire("Error!", result.message, "error");
                              }
                          }).catch(error => {
                            Swal.fire(
                                "Error!",
                                "There was an error saving the announcement.",
                                "error"
                            );
                          });
                    }
                });
            </script>';
    }

    public function member_account() {
        // Ensure the session ID is available
        $user_id = $_SESSION['id'] ?? null; // Get user ID from session
    
        if ($user_id === null) {
            throw new Exception("Session variable 'id' is not set.");
        }
    
        // Prepare the SQL statement
        $sql = "SELECT * FROM orgmembers_tbl WHERE id = :user_id";
    
        try {
            $stmt = $this->connection->prepare($sql); // Prepare the statement
            // Bind the session ID to the parameter
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            
            // Execute the statement
            $stmt->execute();
            
            // Fetch the result
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Check if a record was found and return it
            if ($result) {
                return $result;
            } else {
                return null; // No record found
            }
        } catch (PDOException $e) {
            // Handle database error
            throw new Exception("Database error: " . $e->getMessage());
        } catch (Exception $e) {
            // Handle general error
            throw new Exception("An error occurred: " . $e->getMessage());
        }
    }
    
    

    function save_announcement($data) {
        $aid = $data['aid'] ?? '';
        $details = $data['announcement_details'] ?? '';
        $previousImage = $data['previous_image'] ?? '';
    
        return '
            <script>
                function updateAnnouncement() {
                    Swal.fire({
                        title: "Are you sure?",
                        text: "Do you want to update this announcement?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, update it!",
                        cancelButtonText: "No, cancel!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var formData = new FormData();
                            formData.append("type", "announcement");
                            formData.append("aid", "' . addslashes($aid) . '");
                            formData.append("announcement_details", "' . addslashes($details) . '");
                            var annImg = document.querySelector("input[name=ann_img]").files[0];
                            if (annImg) {
                                formData.append("ann_img", annImg);
                            } else {
                                formData.append("previous_image", "' . addslashes($previousImage) . '");
                            }
    
                            fetch("../admin/ajax/editData.php", {
                                method: "POST",
                                body: formData
                            }).then(response => response.json())
                              .then(result => {
                                  if (result.success) {
                                      Swal.fire({
                                          title: "Success",
                                          text: result.message,
                                          icon: "success"
                                      }).then(() => {
                                          document.location = "announcement.php";
                                      });
                                  } else {
                                      Swal.fire("Error!", result.message, "error");
                                  }
                              }).catch(error => {
                                  Swal.fire("Error!", "There was an error processing your request.", "error");
                              });
                        }
                    });
                }
                // Automatically call the function if needed
                updateAnnouncement();
            </script>';
    }
    
    
    public function handleRequest() {
        // Check for the archive request
        if (isset($_GET['archive_id'])) {
            $appID = $_GET['archive_id'];
            // Call the archive function and capture the result
            $result = $this->archive_announcement($appID);
            echo $result; // Output the result
            exit(); // Stop further execution
        }
    }


    function archive_announcement($appID) {
        $query = "UPDATE announcement_tbl SET is_archived = 1 WHERE announcement_id = :appID";
        $statement = $this->connection->prepare($query);
        
        // Debugging: Check if the appID is received
        if (!$appID) {
            return '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: "No announcement ID provided."
                    });
                    </script>';
        }
        
        // Execute the query and check if it was successful
        if ($statement->execute(array("appID" => $appID))) {
            return '<script>
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: "success",
                        title: "Announcement archived successfully"
                    }).then((result) => {
                        document.location = "announcement.php"; // Redirect to the announcement page
                    });
                    </script>';
        } else {
            return '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: "Failed to archive the announcement."
                    });
                    </script>';
        }
    }
    
    function delete_announcement($appID)
    {
        $query = "DELETE FROM announcement_tbl WHERE announcement_id = :appID";
        $statement = $this->connection->prepare($query);
        $statement->execute(array("appID" => $appID));
        if ($statement->execute()) {
            return '<script>
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: "success",
                        title: "Announcement Deleted successfully"
                    }).then((result) => {
                        if (result.isConfirmed) {
                          document.location = "announcement.php";
                        } else {
                          document.location = "announcement.php";
                        }
                      });
                </script>';
        } else {
            return "Error Deleting";
        }
    }
    public function get_announcements_by_org($orgId)
    {
        try {
            // Fetch user IDs from users_tbl where users_org matches org_id
            $query = "SELECT users_id FROM users_tbl WHERE users_org = :orgId";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':orgId', $orgId, PDO::PARAM_INT);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            if (!$users) {
                return []; // No users found for this org_id
            }
        
            $userIds = array_column($users, 'users_id'); // Get an array of user IDs
        
            // Create placeholders for the user IDs
            $placeholders = implode(',', array_fill(0, count($userIds), '?'));
    
            // Fetch announcements from announcement_tbl where announcement_creator is in the list of user IDs and is_archived is 0
            $query = "SELECT announcement_id, announcement_details, announcement_creator, announcement_image, created_at
                      FROM announcement_tbl
                      WHERE announcement_creator IN ($placeholders) AND is_archived = 0";
            $stmt = $this->connection->prepare($query);
            
            // Bind the user IDs to the query
            foreach ($userIds as $index => $userId) {
                $stmt->bindValue($index + 1, $userId, PDO::PARAM_INT);
            }
        
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            return $results;
    
        } catch (Exception $e) {
            error_log('Error fetching announcements: ' . $e->getMessage());
            return ['error' => 'An error occurred while fetching announcements.'];
        }
    }
    
    function show_announcement()
{
    // Fetch the user's organization ID based on session variable
    $userId = isset($_SESSION['aid']) ? intval($_SESSION['aid']) : 0;

    // Query to get the user's organization from users_tbl
    $orgQuery = "SELECT users_org FROM users_tbl WHERE users_id = :userId";
    $orgStatement = $this->connection->prepare($orgQuery);
    $orgStatement->bindValue(':userId', $userId, PDO::PARAM_INT);
    $orgStatement->execute();
    $orgRow = $orgStatement->fetch(PDO::FETCH_ASSOC);

    // Safely escape the organization ID
    $userOrgId = $orgRow ? intval($orgRow['users_org']) : 0;

    // If the user has no organization, return an empty result or error message
    if ($userOrgId == 0) {
        return "No organization found for the user.";
    }

    // Main announcement query, filtered by the user's organization and only fetching non-archived announcements
    $query = "
        SELECT a.*, 
               u.users_username AS author_name, 
               om.name AS updated_by_name, 
               c.users_username AS creator_name, 
               o.org_name, 
               o.org_image
        FROM announcement_tbl a 
        LEFT JOIN users_tbl u ON a.announcement_creator = u.users_id 
        LEFT JOIN orgmembers_tbl om ON a.updated_by = om.id 
        LEFT JOIN users_tbl c ON a.created_by = c.users_id  -- Join to get the creator's name
        LEFT JOIN organization_tbl o ON u.users_org = o.org_id
        WHERE u.users_org = :userOrgId AND a.is_archived = 0
    ";

    $statement = $this->connection->prepare($query);
    $statement->bindValue(':userOrgId', $userOrgId, PDO::PARAM_INT);

    if ($statement->execute()) {
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Check for creator names and fallback to orgmembers_tbl if necessary
        foreach ($result as &$row) {
            // Handle org_image, fallback to a placeholder if not available
            $row['org_image'] = isset($row['org_image']) && !empty($row['org_image'])
                                ? htmlspecialchars($row['org_image'], ENT_QUOTES, 'UTF-8')
                                : 'placeholder.jpg'; // Default placeholder if no image is found

            // If creator name is not found in users_tbl, try to find it in orgmembers_tbl
            if (empty($row['creator_name'])) {
                $creatorId = $row['created_by']; // Get the creator ID
                // Fetch the creator's name from orgmembers_tbl
                $fallbackQuery = "SELECT name FROM orgmembers_tbl WHERE id = :creatorId";
                $fallbackStatement = $this->connection->prepare($fallbackQuery);
                $fallbackStatement->bindValue(':creatorId', $creatorId, PDO::PARAM_INT);
                $fallbackStatement->execute();
                $fallbackRow = $fallbackStatement->fetch(PDO::FETCH_ASSOC);
                
                // If a name is found in orgmembers_tbl, use it
                if ($fallbackRow) {
                    $row['creator_name'] = htmlspecialchars($fallbackRow['name'], ENT_QUOTES, 'UTF-8');
                } else {
                    $row['creator_name'] = 'Unknown'; // Fallback if no name is found
                }
            } else {
                // Sanitize creator name from users_tbl
                $row['creator_name'] = htmlspecialchars($row['creator_name'], ENT_QUOTES, 'UTF-8');
            }
        }
        return $result;
    } else {
        return "No Data";
    }
}

function show_announcement2()
{
    // Fetch the user's name based on session variable
    $userId = isset($_SESSION['aid']) ? intval($_SESSION['aid']) : 0;

    // Query to get the user's name from orgmembers_tbl
    $userQuery = "SELECT name FROM orgmembers_tbl WHERE id = :userId";
    $userStatement = $this->connection->prepare($userQuery);
    $userStatement->bindValue(':userId', $userId, PDO::PARAM_INT);
    $userStatement->execute();
    $userRow = $userStatement->fetch(PDO::FETCH_ASSOC);

    // If the name is not found in orgmembers_tbl, fallback to users_tbl
    if (!$userRow) {
        $userQuery = "SELECT users_username AS name FROM users_tbl WHERE users_id = :userId";
        $userStatement = $this->connection->prepare($userQuery);
        $userStatement->bindValue(':userId', $userId, PDO::PARAM_INT);
        $userStatement->execute();
        $userRow = $userStatement->fetch(PDO::FETCH_ASSOC);
    }

    // Safely escape the user's name
    $userName = $userRow ? htmlspecialchars($userRow['name'], ENT_QUOTES, 'UTF-8') : 'N/A';

    // Main announcement query, including org_image from organization_tbl, filtering where is_archived = 0
    $query = "
        SELECT a.*, 
               u.users_username AS author_name, 
               om.name AS updated_by_name, 
               o.org_name, 
               o.org_image  -- Added org_image from organization_tbl
        FROM announcement_tbl a 
        LEFT JOIN users_tbl u ON a.announcement_creator = u.users_id 
        LEFT JOIN orgmembers_tbl om ON a.updated_by = om.id 
        LEFT JOIN organization_tbl o ON u.users_org = o.org_id
        WHERE a.is_archived = 0  -- Only fetch non-archived announcements
    ";

    $statement = $this->connection->prepare($query);

    if ($statement->execute()) {
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Add the fetched user name and organization image to each row
        foreach ($result as &$row) {
            $row['user_name'] = $userName; // Attach the user's name

            // Handle org_image, fallback to a placeholder if not available
            $row['org_image'] = isset($row['org_image']) && !empty($row['org_image'])
                                ? htmlspecialchars($row['org_image'], ENT_QUOTES, 'UTF-8')
                                : 'placeholder.jpg'; // Default placeholder if no image is found
        }
        return $result;
    } else {
        return "No Data";
    }
}


    function add_calendar_event($data)
    {
        $details = $data['event_details'];
        $date = $data['event_date'];
    
        // Return JavaScript for confirmation dialog and AJAX request
        return '
            <script>
                Swal.fire({
                    title: "Are you sure?",
                    text: "Do you want to save this event?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, save it!",
                    cancelButtonText: "No, cancel!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = new FormData();
                        formData.append("event_details", "' . $details . '");
                        formData.append("event_date", "' . $date . '");
    
                        fetch("../admin/ajax/createData.php", {
                            method: "POST",
                            body: formData
                        }).then(response => response.text())
                          .then(result => {
                              Swal.fire("Response", result, "info");
                              if (result.trim() === "Success") {
                                Swal.fire(
                                    "Saved!",
                                    "The event has been saved.",
                                    "success"
                                ).then(() => {
                                    document.location = "schoolcalendar.php";
                                });
                              } else {
                                  Swal.fire("Error!", result, "error");
                              }
                          }).catch(error => {
                            Swal.fire(
                                "Error!",
                                "There was an error saving the event.",
                                "error"
                            );
                          });
                    }
                });
            </script>';
    }
    function save_event($data)
{
    $cid = htmlspecialchars($data['cid'], ENT_QUOTES, 'UTF-8');
    $details = htmlspecialchars($data['event_details'], ENT_QUOTES, 'UTF-8');
    $date = htmlspecialchars($data['event_date'], ENT_QUOTES, 'UTF-8');

    // Generate the confirmation dialog script
    $script = '<script>
                Swal.fire({
                    title: "Are you sure?",
                    text: "Do you want to update this event?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, update it!",
                    cancelButtonText: "No, cancel!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Proceed with the AJAX request
                        var xhr = new XMLHttpRequest();
                        var formData = new FormData();
                        formData.append("type", "event"); // or "event"
                        formData.append("cid", "' . $cid . '");
                        formData.append("event_details", "' . $details . '");
                        formData.append("event_date", "' . $date . '");

                        xhr.open("POST", "ajax/editData.php", true);
                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                var response = JSON.parse(xhr.responseText);
                                if (response.success) {
                                    Swal.fire({
                                        icon: "success",
                                        title: "Event Updated",
                                        text: response.message,
                                        timer: 2000,
                                        timerProgressBar: true
                                    }).then(() => {
                                        window.location = "schoolcalendar.php";
                                    });
                                } else {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Update Failed",
                                        text: response.message,
                                        timer: 3000,
                                        timerProgressBar: true
                                    });
                                }
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Update Failed",
                                    text: "An error occurred while updating the event.",
                                    timer: 3000,
                                    timerProgressBar: true
                                });
                            }
                        };
                        xhr.send(formData);
                    } else {
                        Swal.fire({
                            icon: "info",
                            title: "Cancelled",
                            text: "The event update has been cancelled.",
                            timer: 2000,
                            timerProgressBar: true
                        });
                    }
                });
            </script>';

    return $script;
}


    function delete_event($appID)
    {
        $query = "DELETE FROM calendar_tbl WHERE calendar_id = :appID";
        $statement = $this->connection->prepare($query);
        $statement->execute(array("appID" => $appID));
        if ($statement->execute()) {
            return '<script>
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: "success",
                        title: "Event Deleted successfully"
                    }).then((result) => {
                        if (result.isConfirmed) {
                          document.location = "schoolcalendar.php";
                        } else {
                          document.location = "schoolcalendar.php";
                        }
                      });
                </script>';
        } else {
            return "Error Deleting";
        }
    }

    function show_events()
    {
        // Fetch the user's organization ID based on session variable
        $userId = isset($_SESSION['aid']) ? intval($_SESSION['aid']) : 0;
    
        // Query to get the user's organization from users_tbl
        $orgQuery = "SELECT users_org FROM users_tbl WHERE users_id = :userId";
        $orgStatement = $this->connection->prepare($orgQuery);
        $orgStatement->bindValue(':userId', $userId, PDO::PARAM_INT);
        $orgStatement->execute();
        $orgRow = $orgStatement->fetch(PDO::FETCH_ASSOC);
    
        // Safely escape the organization ID
        $userOrgId = $orgRow ? intval($orgRow['users_org']) : 0;
    
        // If the user has no organization, return an empty result or error message
        if ($userOrgId == 0) {
            return "No organization found for the user.";
        }
    
        // Main event query, filtered by the user's organization
        $query = "
            SELECT e.*, 
                   u.users_username AS creator_name, 
                   om.name AS updated_by_name, 
                   o.org_name, 
                   o.org_image
            FROM calendar_tbl e
            LEFT JOIN users_tbl u ON e.event_creator = u.users_id
            LEFT JOIN orgmembers_tbl om ON e.updated_by = om.id
            LEFT JOIN organization_tbl o ON u.users_org = o.org_id
            WHERE u.users_org = :userOrgId
        ";
    
        $statement = $this->connection->prepare($query);
        $statement->bindValue(':userOrgId', $userOrgId, PDO::PARAM_INT);
    
        if ($statement->execute()) {
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    
            // Check for creator names and fallback to orgmembers_tbl if necessary
            foreach ($result as &$row) {
                // Handle org_image, fallback to a placeholder if not available
                $row['org_image'] = isset($row['org_image']) && !empty($row['org_image'])
                                    ? htmlspecialchars($row['org_image'], ENT_QUOTES, 'UTF-8')
                                    : 'placeholder.jpg'; // Default placeholder if no image is found
    
                // If creator name is not found in users_tbl, try to find it in orgmembers_tbl
                if (empty($row['creator_name'])) {
                    $creatorId = $row['event_creator']; // Get the creator ID
                    // Fetch the creator's name from orgmembers_tbl
                    $fallbackQuery = "SELECT name FROM orgmembers_tbl WHERE id = :creatorId";
                    $fallbackStatement = $this->connection->prepare($fallbackQuery);
                    $fallbackStatement->bindValue(':creatorId', $creatorId, PDO::PARAM_INT);
                    $fallbackStatement->execute();
                    $fallbackRow = $fallbackStatement->fetch(PDO::FETCH_ASSOC);
                    
                    // If a name is found in orgmembers_tbl, use it
                    if ($fallbackRow) {
                        $row['creator_name'] = htmlspecialchars($fallbackRow['name'], ENT_QUOTES, 'UTF-8');
                    } else {
                        $row['creator_name'] = 'Unknown'; // Fallback if no name is found
                    }
                } else {
                    // Sanitize creator name from users_tbl
                    $row['creator_name'] = htmlspecialchars($row['creator_name'], ENT_QUOTES, 'UTF-8');
                }
    
                // Check if updated_by has a valid name; otherwise, fallback to orgmembers_tbl
                if (empty($row['updated_by_name']) || !$row['updated_by']) { // Check if updated_by is 0 or null
                    $updatedById = $row['updated_by']; // Get the updated_by ID
                    if ($updatedById > 0) { // Only query if updated_by is a valid ID
                        // Fetch the updater's name from orgmembers_tbl
                        $fallbackQuery = "SELECT name FROM orgmembers_tbl WHERE id = :updatedById";
                        $fallbackStatement = $this->connection->prepare($fallbackQuery);
                        $fallbackStatement->bindValue(':updatedById', $updatedById, PDO::PARAM_INT);
                        $fallbackStatement->execute();
                        $fallbackRow = $fallbackStatement->fetch(PDO::FETCH_ASSOC);
                        
                        // If a name is found in orgmembers_tbl, use it
                        if ($fallbackRow) {
                            $row['updated_by_name'] = htmlspecialchars($fallbackRow['name'], ENT_QUOTES, 'UTF-8');
                        } else {
                            $row['updated_by_name'] = 'Unknown'; // Fallback if no name is found
                        }
                    } else {
                        $row['updated_by_name'] = 'Unknown'; // No valid ID, set to Unknown
                    }
                } else {
                    // Sanitize updated_by_name from orgmembers_tbl
                    $row['updated_by_name'] = htmlspecialchars($row['updated_by_name'], ENT_QUOTES, 'UTF-8');
                }
            }
            return $result;
        } else {
            return "No Data";
        }
    }
    
    
    function show_eventsByMonth()
    {
        $query = "SELECT *, DATE_FORMAT(calendar_date, '%m-%d') as monthDate FROM calendar_tbl ORDER BY calendar_date";
        $statement = $this->connection->prepare($query);

        $eventsByMonth = [];



        if ($statement->execute()) {
            $result = $statement->fetchAll();
            foreach ($result as $event) {
                $eventDate = new DateTime($event['calendar_date']);
                $monthYear = $eventDate->format('F Y');

                // Initialize the month array if it doesn't exist
                if (!isset($eventsByMonth[$monthYear])) {
                    $eventsByMonth[$monthYear] = [];
                }

                // Add the event to the corresponding month
                $eventsByMonth[$monthYear][] = $event;
            }

            // Sort the months chronologically
            // ksort($eventsByMonth);s
            return $eventsByMonth;
        } else {
            return "No Data";
        }
    }
  
    
    function add_faculty_member($data) {
        $name = htmlspecialchars($data['faculty_name'] ?? '', ENT_QUOTES, 'UTF-8');
        $dept = htmlspecialchars($data['department'] ?? '', ENT_QUOTES, 'UTF-8');
    
        return '
            <script>
                Swal.fire({
                    title: "Are you sure?",
                    text: "Do you want to save this faculty member?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, save it!",
                    cancelButtonText: "No, cancel!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = new FormData();
                        formData.append("type", "faculty");
                        formData.append("faculty_name", "' . $name . '");
                        formData.append("department", "' . $dept . '");
                        var facultyImageInput = document.querySelector("input[name=faculty_image]");
                        if (facultyImageInput.files.length > 0) {
                            formData.append("faculty_image", facultyImageInput.files[0]);
                        }
    
                        fetch("../admin/ajax/createData.php", {
                            method: "POST",
                            body: formData
                        }).then(response => response.json())
                          .then(result => {
                              Swal.fire("Response", result.message, "info");
                              if (result.success) {
                                Swal.fire(
                                    "Saved!",
                                    "The faculty member has been saved.",
                                    "success"
                                ).then(() => {
                                    document.location = "facultymembers.php";
                                });
                              } else {
                                  Swal.fire("Error!", result.message, "error");
                              }
                          }).catch(error => {
                            Swal.fire(
                                "Error!",
                                "There was an error saving the faculty member.",
                                "error"
                            );
                          });
                    }
                });
            </script>';
    }
    function add_faculty_member_using_Excel() {
        return '
            <script>
                Swal.fire({
                    title: "Are you sure?",
                    text: "Do you want to import faculty members from the Excel file?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, import it!",
                    cancelButtonText: "No, cancel!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Create a FormData object for the Excel file
                        var formData = new FormData();
                        formData.append("type", "excel_import");
                        
                        var facultyImageInput = document.querySelector("input[name=faculty_excel]");
                        if (facultyImageInput.files.length > 0) {
                            formData.append("faculty_excel", facultyImageInput.files[0]);
                        }
    
                        // Make the AJAX request to your server-side script
                        fetch("../admin/ajax/createData.php", {
                            method: "POST",
                            body: formData
                        }).then(response => response.json())
                          .then(result => {
                              Swal.fire("Response", result.message, "info");
                              if (result.success) {
                                  Swal.fire(
                                      "Imported!",
                                      "The faculty members have been imported successfully.",
                                      "success"
                                  ).then(() => {
                                      document.location = "facultymembers.php"; // Redirect to the faculty members page
                                  });
                              } else {
                                  Swal.fire("Error!", result.message, "error");
                              }
                          }).catch(error => {
                              Swal.fire(
                                  "Error!",
                                  "There was an error importing the faculty members.",
                                  "error"
                              );
                          });
                    }
                });
            </script>';
    }
    
    function save_faculty($data)
{
    $fid = htmlspecialchars($data['fid'], ENT_QUOTES, 'UTF-8');
    $name = htmlspecialchars($data['faculty_name'], ENT_QUOTES, 'UTF-8');
    $dept = htmlspecialchars($data['department'], ENT_QUOTES, 'UTF-8');
    $previous = htmlspecialchars($data['previous'], ENT_QUOTES, 'UTF-8');
    
    // Generate the confirmation dialog script
    $script = '<script>
                Swal.fire({
                    title: "Are you sure?",
                    text: "Do you want to save this faculty member?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, save it!",
                    cancelButtonText: "No, cancel!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = new FormData();
                        formData.append("type", "faculty");
                        formData.append("fid", "' . $fid . '");
                        formData.append("faculty_name", "' . $name . '");
                        formData.append("department", "' . $dept . '");
                        formData.append("previous", "' . $previous . '");
                        
                        var fileInput = document.querySelector("input[name=\'faculty_image\']");
                        if (fileInput.files.length > 0) {
                            formData.append("faculty_image", fileInput.files[0]);
                        }
                        
                        fetch("ajax/editData.php", {
                            method: "POST",
                            body: formData
                        })
                        .then(response => response.json())
                        .then(result => {
                            if (result.success) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Faculty Member Updated",
                                    text: result.message,
                                    timer: 2000,
                                    timerProgressBar: true
                                }).then(() => {
                                    window.location.href = "facultymembers.php";
                                });
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Update Failed",
                                    text: result.message,
                                    timer: 3000,
                                    timerProgressBar: true
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: "error",
                                title: "Update Failed",
                                text: "An error occurred while updating the faculty member.",
                                timer: 3000,
                                timerProgressBar: true
                            });
                        });
                    } else {
                        Swal.fire({
                            icon: "info",
                            title: "Cancelled",
                            text: "The faculty member update has been cancelled.",
                            timer: 2000,
                            timerProgressBar: true
                        });
                    }
                });
            </script>';

    return $script;
}

    function delete_faculty($appID)
    {
        $query = "DELETE FROM faculty_tbl WHERE faculty_id = :appID";
        $statement = $this->connection->prepare($query);
        $statement->execute(array("appID" => $appID));
        if ($statement->execute()) {
            return '<script>
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: "success",
                        title: "Member Deleted successfully"
                    }).then((result) => {
                        if (result.isConfirmed) {
                          document.location = "facultymembers.php";
                        } else {
                          document.location = "facultymembers.php";
                        }
                      });
                </script>';
        } else {
            return "Error Deleting";
        }
    }

    function show_facultyheads($department_ids = null)
    {
        // Assuming the Dean's ID is 5, adjust as necessary
        $dean_id = 5;
    
        // Base query to get faculty members
        $query = "SELECT f.*, d.department_name 
                  FROM faculty_tbl f 
                  LEFT JOIN department_tbl d ON f.faculty_dept = d.department_id";
        
        // Add condition to filter by departments if provided and exclude the Dean
        if ($department_ids) {
            // Create a placeholder string for the IN clause
            $placeholders = rtrim(str_repeat('?,', count($department_ids)), ',');
            $query .= " WHERE f.faculty_dept IN ($placeholders) AND f.faculty_dept != ?";
        }
        
        $statement = $this->connection->prepare($query);
        
        // Bind parameters if filtering by departments
        if ($department_ids) {
            // Bind each department ID and the dean's ID
            foreach ($department_ids as $key => $id) {
                $statement->bindValue($key + 1, $id, PDO::PARAM_INT);
            }
            $statement->bindValue(count($department_ids) + 1, $dean_id, PDO::PARAM_INT);
        }
    
        // Execute query
        if ($statement->execute()) {
            $result = $statement->fetchAll();
            return $result;
        } else {
            return "No Data";
        }
    }
    function show_facultymembers($department_ids = null)
    {
        // Assuming the Dean's ID is 5, adjust as necessary
        $dean_id = 5;
    
        // Base query to get faculty members
        $query = "SELECT f.*, d.department_name 
                  FROM faculty_tbl f 
                  LEFT JOIN department_tbl d ON f.faculty_dept = d.department_id";
        
        // Add condition to filter by departments if provided and exclude the Dean
        if ($department_ids) {
            // Create a placeholder string for the IN clause
            $placeholders = rtrim(str_repeat('?,', count($department_ids)), ',');
            $query .= " WHERE f.faculty_dept IN ($placeholders) AND f.faculty_dept != ?";
        }
        
        $statement = $this->connection->prepare($query);
        
        // Bind parameters if filtering by departments
        if ($department_ids) {
            // Bind each department ID and the dean's ID
            foreach ($department_ids as $key => $id) {
                $statement->bindValue($key + 1, $id, PDO::PARAM_INT);
            }
            $statement->bindValue(count($department_ids) + 1, $dean_id, PDO::PARAM_INT);
        }
    
        // Execute query
        if ($statement->execute()) {
            $result = $statement->fetchAll();
            return $result;
        } else {
            return "No Data";
        }
    }
    
function add_org($data) {
    $name = htmlspecialchars($data['org_name'] ?? '', ENT_QUOTES, 'UTF-8');

    return '
        <script>
            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to add this organization?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, add it!",
                cancelButtonText: "No, cancel!"
            }).then((result) => {
                if (result.isConfirmed) {
                    var formData = new FormData();
                    formData.append("type", "organization"); // Ensure the type parameter is included
                    formData.append("org_name", "' . $name . '");
                    formData.append("org_image", document.querySelector("input[name=org_image]").files[1]);

                    fetch("../admin/ajax/createData.php", {
                        method: "POST",
                        body: formData
                    }).then(response => response.json()) // Handle JSON response
                      .then(result => {
                          Swal.fire("Response", result.message, "info");
                          if (result.success) {
                            Swal.fire(
                                "Added!",
                                "The organization has been added.",
                                "success"
                            ).then(() => {
                                document.location = "organization.php";
                            });
                          } else {
                              Swal.fire("Error!", result.message, "error");
                          }
                      }).catch(error => {
                        Swal.fire(
                            "Error!",
                            "There was an error adding the organization.",
                            "error"
                        );
                      });
                }
            });
        </script>';
}


function save_org($data)
{
    // Retrieve and sanitize data
    $oid = $data['oid'];
    $name = htmlspecialchars($data['org_name'], ENT_QUOTES, 'UTF-8'); // Sanitize org_name
    $previous = $data['previous']; // No need to sanitize previous image

    $newImage = "";

    // Handle image upload
    if (isset($_FILES['org_image']) && $_FILES['org_image']['error'] <= 0) {
        $uploadTo = "../uploaded/orgUploaded/";
        $newImage = $name . "_" . basename($_FILES['org_image']['name']); // Create a new image name
        $tempPath = $_FILES["org_image"]["tmp_name"];
        $originalPath = $uploadTo . $newImage;

        if (move_uploaded_file($tempPath, $originalPath)) {
            // Image uploaded successfully
        } else {
            // Failure to move the file, fallback to previous image
            $newImage = $previous;
        }
    } else {
        // No new image uploaded, use the previous image
        $newImage = $previous;
    }

    // Prepare and execute the database update
    $query = "UPDATE organization_tbl SET org_name = :org_name, org_image = :org_image WHERE org_id = :oid";
    $statement = $this->connection->prepare($query);

    if ($statement->execute(array(
        "org_name" => $name,
        "org_image" => $newImage,
        "oid" => $oid
    ))) {
        return '<script>
            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to save these changes?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, save it!",
                cancelButtonText: "No, cancel!"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: "success",
                        title: "Organization Updated Successfully",
                        timer: 2000,
                        timerProgressBar: true
                    }).then(() => {
                        window.location.href = "organization.php"; // Redirect to the appropriate page
                    });
                } else {
                    Swal.fire({
                        icon: "info",
                        title: "Cancelled",
                        text: "The organization update has been cancelled.",
                        timer: 2000,
                        timerProgressBar: true
                    });
                }
            });
        </script>';
    } else {
        return 'Error';
    }
}

    function show_org()
    {
        $query = "SELECT * FROM organization_tbl";
        $statement = $this->connection->prepare($query);

        if ($statement->execute()) {
            $result = $statement->fetchAll();
            return $result;
        } else {
            return "No Data";
        }
    }

    function delete_org($appID)
    {
        $query = "DELETE FROM organization_tbl WHERE org_id = :appID";
        $statement = $this->connection->prepare($query);
    
        // Execute the statement
        if ($statement->execute(array("appID" => $appID))) {
            return '<script>
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: "success",
                        title: "Organization Deleted successfully"
                    }).then((result) => {
                        if (result.isConfirmed) {
                          document.location = "organization.php";
                        } else {
                          document.location = "organization.php";
                        }
                    });
                </script>';
        } else {
            return '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "There was an error deleting the organization."
                    });
                </script>';
        }
    }
    

    function add_faqs($data) {
        // Escape PHP variables to be safely included in JavaScript
        $question = htmlspecialchars($data['faqs_question'] ?? '', ENT_QUOTES, 'UTF-8');
        $answer = htmlspecialchars($data['faqs_answer'] ?? '', ENT_QUOTES, 'UTF-8');
    
        // Return JavaScript code
        return '
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var faqForm = document.getElementById("faqForm");
    
                    if (faqForm) {
                        faqForm.addEventListener("submit", function(event) {
                            event.preventDefault(); // Prevent the default form submission
    
                            Swal.fire({
                                title: "Are you sure?",
                                text: "Do you want to add this FAQ?",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                                confirmButtonText: "Yes, add it!",
                                cancelButtonText: "No, cancel!"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    var formData = new FormData(faqForm);
                                    formData.append("type", "faq"); // Ensure type parameter is included
                                    formData.append("faqs_question", "' . $question . '");
                                    formData.append("faqs_answer", "' . $answer . '");
    
                                    fetch("../admin/ajax/createData.php", {
                                        method: "POST",
                                        body: formData
                                    }).then(response => response.json()) // Handle JSON response
                                      .then(result => {
                                          Swal.fire("Response", result.message, "info");
                                          if (result.success) {
                                              Swal.fire(
                                                  "Added!",
                                                  "The FAQ has been added.",
                                                  "success"
                                              ).then(() => {
                                                  document.location = "faqs.php";
                                              });
                                          } else {
                                              Swal.fire("Error!", result.message, "error");
                                          }
                                      }).catch(error => {
                                          Swal.fire(
                                              "Error!",
                                              "There was an error adding the FAQ.",
                                              "error"
                                          );
                                      });
                                }
                            });
                        });
                    } else {
                        console.warn("Element with ID \'faqForm\' not found.");
                    }
                });
            </script>';
    }
    
function save_faqs($data)
{
    $fid = htmlspecialchars($data['fid'], ENT_QUOTES, 'UTF-8');
    $question = htmlspecialchars($data['faqs_question'], ENT_QUOTES, 'UTF-8');
    $answer = htmlspecialchars($data['faqs_answer'], ENT_QUOTES, 'UTF-8');

    // Generate the confirmation dialog script
    $script = '<script>
                Swal.fire({
                    title: "Are you sure?",
                    text: "Do you want to update this FAQ?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, update it!",
                    cancelButtonText: "No, cancel!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Proceed with the AJAX request
                        var xhr = new XMLHttpRequest();
                        var formData = new FormData();
                        formData.append("type", "faq");
                        formData.append("fid", "' . $fid . '");
                        formData.append("faqs_question", "' . $question . '");
                        formData.append("faqs_answer", "' . $answer . '");

                        xhr.open("POST", "ajax/editData.php", true);
                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                var response = JSON.parse(xhr.responseText);
                                if (response.success) {
                                    Swal.fire({
                                        icon: "success",
                                        title: "FAQ Updated",
                                        text: response.message,
                                        timer: 2000,
                                        timerProgressBar: true
                                    }).then(() => {
                                        window.location = "faqs.php";
                                    });
                                } else {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Update Failed",
                                        text: response.message,
                                        timer: 3000,
                                        timerProgressBar: true
                                    });
                                }
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Update Failed",
                                    text: "An error occurred while updating the FAQ.",
                                    timer: 3000,
                                    timerProgressBar: true
                                });
                            }
                        };
                        xhr.send(formData);
                    } else {
                        Swal.fire({
                            icon: "info",
                            title: "Cancelled",
                            text: "The FAQ update has been cancelled.",
                            timer: 2000,
                            timerProgressBar: true
                        });
                    }
                });
            </script>';

    return $script;
}


    function delete_faqs($appID)
    {
        $query = "DELETE FROM faqs_tbl WHERE faqs_id = :appID";
        $statement = $this->connection->prepare($query);
        $statement->execute(array("appID" => $appID));
        if ($statement->execute()) {
            return '<script>
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: "success",
                        title: "FAQs Deleted successfully"
                    }).then((result) => {
                        if (result.isConfirmed) {
                          document.location = "faqs.php";
                        } else {
                          document.location = "faqs.php";
                        }
                      });
                </script>';
        } else {
            return "Error Deleting";
        }
    }
    public function show_faqs()
    {
        $query = "SELECT * FROM faqs_tbl";
        $statement = $this->connection->prepare($query);
    
        if ($statement->execute()) {
            $result = $statement->fetchAll(PDO::FETCH_ASSOC); // Fetch results as an associative array
    
            // Loop through each FAQ and strip HTML tags
            foreach ($result as &$faq) {
                $faq['faqs_question'] = strip_tags($faq['faqs_question']); // Sanitize question
                $faq['faqs_answer'] = strip_tags($faq['faqs_answer']);     // Sanitize answer
            }
    
            return $result;
        } else {
            return "No Data";
        }
    }
    
    function add_account($data) {
        $username = htmlspecialchars($data['username'] ?? '', ENT_QUOTES, 'UTF-8');
        $password = password_hash($data['password'] ?? '', PASSWORD_DEFAULT); // Hashing the password
        $org = htmlspecialchars($data['org'] ?? '', ENT_QUOTES, 'UTF-8');
    
        return '
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var accountForm = document.getElementById("accountForm");
    
                    if (accountForm) {
                        accountForm.addEventListener("submit", function(event) {
                            event.preventDefault(); // Prevent default form submission
    
                            Swal.fire({
                                title: "Are you sure?",
                                text: "Do you want to add this account?",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                                confirmButtonText: "Yes, add it!",
                                cancelButtonText: "No, cancel!"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    var formData = new FormData(accountForm);
                                    formData.append("type", "account"); // Ensure type parameter is included
                                    formData.append("username", "' . $username . '");
                                    formData.append("password", "' . $password . '");
                                    formData.append("org", "' . $org . '");
    
                                    fetch("../admin/ajax/createData.php", {
                                        method: "POST",
                                        body: formData
                                    })
                                    .then(response => response.json()) // Handle JSON response
                                    .then(result => {
                                        Swal.fire("Response", result.message, "info");
                                        if (result.success) {
                                            Swal.fire(
                                                "Added!",
                                                "The account has been added.",
                                                "success"
                                            ).then(() => {
                                                document.location = "organization.php";
                                            });
                                        } else {
                                            Swal.fire("Error!", result.message, "error");
                                        }
                                    })
                                    .catch(error => {
                                        Swal.fire(
                                            "Error!",
                                            "There was an error adding the account.",
                                            "error"
                                        );
                                    });
                                }
                            });
                        });
                    } else {
                        console.warn("Element with ID \'accountForm\' not found.");
                    }
                });
            </script>';
    }
    
function save_account($data)
{
    // Retrieve and sanitize data
    $uid = htmlspecialchars($data['uid'], ENT_QUOTES, 'UTF-8');
    $username = htmlspecialchars($data['username'], ENT_QUOTES, 'UTF-8');
    $password = $data['password'] ?? ''; 
    $position = htmlspecialchars($data['position'], ENT_QUOTES, 'UTF-8');

    try {
        // Check if the user exists
        $sql = "SELECT password FROM orgmembers_tbl WHERE id = :uid";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":uid", $uid, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $existingPasswordHash = $stmt->fetchColumn();

            // Initialize an array to collect validation errors
            $errors = [];

            // Validate the password if a new one is provided
            if (!empty($password)) {
                // Check minimum and maximum length (8 to 16 characters)
                if (strlen($password) < 8 || strlen($password) > 16) {
                    $errors[] = "Password must be between 8 and 16 characters long.";
                }

                // Check for at least one uppercase letter
                if (!preg_match('/[A-Z]/', $password)) {
                    $errors[] = "Password must contain at least one uppercase letter.";
                }

                // Check for at least one number
                if (!preg_match('/[0-9]/', $password)) {
                    $errors[] = "Password must contain at least one number.";
                }

                // Check for at least one special character
                if (!preg_match('/[!@#$%^&*(),.?":{}|<>_]/', $password)) {
                    $errors[] = "Password must contain at least one special character.";
                }

                // If there are validation errors, display all of them and cancel the form submission
                if (!empty($errors)) {
                    $errorMessage = implode('<br>', $errors);
                    return '<script>
                        Swal.fire({
                            icon: "error",
                            title: "Invalid Password",
                            html: "' . $errorMessage . '",
                            timer: 5000,
                            timerProgressBar: true
                        }).then(() => {
                            // Auto cancel the form submission after showing validation errors
                            window.history.back(); // Go back to the previous form/page
                        });
                    </script>';
                }

                // Hash the new password using SHA-256 if all validations pass
                $hashedPassword = hash('sha256', $password);
            } else {
                // Keep the existing hashed password if no new password is provided
                $hashedPassword = $existingPasswordHash;
            }

            // Prepare and execute the database update
            $query = "UPDATE orgmembers_tbl 
                      SET username = :username, password = :password, position = :position
                      WHERE id = :uid";
            $statement = $this->connection->prepare($query);

            // Debug: Log query and parameters
            error_log("Executing update query for UID = $uid");
            error_log("Parameters: Username = $username, Password = $hashedPassword, position = $position");

            if ($statement->execute([
                ":username" => $username,
                ":password" => $hashedPassword,
                ":position" => $position,
                ":uid" => $uid
            ])) {
                return '<script>
                    Swal.fire({
                        title: "Are you sure?",
                        text: "Do you want to save these changes?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, save it!",
                        cancelButtonText: "No, cancel!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                icon: "success",
                                title: "Account Updated Successfully",
                                timer: 2000,
                                timerProgressBar: true
                            }).then(() => {
                                window.location.href = "organization.php"; // Redirect to the appropriate page
                            });
                        } else {
                            Swal.fire({
                                icon: "info",
                                title: "Cancelled",
                                text: "The account update has been cancelled.",
                                timer: 2000,
                                timerProgressBar: true
                            });
                        }
                    });
                </script>';
            } else {
                // Log error if update fails
                error_log("Failed to update account for UID = $uid");

                return '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Failed to update account.",
                        timer: 3000,
                        timerProgressBar: true
                    });
                </script>';
            }
        } else {
            return '<script>
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "User not found.",
                    timer: 3000,
                    timerProgressBar: true
                });
            </script>';
        }
    } catch (PDOException $e) {
        error_log("PDOException: " . $e->getMessage());
        return '<script>
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Database error occurred.",
                timer: 3000,
                timerProgressBar: true
            });
        </script>';
    } catch (Exception $e) {
        error_log("Exception: " . $e->getMessage());
        return '<script>
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "An unexpected error occurred.",
                timer: 3000,
                timerProgressBar: true
            });
        </script>';
    }
}function save_membersaccount($data)
{
    // Retrieve and sanitize data
    $uid = htmlspecialchars($data['uid'], ENT_QUOTES, 'UTF-8');
    $name = htmlspecialchars($data['name'], ENT_QUOTES, 'UTF-8');
    $username = htmlspecialchars($data['username'], ENT_QUOTES, 'UTF-8');
    $password = $data['password'] ?? ''; 
    $position = htmlspecialchars($data['position'], ENT_QUOTES, 'UTF-8');

    try {
        // Check if the user exists
        $sql = "SELECT password FROM orgmembers_tbl WHERE id = :uid";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":uid", $uid, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $existingPasswordHash = $stmt->fetchColumn();
            $errors = [];

            // Validate the password if a new one is provided
            if (!empty($password)) {
                if (strlen($password) < 8 || strlen($password) > 16) {
                    $errors[] = "Password must be between 8 and 16 characters long.";
                }
                if (!preg_match('/[A-Z]/', $password)) {
                    $errors[] = "Password must contain at least one uppercase letter.";
                }
                if (!preg_match('/[0-9]/', $password)) {
                    $errors[] = "Password must contain at least one number.";
                }
                if (!preg_match('/[!@#$%^&*(),.?":{}|<>_]/', $password)) {
                    $errors[] = "Password must contain at least one special character.";
                }

                if (!empty($errors)) {
                    $errorMessage = implode('<br>', $errors);
                    return '<script>
                        Swal.fire({
                            icon: "error",
                            title: "Invalid Password",
                            html: "' . $errorMessage . '",
                            timer: 5000,
                            timerProgressBar: true
                        }).then(() => {
                            window.history.back(); // Go back to the previous form/page
                        });
                    </script>';
                }

                // Hash the new password using SHA-256 if all validations pass
                $hashedPassword = hash('sha256', $password);
            } else {
                $hashedPassword = $existingPasswordHash; // Keep the existing hashed password if no new password
            }

            // Prepare and execute the database update
            $query = "UPDATE orgmembers_tbl 
                      SET username = :username, password = :password, position = :position, name = :name
                      WHERE id = :uid";
            $statement = $this->connection->prepare($query);

            // Bind parameters
            $statement->bindParam(":username", $username, PDO::PARAM_STR);
            $statement->bindParam(":password", $hashedPassword, PDO::PARAM_STR);
            $statement->bindParam(":position", $position, PDO::PARAM_STR);
            $statement->bindParam(":name", $name, PDO::PARAM_STR);
            $statement->bindParam(":uid", $uid, PDO::PARAM_INT);

            // Debug: Log query execution
            error_log("Executing update query for UID = $uid");
            error_log("Parameters: name= $name, Username = $username, Password = $hashedPassword, position = $position");

            if ($statement->execute()) {
                return '<script>
                    Swal.fire({
                        title: "Are you sure?",
                        text: "Do you want to save these changes?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, save it!",
                        cancelButtonText: "No, cancel!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                icon: "success",
                                title: "Account Updated Successfully",
                                timer: 2000,
                                timerProgressBar: true
                            }).then(() => {
                                window.location.href = "membersmanagement.php"; // Redirect to the appropriate page
                            });
                        } else {
                            Swal.fire({
                                icon: "info",
                                title: "Cancelled",
                                text: "The account update has been cancelled.",
                                timer: 2000,
                                timerProgressBar: true
                            });
                        }
                    });
                </script>';
            } else {
                // Log error if update fails
                error_log("Failed to update account for UID = $uid");
                return '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Failed to update account.",
                        timer: 3000,
                        timerProgressBar: true
                    });
                </script>';
            }
        } else {
            return '<script>
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "User not found.",
                    timer: 3000,
                    timerProgressBar: true
                });
            </script>';
        }
    } catch (PDOException $e) {
        error_log("PDOException: " . $e->getMessage());
        return '<script>
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Database error occurred: ' . $e->getMessage() . '",
                timer: 3000,
                timerProgressBar: true
            });
        </script>';
    } catch (Exception $e) {
        error_log("Exception: " . $e->getMessage());
        return '<script>
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "An unexpected error occurred: ' . $e->getMessage() . '",
                timer: 3000,
                timerProgressBar: true
            });
        </script>';
    }
}
function save_profile($data)
{
    // Retrieve and sanitize data
    $uid = htmlspecialchars($data['uid'], ENT_QUOTES, 'UTF-8');
    $name = htmlspecialchars($data['name'], ENT_QUOTES, 'UTF-8');
    $username = htmlspecialchars($data['username'], ENT_QUOTES, 'UTF-8');
    $password = $data['password'] ?? ''; 
    $profileImagePath = ''; // Initialize profile image path variable

    try {
        // Check if the user exists
        $sql = "SELECT password, member_img FROM orgmembers_tbl WHERE id = :uid";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":uid", $uid, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);
            $existingPasswordHash = $userData['password'];
            $existingProfileImage = $userData['member_img']; // Retrieve the current profile image path
            $errors = [];

            // Validate the password if a new one is provided
            if (!empty($password)) {
                if (strlen($password) < 8 || strlen($password) > 16) {
                    $errors[] = "Password must be between 8 and 16 characters long.";
                }
                if (!preg_match('/[A-Z]/', $password)) {
                    $errors[] = "Password must contain at least one uppercase letter.";
                }
                if (!preg_match('/[0-9]/', $password)) {
                    $errors[] = "Password must contain at least one number.";
                }
                if (!preg_match('/[!@#$%^&*(),.?":{}|<>_]/', $password)) {
                    $errors[] = "Password must contain at least one special character.";
                }

                // If there are validation errors, return an error message
                if (!empty($errors)) {
                    $errorMessage = implode('<br>', $errors);
                    return '<script>
                        Swal.fire({
                            icon: "error",
                            title: "Invalid Password",
                            html: "' . $errorMessage . '",
                            timer: 5000,
                            timerProgressBar: true
                        }).then(() => {
                            window.history.back(); // Go back to the previous form/page
                        });
                    </script>';
                }

                // Hash the new password using SHA-256 if all validations pass
                $hashedPassword = hash('sha256', $password);
            } else {
                $hashedPassword = $existingPasswordHash; // Keep the existing hashed password if no new password
            }

            // File upload handling
            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
                $targetDir = '../uploaded/orgUploaded/';
                $targetFile = $targetDir . basename($_FILES['profile_image']['name']);
                $uploadOk = 1;

                // Check file size
                if ($_FILES['profile_image']['size'] > 500000) { // Adjust size as needed
                    $uploadOk = 0;
                    return "Sorry, your file is too large.";
                }

                // Allow certain file formats
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                if(!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
                    $uploadOk = 0;
                    return "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk === 0) {
                    return "Sorry, your file was not uploaded.";
                } else {
                    if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFile)) {
                        // File upload successful, update the profile image path
                        $profileImagePath = $_FILES['profile_image']['name'];
                    } else {
                        return "Sorry, there was an error uploading your file.";
                    }
                }
            } else {
                // If no new file was uploaded, keep the existing image path
                $profileImagePath = $existingProfileImage;
            }

            // Prepare and execute the database update
            $query = "UPDATE orgmembers_tbl 
                      SET username = :username, password = :password, name = :name, member_img = :profile_image
                      WHERE id = :uid";
            $statement = $this->connection->prepare($query);

            // Log parameters before executing the update
            error_log("Preparing to update user with UID: $uid");
            error_log("Username: $username, Name: $name, Password: $hashedPassword, Profile Image: $profileImagePath");

            // Bind parameters
            $statement->bindParam(":username", $username, PDO::PARAM_STR);
            $statement->bindParam(":password", $hashedPassword, PDO::PARAM_STR);
            $statement->bindParam(":name", $name, PDO::PARAM_STR);
            $statement->bindParam(":profile_image", $profileImagePath, PDO::PARAM_STR);
            $statement->bindParam(":uid", $uid, PDO::PARAM_INT);

            if ($statement->execute()) {
                // Log the successful update
                error_log("Successfully updated account for UID = $uid");
                return '<script>
                    Swal.fire({
                        title: "Are you sure?",
                        text: "Do you want to save these changes?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, save it!",
                        cancelButtonText: "No, cancel!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                icon: "success",
                                title: "Account Updated Successfully",
                                timer: 2000,
                                timerProgressBar: true
                            }).then(() => {
                                window.location.href = "memberprofile.php"; // Redirect to the appropriate page
                            });
                        } else {
                            Swal.fire({
                                icon: "info",
                                title: "Cancelled",
                                text: "The account update has been cancelled.",
                                timer: 2000,
                                timerProgressBar: true
                            });
                        }
                    });
                </script>';
            } else {
                // Log error if update fails
                error_log("Failed to update account for UID = $uid: " . implode(", ", $statement->errorInfo()));
                return '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Failed to update account.",
                        timer: 3000,
                        timerProgressBar: true
                    });
                </script>';
            }
        } else {
            return '<script>
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "User not found.",
                    timer: 3000,
                    timerProgressBar: true
                });
            </script>';
        }
    } catch (Exception $e) {
        error_log("Error in save_profile: " . $e->getMessage());
        return '<script>
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "An unexpected error occurred.",
                timer: 3000,
                timerProgressBar: true
            });
        </script>';
    }
}


function delete_account($appID)
{
    $query = "DELETE FROM users_tbl WHERE users_id = :appID";
    $statement = $this->connection->prepare($query);
    $statement->execute(array("appID" => $appID));

    if ($statement->execute()) {
        return '<script>
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "success",
                    title: "User Deleted successfully"
                }).then((result) => {
                    if (result.isConfirmed) {
                      document.location = "membersmanagement.php";
                    } else {
                      document.location = "membersmanagement.php";
                    }
                });
            </script>';
    } else {
        return "Error Deleting";
    }
}

    function show_account()
    {
        $query = "SELECT * FROM users_tbl";
        $statement = $this->connection->prepare($query);

        if ($statement->execute()) {
            $result = $statement->fetchAll();
            return $result;
        } else {
            return "No Data";
        }
    }

    function delete_membersaccount($appID)
    {
        $query = "DELETE FROM orgmembers_tbl WHERE id = :appID";
        $statement = $this->connection->prepare($query);
        $statement->execute(array("appID" => $appID));
        if ($statement->execute()) {
            return '<script>
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: "success",
                        title: "User Deleted successfully"
                    }).then((result) => {
                        if (result.isConfirmed) {
                          document.location = "membersmanagement.php";
                        } else {
                          document.location = "membersmanagement.php";
                        }
                      });
                </script>';
        } else {
            return "Error Deleting";
        }
    }
    function show_membersaccount()
    {
        // First, retrieve the org_type based on the logged-in user's organization
        $query = "SELECT users_org FROM users_tbl WHERE users_id = :user_id";
        $statement = $this->connection->prepare($query);
        
        // Bind the session variable to get the user ID
        $user_id = $_SESSION['aid'];
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        
        // Execute the statement to fetch the org_type
        if ($statement->execute()) {
            if ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $org_type = $row['users_org']; // Get the organization type
                
                // Now query the orgmembers_tbl using the retrieved org_type
                $query = "SELECT * FROM orgmembers_tbl WHERE org_type = :org_type";
                $memberStatement = $this->connection->prepare($query);
                $memberStatement->bindParam(':org_type', $org_type, PDO::PARAM_INT);
                
                // Execute the member statement and fetch results
                if ($memberStatement->execute()) {
                    $result = $memberStatement->fetchAll();
                    return $result; // Return the fetched results
                } else {
                    return "No Data"; // Return a message if no data is found
                }
            } else {
                return "No organization found for this user."; // Handle case where no organization is found
            }
        } else {
            return "Error fetching organization type."; // Handle query execution error
        }
    }
    
    
    function show_department()
    {
        $query = "SELECT * FROM department_tbl";
        $statement = $this->connection->prepare($query);

        if ($statement->execute()) {
            $result = $statement->fetchAll();
            return $result;
        } else {
            return "No Data";
        }
    }

    function show_allIt()
    {
        $query = "SELECT * FROM faculty_tbl WHERE faculty_dept = 1";
        $statement = $this->connection->prepare($query);

        if ($statement->execute()) {
            $result = $statement->fetchAll();
            return $result;
        } else {
            return "No Data";
        }
    }

    function show_allCs()
    {
        $query = "SELECT * FROM faculty_tbl WHERE faculty_dept = 2";
        $statement = $this->connection->prepare($query);

        if ($statement->execute()) {
            $result = $statement->fetchAll();
            return $result;
        } else {
            return "No Data";
        }
    }

    function show_allIs()
    {
        $query = "SELECT * FROM faculty_tbl WHERE faculty_dept = 3";
        $statement = $this->connection->prepare($query);

        if ($statement->execute()) {
            $result = $statement->fetchAll();
            return $result;
        } else {
            return "No Data";
        }
    }
    function show_allMit()
    {
        $query = "SELECT * FROM faculty_tbl WHERE faculty_dept = 4";
        $statement = $this->connection->prepare($query);

        if ($statement->execute()) {
            $result = $statement->fetchAll();
            return $result;
        } else {
            return "No Data";
        }
    }

    
    function show_allItHeads()
    {
        $query = "SELECT * FROM heads_tbl WHERE faculty_dept = 1";
        $statement = $this->connection->prepare($query);
    
        if ($statement->execute()) {
            $result = $statement->fetchAll();
            return $result;
        } else {
            return "No Data";
        }
    }
    
    function show_allCsHeads()
    {
        $query = "SELECT * FROM heads_tbl WHERE faculty_dept = 2";
        $statement = $this->connection->prepare($query);
    
        if ($statement->execute()) {
            $result = $statement->fetchAll();
            return $result;
        } else {
            return "No Data";
        }
    }
    
    function show_allIsHeads()
    {
        $query = "SELECT * FROM heads_tbl WHERE faculty_dept = 3";
        $statement = $this->connection->prepare($query);
    
        if ($statement->execute()) {
            $result = $statement->fetchAll();
            return $result;
        } else {
            return "No Data";
        }
    }
    
    function show_allMitHeads()
    {
        $query = "SELECT * FROM heads_tbl WHERE faculty_dept = 4";
        $statement = $this->connection->prepare($query);
    
        if ($statement->execute()) {
            $result = $statement->fetchAll();
            return $result;
        } else {
            return "No Data";
        }
    }
    function show_allDeanHeads()
{
    $query = "SELECT * FROM faculty_tbl WHERE faculty_dept = 5";
    $statement = $this->connection->prepare($query);

    if ($statement->execute()) {
        $result = $statement->fetchAll();
        return $result;
    } else {
        return "No Data";
    }
}

function show_alllvl2()
{
    $query = "SELECT * FROM faculty_tbl WHERE faculty_dept = 6";
    $statement = $this->connection->prepare($query);

    if ($statement->execute()) {
        $result = $statement->fetchAll();
        return $result;
    } else {
        return "No Data";
    }
}
function show_alllvl3()
{
    $query = "SELECT * FROM faculty_tbl WHERE faculty_dept IN (7, 8, 9)";

    $statement = $this->connection->prepare($query);

    if ($statement->execute()) {
        $result = $statement->fetchAll();
        return $result;
    } else {
        return "No Data";
    }
}


public function show_allFAQs() {
    $query = "SELECT * FROM faqs_tbl";
    $statement = $this->connection->prepare($query);

    if ($statement->execute()) {
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } else {
        return "No Data";
    }
}
public function add_faq($question, $answer) {
    $query = "INSERT INTO faqs_tbl (faqs_question, faqs_answer) VALUES (:question, :answer)";
    $statement = $this->connection->prepare($query);
    $statement->bindParam(':question', $question);
    $statement->bindParam(':answer', $answer);
    
    if ($statement->execute()) {
        // Return the ID of the inserted FAQ
        return $this->connection->lastInsertId();
    } else {
        // Return false if the insertion failed
        return false;
    }
}

}
?>