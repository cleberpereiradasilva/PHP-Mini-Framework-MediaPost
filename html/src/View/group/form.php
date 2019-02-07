<form action="/group" method='POST'>  
  <input type='hidden' name='id' value='<?= $group->id ?>'>
  <div class="form-group">
    <label for="name">Nome:</label>
    <input type="text" name="name" class="form-control" id="name" value='<?= $group->name; ?>'>
  </div>
  <button type="submit" class="btn btn-primary">Entrar</button>
</form>