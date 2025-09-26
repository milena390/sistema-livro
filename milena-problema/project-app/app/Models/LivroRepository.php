<?php
class LivroRepository {
    private string $filePath;
    private array $livros = [];

    public function __construct() {
        $dataDir = __DIR__ . '/../data';
        $this->filePath = $dataDir . '/livros.json';

        if (!is_dir($dataDir)) {
            mkdir($dataDir, 0777, true);
        }

        if (file_exists($this->filePath)) {
            $json = file_get_contents($this->filePath);
            $decoded = json_decode($json, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $this->livros = $decoded;
            } else {
                error_log("Erro ao decodificar JSON em {$this->filePath}: " . json_last_error_msg());
                $this->livros = [];
            }
        }
    }

    public function adicionar(Livro $livro): int {
        $id = count($this->livros) > 0 ? max(array_column($this->livros, 'id')) + 1 : 1;

        $this->livros[] = [
            'id'     => $id,
            'titulo' => $livro->getTitulo(),
            'autor'  => $livro->getAutor(),
            'ano'    => $livro->getAno(),
            'isbn'   => $livro->getIsbn()
        ];

        $this->salvar();
        return $id;
    }

    public function listar(): array {
        return $this->livros;
    }

    public function editar(int $id, Livro $livroAtualizado): bool {
        foreach ($this->livros as &$livro) {
            if ($livro['id'] === $id) {
                $livro['titulo'] = $livroAtualizado->getTitulo();
                $livro['autor'] = $livroAtualizado->getAutor();
                $livro['ano'] = $livroAtualizado->getAno();
                $livro['isbn'] = $livroAtualizado->getIsbn();
                $this->salvar();
                return true;
            }
        }
        return false; // livro não encontrado
    }

    public function excluir(int $id): bool {
        $originalCount = count($this->livros);
        $this->livros = array_filter($this->livros, fn($livro) => $livro['id'] !== $id);
        $this->livros = array_values($this->livros);
        $this->salvar();
        return count($this->livros) < $originalCount;
    }

    private function salvar(): void {
        $result = file_put_contents($this->filePath, json_encode($this->livros, JSON_PRETTY_PRINT));
        if ($result === false) {
            error_log("Erro ao salvar o arquivo JSON em: " . $this->filePath);
        }
    }
}
?>
