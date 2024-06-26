<?php

require 'loader.php';

$userDao = new UserDao($db);
$colorDao = new ColorDao($db);

// verificar se veio parametro id
if (empty($_GET['id'])) {
    notifyAndRedir('danger', 'ID do usuario não enviado!', 'lista_user.php');
}

try {
    $id = $_GET['id'];

    $user = $userDao->getUserById($id);
    $colors = $colorDao->getAll();

    $color_array = [];

    foreach ($user->getColors() as $color) {
        array_push($color_array, (string) $color->getId());
    }
} catch ( Exception $e) {
    notifyAndRedir('danger', $e->getMessage(), 'lista_user.php');
}

include_once 'layout/header.php';

?>


<main>
    <div class="container py-4">
        <div class="row">
            <div class="offset-1 col-10">
                <h2 style="margin-bottom: 2px;">Editando usuário:
                    <?php echo $user->getName(); ?>
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="offset-1 col-10">
                <hr style="margin-top: 0px;">
            </div>
        </div>

        <form method="post" action="edit_p.php">

            <input type="hidden" name="uid" value="<?php echo $user->getId() ?>">

            <div class="row">
                <div class="offset-1 col-10">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="name-label">Nome</span>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Nome"
                            aria-label="Nome" aria-describedby="name-label" value="<?php echo $user->getName() ?>">
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="offset-1 col-10">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="email-label">E-mail</span>
                        <input type="text" id="email" name="email" class="form-control" placeholder="E-mail"
                            aria-label="Email" aria-describedby="email-label" value="<?php echo $user->getEmail() ?>">
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="offset-1 col-10">
                    <div class="mb-3">
                        <label for="colors" class="form-label">Cores</label>
                        <select id="colors" name="colors[]" class="form-select" multiple>
                            <?php foreach ($colors as $color) { ?>
                                <option value="<?php echo $color->getId() ?>">
                                    <?php echo $color->getName() ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="offset-1 col-10">
                    <button type="submit" class="btn btn-success">Salvar</button>
                </div>
            </div>

        </form>

    </div>
</main>

<script>
    var colorsSelect = document.getElementById("colors");
    var selectedOptions = <?php echo json_encode($color_array); ?>;

    for (var i = 0; i < colorsSelect.options.length; i++) {
        if (selectedOptions.includes(colorsSelect.options[i].value)) {
            colorsSelect.options[i].selected = true;
        }
    }
</script>

