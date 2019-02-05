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
- PHP 7.2+.(inicialmente fiz com o sqlite apenas para desenvolver...)

### Lives do desenvolvimento:

- https://www.twitch.tv/collections/hTye8WEwgBXx0g

----

### Models    
- Os Models ficam em `src\Model` e devem extender de `Model` usando o namespace `core\Model`
- Os atributos são determinados em um campo `protected $fields = []`
- Cada atributo já é setado com os detalhes para o banco de dados:
    ```['email','varchar', '(150)', 'NOT NULL']```
- Sempre com os 4 campos na matriz respectivamente
* ``` nome do campo ```
* ``` tipo ``` 
* ``` tamanho ```
* ``` demais informações ``` como por exemplo ``` DEFAULT(1) ``` ou ``` NOT NULL ```.
- Tipos de dados
- Os tipos de dados suportados até o momento são:
- ```int``` numérico
- ```varchar``` texto
- ```datetime``` data e hora
- ```real``` número com casa decimais
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
- Os `Controller` já erdam os métodos de `CRUD` de `core\Controller`, podendo ser substituido.
    * No caso de substituir algum método lembrar de olhar o método original em `core\Controller` 
- Importante setar o atributo `protected $class` com o nome do modelo que o controller representa.
    * Ex: `protected $class = 'Model\Usuario';`
- Exemplo de `Controller`
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
                echo ';    
            });
        ```
- Os `end-points` podem receber variáveis para enviar para os métodos:
    ```
        $router->delete('/end-point/{id}', "NameController@method");
    ```
- Exemplo de um arquivo de rotas:
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
* Ainda fazendo....


### Protegendo as Rotas
- As rotas também podem receber um terceiro parâmetro, um `array()`.
- Esse parâmetro será enviado para um método `is_autenticated` em `core\Auth`.
- Nesse método pode-se fazer as regras para a autenticação.
- Exemplo de implementação apenas para ilustrar:
    ```
        static function is_autenticated($parans = []){        
            //pode-se usar qualquer regra para validar
            $_SESSION["usuario"] = [
                'name' => 'User Name',
                'user_id' => 1,
                'grupo_id' => 10
            ];
            print_r($_SESSION["usuario"]['name']);
            echo "<hr />";
            
            //se não for um array válido então nem tem proteção
            if(!is_array($parans)){
                return true;
            }

            //verifica se o usurio tem o grupo necessário...
            if(in_array($parans['grupo_id'], $_SESSION["user"]['grupo_id'])){
                return true;
            }        
            return false;
        }
    ```



## ToDo
- [ ] Fazer o sistema de Autenticação.
- [x] Terminar a proteção das rotas por autenticação.
- [ ] Fazer os Models entender os relacionamentos.
- [ ] Fazer os métodos para exibir conteúdos(view)
- [ ] Fazer a classe do MySql