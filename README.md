## Passo a passo para rodar este aplicativo em seu pc


1. Clone o repositório em seu terminal:
   `git clone https://github.com/Elfoinquieto/crud-filmilioteca-Cauan-Joao.git`

2. Entre na pasta do repositório:
   `cd crud-filmilioteca-Cauan-Joao`

3. Instale as dependências do projeto:
   `composer install`

4. Certifique-se de que a extensão GD do PHP está ativa no seu computador:
   - Abra o arquivo `php.ini`.
   - Busque por `;extension=gd` e remova o `;` do início da linha (`extension=gd`).
   - Salve o arquivo.

5. Configure as variáveis de ambiente:
   - Abra o projeto no VS Code ou editor de sua preferência.
   - Copie o arquivo `.env.example` e renomeie a cópia para `.env`.
   - Ajuste as configurações do seu banco de dados no `.env` (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).
   - Gere a chave da aplicação rodando:
     `php artisan key:generate`

6. Crie o link simbólico para as capas de livros e mídias:
   `php artisan storage:link`

7. Crie as tabelas e popule o banco de dados com os registros de teste:
   `php artisan migrate --seed`

8. Inicie o servidor local:
   `php artisan serve`
   - Clique no link gerado (`http://127.0.0.1:8000`) mantendo a tecla `Ctrl` pressionada para abrir no navegador.
