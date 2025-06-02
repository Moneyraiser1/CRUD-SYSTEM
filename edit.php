<?php 
    include 'includes/header.php'; 
    include 'Controller/Users.php'; 
    $user = new Users(); 
    $db = new Database();
?>
<div class="container mt-5 p-2">
    <a href="index.php" class="btn btn-dark">Back</a>
<?php 
if (isset($_GET['edit'])): 
    $id = $_GET['edit']; 
    $userData = $user->showOneUsers($id); 
 
if (!$userData): ?> 
     <div class="alert alert-danger">User not found!</div> 
 <?php  else: ?> 
<div class="row justify-content-center">
        <div class="col-md-6">
        <form class="form-control mt-5" method="POST" action=""> 
                <h4 class="text-center mt-3">Edit user</h4> 
                <input type="hidden" name="id" value="<?= $userData['id']; ?>"> 
                <div> 
                    <label for="fname" class="col-sm-3 col-form-label">First name:</label> 
                    <div> 
                        <input type="text" class="form-control" name="fname" value="<?= validateUser($userData['fname']); ?>"> 
                    </div> 
                </div> 
                <div> 
                    <label for="lname" class="col-sm-3 col-form-label">Last name:</label> 
                    <div> 
                        <input type="text" class="form-control" name="lname" value="<?= validateUser($userData['lname']); ?>"> 
                    </div> 
                </div> 
                <div> 
                    <label for="email" class="col-sm-2 col-form-label">Email:</label> 
                    <div> 
                        <input type="email" class="form-control" name="email" value="<?= validateUser($userData['email']); ?>"> 
                    </div> 
                </div> 
                <button type="submit" name="update" class="w-100 btn btn-lg btn-dark mt-4 mb-4">Update</button>
            </form> 
        </div>
</div>
</div>
<?php endif; ?>
<?php endif; 
    if(isset($_POST['update'])){
        $fname = validateUser($_POST['fname']); 
        $lname = validateUser($_POST['lname']); 
        $email = validateUser($_POST['email']); 
        if(!$user->updateUser($id, $fname, $lname, $email)){
            $_SESSION['msg'] = "Update Failed"; 
            $_SESSION['msg_type'] = 'error'; 
        }else { 
            $_SESSION['msg'] = "Update Successful"; 
            $_SESSION['msg_type'] = 'success';
            header('Location: index.php');
        }
    }
?>

