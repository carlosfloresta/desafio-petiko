# desafio-petiko
 

<P>Nesse desafio você usará um pouco de sua habilidade Full Stack. Queremos que você construa uma aplicação usando dados abertos da API de consulta de CEPs VIACEP. </p>

<P> O objetivo é criar uma aplicação que simule um formulário de pedido com nome do cliente e endereço. Com base no CEP digitado pelo cliente localize e autocomplete o endereço utilizando os dados disponibilizados pela API VIACEP. Ao clicar no botão salvar enviar esses dados para sua aplicação criar e salvar um pedido fictício para esse cliente com entrega neste endereço.</p>
<P> Exigências:

- Criar um backend para coletar esses dados via API json e disponibilize-os para o front.
- Valide os campos autopreenchidos com a busca, não permitindo que o cliente submeta as informações com campos não preenchidos.
- Garantir que o endereço preenchido pelo cliente no frontend esteja realmente igual ao endereço fornecido para aquele CEP no backend.
- Usar Laravel no Backend
- Usar Bootstrap no frontend</p>

<P> Extras:

- Usar outra fonte de consulta de endereço POSTMON, para casos de instabilidade, ou o endereço não for encontrado.</p>


## Desafio concluido!

- link: https://desafio-petiko.alldox.online/
- Tecnologias utilizadas: Javascript, ajax, php, laravel, bootstrap, mysql
- Foram feitas duas paginas uma de formulario e outra de uma tabela mostrando os pedidos adicionados no db.
- Foram feitas validações no front e backend.
- Foi utilizado ajax para pesquisa dinamica do cep a api que esta no backend laravel, e foi utilizado tambem para salvar os dados no banco.
- No backend foi feita toda validação da api se uma api não estiver disponivel ou demorar a responder a requisição é enviada para a outra. Também é validado antes o cep. Quando é salvo tudo no banco, é verificado novamente junto a api se o usuario não modificou o cep por algum invalido, depois de verificado, a ultima verificação é se o usuario não alterou os outros dados ou seja é verificado se o logradouro é de fato daquele cep.

## Para executar:

- Faça o clone desse repositório
- Tenha instalado xampp ou outro de sua preferencia
- Dentro da pasta do projeto execute: php artisan key:generate para gerar a chave
- Crie o .env (pode usar o de exemplo) configure o banco.
- Execute php artisan migrate para criar as tabelas do banco.
- Por fim execute php artisan serve

## Se encontrar dificuldade de executar tente limpar os caches:

- php artisan cache:clear
- php artisan route:clear
- php artisan config:clear
- php artisan view:clear


