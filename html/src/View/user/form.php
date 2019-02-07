<form action="/user" method='POST'>  
  <input type='hidden' name='id' value='<?= $user->id ?>'>
  <?php foreach(errors() as $erro): ?>
    <div class='alert-danger'><?= $erro['message']; ?></div>
  <?php endforeach ?>
  
  <div class="form-group">
    <label for="name">Nome:</label>
    <input type="text" name="name" class="form-control" id="name" value='<?= $user->name; ?>'>
  </div>

  <div class="form-group">
    <label for="usename">Usuário:</label>
    <input type="text" name="username" class="form-control" id="username" value='<?= $user->username; ?>'>
  </div>

  <div class="form-group">
    <label for="group_id">Grupo:</label>
    <select name='group_id' id='group_id'>
    <option value="">Selecione</option>
        <?php foreach($grupos as $grupo): ?>
            <option value="<?php echo $grupo->id; ?>"><?= $grupo->name; ?></option>
        <?php endforeach; ?>     
    </select>
  </div>

  <div class="form-group">
    <label for="pwd">Password:</label>
    <input type="password" class="form-control" name="password" id="password">
  </div>  
  <button type="submit" class="btn btn-primary">Entrar</button>
</form> 