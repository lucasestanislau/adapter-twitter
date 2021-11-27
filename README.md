# tcc-projects

Projetos referentes a arquitetura para produção de séries temporais a partir de fontes de dados heterogêneas.

Configuração do banco de dados:

  No arquivo ".env" do registrador de adaptadores contém as informações necessárias para a conexão com o banco de dados.
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=middleware
  DB_USERNAME=root
  DB_PASSWORD=

deve-se criar um banco de dados com o nome "middleware" utilizando mysql, de preferência utilizar o usuário root com senha em branco, caso queira mudar,
apenas altere no arquivo essas opção tanto no registrador de adaptadores como no serviço produtor de séries.

-Requisitos para a execução da implementação: composer instalado, mysql, java 8, node versão 14 ou superior.


 - Integrador de fontes: necessida do node instalado versão 14 ou superior. Rodar os comandos "npm install" e "npm start" respectivamente.
 - Registrador de adaptadores: rodar "composer install" depois "php -S localhost:8082 -t public/"
 - Adaptador hidrológico: rodar "composer install" depois "php -S localhost:8088 -t public/", logo após, executar o comando "php artisan db:seed --class=GravarEventosHidrologicoSeeder" para realizar a coleta das observações.
 - Adaptador Twitter: configurar a sua chave de acesso com a plataforma Twitter e executar o programa.
 - Produtor de séries temporais: rodar "composer install" depois "php -S localhost:8083 -t public/"
 - Frontend: executar "npm install" e "npm start"
 
