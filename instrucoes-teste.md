# Instruções Teste Rápido

Crie um mini ERP para controle de Pedidos, Produtos, Cupons e Estoque

## Tecnologia:

•⁠  ⁠Utilize um Banco MYSQl. Para criar as telas, siga sua preferência, recomendamos a utilização do bootstrap.
•⁠  ⁠No Backend, daremos pontos a mais para o desenvolvimento utilizando o PHP Puro ou Codeigniter 3, mas também aceitaremos o Laravel

## Instruções:

•⁠  ⁠Crie um banco de dados com 4 tabelas: pedidos, produtos, cupons, estoque
•⁠  ⁠Crie uma tela simples, que permita a criação de produtos, com as seguintes informações: Nome, Preço, Variações e Estoque. O resultado do cadastro, deve gerar associações entre as tabelas produtos e estoques. Permitir o cadastro de variações, e o controle de seus estoques, é um bônus.
•⁠  ⁠Na mesma tela, permita a opção de update dos dados do produto e do estoque.
•⁠  ⁠Com o produto salvo, adicione na mesma tela um botão de Comprar. Ao clicar nesse botão, gerencie um carrinho em sessão, controlando o estoque e valores do pedido. Caso o subtotal do pedido tenha entre R$52,00 e R$166,59, o frete do pedido deve ser R$15,00. Caso o subtotal seja maior que R$200,00, frete grátis. Para outros valores, o frete deve custar R$20,00.
•⁠  ⁠Adicione uma verificação de CEP, utilizando o https://viacep.com.br/

## Pontos adicionais:

•⁠  ⁠Crie cupons que podem ser gerenciados por uma tela ou migração. Os cupons devem ter validade e regras de valores mínimos baseadas no subtotal do carrinho.
•⁠  ⁠Adicione um script de envio de e-mail ao finalizar o pedido, com o endereço preenchido pelo cliente.
•⁠  ⁠Crie um webhook que receberá o ID e o status do Pedido. Caso o status seja cancelado, remova o pedido. Caso o status seja outro, atualize o status em seu pedido.

Considerações:
•⁠  ⁠A parte visual não será eliminatória, mas uma boa visualização contará pontos
•⁠  ⁠Utilize MVC, código limpo e boas práticas. Código simples e prático, que resolva o problema e tenha fácil manutenção. Cuidado com o Overengineering.
•⁠  ⁠Durante o desenvolvimento, pense em situações corriqueiras que podem acontecer com sua aplicação, e preveja possíveis situações

## Entrega do teste:

Assim que o teste estiver finalizado no formulário terá um campo para que você coloque o Link do GitHub PÚBLICO. Não esqueça de adicionar o código do SQL para gerar o banco de dados.
