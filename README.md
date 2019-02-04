### PHP Mini-Framework

## Criação de um "mini-framework"

    - Crie um sistema de roteamento para mapear URLs para uma classe/método ("controller")
    - Todas as requisições devem passar por um arquivo único;
    - Faça a renderização do HTML em arquivos separados do PHP;
    - Crie o autoloading de seu sistema sem utilizar o composer ou outra biblioteca pronta.


## Configure um ambiente para rodar seu sistema com:
    - Qualquer distribuição Linux;
    - Um servidor web de sua escolha (de preferência nginx);
    - Banco de dados MySQL/MariaDB;
    - PHP 7.2+.(inicialmente fiz com o sqlite apenas para desenvolver...)

## Lives do desenvolvimento:

    - https://www.twitch.tv/collections/hTye8WEwgBXx0g


## ToDo
    - [ ] Fazer o sistema de Autenticação.
    - [ ] Terminar a proteção das rotas por autenticação.
    - [ ] Fazer os Models entender os relacionamentos.
    - [ ] Fazer os métodos para exibir conteúdos(view)