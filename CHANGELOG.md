## [2.0.0] - 2026-04-30



### Added


- Adicionar caregamento e processamento de arquivos .env

- Add funcionalidade de gerenciamento e exibição das views

- Add funcionalidade roteamento

- Add camando de segurança como Middlewares(Auth, Guest)

- Add tela incial, login e register

- Add tela de Dashboard

- Add Controlador de Dashboard



### Changed


- Refatorar classe Database para usar superglobal $_ENV

- Index passa a ser apenas Entrypoint (FrontController)

- Add metodo findById na classe User

- Atualização na classe AuthController adição dos metodos index, showLogin e showRegister e mudanças nos metodos ja existentes



### Documentation


- Update changelog for v1.0.0

- Trocar armazenamento credenciais banco de dados para arquivo .env

- Add variavel DB_CONNECTION no arquivo .env.example



### Fixed


- Method da uri /logout da classe AuthController

- Retorno do metodo dispatch da classe Router



