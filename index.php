<?php
ob_start(); 
session_start(); 

include 'includes/header.php'; 
include 'Controller/Users.php'; 
$user = new Users(); 
$db = new Database();

if(isset($_POST['submit'])){
    $fname = validateUser($_POST['fname']); 
    $lname = validateUser($_POST['lname']); 
    $email = validateUser($_POST['email']); 
    if(!$user->registerUsers($fname, $lname, $email)){
        $_SESSION['msg'] = "Registration Failed"; 
        $_SESSION['msg_type'] = 'error'; 
    }else { 
        $_SESSION['msg'] = "Registration Successful"; 
        $_SESSION['msg_type'] = 'success'; 
    }
    header("Location: index.php"); 
    // Redirect to refresh the page
    exit();
}
?>

<div class="container"> 
    <?php include 'includes/alertify.php'; ?> 
    <?php include 'form.php'; ?> 
    <?php 
    if(!empty($user->showUsers())): 
            $i = 0; foreach($user->showUsers() as $data): $i++; ?> 
        <tr> 
            <td><?= $i; ?></td> 
            <td><?= $data['fname']; ?></td> 
            <td><?= $data['lname']; ?></td> 
            <td><?= $data['email']; ?></td> 
            <td>
                <a href="edit.php?edit=<?= $data['id']; ?>" class="btn btn-success">
                    <i class="fa fa-edit"></i> 
                </a> 
                <a href="index.php?delete=<?= $data['id']; ?>" class="btn btn-danger">
                    <i class="fa fa-trash"></i> 
                </a>
            </td> 
            <td><?= $data['created_at']; ?></td> 
        </tr> 
        <?php endforeach; ?> 
    <?php else: ?>
        
        <div class="alert alert-warning">
            <strong>Note!</strong> Table is empty
        </div>

    <?php endif; ?> 
</table> 
</div> 

<?php if (isset($_GET['delete'])) { 
    $id = $_GET['delete']; 
    $user->deleteUser($id); 
    header("Location: index.php"); 
    exit();
}?> 


</body>
</html>
