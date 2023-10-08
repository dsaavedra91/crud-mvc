<div class="form-container bg-gradient">
    <form method="POST">
        <label class="form-label" for="email">Email:</label>
        <input class="form-input" type="email" id="email" name="email" required><br>

        <label class="form-label" for="password">Contraseña:</label>
        <input class="form-input" type="password" id="password" name="password" required><br>

        <span class="form-error hidden" id="error"></span>
        
        <button class="btn-submit" id="btn-login" type="submit">Iniciar Sesión</button>
    </form>

    <p>¿No tienes una cuenta? <a href="register">Regístrate</a></p>
</div>