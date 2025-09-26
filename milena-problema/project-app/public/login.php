<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
    <style>
    /* Seu CSS aconchegante (pode copiar do seu exemplo) */
    :root {
        --bg: #F5F1E8;
        --card: #FAF7F0;
        --text: #4E4A46;
        --muted: #6B655E;
        --border: #D2C6B8;
        --btn: #EDE3D4;
        --btn-hover: #D9CBB8;
        --shadow: rgba(34, 30, 24, 0.12);
        --shadow-strong: rgba(34, 30, 24, 0.18);
    }
    * { box-sizing: border-box; }
    body {
        margin: 0;
        background-color: var(--bg);
        font-family: Arial, sans-serif;
        color: var(--text);
        text-align: center;
        line-height: 1.5;
    }
    .container {
        margin: 56px auto;
        max-width: 400px;
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 32px 28px;
        box-shadow: 0 8px 24px var(--shadow);
    }
    h2 {
        font-size: 28px;
        font-weight: bold;
        margin: 8px 0 18px;
        color: var(--text);
    }
    label {
        font-size: 18px;
        display: block;
        margin: 10px 0 6px;
        color: var(--muted);
        text-align: left;
    }
    input {
        width: 100%;
        padding: 12px;
        margin-bottom: 18px;
        border-radius: 8px;
        border: 1px solid var(--border);
        font-size: 16px;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    input:focus {
        border-color: #CDBFAE;
        box-shadow: 0 0 6px rgba(205, 191, 174, 0.6);
    }
    button {
        background-color: var(--btn);
        border: 1px solid var(--border);
        color: var(--text);
        padding: 14px 28px;
        font-size: 18px;
        cursor: pointer;
        border-radius: 12px;
        box-shadow: 0 4px 12px var(--shadow);
        transition: background-color 0.2s ease, transform 0.05s ease, box-shadow 0.2s ease;
    }
    button:hover {
        background-color: var(--btn-hover);
        transform: translateY(-1px);
        box-shadow: 0 8px 18px var(--shadow-strong);
    }
    button:active {
        transform: translateY(0);
        box-shadow: 0 4px 10px var(--shadow);
    }
    button:focus {
        outline: 3px solid #CDBFAE;
        outline-offset: 2px;
    }
    .error {
        color: red;
        font-weight: bold;
        margin-bottom: 15px;
    }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>

        <?php
        session_start();
        if (isset($_SESSION['error'])) {
            echo '<div class="error">'.htmlspecialchars($_SESSION['error']).'</div>';
            unset($_SESSION['error']);
        }
        ?>

        <form action="process_login.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required />

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required />

            <button type="submit" name="submit">Entrar</button>
        </form>
    </div>
</body>
</html>
