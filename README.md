👑 Rainha do Ouro - Estética Afro & E-commerce

O Rainha do Ouro é uma plataforma completa de gestão e vendas desenvolvida para salões de beleza especializados em estética afro. O sistema une a conveniência de um e-commerce de produtos cosméticos com a praticidade de um sistema de agendamento de serviços profissionais, tudo integrado numa interface intuitiva e personalizada.

🚀 Funcionalidades Principais

👤 Área do Cliente

Personalização de Perfil: O sistema identifica o género do cliente para personalizar a experiência visual, como a foto de perfil automática.

E-commerce Integrado: Navegação por categorias de produtos (Lola, Salon Line, Widi Care, etc.) com adição ao carrinho via localStorage.

Agendamentos Online: Interface para marcação de serviços como tranças afro, coloração e cortes femininos/masculinos.

Gestão de Pedidos: Acompanhamento de compras e status de pedidos realizados.

🛠️ Área Administrativa (Dashboard)

Controlo de Acesso: Níveis de permissão distintos para Administradores, Recepcionistas, Cabeleireiros e Atendentes.

Gestão de Staff: CRUD completo de funcionários, incluindo dados contratuais (CLT, Autônomo, Freelancer) e horários de trabalho.

Gestão de Inventário: Controlo de stock de produtos e catálogo de serviços ativos.

Automatização de Vendas: Uso de gatilhos (triggers) na base de dados para registar vendas automaticamente após a confirmação de uma compra.

🛠️ Tecnologias e Dependências

Backend: PHP 8.x

Base de Dados: MySQL/MariaDB

Frontend: HTML5, CSS3, JavaScript (Vanilla)

E-mails: PHPMailer (v6.10) para notificações e recuperação de senha

🗄️ Estrutura da Base de Dados

A base de dados db_rainhadoouro foi desenhada para suportar uma operação complexa:

Núcleo de Vendas: Tabelas de pedidos, itens de pedidos, compras e vendas automáticas.

Operacional: Gestão de agendamentos com status (agendado, realizado, cancelado) e integração com a tabela de clientes.

Segurança: Tabela de login dedicada para funcionários vinculada aos seus IDs de registo.

📈 O que pode ser melhorado (Análise Técnica)

Para tornar este projeto ainda mais robusto e profissional, aqui estão sugestões de evolução:

1. Sincronização de Carrinho (Híbrido)

Atualmente, o carrinho é manipulado via JavaScript no localStorage. Uma melhoria importante seria sincronizar estes dados com a tabela tb_carrinho na base de dados assim que o utilizador fizer login. Isso permite que o cliente comece a compra no telemóvel e termine no computador sem perder os itens.

2. Reforço na Segurança de Dados

Hashing de Senhas: Certifique-se de que as senhas em tb_clientes e tb_login_gerencia são armazenadas com password_hash() e não em texto simples.

Prepared Statements: Embora a pagina_inicial.php já utilize prepare() e bind_param(), é crucial garantir que todos os ficheiros dentro da pasta crud/ sigam este padrão para eliminar riscos de SQL Injection.

3. Melhoria na Experiência do Utilizador (UX)

Feedback em Tempo Real: No agendamento, implementar uma verificação via AJAX para mostrar apenas horários realmente disponíveis, evitando conflitos de agenda.

Páginas de Erro: Substituir o die() no ficheiro de conexão por um tratamento de exceções que redirecione o utilizador para uma página de erro personalizada.

4. Gestão de Imagens

Na base de dados, existem colunas path para produtos e serviços. Seria ideal implementar um sistema de upload no painel administrativo que redimensione automaticamente as imagens para manter a performance do site.

👥 Contribuintes

Victoria Ferreira Santos - Desenvolvedora Full-Stack

Kauã Oliveira - Colaborador do Projeto
