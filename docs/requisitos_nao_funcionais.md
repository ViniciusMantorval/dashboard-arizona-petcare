# 2. Requisitos Não Funcionais

Cada requisito traz critérios de aceitação mensuráveis (quantitativos) ou verificáveis por inspeção (qualitativos), o método de verificação e a situação atual da aplicação.

As metas numéricas são **propostas** para o contexto do projeto: uma clínica, poucos usuários simultâneos e execução local via Docker (`php artisan serve`) com banco SQLite.

**Situação:** ✅ atendido · ⚠️ parcial · ❌ não atendido.

## Resumo

| ID | Requisito | Situação |
|---|---|---|
| RNF-01 | Conexão com banco de dados | ✅ |
| RNF-02 | Segurança da informação | ⚠️ |
| RNF-03 | Responsividade | ✅ |
| RNF-04 | Desempenho | ⚠️ (não medido) |
| RNF-05 | Disponibilidade | ❌ |
| RNF-06 | Backup e recuperação de dados | ❌ |
| RNF-07 | Conformidade com a LGPD | ⚠️ |
| RNF-08 | Usabilidade e acessibilidade | ⚠️ |
| RNF-09 | Compatibilidade com navegadores e dispositivos | ⚠️ (não medido) |
| RNF-10 | Logs de auditoria | ❌ |

## RNF-01 – Conexão com banco de dados

**Descrição:** toda leitura e gravação de dados deve passar pelo Eloquent, usando a conexão configurada no `.env`, sem credenciais no código-fonte.

**Critérios de aceitação:**

1. A conexão é definida apenas por variáveis de ambiente (`DB_CONNECTION`, `DB_DATABASE` etc.); nenhuma credencial aparece em arquivos versionados.
2. `php artisan migrate:fresh --seed` cria o esquema completo (tutor, pet, funcionario, clinicas, atendimento, exame, users) sem erros.
3. Operações que gravam mais de uma tabela (cadastro e edição de funcionário) são atômicas: se uma etapa falhar, nenhuma alteração é persistida.
4. A integridade referencial é garantida por chaves estrangeiras (pet → tutor, atendimento → pet/funcionário/clínica, exame → atendimento).

**Verificação:** inspeção do `.env.example` e de `config/database.php`; execução do comando de migração; inspeção do uso de `DB::transaction` em `FuncionarioController` e `AuthService`.

**Situação:** ✅ Atendido. A conexão padrão é SQLite (`database/database.sqlite`).

## RNF-02 – Segurança da informação

**Descrição:** o sistema deve proteger as credenciais e restringir o acesso aos dados conforme o perfil do usuário.

**Critérios de aceitação:**

1. As senhas são armazenadas com hash bcrypt (custo ≥ 12); nenhuma senha em texto puro no banco.
2. A senha tem no mínimo 8 e no máximo 72 caracteres.
3. Todas as rotas, exceto login e recuperação de senha, exigem autenticação; um acesso anônimo é redirecionado para `/login`.
4. Rotas de funcionários (`/funcionarios*`) retornam **HTTP 403** para o perfil `funcionario`.
5. Todo formulário que altera dados exige token CSRF; uma requisição sem token é rejeitada (HTTP 419).
6. Login: no máximo 5 tentativas falhas por e-mail + IP por minuto, e 10 requisições por minuto na rota. Recuperação de senha: 5 requisições por minuto.
7. A recuperação de senha responde com a mesma mensagem para e-mails cadastrados e não cadastrados.
8. A sessão é regenerada no login e invalidada no logout; a sessão expira após 120 minutos de inatividade.
9. Em produção, a aplicação é servida somente por HTTPS e com `APP_DEBUG=false`.

**Verificação:** inspeção da tabela `users`; testes manuais de acesso anônimo, de acesso por perfil e de envio sem token; tentativas repetidas de login; inspeção de `routes/web.php`, `AuthService` e `.env`.

**Situação:** ⚠️ Parcial. Os critérios 1 a 8 estão implementados. O critério 9 não é atendido no ambiente atual: o Docker expõe HTTP em `127.0.0.1:8000`, e o `.env.example` usa `APP_DEBUG=true`.

## RNF-03 – Responsividade

**Descrição:** a interface deve se adaptar a telas de celular, tablet e desktop.

**Critérios de aceitação:**

1. Todas as telas são utilizáveis nas larguras de 360 px, 768 px e 1366 px, sem rolagem horizontal da página (tabelas podem rolar dentro do próprio contêiner).
2. Abaixo de 900 px, o menu lateral é recolhido e acessível por um botão.
3. Textos e campos continuam legíveis sem zoom (fonte base ≥ 16 px nos campos).

**Verificação:** inspeção manual com as ferramentas de desenvolvedor do navegador nas três larguras, percorrendo as telas de `docs/telas.md`.

**Situação:** ✅ Atendido por inspeção do código: o CSS tem pontos de quebra em 640, 900, 1100 e 1500 px, um menu recolhível e campos com fonte herdada de 1rem (16 px). Ainda não foi confirmado visualmente nas três larguras.

## RNF-04 – Desempenho

**Descrição:** as telas devem responder em tempo adequado para o uso no balcão da clínica.

**Critérios de aceitação:**

1. Com uma base de até 1.000 clientes, 2.000 pets e 5.000 consultas, o percentil 95 do tempo de resposta do servidor é ≤ 1 s nas listagens e ≤ 500 ms nas demais telas.
2. O filtro dinâmico de clientes devolve o resultado em ≤ 1 s após o usuário parar de digitar.
3. Upload de um exame de 5 MB concluído em ≤ 5 s em rede local.
4. As listagens carregam relacionamentos com *eager loading* (sem consultas N+1).

**Verificação:** popular a base com *seeders* de volume e medir com as ferramentas de rede do navegador ou com uma ferramenta de carga (ex.: `ab`, `k6`); inspecionar o uso de `with()` nos controllers.

**Situação:** ⚠️ O critério 4 é atendido. Os critérios 1 a 3 não foram medidos. As listagens não são paginadas, o que é um risco para o critério 1 com bases grandes.

## RNF-05 – Disponibilidade

**Descrição:** o sistema deve estar disponível durante o horário de funcionamento da clínica.

**Critérios de aceitação:**

1. Disponibilidade mensal ≥ 99% em horário comercial (segunda a sábado, 8h às 20h), medida por monitoramento externo.
2. Após uma falha, o serviço é restabelecido em ≤ 1 hora.
3. Em produção, a aplicação roda em servidor web de produção (ex.: Nginx + PHP-FPM) com reinício automático.

**Verificação:** monitor de disponibilidade (*uptime check*) a cada 5 minutos e relatório mensal.

**Situação:** ❌ Não atendido. Há apenas o ambiente local de desenvolvimento (`php artisan serve` em Docker), sem implantação nem monitoramento.

## RNF-06 – Backup e recuperação de dados

**Descrição:** os dados da clínica e os arquivos de exame devem poder ser recuperados após perda ou corrupção.

**Critérios de aceitação:**

1. Backup automático diário do banco de dados e da pasta `public/uploads/exames`.
2. RPO (perda máxima de dados) ≤ 24 horas; RTO (tempo para restaurar) ≤ 4 horas.
3. Retenção mínima de 30 dias, com cópia fora do servidor.
4. Teste de restauração documentado ao menos uma vez por mês.

**Verificação:** inspeção do agendamento de backup e restauração em um ambiente de teste.

**Situação:** ❌ Não atendido. Não há rotina de backup. O arquivo `backup_arizona_petcare.sql` na raiz do projeto está vazio.

## RNF-07 – Conformidade com a LGPD

**Descrição:** o tratamento de dados pessoais de clientes e funcionários (nome, CPF, e-mail, telefone, endereço) e dos dados de saúde animal deve seguir a Lei nº 13.709/2018.

**Critérios de aceitação:**

1. Apenas usuários autenticados acessam dados pessoais (ver RNF-02).
2. Coletam-se apenas os dados necessários ao atendimento; para clientes, somente o nome é obrigatório.
3. É possível eliminar os dados de um cliente a pedido do titular (exclusão do RF7).
4. Os arquivos de exame não são acessíveis sem autenticação.
5. A interface apresenta uma política de privacidade e registra a base legal do tratamento.
6. Ações sobre dados pessoais ficam registradas (ver RNF-10).

**Verificação:** inspeção das rotas e dos formulários; tentativa de acessar a URL de um arquivo de exame sem login; checklist LGPD.

**Situação:** ⚠️ Parcial. Os critérios 1, 2 e 3 são atendidos. Os critérios 4 a 6 não são:

- os arquivos ficam em `public/uploads/exames` e podem ser baixados por qualquer pessoa que conheça a URL;
- a exclusão de cliente ou pet não apaga os arquivos do disco;
- não há política de privacidade nem registro de auditoria.

## RNF-08 – Usabilidade e acessibilidade

**Descrição:** a interface deve ser simples para a equipe da clínica e acessível conforme as WCAG 2.1 nível AA.

**Critérios de aceitação:**

1. Toda a interface está em português do Brasil (`lang="pt-BR"`), inclusive as mensagens de validação.
2. Cada ação concluída exibe uma mensagem de sucesso ou erro; cada campo inválido mostra a mensagem junto a ele.
3. Ações destrutivas (excluir, cancelar) pedem confirmação.
4. A navegação completa é possível pelo teclado, com link "Pular para o conteúdo" e foco visível.
5. Campos têm rótulos associados; botões só com ícone têm texto acessível (`aria-label`/`title`).
6. O contraste de texto é ≥ 4,5:1 (texto normal).
7. Um usuário novo agenda uma consulta para um pet existente em ≤ 2 minutos, sem ajuda.

**Verificação:** auditoria com Lighthouse ou axe DevTools (meta: pontuação de acessibilidade ≥ 90); navegação somente por teclado; teste com usuário cronometrado.

**Situação:** ⚠️ Os critérios 1 a 5 estão implementados (verificados no código). Os critérios 6 e 7 não foram medidos.

## RNF-09 – Compatibilidade com navegadores e dispositivos

**Descrição:** o sistema deve funcionar nos navegadores mais usados, em computador e celular.

**Critérios de aceitação:**

1. Todos os fluxos dos casos de uso funcionam nas duas últimas versões estáveis de Chrome, Edge, Firefox e Safari.
2. Os fluxos funcionam no Chrome para Android e no Safari para iOS (versões atuais).
3. Nenhum erro de JavaScript no console durante os fluxos.
4. Não é necessário instalar plugin ou aplicativo.

**Verificação:** execução manual dos casos de uso em cada navegador, com o console aberto.

**Situação:** ⚠️ O critério 4 é atendido: é uma aplicação web com CSS/JS gerados pelo Vite. Os demais não foram testados formalmente.

## RNF-10 – Logs de auditoria

**Descrição:** alterações no prontuário (consultas e estados), nos exames e nos cadastros devem ser rastreáveis.

**Critérios de aceitação:**

1. Toda criação, alteração e exclusão de consulta, exame, pet, cliente e funcionário gera um registro com usuário, data/hora, ação, entidade, identificador e valores anteriores e novos.
2. Os registros não podem ser alterados nem excluídos pela interface.
3. Os registros são mantidos por pelo menos 5 anos.
4. O dono da clínica consegue consultar os registros por entidade e por período.

**Verificação:** executar cada operação e conferir o registro gerado; tentar alterá-lo pela interface.

**Situação:** ❌ Não atendido. Existem apenas os timestamps `created_at`/`updated_at` e o log de erros do Laravel (`storage/logs`).
