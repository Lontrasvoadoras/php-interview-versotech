<?php
require 'loader.php';

$userDao = new UserDao($db);

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["cores"])) {
    try {
        $coresAtualizadas = $_POST["cores"];

        // Atualizar as cores para cada usuário
        foreach ($coresAtualizadas as $userId => $cores) {
            $userDao->updateUserColors($userId, $cores);
        }

        // Redirecionar com mensagem de sucesso
        notifyAndRedir('success', 'Cores atualizadas com sucesso.', 'lista_user.php');
    } catch (Exception $e) {
        notifyAndRedir('danger', $e->getMessage(), 'lista_user.php');
    }
} else {
    // Redirecionar para a página de clusters_cores se não houver dados de atualização
    notifyAndRedir('danger', 'Nenhum dado de atualização fornecido.', 'lista_user.php');
}
