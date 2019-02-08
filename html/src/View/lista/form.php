<form action="/lista" method='POST'>  
  <input type='hidden' name='id' value='<?= $lista['cod'] ?>'>
  <div class="form-group">
    <label for="name">Nome:</label>
    <input type="text" name="name" class="form-control" id="name" value='<?= $lista['nome'] ?>'>
  </div>
  <button type="submit" class="btn btn-primary">Entrar</button>
</form>