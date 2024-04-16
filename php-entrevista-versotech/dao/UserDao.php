<?php
 
class UserDao
{
    private PDO $db_conn;
    private $colorDao;

    public function __construct($db_conn)
    {
        $this->db_conn = $db_conn;
    }
     public function setColorDao($colorDao)
    {
        $this->colorDao = $colorDao;
    }


   


   /**
     * @return User[]
     */
    public function getAll(string $color = null): array
    {
        // Se uma cor foi fornecida, adiciona uma cláusula WHERE à consulta SQL
        $query_users = "SELECT id FROM users";
        if ($color !== null) {
            $query_users .= " WHERE id IN (SELECT user_id FROM user_colors WHERE color_id IN (SELECT id FROM colors WHERE name = :color))";
        }
        
        $stmt_users = $this->db_conn->prepare($query_users);
        
        // Se uma cor foi fornecida, vincula o parâmetro :color à consulta SQL
        if ($color !== null) {
            $stmt_users->bindParam(':color', $color, PDO::PARAM_STR);
        }

        if ($stmt_users->execute()) {
            $result = $stmt_users->fetchAll(PDO::FETCH_ASSOC);

            $users_list = [];

            foreach ($result as $user_id) {
                array_push($users_list, $this->getUserById((int) $user_id['id']));
            }

            return $users_list;

        } else {
            throw new Exception("Erro ao obter lista de usuários!");
        }
    }

    // Outros métodos da classe UserDao...



    

    /**
     * @return User
     */
    public function getUserById(int $user_id): User
    {
        $colorDao = new ColorDao($this->db_conn);

        $query_user = "SELECT * FROM users WHERE id = :user_id LIMIT 1";
        $stmt_user = $this->db_conn->prepare($query_user);
        $stmt_user->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        if ($stmt_user->execute()) {
            $result_user = $stmt_user->fetch(PDO::FETCH_ASSOC);

            $user_colors = [];

            if ($result_user) {
                $query_user_colors = "SELECT * FROM user_colors WHERE user_id = :user_id";
                $stmt_user_colors = $this->db_conn->prepare($query_user_colors);
                $stmt_user_colors->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt_user_colors->execute();

                $result_user_colors = $stmt_user_colors->fetchAll(PDO::FETCH_ASSOC);

                if ($result_user_colors) {
                    foreach ($result_user_colors as $color_id) {

                        $color = $colorDao->getColorById($color_id['color_id']);
                        array_push($user_colors, $color);

                    }
                }

                return new User($result_user['name'], $result_user['email'], $result_user['id'], $user_colors);
            } else {
                throw new Exception("Usuário não encontrado.");
            }
        } else {
            throw new Exception("Erro ao obter usuario no banco de dados.");
        }

    }

    public function insertColorForUserId(int $user_id, Color $color)
    {

        $color_id = (int) $color->getId();

        $insert_query = "INSERT INTO user_colors (user_id, color_id) VALUES (:user_id, :color_id)";
        $stmt_insert = $this->db_conn->prepare($insert_query);
        $stmt_insert->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt_insert->bindParam(':color_id', $color_id, PDO::PARAM_INT);
        return $stmt_insert->execute();

    }

    public function deleteColorsForUserId(int $user_id)
    {
        $delete_query = "DELETE FROM user_colors WHERE user_id = :user_id";
        $stmt_delete = $this->db_conn->prepare($delete_query);
        $stmt_delete->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        return $stmt_delete->execute();
    }

    public function update(User $user)
    {

        $name = (string) $user->getName();
        $email = (string) $user->getEmail();
        $user_id = (int) $user->getId();

        $update_query = "UPDATE users SET name = :name, email = :email WHERE id = :user_id";
        $stmt_update = $this->db_conn->prepare($update_query);
        $stmt_update->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt_update->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt_update->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        if ($stmt_update->execute()) {
            if ($this->deleteColorsForUserId($user_id)) {
                foreach ($user->getColors() as $color) {
                    if (!$this->insertColorForUserId($user_id, $color)) {
                        throw new Exception("Erro ao atualizar usuário no banco de dados (insertColorForUserId). ");
                    }
                }
            } else {
                throw new Exception("Erro ao atualizar usuário no banco de dados (deleteColorsForUserId). ");
            }
        } else {
            throw new Exception("Erro ao atualizar usuário no banco de dados");
        }

    }

    public function insert(User $user)
    {

        $name = (string) $user->getName();
        $email = (string) $user->getEmail();

        $insert_query = "INSERT INTO users (name, email) VALUES (:name, :email)";
        $stmt_insert = $this->db_conn->prepare($insert_query);
        $stmt_insert->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt_insert->bindParam(':email', $email, PDO::PARAM_STR);

        if ($stmt_insert->execute()) {
            $user_id = $this->db_conn->lastInsertId();
            foreach ($user->getColors() as $color) {
                if (!$this->insertColorForUserId($user_id, $color)) {
                    throw new Exception("Erro ao inserir novo usuário no banco de dados (insertColorForUserId). ");
                }
            }
        } else {
            throw new Exception("Erro ao inserir novo usuário no banco de dados");
        }

    }

    public function delete(User $user)
    {

        $user_id = (int) $user->getId();

        if ($this->deleteColorsForUserId($user_id)) {
            $delete_query = "DELETE FROM users WHERE id = :user_id";
            $stmt_delete = $this->db_conn->prepare($delete_query);
            $stmt_delete->bindParam(':user_id', $user_id, PDO::PARAM_INT);

            if ($stmt_delete->execute()) {
                return true;
            } else {
                throw new Exception("Erro ao deletar usuário do banco de dados.");
            }
        } else {
            throw new Exception("Erro ao deletar usuário do banco de dados (deleteColorsForUserId) .");
        }

    }

    public function getColorsForUser($userId)
{
    $query = "SELECT colors.id, colors.name FROM user_colors JOIN colors ON user_colors.color_id = colors.id WHERE user_colors.user_id = :user_id";
    $statement = $this->db_conn->prepare($query);
    $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $statement->execute();
    
    $colors = [];
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $color = new Color($row['id'], $row['name']);
        $colors[] = $color;
    }
    
    return $colors;
}
public function updateUserColors($userId, $colors)
{
    // Deleta todas as cores do usuário
    $this->deleteColorsForUserId($userId);

    // Insere as novas cores selecionadas
    foreach ($colors as $colorId) {
        $color = $this->colorDao->getColorById($colorId);
        $this->insertColorForUserId($userId, $color);
    }
}
public function getUserByEmail(string $email): ?User
{
    $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
    $statement = $this->db_conn->prepare($query);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $user = new User($result['name'], $result['email'], $result['id']);
        // Você pode carregar as cores do usuário aqui, se necessário
        return $user;
    } else {
        return null;
    }
}


}