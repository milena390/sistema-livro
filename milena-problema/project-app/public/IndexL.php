<?php
session_start();

define('JSON_FILE', __DIR__ . '/../project-app/app/config/livros.json');

function lerLivros() {
    if (file_exists(JSON_FILE)) {
        $jsonData = file_get_contents(JSON_FILE);
        return json_decode($jsonData, true) ?: [];
    }
    return [];
}

function salvarLivros($livros) {
    $jsonData = json_encode($livros, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents(JSON_FILE, $jsonData);
}

if (isset($_POST['adicionar'])) {
    $titulo = trim($_POST['titulo'] ?? '');
    $autor = trim($_POST['autor'] ?? '');
    $ano = filter_var($_POST['ano'] ?? '', FILTER_VALIDATE_INT);
    $isbn = trim($_POST['isbn'] ?? '');

    if ($titulo && $autor && $ano !== false && $isbn) {
        $livros = lerLivros();
        $id = $livros ? max(array_column($livros, 'id')) + 1 : 1;

        $livros[] = [
            'id' => $id,
            'titulo' => $titulo,
            'autor' => $autor,
            'ano' => $ano,
            'isbn' => $isbn
        ];

        salvarLivros($livros);
        $_SESSION['mensagem'] = "📚 Livro cadastrado com sucesso!";
    } else {
        $_SESSION['mensagem'] = "❌ Preencha todos os campos corretamente!";
    }

    header("Location: indexl.php");
    exit;
}

if (isset($_POST['editar'])) {
    $id = filter_var($_POST['id'] ?? '', FILTER_VALIDATE_INT);
    $titulo = trim($_POST['titulo'] ?? '');
    $autor = trim($_POST['autor'] ?? '');
    $ano = filter_var($_POST['ano'] ?? '', FILTER_VALIDATE_INT);

    if ($id && $titulo && $autor && $ano !== false) {
        $livros = lerLivros();
        foreach ($livros as &$livro) {
            if ($livro['id'] === $id) {
                $livro['titulo'] = $titulo;
                $livro['autor'] = $autor;
                $livro['ano'] = $ano;
                break;
            }
        }
        salvarLivros($livros);
        $_SESSION['mensagem'] = "✏️ Livro editado com sucesso!";
    } else {
        $_SESSION['mensagem'] = "❌ Preencha todos os campos corretamente!";
    }

    header("Location: indexl.php");
    exit;
}

if (isset($_POST['excluir'])) {
    $id = filter_var($_POST['id'] ?? '', FILTER_VALIDATE_INT);

    if ($id) {
        $livros = lerLivros();
        $livros = array_filter($livros, fn($livro) => $livro['id'] !== $id);
        $livros = array_values($livros); // reindexa array
        salvarLivros($livros);
        $_SESSION['mensagem'] = "🗑️ Livro excluído com sucesso!";
    } else {
        $_SESSION['mensagem'] = "❌ ID inválido para exclusão!";
    }

    header("Location: indexl.php");
    exit;
}

$livros = lerLivros();
$mensagem = $_SESSION['mensagem'] ?? '';
unset($_SESSION['mensagem']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Cadastro de Livros</title>
  <style>
  /* Seu CSS (mantive o que enviou) */
  /* ... */
  </style>
</head>
<body>
  <div class="container">
    <h1>Cadastro de Livros</h1>

    <?php if ($mensagem): ?>
      <div class="mensagem"><?= htmlspecialchars($mensagem) ?></div>
    <?php endif; ?>

    <form action="indexl.php" method="POST" autocomplete="off">
      <label for="titulo">Título:</label>
      <input type="text" name="titulo" id="titulo" required>

      <label for="autor">Autor:</label>
      <input type="text" name="autor" id="autor" required>

      <label for="ano">Ano:</label>
      <input type="number" name="ano" id="ano" required>

      <label for="isbn">ISBN:</label>
      <input type="text" name="isbn" id="isbn" required>

      <button type="submit" name="adicionar">Adicionar Livro</button>
    </form>

    <h2>Lista de Livros</h2>
    <ul>
      <?php foreach ($livros as $livro): ?>
        <li>
          <div class="livro-info">
            <h3><?= htmlspecialchars($livro['titulo']) ?> - <?= htmlspecialchars($livro['autor']) ?></h3>
            <p>Ano: <?= $livro['ano'] ?> | ISBN: <?= htmlspecialchars($livro['isbn']) ?> | ID: <?= $livro['id'] ?></p>
          </div>

          <div class="button-container">
            <form action="indexl.php" method="POST" autocomplete="off" style="display:inline-block; margin-right:8px;">
              <input type="hidden" name="id" value="<?= $livro['id'] ?>">
              <input type="text" name="titulo" value="<?= htmlspecialchars($livro['titulo']) ?>" required>
              <input type="text" name="autor" value="<?= htmlspecialchars($livro['autor']) ?>" required>
              <input type="number" name="ano" value="<?= $livro['ano'] ?>" required>
              <button type="submit" name="editar" class="edit">Salvar Edição</button>
            </form>

            <form action="indexl.php" method="POST" autocomplete="off" style="display:inline-block;">
              <input type="hidden" name="id" value="<?= $livro['id'] ?>">
              <button type="submit" name="excluir" class="delete" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
            </form>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</body>
</html>
