# Sistema para cadastro de igreja/menbro

### Instalação

> É necessário o uso do wsl2 no windows, de preferência com o ubuntu 
>
> É necessário o docker instalado com o wls2 habilitado

1. `git clone https://github.com/joaoVtr/backend_sys_igreja.git`
    - `cd backend_sys_igreja`
    
2. Para usar o composer install via docker `docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs`
    
3. Criar arquivo .env `cp .env.example .env`

4. Gerar chave  `php artisan key:generate`

5. Subir containers `./vendor/bin/sail up -d`

6. Rodar testes `./vendor/bin/sail test`

7. Criar banco de dados 
    - `./vendor/bin/sail php artisan migrate:fresh`
    
    *ou*
    
    - Criar banco de dados com seeders `./vendor/bin/sail php artisan migrate:fresh --seed`
