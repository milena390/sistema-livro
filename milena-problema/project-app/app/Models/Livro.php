<?php
// classes/Livro.php

class Livro {
    private ?int $id;
    private string $titulo;
    private string $autor;
    private string $ano;   // formato DATE, pode ser string ou DateTime se preferir
    private string $isbn;

    /**
     * Construtor do livro
     * @param string $isbn
     * @param string $titulo
     * @param string $autor
     * @param string $ano Formato YYYY-MM-DD
     * @param int|null $id Opcional, padrão null
     */
    public function __construct(string $isbn, string $titulo, string $autor, string $ano, ?int $id = null) {
        $this->id = $id;
        $this->isbn = $isbn;
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->ano = $ano;
    }

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getTitulo(): string { return $this->titulo; }
    public function getAutor(): string { return $this->autor; }
    public function getAno(): string { return $this->ano; }
    public function getIsbn(): string { return $this->isbn; }

    // Setters
    public function setId(?int $id): void { $this->id = $id; }
    public function setTitulo(string $titulo): void { $this->titulo = $titulo; }
    public function setAutor(string $autor): void { $this->autor = $autor; }
    public function setAno(string $ano): void { $this->ano = $ano; }
    public function setIsbn(string $isbn): void { $this->isbn = $isbn; }
}
?>
