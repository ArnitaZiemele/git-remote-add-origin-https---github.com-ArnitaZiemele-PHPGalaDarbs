<?php
    $page="edit-profile";
    
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: index.php?page=login");
        exit;
    }
    
    require_once "widgets/config.php";
    $full_name = $_SESSION["full_name"];
    $gender = $_SESSION["gender"];
    $email = $_SESSION["email"];


    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $full_name = trim($_POST["full_name"]);
        $gender = trim($_POST["gender"]);
        $email = trim($_POST["email"]);
        $sql = "UPDATE users SET full_name = ?, gender = ?, email = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sssi", $full_name, $gender, $email, $param_id);
            $param_id = $_SESSION["id"];
            
            if(mysqli_stmt_execute($stmt)){
                // info veiksmīgi noaminīts, redirekto uz profila lapu un ieseto jaunos parametrus
                header("location: index.php?page=account");
    
                $_SESSION["full_name"] = $full_name;
                $_SESSION["gender"] = $gender;
                $_SESSION["email"] = $email;   
                exit();
            } else{
                echo "Kaut kas nogāja greizi... Lūdzu mēģiniet vēlreiz.";
            }
            mysqli_stmt_close($stmt);
        }
        mysqli_close($link);
    }  
?>
/** TODO panākt lai atceras kāds ir patreizējais gender un to piedāvā pirmo **/
<div class="container mt-3" style="width: 400px">
    <h2>Labot profilu</h2>
    <p>Lūdzu aizpildiet laukus, ko vēlaties labot.</p>
    <form action="index.php?page=edit-profile" method="post"> 
        <div class="form-group">
            <label>Vārds uzvārds</label>
            <input type="text" name="full_name" class="form-control" value="<?php echo $full_name; ?>">
        </div>
        <div class="form-group">
            <label>Dzimums</label>
            <select class="form-control" name="gender" selected="<?php echo $gender; ?>">
                <option value="Sieviete">Sieviete</option>
                <option value="Vīrietis">Vīrietis</option>
            </select>
        </div>
        <div class="email">
            <label>Epasts</label>
            <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Mainīt">
            <a class="btn btn-secondary" href="index.php?page=account">Atcelt</a>
        </div>
    </form>
</div> 