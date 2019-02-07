<h3>Lista de Usuários</h3>  
  <table class="table">
    <tr>
        <td colspan='4' style='text-align:right'>
        <a class="btn btn-success" href="/user/new">                
                Novo
        </a>
        </td>
    </tr>    
  </table>  
  <table class="table">    
    <thead>
      <tr>
        <th>#</th>
        <th>Nome</th>
        <th>Usuário</th>
        <th>Grupo</th>
        <th>&nbsp;</th>
      </tr>
    </thead>
    <tbody>
    
    <?php

    foreach($users as $user):        
    ?>

        <tr>
            <td><?= $user->id ?></td>
            <td><?= $user->name ?></td>
            <td><?= $user->username ?></td>
            <td><?= ($user->group ? $user->group->name : '') ?></td>
            <td>
                <a class="btn btn-warning" href="/user/edit/<?= $user->id ?>">
                <span class="glyphicon glyphicon-edit"></span>
                </a>
                <a class="btn btn-danger" href="/user/delete/<?= $user->id ?>">
                <span class="glyphicon glyphicon-trash"></span>
                </a>
            </td>
        </tr>
        
    <?php endforeach; ?>
    </tbody>
  </table>
