<a class="btn" href="adduser">Registrar Nuevo Usuario</a>
<table class="user-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user): ?>
    <tr data-rowid="<?php echo $user['id']; ?>">
        <td><?php echo $user['id']; ?></td>
        <td><?php echo $user['first_name']; ?></td>
        <td><?php echo $user['last_name']; ?></td>
        <td><?php echo $user['email']; ?></td>
        <td>
            <a class="btn" href="users/edit/<?php echo $user['id']; ?>">Editar</a>
            <button class="btn btn-danger" data-id="<?php echo $user['id']; ?>">Eliminar</button>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div id="modal" class="modal">
    <div class="modal-container">
        <div class="background-primary">
            <h3>¿Estás seguro de eliminar este usuario?</h3>
        </div>
        <div class="modal-body">
            <p>Esta acción no se puede deshacer.</p>
            <button class="btn btn-danger" id="confirmDelete">Eliminar</button>
            <button class="btn" id="closeModal">Cancelar</button>
        </div>
    </div>
</div>