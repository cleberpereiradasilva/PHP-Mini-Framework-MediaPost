<h3>Lista de Destinatários</h3>  
  <table class="table">
    <tr>
        <td colspan='4' style='text-align:right'>
        <a class="btn btn-success" href="/lista/new">                
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

    foreach($lista as $item):        
    ?>
        <tr>            
            <td><?= $item->name ?></td>            
            <td>
                <a class="btn btn-warning" href="/lista/edit/<?= $item->id ?>">
                <span class="glyphicon glyphicon-edit"></span>
                </a>
                <a class="btn btn-danger" href="/lista/delete/<?= $item->id ?>">
                <span class="glyphicon glyphicon-trash"></span>
                </a>
            </td>
        </tr>
        
    <?php endforeach; ?>
    </tbody>
  </table>
