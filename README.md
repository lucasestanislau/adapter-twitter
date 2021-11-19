# tcc-projects

Projetos referentes a arquitetura para produção de séries temporais a partir de fontes de dados heterogêneas.

Configuração do bancode dados:

  No arquivo ".env" do registrador de adaptadores contém as informações necessárias para a conexão com o banco de dados.
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=middleware
  DB_USERNAME=root
  DB_PASSWORD=

deve-se criar um banco de dados com o nome "middleware" utilizando mysql, de preferência utilizar o usuário root com senha em branco, caso queira mudar,
apenas altere no arquivo essas opção tanto no registrador de adaptadores como no serviço produtor de séries.


 - Integrador de fontes: necessida do node intalado versão 14 ou superior. Rodar os comandos "npm install" e "npm start" respectivamente.
 
 -
 
