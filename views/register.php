<script>
    var page = "<?php echo $page;?>";
</script>
<div class="form-container bg-gradient">
    <form method="POST">
        <label class="form-label" for="first_name">Nombre:</label>
        <input class="form-input" type="text" id="first_name" name="first_name" value="<?php echo (isset($user))? $user['first_name'] : null;?>" required><br>

        <label class="form-label" for="last_name">Apellido:</label>
        <input class="form-input" type="text" id="last_name" name="last_name" value="<?php echo (isset($user))? $user['last_name'] : null;?>" required><br>

        <label class="form-label" for="email">Email:</label>
        <input class="form-input" type="email" id="email" name="email" value="<?php echo (isset($user))? $user['email'] : null;?>" required><br>

        <label class="form-label" for="password">Contraseña:</label>
        <input class="form-input" type="password" id="password" name="password" <?php echo ($page != 'update') ? 'required' : ''; ?>><br>

        <label class="form-label" for="confirm_password">Confirmar Contraseña:</label>
        <input class="form-input" type="password" id="confirm_password" name="confirm_password" <?php echo ($page != 'update') ? 'required' : ''; ?>><br>
        
        <?php if((isset($user))): ?>
        <input type="hidden" name="userid" id="userid" value="<?php echo $user['id']; ?>">
        <?php endif;?>

        <span class="form-error hidden" id="error"></span>
        
        <button class="btn-submit" id="<?php echo ($page == 'update') ? 'btn-update' : 'btn-register'; ?>" type="submit"><?php echo $title;?></button>
    </form>
    <?php if($page == 'register'): ?>
    <p>¿Ya tienes una cuenta? <a href="login">Iniciar Sesión</a></p>
    <?php endif;?>
</div>