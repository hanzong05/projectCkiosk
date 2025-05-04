<?php
session_start();

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
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    public function getConnection()
    {
        return $this->connection;
    }
    public function admin_account() {
    // Ensure the session ID is available
    $user_id = $_SESSION['id'] ?? null; // Get user ID from session

    if ($user_id === null) {
        throw new Exception("Session variable 'id' is not set.");
    }

    // Prepare the SQL statement with a JOIN to fetch the orgname
    $sql = "SELECT u.*, o.org_name 
            FROM users_tbl u
            LEFT JOIN organization_tbl o ON u.users_org = o.org_id
            WHERE u.users_id = :user_id"; // Perform a LEFT JOIN with the organization table

    try {
        $stmt = $this->connection->prepare($sql); // Prepare the statement
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);

        // Execute the statement
        $stmt->execute();

        // Fetch the result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if a record was found and handle null values
        if ($result) {
            // Ensure all values are non-null for fields where htmlspecialchars will be applied
            foreach ($result as $key => $value) {
                $result[$key] = $value ?? ''; // Default to empty string if null
            }
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
                                        }  elseif ($row['users_type'] == 0 || $row['users_type'] == 1 || $row['users_type'] == 4) { 
                                            // User type 0 or 1 - allow login
                                            $_SESSION['aid'] = $row['users_id'];
                                            $_SESSION['id'] = $row['users_id'];
                                            $_SESSION['auname'] = $row['users_username'];
                                            $_SESSION['atype'] = $row['users_type'];
            
                                            // Update is_active and last_active fields
                                            $update_sql = "UPDATE users_tbl SET is_active = 1, last_active = NOW() WHERE users_id = :user_id";
                                            if ($update_stmt = $this->connection->prepare($update_sql)) {
                                                $update_stmt->bindParam(":user_id", $row['users_id'], PDO::PARAM_INT);
                                                $update_stmt->execute();
                                            }
            
                                            // Redirect to dashboard or appropriate page
                                            header('Location: dashboard.php');
                                            exit();
                                        } else {
                                            // Handle other user types if necessary
                                            $log_msg['msg'] = "You do not have permission to access the admin area.";
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
                                $input_hash = hash('sha256', $password);

                                if ($input_hash === $stored_hash) {
                                    if ($row['users_type'] == 1) {
                                        $log_msg['msg'] = "You are not an Organization.";
                                    } else {
                                    
                                        $_SESSION['aid'] = $row['users_id'];
                                        $_SESSION['id'] = $row['users_id'];
                                        $_SESSION['auname'] = $row['users_username'];
                                        $_SESSION['atype'] = $row['users_type'];

                                        $update_sql = "UPDATE users_tbl SET is_active = 1, last_active = NOW() WHERE users_id = :user_id";
                                        if ($update_stmt = $this->connection->prepare($update_sql)) {
                                            $update_stmt->bindParam(":user_id", $row['users_id'], PDO::PARAM_INT);
                                            $update_stmt->execute();
                                        }

                                        header('Location: dashboard.php');
                                        exit();
                                    }
                                } else {
                                    $log_msg['msg'] = "Invalid username or password.";
                                }
                            }
                        } else {
                            $sql = "SELECT * FROM orgmembers_tbl WHERE username = :username";
                            if ($stmt = $this->connection->prepare($sql)) {
                                $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
                                $param_username = $username;

                                if ($stmt->execute()) {
                                    if ($stmt->rowCount() == 1) {
                                        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            $stored_hash = $row["password"];
                                            $input_hash = hash('sha256', $password);

                                            if ($input_hash === $stored_hash) {
                                                
                                                $_SESSION['aid'] = $row['id'];
                                                $_SESSION['id'] = $row['id'];
                                                $_SESSION['auname'] = $row['username'];
                                                $_SESSION['atype'] = $row['users_type'];

                                                $org_type = $row['org_type'];
                                                $userSql = "SELECT users_id FROM users_tbl WHERE users_org = :org_type";
                                                $userStmt = $this->connection->prepare($userSql);
                                                $userStmt->bindParam(':org_type', $org_type, PDO::PARAM_INT);

                                                if ($userStmt->execute()) {
                                                    if ($userRow = $userStmt->fetch(PDO::FETCH_ASSOC)) {
                                                        $_SESSION['aid'] = $userRow['users_id'];
                                                    } else {
                                                        $log_msg['msg'] = "No matching user ID found for the organization.";
                                                    }
                                                } else {
                                                    $log_msg['msg'] = "Error fetching users ID from users_tbl.";
                                                }

                                                $update_org_sql = "UPDATE orgmembers_tbl SET is_active = 1, last_active = NOW() WHERE id = :user_id";
                                                if ($update_org_stmt = $this->connection->prepare($update_org_sql)) {
                                                    $update_org_stmt->bindParam(":user_id", $row['id'], PDO::PARAM_INT);
                                                    $update_org_stmt->execute();
                                                }

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
                        }
                    }
                }
            }

            return $log_msg;
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
        $previousImages = $data['previous_images'] ?? []; // Array of previously uploaded images
    
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
    
                            // Add previously uploaded images if no new images are selected
                            previousImages.forEach(function(image) {
                                formData.append("previous_images[]", image); // Include previously uploaded images
                            });
    
                            // Handle new image uploads
                            var annImgs = document.querySelector("input[name=ann_imgs]");
                            if (annImgs && annImgs.files.length > 0) {
                                for (var i = 0; i < annImgs.files.length; i++) {
                                    formData.append("ann_imgs[]", annImgs.files[i]); // Append each new image
                                }
                            }
    
                            // Handle removed images
                            var removedImages = []; // Initialize an array for removed images
                     
                            document.querySelectorAll("input[name=\'removed_images[]\']:checked").forEach(function(input) {
                                removedImages.push(input.value); // Collect the values of removed images
                            });
                            formData.append("removed_images", JSON.stringify(removedImages)); // Send as JSON
    
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
        // Archive request
        if (isset($_GET['archive_id'])) {
            $appID = $_GET['archive_id'];
            $result = $this->archive_announcement($appID);
            echo $result;
            exit();
        }
    
        // Restore request
        if (isset($_GET['restore_id'])) {
            $appID = $_GET['restore_id'];
            $result = $this->restore_announcement($appID);
            echo $result;
            exit();
        }
    
        // Delete request
        if (isset($_GET['delete_id'])) {
            $appID = $_GET['delete_id'];
            $result = $this->delete_announcement($appID);
            echo $result;
            exit();
        }
    }
    
    
    function delete_announcement($appID) {
        // Fetch editor's name for audit trail
        $editor_id = $_SESSION['id'] ?? '';
        $editor_stmt = $this->connection->prepare("SELECT users_username FROM users_tbl WHERE users_id = :editor_id");
        $editor_stmt->execute([':editor_id' => $editor_id]);
        $editor_name = $editor_stmt->fetchColumn() ?: 'Unknown User';
    
        // Fetch announcement details for logging
        $announcement_stmt = $this->connection->prepare("SELECT announcement_title FROM announcement_tbl WHERE announcement_id = :appID");
        $announcement_stmt->execute([':appID' => $appID]);
        $announcement_title = $announcement_stmt->fetchColumn();
    
        // Delete announcement query
        $query = "DELETE FROM announcement_tbl WHERE announcement_id = :appID";
        $statement = $this->connection->prepare($query);
    
        if ($statement->execute([':appID' => $appID])) {
            // Log the delete action to audit trail with action type and message
            $audit_message = "{$editor_name} deleted an announcement (Title: {$announcement_title})";
            $audit_action = 'delete';  // Action indicating that something was deleted
    
            // Insert audit trail with action and message
            $audit_stmt = $this->connection->prepare("INSERT INTO audit_trail (message, actions) VALUES (:message, :actions)");
            $audit_stmt->execute([
                ':message' => $audit_message,
                ':actions' => $audit_action
            ]);
    
            // Success message
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
                        title: "Announcement deleted successfully"
                    }).then((result) => {
                        document.location = "announcement.php"; // Redirect to the announcement page
                    });
                    </script>';
        } else {
            // Failure message
            return '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: "Failed to delete the announcement."
                    });
                    </script>';
        }
    }
    
    function restore_announcement($appID) {
        // Fetch editor's name for audit trail
        $editor_id = $_SESSION['id'] ?? ''; 
        $editor_stmt = $this->connection->prepare("SELECT users_username FROM users_tbl WHERE users_id = :editor_id");
        $editor_stmt->execute([':editor_id' => $editor_id]);
        $editor_name = $editor_stmt->fetchColumn() ?: 'Unknown User';
        
        // Check for the announcement
        $announcement_stmt = $this->connection->prepare("SELECT announcement_details FROM announcement_tbl WHERE announcement_id = :appID");
        $announcement_stmt->execute([':appID' => $appID]);
        $announcement_details = $announcement_stmt->fetchColumn();
        
        // Restore the announcement by updating the archive status
        $query = "UPDATE announcement_tbl SET is_archived = 0 WHERE announcement_id = :appID";
        $statement = $this->connection->prepare($query);
        
        if ($statement->execute(['appID' => $appID])) {
            // Log audit trail with action and message
            $audit_message = "{$editor_name} restored an announcement (Details: {$announcement_details})";
            $audit_action = 'restore';  // Action indicating the restoration
            
            // Insert audit trail with action and message
            $audit_stmt = $this->connection->prepare("INSERT INTO audit_trail (message, actions) VALUES (:message, :actions)");
            $audit_stmt->execute([
                ':message' => $audit_message,
                ':actions' => $audit_action
            ]);
            
            return '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Announcement restored successfully",
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    }).then(() => {
                        document.location = "announcement.php"; // Redirect to the announcement page
                    });
                    </script>';
        } else {
            return '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: "Failed to restore the announcement."
                    });
                    </script>';
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
    function archive_announcement($appID) {
        // First, fetch the editor's name for the audit trail
        $editor_id = $_SESSION['id'] ?? ''; 
        $editor_stmt = $this->connection->prepare("SELECT users_username FROM users_tbl WHERE users_id = :editor_id");
        $editor_stmt->execute([':editor_id' => $editor_id]);
        $editor_name = $editor_stmt->fetchColumn() ?: 'Unknown User';
        
        // Fetch the announcement details to be archived
        $announcement_stmt = $this->connection->prepare("SELECT announcement_details FROM announcement_tbl WHERE announcement_id = :appID");
        $announcement_stmt->execute([':appID' => $appID]);
        $announcement_details = $announcement_stmt->fetchColumn();
        
        // Prepare the archive query
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
            // Log the archiving action to audit trail with action type and message
            $audit_message = "{$editor_name} archived an announcement (Details: {$announcement_details})";
            $audit_action = 'archive';  // Action indicating that something was archived
            
            // Insert audit trail with action and message
            $audit_stmt = $this->connection->prepare("INSERT INTO audit_trail (message, actions) VALUES (:message, :actions)");
            $audit_stmt->execute([
                ':message' => $audit_message,
                ':actions' => $audit_action
            ]);
            
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
    function show_announcement()
{
    try {
        // Fetch the user's ID from session
        $userId = isset($_SESSION['aid']) ? intval($_SESSION['aid']) : 0;
        
        // If user ID is 1 (admin), show all announcements without organization filter
        if ($userId == 1) {
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
                LEFT JOIN users_tbl c ON a.created_by = c.users_id  
                LEFT JOIN organization_tbl o ON u.users_org = o.org_id
                WHERE a.is_archived = 0
            ";
            
            $statement = $this->connection->prepare($query);
            
        } else {
            // For regular users, fetch their organization ID first
            $orgQuery = "SELECT users_org FROM users_tbl WHERE users_id = :userId";
            $orgStatement = $this->connection->prepare($orgQuery);
            $orgStatement->bindValue(':userId', $userId, PDO::PARAM_INT);
            $orgStatement->execute();
            $orgRow = $orgStatement->fetch(PDO::FETCH_ASSOC);
        
            // Safely escape the organization ID
            $userOrgId = $orgRow ? intval($orgRow['users_org']) : 0;
        
            // If the user has no organization, return an empty result
            if ($userOrgId == 0) {
                return []; // Return empty array if no organization is found
            }
        
            // Regular user query, filtered by organization
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
                LEFT JOIN users_tbl c ON a.created_by = c.users_id 
                LEFT JOIN organization_tbl o ON u.users_org = o.org_id
                WHERE u.users_org = :userOrgId AND a.is_archived = 0
            ";
            
            $statement = $this->connection->prepare($query);
            $statement->bindValue(':userOrgId', $userOrgId, PDO::PARAM_INT);
        }

        if ($statement->execute()) {
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            // Process the result set
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
                    $row['creator_name'] = $fallbackRow ? htmlspecialchars($fallbackRow['name'], ENT_QUOTES, 'UTF-8') : 'Unknown';
                } else {
                    // Sanitize creator name from users_tbl
                    $row['creator_name'] = htmlspecialchars($row['creator_name'], ENT_QUOTES, 'UTF-8');
                }
            }
            return $result;
        } else {
            return [];
        }
    } catch (Exception $e) {
        error_log('Error fetching announcements: ' . $e->getMessage());
        return [];
    }
}
function show_archived_announcements()
{
    try {
        // Fetch the user's ID from session
        $userId = isset($_SESSION['aid']) ? intval($_SESSION['aid']) : 0;
        
        // If user ID is 1 (admin), show all archived announcements without organization filter
        if ($userId == 1) {
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
                LEFT JOIN users_tbl c ON a.created_by = c.users_id  
                LEFT JOIN organization_tbl o ON u.users_org = o.org_id
                WHERE a.is_archived = 1
            ";
            
            $statement = $this->connection->prepare($query);
            
        } else {
            // For regular users, fetch their organization ID first
            $orgQuery = "SELECT users_org FROM users_tbl WHERE users_id = :userId";
            $orgStatement = $this->connection->prepare($orgQuery);
            $orgStatement->bindValue(':userId', $userId, PDO::PARAM_INT);
            $orgStatement->execute();
            $orgRow = $orgStatement->fetch(PDO::FETCH_ASSOC);
        
            // Safely escape the organization ID
            $userOrgId = $orgRow ? intval($orgRow['users_org']) : 0;
        
            // If the user has no organization, return an empty result
            if ($userOrgId == 0) {
                return []; // Return empty array if no organization is found
            }
        
            // Regular user query, filtered by organization
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
                LEFT JOIN users_tbl c ON a.created_by = c.users_id 
                LEFT JOIN organization_tbl o ON u.users_org = o.org_id
                WHERE u.users_org = :userOrgId AND a.is_archived = 1
            ";
            
            $statement = $this->connection->prepare($query);
            $statement->bindValue(':userOrgId', $userOrgId, PDO::PARAM_INT);
        }

        if ($statement->execute()) {
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            // Process the result set
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
                    $row['creator_name'] = $fallbackRow ? htmlspecialchars($fallbackRow['name'], ENT_QUOTES, 'UTF-8') : 'Unknown';
                } else {
                    // Sanitize creator name from users_tbl
                    $row['creator_name'] = htmlspecialchars($row['creator_name'], ENT_QUOTES, 'UTF-8');
                }
            }
            return $result;
        } else {
            return [];
        }
    } catch (Exception $e) {
        error_log('Error fetching archived announcements: ' . $e->getMessage());
        return [];
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
    // First, fetch the editor's name for the audit trail
    $editor_id = $_SESSION['id'] ?? ''; 
    $editor_stmt = $this->connection->prepare("SELECT users_username FROM users_tbl WHERE users_id = :editor_id");
    $editor_stmt->execute([':editor_id' => $editor_id]);
    $editor_name = $editor_stmt->fetchColumn() ?: 'Unknown User';

    // Fetch the event details to be deleted
    $event_stmt = $this->connection->prepare("SELECT calendar_details FROM calendar_tbl WHERE calendar_id = :appID");
    $event_stmt->execute([':appID' => $appID]);
    $event_details = $event_stmt->fetchColumn();

    // Prepare the deletion query
    $query = "DELETE FROM calendar_tbl WHERE calendar_id = :appID";
    $statement = $this->connection->prepare($query);

    // Execute the deletion
    if ($statement->execute([':appID' => $appID])) {
        // Log the deletion in the audit trail with the editor's name, the deleted event's details, and action
        $audit_message = "{$editor_name} deleted an event: (Details - {$event_details})";
        $audit_action = 'delete';  // Action indicating that something was deleted
        
        // Insert audit trail with action and message
        $audit_stmt = $this->connection->prepare("INSERT INTO audit_trail (message, actions) VALUES (:message, :actions)");
        $audit_stmt->execute([
            ':message' => $audit_message,
            ':actions' => $audit_action
        ]);

        // Return success message
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
                    document.location = "schoolcalendar.php"; // Redirect to the school calendar page
                });
            </script>';
    } else {
        // Return error message if deletion fails
        return '<script>
                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text: "Failed to delete the event."
                });
                </script>';
    }
}

function show_events()
{
    // Fetch the user's ID from session
    $userId = isset($_SESSION['aid']) ? intval($_SESSION['aid']) : 0;
    
    // If user ID is 1 (admin), show all events without organization filter
    if ($userId == 1) {
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
        ";
        
        $statement = $this->connection->prepare($query);
        
    } else {
        // For regular users, fetch their organization ID first
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
    
        // Regular user query, filtered by organization
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
    }

    if ($statement->execute()) {
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Process each event row
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
    $query = "SELECT calendar_id, calendar_start_date, calendar_end_date, calendar_details, 
                     DATE_FORMAT(calendar_start_date, '%m-%d') as monthDate 
              FROM calendar_tbl 
              ORDER BY calendar_start_date";
    $statement = $this->connection->prepare($query);

    $eventsByMonth = [];

    try {
        // Execute the query
        if ($statement->execute()) {
            // Fetch the results as an associative array
            $result = $statement->fetchAll(PDO::FETCH_ASSOC); 

            // If there are no events, return an empty array
            if (empty($result)) {
                return $eventsByMonth;
            }

            // Process the results
            foreach ($result as $event) {
                $eventDate = new DateTime($event['calendar_start_date']);
                $monthYear = $eventDate->format('F Y');

                // Initialize the month array if it doesn't exist
                if (!isset($eventsByMonth[$monthYear])) {
                    $eventsByMonth[$monthYear] = [];
                }

                // Add the event to the corresponding month
                $eventsByMonth[$monthYear][] = $event;
            }

            // Sort the months chronologically
            ksort($eventsByMonth);
            return $eventsByMonth;
        } else {
            throw new Exception("Failed to execute the query.");
        }
    } catch (Exception $e) {
        // Handle any errors or exceptions
        echo "Error: " . $e->getMessage();
        return []; // Always return an empty array on failure
    }
}


   function add_faculty_member($data) {
    // Ensure faculty_name and department are treated as strings
    $name = is_array($data['faculty_name'] ?? null) ? implode(', ', $data['faculty_name']) : ($data['faculty_name'] ?? '');
    $dept = is_array($data['department'] ?? null) ? implode(', ', $data['department']) : ($data['department'] ?? '');

    // Sanitize the values
    $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    $dept = htmlspecialchars($dept, ENT_QUOTES, 'UTF-8');

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
    // First, fetch the editor's name for the audit trail
    $editor_id = $_SESSION['id'] ?? ''; 
    $editor_stmt = $this->connection->prepare("SELECT users_username FROM users_tbl WHERE users_id = :editor_id");
    $editor_stmt->execute([':editor_id' => $editor_id]);
    $editor_name = $editor_stmt->fetchColumn() ?: 'Unknown User';

  // Fetch the faculty member's details to be deleted
$faculty_stmt = $this->connection->prepare("SELECT faculty_name FROM faculty_tbl WHERE faculty_id = :appID");
$faculty_stmt->execute([':appID' => $appID]);
$faculty_details = $faculty_stmt->fetchColumn();

// Temporarily disable foreign key checks
$this->connection->exec("SET FOREIGN_KEY_CHECKS = 0");

// Prepare the deletion query
$query = "DELETE FROM faculty_tbl WHERE faculty_id = :appID";
$statement = $this->connection->prepare($query);

// Execute the deletion
if ($statement->execute(['appID' => $appID])) {
    // Log the deletion in the audit trail with the editor's name and the deleted faculty's details
    $audit_message = "{$editor_name} deleted a faculty member: (Name - {$faculty_details})";

    $audit_action = 'delete';  // Action indicating that something was deleted
    
    // Insert audit trail with action and message
    $audit_stmt = $this->connection->prepare("INSERT INTO audit_trail (message, actions) VALUES (:message, :actions)");
    $audit_stmt->execute([
        ':message' => $audit_message,
        ':actions' => $audit_action
    ]);
    // Re-enable foreign key checks
    $this->connection->exec("SET FOREIGN_KEY_CHECKS = 1");

    // Return success message
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
                document.location = "facultymembers.php"; // Redirect to the faculty members page
            });
        </script>';
} else {
    // Re-enable foreign key checks in case of error
    $this->connection->exec("SET FOREIGN_KEY_CHECKS = 1");

    // Return error message if deletion fails
    return '<script>
            Swal.fire({
                icon: "error",
                title: "Error!",
                text: "Failed to delete the faculty member."
            });
        </script>';
}

}

function show_facultyheads($department_ids = null)
{
    // Base query to get faculty members and their associated departments
    $query = "SELECT f.*, GROUP_CONCAT(d.department_name SEPARATOR ', ') AS departments
              FROM faculty_tbl f
              LEFT JOIN faculty_departments_tbl fd ON f.faculty_id = fd.faculty_id
              LEFT JOIN department_tbl d ON fd.department_id = d.department_id";

    // Add condition to filter by departments if provided
    if ($department_ids) {
        // Create a placeholder string for the IN clause
        $placeholders = rtrim(str_repeat('?,', count($department_ids)), ',');
        $query .= " WHERE fd.department_id IN ($placeholders)";
    }

    // Group by faculty to ensure we get each faculty member with their departments concatenated
    $query .= " GROUP BY f.faculty_id";

    // Prepare the statement
    $statement = $this->connection->prepare($query);

    // Bind department IDs if filtering by departments
    if ($department_ids) {
        foreach ($department_ids as $key => $id) {
            $statement->bindValue($key + 1, $id, PDO::PARAM_INT); // Bind department IDs
        }
    }

    // Execute query
    if ($statement->execute()) {
        $result = $statement->fetchAll();
        return $result;
    } else {
        return "No Data";
    }
}function show_facultymembers($department_ids = null)
{
    // Base query to get faculty members, joining with faculty_departments_tbl to get department IDs
    $query = "SELECT f.*, GROUP_CONCAT(d.department_name SEPARATOR ', ') AS departments 
              FROM faculty_tbl f
              LEFT JOIN faculty_departments_tbl fd ON f.faculty_id = fd.faculty_id
              LEFT JOIN department_tbl d ON fd.department_id = d.department_id";  // Correct join for departments

    // Add condition to filter by departments if provided
    if ($department_ids) {
        // Create a placeholder string for the IN clause
        $placeholders = rtrim(str_repeat('?,', count($department_ids)), ',');
        $query .= " WHERE fd.department_id IN ($placeholders)";  // Filter by department IDs
    }

    // Group by faculty_id to ensure unique faculty records
    $query .= " GROUP BY f.faculty_id";

    // Prepare the statement
    $statement = $this->connection->prepare($query);

    // Bind department IDs if filtering by departments
    if ($department_ids) {
        foreach ($department_ids as $key => $id) {
            $statement->bindValue($key + 1, $id, PDO::PARAM_INT); // Bind department IDs
        }
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
    $name = htmlspecialchars(trim($data['org_name']), ENT_QUOTES, 'UTF-8'); // Sanitize and trim org_name
    $previous = $data['previous']; // No need to sanitize previous image

    // Check for duplicate organization name
    $duplicateQuery = "SELECT COUNT(*) FROM organization_tbl WHERE TRIM(LOWER(org_name)) = TRIM(LOWER(:org_name)) AND org_id != :oid";
    $duplicateStatement = $this->connection->prepare($duplicateQuery);
    $duplicateStatement->execute([':org_name' => $name, ':oid' => $oid]);
    $duplicateCount = $duplicateStatement->fetchColumn();

    if ($duplicateCount > 0) {
        return '<script>
            Swal.fire({
                icon: "error",
                title: "Duplicate Organization Name",
                text: "An organization with this name already exists.",
                timer: 2000,
                timerProgressBar: true
            });
        </script>';
    }

    $newImage = "";

    // Handle image upload
    if (isset($_FILES['org_image']) && $_FILES['org_image']['error'] === UPLOAD_ERR_OK) {
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
        error_log('Update failed: ' . implode(", ", $statement->errorInfo()), 3, '../error_log.txt');
        return '<script>
            Swal.fire({
                icon: "error",
                title: "Update Failed",
                text: "There was an error updating the organization. Please try again.",
                timer: 2000,
                timerProgressBar: true
            });
        </script>';
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
    // First, fetch the editor's name for the audit trail
    $editor_id = $_SESSION['id'] ?? ''; 
    $editor_stmt = $this->connection->prepare("SELECT users_username FROM users_tbl WHERE users_id = :editor_id");
    $editor_stmt->execute([':editor_id' => $editor_id]);
    $editor_name = $editor_stmt->fetchColumn() ?: 'Unknown User';

    // Check if the organization has user_type = 1 (admin)
    $type_stmt = $this->connection->prepare("SELECT user_type, org_name FROM organization_tbl WHERE org_id = :appID");
    $type_stmt->execute([':appID' => $appID]);
    $org_info = $type_stmt->fetch(PDO::FETCH_ASSOC);

    if ($org_info['user_type'] == 1) {
        // Return error message if user_type is 1 (admin)
        return '<script>
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Admin organizations cannot be deleted."
                });
            </script>';
    }

    // Proceed with deletion if user_type is not 1 (not admin)
    $query = "DELETE FROM organization_tbl WHERE org_id = :appID";
    $statement = $this->connection->prepare($query);

    if ($statement->execute(['appID' => $appID])) {
        // Log the deletion in the audit trail
        $audit_message = "{$editor_name} deleted an organization: (Organization Name - {$org_info['org_name']})";
        $audit_action = 'delete';  // Action indicating deletion

        // Insert audit trail with action and message
        $audit_stmt = $this->connection->prepare("INSERT INTO audit_trail (message, actions) VALUES (:message, :actions)");
        $audit_stmt->execute([
            ':message' => $audit_message,
            ':actions' => $audit_action
        ]);

        // Return success message
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
                    document.location = "organization.php"; // Redirect to the organization page
                });
            </script>';
    } else {
        // Return error message if deletion fails
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
    // First, fetch the editor's name for the audit trail
    $editor_id = $_SESSION['id'] ?? ''; 
    $editor_stmt = $this->connection->prepare("SELECT users_username FROM users_tbl WHERE users_id = :editor_id");
    $editor_stmt->execute([':editor_id' => $editor_id]);
    $editor_name = $editor_stmt->fetchColumn() ?: 'Unknown User';

    // Fetch the FAQ details to be deleted
    $faq_stmt = $this->connection->prepare("SELECT faqs_question FROM faqs_tbl WHERE faqs_id = :appID");
    $faq_stmt->execute([':appID' => $appID]);
    $faq_details = $faq_stmt->fetchColumn();

    // Prepare the deletion query
    $query = "DELETE FROM faqs_tbl WHERE faqs_id = :appID";
    $statement = $this->connection->prepare($query);

    // Execute the deletion
    if ($statement->execute(['appID' => $appID])) {
        // Log the deletion in the audit trail with the editor's name and the deleted FAQ's details
        $audit_message = "{$editor_name} deleted a FAQ: (Question - {$faq_details})";

        // Insert audit trail
        $audit_action = 'delete';  // Action indicating that something was deleted
    
        // Insert audit trail with action and message
        $audit_stmt = $this->connection->prepare("INSERT INTO audit_trail (message, actions) VALUES (:message, :actions)");
        $audit_stmt->execute([
            ':message' => $audit_message,
            ':actions' => $audit_action
        ]);

        // Return success message
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
                    document.location = "faqs.php"; // Redirect to the FAQs page
                });
            </script>';
    } else {
        // Return error message if deletion fails
        return '<script>
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Failed to delete the FAQ."
                });
            </script>';
    }
}
public function show_audit_trail()
{
    // Modify the query to select all entries and order them by created_at in descending order
    $query = "SELECT * FROM audit_trail ORDER BY created_at DESC";
    $statement = $this->connection->prepare($query);

    if ($statement->execute()) {
        $result = $statement->fetchAll(PDO::FETCH_ASSOC); // Fetch results as an associative array

        // Loop through each audit trail entry and sanitize the message
        foreach ($result as &$entry) {
            $entry['message'] = strip_tags($entry['message']); // Sanitize message
        }

        return $result;
    } else {
        return "No Data";
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
    }function save_account($data)
    {
        // Retrieve and sanitize data
        $uid = htmlspecialchars($data['uid'] ?? '', ENT_QUOTES, 'UTF-8'); // Use null coalescing operator to prevent undefined index
        $username = htmlspecialchars($data['username'] ?? '', ENT_QUOTES, 'UTF-8');
        $password = $data['password'] ?? '';
        $org_id = htmlspecialchars($data['org'] ?? '', ENT_QUOTES, 'UTF-8');
        $editor_id = $_SESSION['id'] ?? ''; 
        
        try {
            // Check if the username already exists (excluding the current user)
            $usernameCheckSql = "SELECT COUNT(*) FROM users_tbl WHERE users_username = :username AND users_id != :uid";
            $usernameCheckStmt = $this->connection->prepare($usernameCheckSql);
            $usernameCheckStmt->execute([':username' => $username, ':uid' => $uid]);
            $usernameCount = $usernameCheckStmt->fetchColumn();
    
            if ($usernameCount > 0) {
                return '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Invalid Username",
                        text: "The username is already taken.",
                        timer: 3000,
                        timerProgressBar: true
                    });
                </script>';
            }
    
            // Check if the user exists
            $sql = "SELECT users_password FROM users_tbl WHERE users_id = :uid";
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
                                window.history.back(); // Go back to the previous form/page
                            });
                        </script>';
                    }
    
                    // Hash the new password using SHA-256
                    $hashedPassword = hash('sha256', $password);
                } else {
                    // Keep the existing hashed password if no new password is provided
                    $hashedPassword = $existingPasswordHash;
                }
    
                // Update the user account
                $query = "UPDATE users_tbl 
                SET users_username = :username, users_password = :password, users_org = :org_id
                WHERE users_id = :uid";
                $statement = $this->connection->prepare($query);
    
                // Execute the update statement
                if ($statement->execute([
                    ":username" => $username,
                    ":password" => $hashedPassword,
                    ":org_id" => $org_id,
                    ":uid" => $uid
                ])) {
                    // Fetch editor's name
                    $editor_stmt = $this->connection->prepare("SELECT users_username FROM users_tbl WHERE users_id = :editor_id");
                    $editor_stmt->execute([':editor_id' => $editor_id]);
                    $editor_name = $editor_stmt->fetchColumn();
    
                    if (!$editor_name) {
                        // If not found in users_tbl, search in orgmembers_tbl
                        $editor_stmt = $this->connection->prepare("SELECT name FROM orgmembers_tbl WHERE id = :editor_id");
                        $editor_stmt->execute([':editor_id' => $editor_id]);
                        $editor_name = $editor_stmt->fetchColumn() ?: 'Unknown User';
                    }
    
                    // Get organization name
                    $org_stmt = $this->connection->prepare("SELECT org_name FROM organization_tbl WHERE org_id = :org_id");
                    $org_stmt->execute([':org_id' => $org_id]);
                    $org_name = $org_stmt->fetchColumn() ?: 'Unknown Organization';
    
                    // Create detailed audit message
                    $changes = [];
                    if (!empty($password)) {
                        $changes[] = "password was updated";
                    }
                    $changes[] = "username set to '{$username}'";
                    $changes[] = "organization set to '{$org_name}'";
    
                    $audit_message = "{$editor_name} updated account for user '{$username}' : " . implode(', ', $changes);
                    
                    // Insert audit trail
                    $audit_stmt = $this->connection->prepare("INSERT INTO audit_trail (message) VALUES (:message)");
                    $audit_stmt->execute([':message' => $audit_message]);
    
                    // Log the successful update
                    error_log("Account Update Success - Editor: {$editor_name} (ID: {$editor_id}), User: {$username} (ID: {$uid})");
    
                    // Return success message
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
                                    window.location.href = "organization.php";
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
        $editor_id = $_SESSION['id'] ?? ''; 
    
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
                                window.history.back(); 
                            });
                        </script>';
                    }
    
                    // Hash the new password using SHA-256 if all validations pass
                    $hashedPassword = hash('sha256', $password);
                } else {
                    $hashedPassword = $existingPasswordHash; // Keep the existing hashed password if no new password
                }
    
                // Check for duplicate username across both tables
                $usernameCheckSQL = "
                    SELECT id FROM orgmembers_tbl WHERE username = :username AND id != :uid
                    UNION
                    SELECT users_id FROM users_tbl WHERE users_username = :username
                ";
                $usernameCheckStmt = $this->connection->prepare($usernameCheckSQL);
                $usernameCheckStmt->bindParam(":username", $username, PDO::PARAM_STR);
                $usernameCheckStmt->bindParam(":uid", $uid, PDO::PARAM_INT);
                $usernameCheckStmt->execute();
                if ($usernameCheckStmt->rowCount() > 0) {
                    return '<script>
                        Swal.fire({
                            icon: "error",
                            title: "Username Taken",
                            text: "The username \'' . $username . '\' is already in use. Please choose another.",
                            timer: 5000,
                            timerProgressBar: true
                        }).then(() => {
                            window.history.back(); 
                        });
                    </script>';
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
                    // Fetch editor's name
                    $editor_stmt = $this->connection->prepare("SELECT users_username FROM users_tbl WHERE users_id = :editor_id");
                    $editor_stmt->execute([':editor_id' => $editor_id]);
                    $editor_name = $editor_stmt->fetchColumn();
    
                    if (!$editor_name) {
                        // If not found in users_tbl, search in orgmembers_tbl
                        $editor_stmt = $this->connection->prepare("SELECT name FROM orgmembers_tbl WHERE id = :editor_id");
                        $editor_stmt->execute([':editor_id' => $editor_id]);
                        $editor_name = $editor_stmt->fetchColumn() ?: 'Unknown User';
                    }
    
                    // Create detailed audit message
                    $changes = [];
                    if (!empty($password)) {
                        $changes[] = "password was updated";
                    }
                    $changes[] = "username set to '{$username}'";
                    $changes[] = "position set to '{$position}'";
                    $changes[] = "name set to '{$name}'";
    
                    $audit_message = "{$editor_name} updated account for user '{$username}' : " . implode(', ', $changes);
                    
                    // Insert audit trail
                    $audit_stmt = $this->connection->prepare("INSERT INTO audit_trail (message) VALUES (:message)");
                    $audit_stmt->execute([':message' => $audit_message]);
    
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
                                    window.location.href = "membersmanagement.php"; 
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

    // Assume editor ID is stored in session, replace with your actual logic
    $editor_id = $_SESSION['id']; // Get the editor ID from the session

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
            // Check if the username is already taken in orgmembers_tbl
            $usernameCheckOrgSql = "SELECT COUNT(*) FROM orgmembers_tbl WHERE username = :username AND id != :uid";
            $usernameCheckOrgStmt = $this->connection->prepare($usernameCheckOrgSql);
            $usernameCheckOrgStmt->bindParam(":username", $username, PDO::PARAM_STR);
            $usernameCheckOrgStmt->bindParam(":uid", $uid, PDO::PARAM_INT);
            $usernameCheckOrgStmt->execute();
            $usernameExistsInOrg = $usernameCheckOrgStmt->fetchColumn();

            // Check if the username is already taken in users_tbl
            $usernameCheckUsersSql = "SELECT COUNT(*) FROM users_tbl WHERE users_username = :username";
            $usernameCheckUsersStmt = $this->connection->prepare($usernameCheckUsersSql);
            $usernameCheckUsersStmt->bindParam(":username", $username, PDO::PARAM_STR);
            $usernameCheckUsersStmt->execute();
            $usernameExistsInUsers = $usernameCheckUsersStmt->fetchColumn();

            // Check if username exists in either table
            if ($usernameExistsInOrg > 0 || $usernameExistsInUsers > 0) {
                return '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Username Taken",
                        text: "The username is already in use. Please choose a different one.",
                        timer: 5000,
                        timerProgressBar: true
                    });
                </script>';
            }


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
                // Fetch editor's name
                $editor_stmt = $this->connection->prepare("SELECT users_username FROM users_tbl WHERE users_id = :editor_id");
                $editor_stmt->execute([':editor_id' => $editor_id]);
                $editor_name = $editor_stmt->fetchColumn();

                if (!$editor_name) {
                    // If not found in users_tbl, search in orgmembers_tbl
                    $editor_stmt = $this->connection->prepare("SELECT name FROM orgmembers_tbl WHERE id = :editor_id");
                    $editor_stmt->execute([':editor_id' => $editor_id]);
                    $editor_name = $editor_stmt->fetchColumn() ?: 'Unknown User';
                }

                // Create detailed audit message
                $changes = [];
                if (!empty($password)) {
                    $changes[] = "password was updated";
                }
                $changes[] = "username set to '{$username}'";
                $changes[] = "name set to '{$name}'";

                $audit_message = "{$editor_name} updated his account '{$username}' : " . implode(', ', $changes);
                
                // Insert audit trail
                $audit_stmt = $this->connection->prepare("INSERT INTO audit_trail (message) VALUES (:message)");
                $audit_stmt->execute([':message' => $audit_message]);

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
        error_log("Exception caught while saving profile: " . $e->getMessage());
        return '<script>
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "An unexpected error occurred. Please try again.",
                timer: 3000,
                timerProgressBar: true
            });
        </script>';
    }
}
function delete_account($appID)
{
    // First, fetch the editor's name for the audit trail
    $editor_id = $_SESSION['id'] ?? ''; 
    $editor_stmt = $this->connection->prepare("SELECT users_username FROM users_tbl WHERE users_id = :editor_id");
    $editor_stmt->execute([':editor_id' => $editor_id]);
    $editor_name = $editor_stmt->fetchColumn();

    if (!$editor_name) {
        // If not found in users_tbl, search in orgmembers_tbl
        $editor_stmt = $this->connection->prepare("SELECT name FROM orgmembers_tbl WHERE id = :editor_id");
        $editor_stmt->execute([':editor_id' => $editor_id]);
        $editor_name = $editor_stmt->fetchColumn() ?: 'Unknown User';
    }

    // Fetch the username of the account to be deleted
    $account_stmt = $this->connection->prepare("SELECT users_username FROM users_tbl WHERE users_id = :appID");
    $account_stmt->execute([':appID' => $appID]);
    $account_username = $account_stmt->fetchColumn();

    // Prepare the deletion query
    $query = "DELETE FROM users_tbl WHERE users_id = :appID";
    $statement = $this->connection->prepare($query);

    // Execute the deletion
    if ($statement->execute(['appID' => $appID])) {
        // Log the deletion in the audit trail with the editor's name and the deleted account's username
        $audit_message = "{$editor_name} deleted an account: (Username - {$account_username})";
        
        $audit_action = 'delete';  // Action indicating that something was deleted
    
    // Insert audit trail with action and message
    $audit_stmt = $this->connection->prepare("INSERT INTO audit_trail (message, actions) VALUES (:message, :actions)");
    $audit_stmt->execute([
        ':message' => $audit_message,
        ':actions' => $audit_action
    ]);
        // Return success message
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
                    document.location = "organization.php"; // Redirect to the organization page
                });
            </script>';
    } else {
        // Return error message if deletion fails
        return '<script>
                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text: "Failed to delete the user account."
                });
            </script>';
    }
}



function show_account()
{
    $query = "SELECT * FROM users_tbl WHERE users_id NOT IN (1, 2)";
    $statement = $this->connection->prepare($query);

    if ($statement->execute()) {
        $result = $statement->fetchAll();
        return $result;
    } else {
        return "No Data";
    }
}

    function show_ratings()
{
    $query = "SELECT * FROM feedback";  // Assuming the table name is 'ratings'
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
    // First, fetch the editor's name for the audit trail
    $editor_id = $_SESSION['id'] ?? ''; 
    $editor_stmt = $this->connection->prepare("SELECT users_username FROM users_tbl WHERE users_id = :editor_id");
    $editor_stmt->execute([':editor_id' => $editor_id]);
    $editor_name = $editor_stmt->fetchColumn();

    if (!$editor_name) {
        // If not found in users_tbl, search in orgmembers_tbl
        $editor_stmt = $this->connection->prepare("SELECT name FROM orgmembers_tbl WHERE id = :editor_id");
        $editor_stmt->execute([':editor_id' => $editor_id]);
        $editor_name = $editor_stmt->fetchColumn() ?: 'Unknown User';
    }

    // Fetch the name of the member account to be deleted
    $member_stmt = $this->connection->prepare("SELECT name FROM orgmembers_tbl WHERE id = :appID");
    $member_stmt->execute([':appID' => $appID]);
    $member_name = $member_stmt->fetchColumn();

    // Prepare the deletion query
    $query = "DELETE FROM orgmembers_tbl WHERE id = :appID";
    $statement = $this->connection->prepare($query);

    // Execute the deletion
    if ($statement->execute(['appID' => $appID])) {
        // Log the deletion in the audit trail with the editor's name and the deleted member's name
        $audit_message = "{$editor_name} deleted a member account: (Name - {$member_name})";
        
        $audit_action = 'delete';  // Action indicating that something was deleted
    
        // Insert audit trail with action and message
        $audit_stmt = $this->connection->prepare("INSERT INTO audit_trail (message, actions) VALUES (:message, :actions)");
        $audit_stmt->execute([
            ':message' => $audit_message,
            ':actions' => $audit_action
        ]);

        // Return success message
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
                    document.location = "membersmanagement.php"; // Redirect to the members management page
                });
            </script>';
    } else {
        // Return error message if deletion fails
        return '<script>
                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text: "Failed to delete the member account."
                });
            </script>';
    }
}
public function getFacultyByDepartment($department_id)
{
    // Query to fetch faculty data with departments
    $query = "
        SELECT f.faculty_id, f.faculty_name, f.faculty_image, f.specialization, f.consultation_time, d.department_name
        FROM faculty_tbl f
        JOIN faculty_departments_tbl fd ON f.faculty_id = fd.faculty_id
        JOIN department_tbl d ON fd.department_id = d.department_id
        WHERE fd.department_id = :department_id
    ";
    
    // Prepare and execute the SQL statement
    $stmt = $this->connection->prepare($query);
    $stmt->bindValue(':department_id', $department_id, PDO::PARAM_INT);
    $stmt->execute();
    
    // Fetch all results into an associative array
    $facultyData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Group the results by faculty_id
    $facultyWithDepartments = [];
    
    foreach ($facultyData as $row) {
        $faculty_id = $row['faculty_id'];
        if (!isset($facultyWithDepartments[$faculty_id])) {
            $facultyWithDepartments[$faculty_id] = [
                'faculty_name' => $row['faculty_name'],
                'faculty_image' => $row['faculty_image'],
                'specialization' => $row['specialization'],
                'consultation_time' => $row['consultation_time'],
                'departments' => []
            ];
        }
        // Add department to the faculty's departments array
        $facultyWithDepartments[$faculty_id]['departments'][] = $row['department_name'];
    }

    return $facultyWithDepartments;
}

public function show_allit($department_id)
{
    return $this->getFacultyByDepartment($department_id);
}

public function show_allItHeads($department_id)
{
    return $this->getFacultyByDepartment($department_id);
}

public function show_allmit($department_id)
{
    return $this->getFacultyByDepartment($department_id);
}
public function show_dean($department_id)
{
    return $this->getFacultyByDepartment($department_id);
}

public function all_assist($department_id)
{
    return $this->getFacultyByDepartment($department_id);
}public function all_mem(array $department_ids)
{
    $facultyData = [];

    // Loop through each department ID and merge the faculty data
    foreach ($department_ids as $department_id) {
        $facultyData = array_merge($facultyData, $this->getFacultyByDepartment($department_id));
    }

    return $facultyData;
}

public function show_allMitHeads($department_id)
{
    return $this->getFacultyByDepartment($department_id);
}

public function show_allcs($department_id)
{
    return $this->getFacultyByDepartment($department_id);
}

public function show_allCsHeads($department_id)
{
    return $this->getFacultyByDepartment($department_id);
}

public function show_allis($department_id)
{
    return $this->getFacultyByDepartment($department_id);
}

public function show_allIsHeads($department_id)
{
    return $this->getFacultyByDepartment($department_id);
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
public function show_allFAQs()
{
    try {
        $query = "SELECT * FROM faqs_tbl"; // Adjust the table name as per your schema
        $statement = $this->connection->prepare($query);

        if ($statement->execute()) {
            $faqs = $statement->fetchAll(PDO::FETCH_ASSOC);
            
            // Check if there are any FAQs found
            if (!empty($faqs)) {
                return $faqs;
            } else {
                return "No FAQs found.";
            }
        } else {
            return false; // Query execution failed
        }
    } catch (PDOException $e) {
        return "Database error: " . $e->getMessage();
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
// Function to show all offices
public function show_offices() {
    try {
        $query = "SELECT * FROM offices ORDER BY office_name ASC";
        $statement = $this->connection->prepare($query);

        if ($statement->execute()) {
            $offices = $statement->fetchAll(PDO::FETCH_ASSOC);
            
            // Check if there are any offices found
            if (!empty($offices)) {
                return $offices;
            } else {
                return [];
            }
        } else {
            return [];
        }
    } catch (PDOException $e) {
        error_log("Error fetching offices: " . $e->getMessage());
        return [];
    }
}
// Function to add a new office
public function add_office($data) {
    try {
        $stmt = $this->connection->prepare("INSERT INTO offices (office_name, office_location, office_contact, office_email, office_hours, office_services, office_description, created_by) VALUES (:office_name, :office_location, :office_contact, :office_email, :office_hours, :office_services, :office_description, :created_by)");
        
        $stmt->bindParam(':office_name', $data['office_name']);
        $stmt->bindParam(':office_location', $data['office_location']);
        $stmt->bindParam(':office_contact', $data['office_contact']);
        $stmt->bindParam(':office_email', $data['office_email']);
        $stmt->bindParam(':office_hours', $data['office_hours']);
        $stmt->bindParam(':office_services', $data['office_services']);
        $stmt->bindParam(':office_description', $data['office_description']);
        $stmt->bindParam(':created_by', $data['uid']);
        
        $stmt->execute();
        return "Office added successfully!";
    } catch (PDOException $e) {
        error_log("Error adding office: " . $e->getMessage());
        return "Error: " . $e->getMessage();
    }
}

// Function to save/update an office
public function save_office($data) {
    try {
        $stmt = $this->connection->prepare("UPDATE offices SET 
            office_name = :office_name, 
            office_location = :office_location, 
            office_contact = :office_contact, 
            office_email = :office_email, 
            office_hours = :office_hours, 
            office_services = :office_services, 
            office_description = :office_description, 
            updated_by = :updated_by, 
            updated_at = NOW() 
            WHERE office_id = :office_id");
        
        $stmt->bindParam(':office_name', $data['office_name']);
        $stmt->bindParam(':office_location', $data['office_location']);
        $stmt->bindParam(':office_contact', $data['office_contact']);
        $stmt->bindParam(':office_email', $data['office_email']);
        $stmt->bindParam(':office_hours', $data['office_hours']);
        $stmt->bindParam(':office_services', $data['office_services']);
        $stmt->bindParam(':office_description', $data['office_description']);
        $stmt->bindParam(':updated_by', $data['editor_id']);
        $stmt->bindParam(':office_id', $data['office_id']);
        
        $stmt->execute();
        return "Office updated successfully!";
    } catch (PDOException $e) {
        error_log("Error updating office: " . $e->getMessage());
        return "Error: " . $e->getMessage();
    }
}

// Function to delete an office
public function delete_office($office_id) {
    try {
        $stmt = $this->connection->prepare("DELETE FROM offices WHERE office_id = :office_id");
        $stmt->bindParam(':office_id', $office_id);
        $stmt->execute();
        return "Office deleted successfully!";
    } catch (PDOException $e) {
        error_log("Error deleting office: " . $e->getMessage());
        return "Error: " . $e->getMessage();
    }
}
}
?>