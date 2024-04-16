<?php
require 'loader.php';

$userDao = new UserDao($db);
$colorDao = new ColorDao($db);

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $colors_ids = $_POST['colors'];

        // Verificar se o email já está sendo usado
        $existingUser = $userDao->getUserByEmail($email);
        if ($existingUser !== null) {
            notifyAndRedir('danger', 'Este email já está sendo usado por outro usuário.', 'lista_user.php');
            exit;
        }

        // Se o email não estiver sendo usado, proceda com a adição do usuário
        $user = new User($name, $email);

        $colors = [];

        foreach ($colors_ids as $color_id) {
            array_push($colors, $colorDao->getColorById($color_id));
        }

        $user->setColors($colors);

        $userDao->insert($user);

        notifyAndRedir('success', 'Usuário adicionado com sucesso!', 'lista_user.php');

    } catch (Exception $e) {
        notifyAndRedir('danger', $e->getMessage(), 'lista_user.php');
    }
}
?>
