<?php
require 'loader.php';

$userDao = new UserDao($db);
$users = $userDao->getAll();
$colorDao = new ColorDao($db);

$userDao->setColorDao($colorDao);
// Carregar todas as cores disponíveis
$colors = $colorDao->getAll();

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
}

include_once 'layout/header.php';
?>

<div class="container py-4">
    <div class="row">
        <div class="offset-1 col-9">
            <h2 style="margin-bottom: 2px;">Lista de usuários</h2>
        </div>
    </div>
    <div class="row">
        <div class="offset-1 col-10">
            <hr style="margin-top: 0px;">
        </div>
    </div>

    <!-- Exibe a lista de usuários e suas cores -->
    <div class="row py-3">
        <div class="offset-1 col-10">
            <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Cores</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user) { ?>
                            <tr>
                                <td scope='row'><a href='view.php?id=<?php echo $user->getId() ?>'>
                                        <?php echo $user->getId() ?>
                                    </a></td>
                                <td>
                                    <?php echo $user->getName() ?>
                                </td>
                                <td>
                                    <?php echo $user->getEmail() ?>
                                </td>
                                <td>
                                    <?php foreach ($colors as $color) { ?>
                                        <label>
                                            <input type="checkbox" name="cores[<?php echo $user->getId() ?>][]" value="<?php echo $color->getId() ?>" <?php if ($user->hasColor($color)) echo "checked"; ?>>
                                            <?php echo $color->getName() ?>
                                        </label>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </form>
        </div>
    </div>
</div>

<?php include_once 'layout/footer.php'; ?>
