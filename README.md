## Passo a passo para rodar este aplicativo em seu pc.


1. Rode em seu terminal: git clone https://github.com/Elfoinquieto/crud-filmilioteca-Cauan-Joao.git

2. Em seguida entre pelo terminal em sua pasta do repositório: cd crud-filmilioteca-Cauan-Joao

3. Rode o comando: composer update

4. Enquanto ele roda, entre no arquivo php.ini no seu computador e procure pela linha ;extension=gd e retire o ; na frente

5. Em seguida abra o seu projeto em algum editor como o vscode, copie o .env.example e o renomeie para .env, colocando a sua senha do banco de dados e rodando php artisan key:generate

6. em seguida rode php artisan ...
