# Arquitetura

Requisitos:

Php >= 7.4<br>
Mysql >= 5.6<br>
Composer<br>
PDO<br>
Curl<br>

Funcionalidade do Sistema:

Gestão do fluxo de contrução ou decoração de uma casa / apartamento, acompanhamento e aprovação de orçamentos pelo cliente, controle financeiro das despesas, abaixo detalhes:

* Gestão de Projetos de Contrução
* Cadastro de Categorias
* Acesso Privado por Cliente
* Controle Financeiro de Gastos
* Controle de Pagamentos
* Agendamento de Reuniões
* Possibilidade de convidar usuários externos para acompanhar o projeto dentro do sistema
* Gestão de Aprovação de Orçamentos de Produtos e Serviços 
* Acompanhamento de Cronogramas da Obra
* Histórico de toda documentação da Obra

# Guia de Instalação

  * Clonar repositório do Docker neste mesmo github:
  
  ```
  git clone https://github.com/DevElias/Docker-Container-Php-MySQL-Apache
  ```
  ![image](https://user-images.githubusercontent.com/14336962/132243143-9581a9c9-205f-4ca8-8819-6448f1b11da1.png)
  
  * Clonar repositório do sistema de Arquitetura
  
  ```
  git clone hhttps://github.com/DevElias/Arquitetura
  ```
  ![image](https://user-images.githubusercontent.com/14336962/132243329-fa958daa-2645-41f1-810b-f4148ea083fa.png)

  * Iniciar instalação do Container
  
  ```
  docker-compose up
  ```
  
  ![image](https://user-images.githubusercontent.com/14336962/132243471-e3417619-5ee8-4e13-bf54-588e43930898.png)
  
  * Testar se os containers do Docker estão rodando corretamente, acessando localhost

 ![image](https://user-images.githubusercontent.com/14336962/132244635-cf29b9fd-856e-47a4-9e7f-7f0024f21dbb.png)

 * Configurar variáveis de ambiente do sistema
 
  ```
  .env - no diretório raiz
  ```  
  ![image](https://user-images.githubusercontent.com/14336962/132243862-ac0de274-8663-4c4e-a91e-1d1fefd9c113.png)

 * Executar as Migrates

  ```
    php artisan migrate
  ```  
  
  ![image](https://user-images.githubusercontent.com/14336962/132244088-0fe4178f-f0fc-48a3-9db4-e4508869d53e.png)

 * Executar Seeder para criar o usuário de teste do sistema

 ```
    php artisan db:seed --class=UserSeeder
  ```  
 * Colocar para rodar o servidor

   ```
    php artisan serve
   ```  

![image](https://user-images.githubusercontent.com/14336962/132244231-71805786-1cd0-403a-85f8-98d8981d6870.png)


Acessar: 
http://127.0.0.1:8000

Usuário de teste:

Email: adm@alfaiatariadesistemas.com
Senha: 12345

# Tela inicial do Sistema:

![image](https://user-images.githubusercontent.com/14336962/132245006-905d53af-0f33-40a8-98c1-ef20a2b35f00.png)


