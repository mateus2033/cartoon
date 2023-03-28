# README

<p align="center">Mini-Biblioteca</p>


# Requisitos

    * PHP 7.4
    * Laravel 8
    * composer 2
    * MySQL



# Instalação

<p> Projeto construido com php 7.4 e larave 8 e MySQL. Foi utilizando insomnia para testar API<br>

Rode os seguintes comandos antes da excecução de qualquer rota.<br>

    * composer install
    * composer update
<br>

<br>

    *Verifique as informações para a conexão com o DB no arquivo .env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=<seu database>
    DB_USERNAME=root
    DB_PASSWORD=<sua senha>

<br>

 Execute o comando abaixo para configurar a estrutura do banco de dados do projeto.
<br>
<strong>php artisan migrate:fresh --seed</strong>
</p>

Em seguida rode o seguinte comando para inicicar o sevidor do Laravel para executarmos as rotas.
<br>
<strong>php artisan server</strong>
</p>
<br>


# OBS

    * User Adm

    email:admin@admin.com
    password: 12345678
    
<br>


# Swagger

   <br>
   
    * http://localhost:8000/api/documentation

