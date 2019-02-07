<h3>Lista de Grupos</h3>  
  <table class="table">
    <tr>
        <td colspan='4' style='text-align:right'>
        <a class="btn btn-success" href="/group/new">                
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
        <th>&nbsp;</th>
      </tr>
    </thead>
    <tbody>
    
    <?php

    foreach($groups as $group):        
    ?>
        <tr>
            <td><?= $group->id ?></td>
            <td><?= $group->name ?></td>            
            <td>
                <a class="btn btn-warning" href="/group/edit/<?= $group->id ?>">
                <span class="glyphicon glyphicon-edit"></span>
                </a>
                <a class="btn btn-danger" href="/group/delete/<?= $group->id ?>">
                <span class="glyphicon glyphicon-trash"></span>
                </a>
            </td>
        </tr>
        
    <?php endforeach; ?>
    </tbody>
  </table>
