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
- Os Models ficam em `src\Model` e devem extender de `Model`
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


## ToDo
- [ ] Fazer o sistema de Autenticação.
- [x] Terminar a proteção das rotas por autenticação.
- [ ] Fazer os Models entender os relacionamentos.
- [ ] Fazer os métodos para exibir conteúdos(view)
- [ ] Fazer a classe do MySql