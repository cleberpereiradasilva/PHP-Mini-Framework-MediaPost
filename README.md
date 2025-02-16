# PHP Mini-Framework

### Criação de um "mini-framework"

- Crie um sistema de roteamento para mapear URLs para uma classe/método ("controller")
- Todas as requisições devem passar por um arquivo único;
- Faça a renderização do HTML em arquivos separados do PHP;
- Crie o autoloading de seu sistema sem utilizar o composer ou outra biblioteca pronta.

### Configure um ambiente para rodar seu sistema com:
- Qualquer distribuição Linux;
- Um servidor web de sua escolha (de preferência nginx);
- Banco de dados MySQL/MariaDB;
- PHP 7.2+.

### Lives do desenvolvimento:

- https://www.twitch.tv/collections/hTye8WEwgBXx0g

----
----

### Convenções
* Todas os `models` devem ficar dentro de `src\Model`.
* Todas os `controllers` devem ficar dentro de `src\Controller`.
* Todas as classes devem começar com maiúscula no nome da classe e no nome do arquivo.
* Todas funções que não pertencem à nenhuma classe devem ficar dentro de `src\helper\funcoes.php`.

### Como Rodar
* Podemos rodar diretamente do `docker-compose` com os comandos:
    -`docker-compose --build`
    -`docker-compose up`
    - Para acessar a máquina:
        * `docker exec -it  <conteiner_ID>  /bin/bash`.
        * Os arquivos ficam em `\var\www\html`.
* Podemos também usar apenas o conteudo da pasta `html/` e hospedar em um servidor.
    - Vale informar que já existe as configurações para o `nginx` na pasta `nginx/`.

### Config(.env)
* Os dados como `hash` para a criptografia e dados de conexão com o banco de dados, ficam na raiz da pasta `html/` em um arquivo chamado `.env`.

### Models    
- Os Models ficam em `src\Model` e devem extender de `Model` usando o namespace `core\Model`.
- Os atributos são determinados em um campo `protected $fields = []`.
- Cada atributo já é setado com os detalhes para o banco de dados:
    ```['email','varchar', '(150)', 'NOT NULL']```
- Sempre com os 5 campos na matriz respectivamente:
* ``` nome do campo ```
* ``` tipo ``` 
* ``` tamanho ```
* ``` demais informações ``` como por exemplo ``` DEFAULT(1) ``` ou ``` NOT NULL ```.
* ``` Modulo de Relacionamento ``` como será explicado em `Relacionamento`, `oneToMany`.
- Tipos de dados
- Os tipos de dados suportados até o momento são:
* ```int``` numérico
* ```varchar``` texto
* ```datetime``` data e hora
* ```real``` número com casa decimais
- Para inserir novos tipo de dados deve-se editar a classe ```core\helper\Type``` 
- Importante saber que isso afeta todos os modelos de banco de dados contidos em ```core\database\```.
- Não é preciso setar a chave primária, ela será integrada automaticamente.
- Exemplo de um `Model`:
    ```
    namespace Model;
    use core\Model;
    class Usuario extends Model{    
        //'int','varchar','datetime','real'
        protected $fields = [
            ['name','varchar', '(150)', 'NOT NULL'],
            ['lastname','varchar', '(150)', ''],
            ['email','varchar', '(150)', , 'NOT NULL'],
            ['password','varchar', '(150)', , 'NOT NULL']
        ];        
        public function __construct($dados = null){
            parent::__construct($dados);
        }
    }
    ```
### Migrations
- Depois de configurar o `Model` deve-se rodar o comando `php migrate` para atualizar o banco de dados.

### Controllers
- Os `Controllers` devem ficar dentro de `src\Controller`, ou o `autoload` não vai encontra-los.
- Os `Controllers` devem extender de `Controller` usando o namespace `core\Controller`.
- Os `Controller` já herdam os métodos de `CRUD` de `core\Controller`, podendo ser substituido.
    * No caso de substituir algum método lembrar de olhar o método original em `core\Controller` 
- Importante setar o atributo `protected $class` com o nome do `Model` que o `controller` representa.
    * Ex: `protected $class = 'Model\Usuario';`
- Exemplo de `Controller`:
    ```
    use Model\Usuario;
    use core\Controller;
    class UserController extends Controller{
        protected $class = 'Model\Usuario';    
    }
    ```

### Rotas
- As rotas devem ser configuradas em `config\Routers.php`
- Há duas formas de configurar as rotas:
    * Usando o nome do `Controller` e seu método:
        ```
            $router->get('/end-point', "NameController@method");
        ```
    * Enviando uma funcção anônima:
        ```
            $router->get('/end-point', function() {   
                echo 'Hello';    
            });
        ```
- Os `end-points` podem receber variáveis para enviar para os métodos:
    ```
        $router->delete('/end-point/{id}', "NameController@method");
    ```
- Exemplo de um arquivo de rotas(`config\Routers.php`):
    ```
        $router = new Router();
        $router->get('/home', function() {
            echo "Home";
        });

        $router->get('/users', "UserController@index");
        $router->get('/user/{id}', "UserController@view");
        $router->delete('/user/{id}', "UserController@delete");
        $router->put('/user/{id}', "UserController@put");
        $router->post('/user', "UserController@post");         

        $router->dispatcher(); 
    ```
### Autenticação
- Enviar formulário de autenticação contendo `username` e `password`.
- Método `POST` para `/auth`.
- Essa rota está fixa(`hard code`) no arquivo de rotas `core\Router.php`.
- Case queria usar `json` para enviar os dados, basta editar o método `Auth::authentication`.
    * Editar a linha `$dados = $data->request('post');` para `$dados = $data->request('json');`.
- Uma vez autenticado poderá consultar o se o usuário está autenticado com as funções `is_auth()`e `auth_user`, essas funções serão explicadas na sessão Helpers Globais

### Logout
- Pode ser feito acessando via `GET` a url `/logout`.
- Essa rota pode ser alterada no arquivo de rotas(`Routers.php`).

### Protegendo as Rotas
- As rotas também podem receber um terceiro parâmetro, um `array()`.
- Esse parâmetro será enviado para um método `is_authenticated` em `core\Auth`.
- Nesse método pode-se fazer as regras para a autenticação.
- Exemplo de implementação apenas para ilustrar:
    ```
        static function is_authenticated($params = []){        
            //pode-se usar qualquer regra para validar
            $_SESSION["usuario"] = [
                'name' => 'User Name',
                'user_id' => 1,
                'grupo_id' => 10
            ];
            print_r($_SESSION["usuario"]['name']);
            echo "<hr />";
            
            //se não for um array válido então nem tem proteção
            if(!is_array($params)){
                return true;
            }

            //verifica se o usurio tem o grupo necessário...
            if(in_array($params['grupo_id'], $_SESSION["user"]['grupo_id'])){
                return true;
            }        
            return false;
        }
    ```

### Views
- O `include` das `views` pode ser feito usando o `core\helpers\Response`.
- Através do método `view($path, Array())`.
- O primeiro parametro é o caminho do arquivo da `view` que deve estar por padrão dentro do diretório `Views`
- O sergundo parametro é um `Array` contendo a lista de variáveis que deseja passar para a `view`.
- Exemplo de implementação em um `Controller`:
    ```
        use Model\User;
        use core\Controller;        
        use core\helper\Response;

        class UserController extends Controller{
            protected $class = 'Model\User';  

            public function index(){        
                $retorno = new $this->class();        
                $users = $retorno->findAll();
                //espera que exista o arquivo src\View\user-list.php
                return Response::view('user-list', ['users' => $users]);
            }
    ```
- Também está disponível o método `json($vars)` para enviar um conteúdo em `json`.
- Exemplo de retorno usando o `json($vars)`:
    ```
        use Model\User;
        use core\Controller;        
        use core\helper\Response;

        class UserController extends Controller{
            protected $class = 'Model\User';  

            public function index(){        
                $retorno = new $this->class();        
                $users = $retorno->findAll();                
                return Response::json(['users' => $users]);
            }
    ```
- Retorno do `json`:
    ```
        {
            "users":[
                {"dados":{"id":"1","name":"Cleber","username":"admin"}},
                {"dados":{"id":"2","name":"cleber010","username":"admin11"}},
                {"dados":{"id":"3","name":"Another Cleber","username":"another"}}
                {"dados":{"id":"4","name":"asdfadsf","username":"asdfasdf"}},
                {"dados":{"id":"5","name":"asdfasdf","username":"dddd"}}
            ]
        }
    ```

### Layout
- O `layout` está separado em arquivos dentro de `src\View\layout`.
- O arquivos são `montados` na função `core\helper\Response::view()`.
- Fica fácil a criação de outras partes como `sides` `bars` e montado em `core\helper\Response::view()`.

### Relacionamento [!!! precisa melhorar !!!]
- OneToMany 
    * Pode ser setado na hora de indicar os `fields` do `Model`, apenas indicado o outro `Model` relacionado.
        - Exemplo:
            ```
                protected $fields = [
                    ['name','varchar', '(150)', 'NOT NULL'],        
                    ['username','varchar', '(150)', 'UNIQUE'],
                    ['password','varchar', '(150)', 'NOT NULL'],
                    ['group_id','int', '', 'NULL', 'UserGroup']
                ];  
            ```
        - A referência seria `$user->group` para o objeto ou aos seus atributos `$user->group->name` por exemplo.
- ManyToMany
    * Neste tipo de relacionameto precisamos setar um método dentro do `Model`.
    * Esse método vai indicar os dados do relacionamento.
    * Por exemplo:
        ```
            public function permissoes(){
                return [            
                    'models' => ['GrupoPermissao', 'Permissao'],
                    'fields' => ['group_id', 'permissao_id']
                ];
            }
        ```
        - Onde `models` indica o caminho do relacionamento. 
            * Nesse caso passa por `Model\GrupoPermissao` e depois em `Model\Permissao`
            * Sempre vai retornar a lista do último(`Model\Permissao`)
        - Onde `fields` indica o `id` de cada `Model` respectivamente.
    * Importante dizer que o `Model` que servirá apenas como a ponte entre os dois outros não precisa de controller.
    * Exemplo completo de relacionamenteo ManyToManay:
        ```
            uses ....
            class UserGroup extends Model{        
                protected $fields = [
                    ['name','varchar', '(150)', 'UNIQUE NOT NULL']
                ];  
                public function __construct($dados = null){
                    parent::__construct($dados);
                }
                //UserGroup tem permissoes...
                public function permissoes(){
                    return [            
                        'models' => ['GrupoPermissao', 'Permissao'],
                        'fields' => ['group_id', 'permissao_id']
                    ];
                }
            }

            uses ....
            class GrupoPermissao extends Model{                    
                protected $fields = [
                    ['group_id','int', '', 'NOT NULL', 'UserGroup'],
                    ['permissao_id','int', '', 'NOT NULL', 'Permissao']
                ];  
                public function __construct($dados = null){
                    parent::__construct($dados);
                }
            }

            uses ...
            class Permissao extends Model{                    
                protected $fields = [
                    ['name','varchar', '(150)', 'NOT NULL']
                ];  
                public function __construct($dados = null){
                    parent::__construct($dados);
                }
            }


            //depois pode ser acessado a lista das permissoes assim:
            ...setar o $grupo 
            $grupo->permissoes
            //outro exemplo partindo do seu usuario
            $user->group->name
        ```
## Helpers Globais
- Exitem algumas funções genéricas criadas em `core\helper\funcions.php`.
- Essas funções estarão disponíveis em todo o sistema.
- São elas:
    * `s_auth()` que retorna `true|false` para informar se o usuário está logado.
    * `auth_user()` que retorna um objeto do tipo `User()` referente ao usuário logado.
    * `errors()` que retorna um `array` contenos erros quando enviado alguma requisição.
        - Essa função pode ser usada em qualquer lugar como validação de formulários
        - Exemplo de verificação de erros:
            ```
                <?php foreach(errors() as $erro): ?>
                    <div class='alert-danger'><?= $erro['message']; ?></div>
                <?php endforeach ?>
            ```
    * Outras mais podem ser criadas dentro do `core\helper\funcions.php`.

## ToDo
- [x] Fazer o sistema de Autenticação.
- [x] Fazer o logout.
- [x] Terminar a proteção das rotas por autenticação.
- [x] Fazer as `views` (uma forma de carregar as páginas e receber as `vars`).
- [x] Fazer os Models entender os relacionamentos(hasHone).
- [x] Fazer os Models entender os relacionamentos(hasMany).
- [x] Fazer a classe do MySql.
- [x] Colocar as configurações do banco de dados no .env
- [x] Fazer uma interface bootstrap
- [x] Fazer retorno de erros
- [x] Fazer um `functions.php` com funções globais.
- [ ] Fazer o .gitignore funcionar (rs.....)



# Comunicação com Sistema[API]



## Permissões:
* Local
    - [ ] Cadastrar usuário;
    - [ ] Listar usuários;

* Remoto
    - [ ] Cadastrar listas
    - [ ] Cadastrar contatos;
    - [ ] Cadastrar mensagem;
    - [ ] Enviar mensagem;
    - [ ] Exibir resultados do envio.
