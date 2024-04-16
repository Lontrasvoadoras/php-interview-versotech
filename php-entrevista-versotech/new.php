<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="css/style1.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<?php
require 'loader.php';

try {
    $colorDao = new ColorDao($db);
    $colors = $colorDao->getAll();
} catch (Exception $e) {
    notifyAndRedir('danger', $e->getMessage(), 'index.php');
}


?>
<body>
  <div class="container">
    <div class="form-box box">


      <header>Sign Up</header>
      <hr>

      <form action="new_p.php" method="post">


        <div class="form-box">
            <div class="input-container">
              <i class="fa fa-user icon"></i>
              <input class="input-field" type="text" id="name"placeholder="Username"  name="name" required>
            </div>

            <div class="input-container">
              <i class="fa fa-envelope icon"></i>
              <input class="input-field" type="email" id="email" placeholder="Email Address" name="email" required>
            </div>

             <div class="input-container">
                <i class="fa fa-paint-brush icon"></i>
                   <select class="input-field form-select" id="colors" name="colors[]" multiple>
                    <?php foreach ($colors as $color) { ?>
                        <option value="<?php echo $color->getId() ?>">
                            <?php echo $color->getName() ?>
                        </option>
                    <?php } ?>
                </select>
            </div>


            <div class="row" >
                <div class="offset-1 col-10 ">
                    <button type="submit" class="btn">Adicionar</button>
                    
                </div>      
            </div>
                
        </form>

    </div>  
    <div>
 <a class="links" href="index.php" > Início </a> 
 <a class="links" href="lista_user.php" > Lista de Usuários </a>
 </div>
    
   
