# 3. Casos de Uso

Os casos de uso descrevem o comportamento implementado na aplicação Laravel. Os casos UC01 a UC22 correspondem aos requisitos RF1 a RF22 (`requisitos_funcionais.md`); o UC20 não foi escrito porque o RF20 não está implementado. Os casos UC23 a UC25 cobrem a autenticação.

**Atores**

- **Visitante:** pessoa ainda não autenticada.
- **Usuário:** pessoa autenticada com perfil *Dono da clínica* ou *Funcionário*.
- **Dono da clínica:** usuário com perfil `dono`; é o único com acesso ao cadastro de funcionários.

**Convenção dos cenários alternativos:** o número indica a etapa do cenário principal que mudou; a letra identifica o cenário. Por exemplo, "4a" é a primeira alternativa da etapa 4.

**Pré-condição comum a UC01–UC22 e UC24:** o ator está autenticado. Um acesso sem autenticação é redirecionado para a tela de login (UC23).

| UC | Nome | Ator | RF |
|---|---|---|---|
| UC01 | Cadastrar funcionário | Dono da clínica | RF1 |
| UC02 | Editar dados de funcionário | Dono da clínica | RF2 |
| UC03 | Remover/inativar funcionário | Dono da clínica | RF3 |
| UC04 | Listar funcionários | Dono da clínica | RF4 |
| UC05 | Cadastrar cliente | Usuário | RF5 |
| UC06 | Editar dados do cliente | Usuário | RF6 |
| UC07 | Remover cliente | Usuário | RF7 |
| UC08 | Listar clientes | Usuário | RF8 |
| UC09 | Cadastrar pet | Usuário | RF9 |
| UC10 | Editar dados do pet | Usuário | RF10 |
| UC11 | Remover/inativar pet | Usuário | RF11 |
| UC12 | Listar pets por cliente | Usuário | RF12 |
| UC13 | Visualizar histórico médico do pet | Usuário | RF13 |
| UC14 | Agendar consulta | Usuário | RF14 |
| UC15 | Reagendar consulta | Usuário | RF15 |
| UC16 | Cancelar consulta | Usuário | RF16 |
| UC17 | Listar consultas | Usuário | RF17 |
| UC18 | Buscar/filtrar consultas | Usuário | RF18 |
| UC19 | Alterar estado da consulta | Usuário | RF19 |
| UC20 | *(não implementado)* | — | RF20 |
| UC21 | Adicionar exames a consulta concluída | Usuário | RF21 |
| UC22 | Anexar arquivo de exame | Usuário | RF22 |
| UC23 | Entrar no sistema (login) | Visitante | — |
| UC24 | Sair do sistema (logout) | Usuário | — |
| UC25 | Recuperar senha | Visitante | — |

---

## UC01 – Cadastrar funcionário

- Nome: Cadastrar funcionário
- Ator: Dono da clínica
- Pré-condições: o ator está autenticado com perfil `dono`.
- Pós-condições: uma conta de acesso (`User`) e um funcionário ativo, vinculado à clínica, são gravados.
- Breve descritivo: o dono cadastra um novo funcionário, que passa a poder entrar no sistema com o e-mail e a senha informados.
- Cenário principal:
    - 1. Ator: acessa *Funcionários* no menu e clica em *Novo funcionário*.
    - 2. Sistema: exibe o formulário com nome, e-mail, CPF, telefone, especialidade, CRMV, perfil de acesso, senha e confirmação de senha.
    - 3. Ator: preenche os dados e confirma.
    - 4. Sistema: valida os dados, cria a conta e o funcionário na mesma transação e volta à lista com a mensagem "Funcionário cadastrado com sucesso."
- Cenário alternativo:
    - 1a. Sistema: o ator tem perfil `funcionario`; o item *Funcionários* não aparece no menu, e o acesso direto à URL exibe a página de erro 403.
    - 4a. Sistema: algum campo obrigatório está vazio ou é inválido (e-mail mal formado, senha com menos de 8 caracteres, confirmação diferente); o formulário é reexibido com os dados digitados e a mensagem junto a cada campo.
    - 4b. Sistema: o e-mail ou o CPF já está cadastrado; o formulário é reexibido com a mensagem "Este e-mail já está cadastrado." ou "Este CPF já está cadastrado."
- Restrições/Validações: nome até 100 caracteres; e-mail válido, até 120 caracteres, único entre contas e funcionários; CPF único entre funcionários; telefone até 20 caracteres; perfil `dono` ou `funcionario`; senha com no mínimo 8 caracteres e confirmada; especialidade e CRMV opcionais; CPF e telefone gravados só com dígitos.
- Dados relacionados: `users` (name, email, password, perfil); `funcionario` (nm_funcionario, nm_email_funcionario, cd_cpf_funcionario, cd_telefone_funcionario, nm_especialidade_funcionario, cd_crmv_funcionario, ic_ativo_funcionario, user_id, clinica_id).

## UC02 – Editar dados de funcionário

- Nome: Editar dados de funcionário
- Ator: Dono da clínica
- Pré-condições: o ator está autenticado com perfil `dono`; o funcionário existe.
- Pós-condições: os dados do funcionário e da sua conta de acesso são atualizados.
- Breve descritivo: o dono altera os dados pessoais, de contato, o perfil ou a senha de um funcionário.
- Cenário principal:
    - 1. Ator: na lista de funcionários, clica no ícone *Editar* do funcionário.
    - 2. Sistema: exibe o formulário preenchido com os dados atuais; os campos de senha ficam vazios.
    - 3. Ator: altera os dados desejados, deixando a senha em branco, e confirma.
    - 4. Sistema: valida os dados, atualiza o funcionário e a conta mantendo a senha atual, e volta à lista com a mensagem "Funcionário atualizado com sucesso."
- Cenário alternativo:
    - 3a. Ator: preenche uma nova senha e a confirmação.
    - 4a. Sistema: além dos dados, atualiza a senha da conta.
    - 4b. Sistema: o novo e-mail ou CPF pertence a outro funcionário; o formulário é reexibido com a mensagem de duplicidade.
    - 4c. Sistema: algum campo obrigatório foi esvaziado ou é inválido; o formulário é reexibido com as mensagens de validação.
- Restrições/Validações: as mesmas do UC01, sendo a senha opcional; a unicidade ignora o próprio funcionário.
- Dados relacionados: `funcionario`, `users`.

## UC03 – Remover/inativar funcionário

- Nome: Remover/inativar funcionário
- Ator: Dono da clínica
- Pré-condições: o ator está autenticado com perfil `dono`; o funcionário existe.
- Pós-condições: o funcionário fica inativo (ou é reativado); ou o funcionário, a sua conta e as suas consultas são excluídos.
- Breve descritivo: o dono retira um funcionário da agenda, inativando-o, ou o exclui definitivamente.
- Cenário principal:
    - 1. Ator: na lista de funcionários, clica no botão de status de um funcionário ativo.
    - 2. Sistema: marca o funcionário como inativo, exibe "Funcionário inativado." e passa a não oferecê-lo em novos agendamentos.
- Cenário alternativo:
    - 1a. Ator: clica no botão de status de um funcionário inativo.
    - 2a. Sistema: marca o funcionário como ativo e exibe "Funcionário reativado."
    - 1b. Ator: clica no ícone *Excluir*.
    - 2b. Sistema: pede confirmação ("Excluir *nome*? A conta de acesso também será removida."); com a confirmação, exclui a conta, o funcionário e, em cascata, as consultas atribuídas a ele e os exames dessas consultas, e exibe "Funcionário excluído com sucesso."
    - 2c. Sistema: na exclusão, o funcionário é o próprio usuário logado; a exclusão é recusada com a mensagem "Você não pode excluir o próprio acesso."
    - 2d. Sistema: na exclusão, o ator não confirma; nada é alterado.
- Restrições/Validações: não é possível excluir o próprio acesso; a inativação não bloqueia o login do funcionário.
- Dados relacionados: `funcionario` (ic_ativo_funcionario, user_id), `users`, `atendimento`, `exame`.

## UC04 – Listar funcionários

- Nome: Listar funcionários
- Ator: Dono da clínica
- Pré-condições: o ator está autenticado com perfil `dono`.
- Pós-condições: nenhuma alteração de dados.
- Breve descritivo: o dono consulta a equipe e localiza um funcionário por nome, CPF ou e-mail.
- Cenário principal:
    - 1. Ator: acessa *Funcionários* no menu.
    - 2. Sistema: exibe todos os funcionários ordenados por nome, com CPF, telefone, especialidade, perfil, clínica, situação e ações.
    - 3. Ator: digita um termo no campo *Buscar* e envia.
    - 4. Sistema: exibe apenas os funcionários cujo nome, e-mail ou CPF contém o termo.
- Cenário alternativo:
    - 4a. Sistema: nenhum funcionário corresponde; exibe "Nenhum funcionário encontrado."
    - 3a. Ator: clica em *Limpar*.
    - 4b. Sistema: exibe novamente a lista completa.
- Restrições/Validações: no CPF, apenas os dígitos do termo são comparados.
- Dados relacionados: `funcionario`, `users` (perfil), `clinicas`.

## UC05 – Cadastrar cliente

- Nome: Cadastrar cliente
- Ator: Usuário
- Pré-condições: o ator está autenticado.
- Pós-condições: um cliente ativo é gravado.
- Breve descritivo: o usuário cadastra o tutor responsável pelos pets.
- Cenário principal:
    - 1. Ator: acessa *Clientes* no menu e clica em *Novo cliente*.
    - 2. Sistema: exibe o formulário com nome, e-mail, CPF, telefone e endereço.
    - 3. Ator: preenche os dados e confirma.
    - 4. Sistema: valida os dados, grava o cliente como ativo e volta à lista com a mensagem "Cliente cadastrado com sucesso."
- Cenário alternativo:
    - 4a. Sistema: o nome está vazio ou o e-mail é inválido; o formulário é reexibido com as mensagens de validação.
- Restrições/Validações: nome obrigatório (até 100 caracteres); e-mail opcional e válido (até 120); endereço até 150; telefone e CPF opcionais, gravados só com dígitos; sem verificação de duplicidade.
- Dados relacionados: `tutor` (nm_tutor, nm_email_tutor, cd_cpf_tutor, cd_telefone_tutor, nm_endereco_tutor, ic_ativo_tutor).

## UC06 – Editar dados do cliente

- Nome: Editar dados do cliente
- Ator: Usuário
- Pré-condições: o ator está autenticado; o cliente existe.
- Pós-condições: o cadastro do cliente é atualizado; os pets continuam vinculados.
- Breve descritivo: o usuário corrige ou atualiza os dados de um cliente.
- Cenário principal:
    - 1. Ator: na lista de clientes, clica no ícone *Editar* do cliente.
    - 2. Sistema: exibe o formulário preenchido com os dados atuais.
    - 3. Ator: altera os dados e confirma.
    - 4. Sistema: valida, atualiza o cadastro e exibe a ficha do cliente com a mensagem "Cliente atualizado com sucesso."
- Cenário alternativo:
    - 1a. Ator: na ficha do cliente, clica em *Editar*.
    - 4a. Sistema: o nome foi esvaziado ou o e-mail é inválido; o formulário é reexibido com as mensagens de validação.
- Restrições/Validações: as mesmas do UC05.
- Dados relacionados: `tutor`.

## UC07 – Remover cliente

- Nome: Remover cliente
- Ator: Usuário
- Pré-condições: o ator está autenticado; o cliente existe.
- Pós-condições: o cliente, os seus pets, as consultas desses pets e os registros de exame são excluídos.
- Breve descritivo: o usuário exclui definitivamente um cliente e todo o histórico associado.
- Cenário principal:
    - 1. Ator: na lista de clientes, clica no ícone *Excluir* do cliente.
    - 2. Sistema: pede confirmação ("Excluir *nome*? Os pets e o histórico também serão removidos.").
    - 3. Ator: confirma.
    - 4. Sistema: exclui o cliente e, em cascata, os pets, as consultas e os exames, e exibe "Cliente excluído com sucesso."
- Cenário alternativo:
    - 3a. Ator: cancela a confirmação.
    - 4a. Sistema: nada é alterado.
- Restrições/Validações: a ação não pode ser desfeita; os arquivos de exame permanecem em disco.
- Dados relacionados: `tutor`, `pet`, `atendimento`, `exame`.

## UC08 – Listar clientes

- Nome: Listar clientes
- Ator: Usuário
- Pré-condições: o ator está autenticado.
- Pós-condições: nenhuma alteração de dados.
- Breve descritivo: o usuário localiza clientes e acessa a ficha, a edição, a exclusão e o cadastro de pets.
- Cenário principal:
    - 1. Ator: acessa *Clientes* no menu.
    - 2. Sistema: exibe os clientes ordenados por nome, com contato, CPF, pets (com link para o histórico) e ações.
    - 3. Ator: digita em um ou mais filtros (nome, CPF, e-mail, pet).
    - 4. Sistema: atualiza a lista enquanto o ator digita, mostrando apenas os clientes que atendem a todos os filtros preenchidos.
- Cenário alternativo:
    - 4a. Sistema: nenhum cliente corresponde; exibe "Nenhum cliente encontrado."
    - 3a. Ator: clica no ícone *Ver* de um cliente.
    - 4b. Sistema: exibe a ficha do cliente com dados de contato, pets e atalhos para editar e para cadastrar um novo pet.
- Restrições/Validações: correspondência parcial em todos os filtros; no CPF, apenas os dígitos são comparados.
- Dados relacionados: `tutor`, `pet`.

## UC09 – Cadastrar pet

- Nome: Cadastrar pet para um cliente
- Ator: Usuário
- Pré-condições: o ator está autenticado; existe ao menos um cliente ativo.
- Pós-condições: um pet ativo, vinculado ao cliente, é gravado.
- Breve descritivo: o usuário registra um animal e o associa ao seu tutor.
- Cenário principal:
    - 1. Ator: acessa *Pets* no menu e clica em *Novo pet*.
    - 2. Sistema: exibe o formulário com cliente (somente ativos), nome, espécie (com sugestões), raça e peso.
    - 3. Ator: escolhe o cliente, preenche os dados e confirma.
    - 4. Sistema: valida, grava o pet como ativo e volta à lista de pets com a mensagem "Pet cadastrado com sucesso."
- Cenário alternativo:
    - 1a. Ator: clica em *Adicionar pet* na lista de clientes ou em *Novo pet* na ficha do cliente.
    - 2a. Sistema: exibe o formulário com o cliente já selecionado.
    - 4a. Sistema: o cliente, o nome ou a espécie estão vazios, ou o peso está fora de 0–999,99; o formulário é reexibido com as mensagens de validação.
- Restrições/Validações: cliente deve existir; nome e espécie até 50 caracteres; raça opcional (até 50); peso opcional, numérico, de 0 a 999,99 kg.
- Dados relacionados: `pet` (id_tutor, nm_pet, nm_especie_pet, nm_raca_pet, qt_peso_pet, ic_ativo_pet), `tutor`.

## UC10 – Editar dados do pet

- Nome: Editar dados do pet
- Ator: Usuário
- Pré-condições: o ator está autenticado; o pet existe.
- Pós-condições: os dados do pet são atualizados; o histórico é preservado.
- Breve descritivo: o usuário corrige os dados do animal, inclusive o cliente responsável.
- Cenário principal:
    - 1. Ator: na lista de pets ou no histórico do pet, clica em *Editar*.
    - 2. Sistema: exibe o formulário preenchido; a lista de clientes contém os clientes ativos e o cliente atual.
    - 3. Ator: altera os dados e confirma.
    - 4. Sistema: valida, atualiza o pet e exibe o histórico do pet com a mensagem "Pet atualizado com sucesso."
- Cenário alternativo:
    - 3a. Ator: escolhe outro cliente.
    - 4a. Sistema: transfere o pet, com todo o histórico, para o novo cliente.
    - 4b. Sistema: dados inválidos; o formulário é reexibido com as mensagens de validação.
- Restrições/Validações: as mesmas do UC09.
- Dados relacionados: `pet`, `tutor`.

## UC11 – Remover/inativar pet

- Nome: Remover/inativar pet
- Ator: Usuário
- Pré-condições: o ator está autenticado; o pet existe.
- Pós-condições: o pet fica inativo (ou é reativado); ou o pet e o seu histórico são excluídos.
- Breve descritivo: o usuário retira um pet dos agendamentos, inativando-o, ou o exclui definitivamente.
- Cenário principal:
    - 1. Ator: na lista de pets, clica no botão de status de um pet ativo.
    - 2. Sistema: marca o pet como inativo, exibe "Pet inativado." e passa a não oferecê-lo em novos agendamentos.
- Cenário alternativo:
    - 1a. Ator: clica no botão de status de um pet inativo.
    - 2a. Sistema: marca o pet como ativo e exibe "Pet reativado."
    - 1b. Ator: clica no ícone *Excluir*.
    - 2b. Sistema: pede confirmação ("Excluir *nome* definitivamente? Isso apaga todo o histórico do pet (consultas e exames). Não dá para desfazer."); com a confirmação, exclui o pet, as consultas e os exames, e exibe "Pet excluído com sucesso."
    - 2c. Sistema: na exclusão, o ator não confirma; nada é alterado.
- Restrições/Validações: a exclusão não pode ser desfeita; os arquivos de exame permanecem em disco.
- Dados relacionados: `pet` (ic_ativo_pet), `atendimento`, `exame`.

## UC12 – Listar pets por cliente

- Nome: Listar pets por cliente
- Ator: Usuário
- Pré-condições: o ator está autenticado.
- Pós-condições: nenhuma alteração de dados.
- Breve descritivo: o usuário consulta os pets cadastrados, todos ou apenas os de um cliente.
- Cenário principal:
    - 1. Ator: acessa *Pets* no menu.
    - 2. Sistema: exibe todos os pets ordenados por nome, com espécie, raça, peso, cliente, situação e ações.
    - 3. Ator: escolhe um cliente e/ou digita um termo de busca e envia.
    - 4. Sistema: exibe apenas os pets do cliente escolhido cujo nome, espécie ou raça contém o termo.
- Cenário alternativo:
    - 1a. Ator: na ficha do cliente, clica em *Ver lista*.
    - 2a. Sistema: exibe somente os pets desse cliente, com o filtro de cliente já preenchido.
    - 4a. Sistema: nenhum pet corresponde; exibe "Nenhum pet encontrado."
    - 3a. Ator: clica em *Limpar*.
    - 4b. Sistema: exibe novamente a lista completa.
- Restrições/Validações: a busca textual aceita correspondência parcial.
- Dados relacionados: `pet`, `tutor`.

## UC13 – Visualizar histórico médico do pet

- Nome: Visualizar histórico médico completo do pet
- Ator: Usuário
- Pré-condições: o ator está autenticado.
- Pós-condições: nenhuma alteração de dados.
- Breve descritivo: o usuário consulta a linha do tempo de consultas e exames de um pet.
- Cenário principal:
    - 1. Ator: clica no ícone *Histórico médico* de um pet (na lista de pets) ou no nome do pet (na lista de clientes, na ficha do cliente ou no painel).
    - 2. Sistema: exibe os dados do pet e do cliente (nome e telefone) e a linha do tempo das consultas, da mais recente para a mais antiga, com data, horário, estado, motivo, profissional, clínica e os exames.
    - 3. Ator: clica em um exame.
    - 4. Sistema: inicia o download do arquivo com o nome original.
- Cenário alternativo:
    - 2a. Sistema: o pet não tem consultas; exibe "Este pet ainda não tem consultas."
    - 2b. Sistema: o pet não existe; exibe a página de erro 404.
    - 3a. Ator: clica em *Agendar consulta*.
    - 4a. Sistema: abre o agendamento (UC14) com o pet pré-selecionado.
- Restrições/Validações: somente as consultas do pet selecionado são exibidas.
- Dados relacionados: `pet`, `tutor`, `atendimento`, `funcionario`, `clinicas`, `exame`.

## UC14 – Agendar consulta

- Nome: Agendar consulta
- Ator: Usuário
- Pré-condições: o ator está autenticado; existem funcionário, cliente e pet ativos.
- Pós-condições: uma consulta no estado "Pendente", vinculada à clínica, é gravada.
- Breve descritivo: o usuário marca um atendimento para um pet com um profissional.
- Cenário principal:
    - 1. Ator: acessa *Consultas* e clica em *Agendar consulta* (o mesmo botão existe no painel).
    - 2. Sistema: exibe o formulário com profissional, cliente, pet, data, horário e motivo, oferecendo apenas registros ativos.
    - 3. Ator: escolhe o profissional e o cliente.
    - 4. Sistema: filtra a lista de pets para os pets do cliente escolhido.
    - 5. Ator: escolhe o pet, a data e o horário, informa o motivo e confirma.
    - 6. Sistema: valida, grava a consulta como "Pendente" e volta à lista de consultas com a mensagem "Consulta agendada com sucesso."
- Cenário alternativo:
    - 1a. Ator: clica em *Agendar consulta* no histórico do pet.
    - 2a. Sistema: exibe o formulário com o cliente e o pet já selecionados.
    - 6a. Sistema: a data é anterior a hoje; o formulário é reexibido com "A data deve ser hoje ou uma data futura."
    - 6b. Sistema: o profissional, o pet, a data ou o horário estão vazios ou inválidos; o formulário é reexibido com as mensagens de validação.
- Restrições/Validações: data ≥ hoje; horário no formato HH:MM (a interface sugere intervalos de 15 minutos); motivo opcional (até 255 caracteres); profissional e pet devem existir; a clínica é atribuída automaticamente.
- Dados relacionados: `atendimento` (PET_id_pet, FUNCIONARIO_id_funcionario, clinica_id, dt_atendimento, hr_atendimento, ds_motivo, ic_status_atendimento), `pet`, `tutor`, `funcionario`, `clinicas`.

## UC15 – Reagendar consulta

- Nome: Reagendar consulta
- Ator: Usuário
- Pré-condições: o ator está autenticado; a consulta existe e está "Pendente" ou "Confirmada".
- Pós-condições: data, horário, profissional e motivo são atualizados; o estado, o pet e a clínica são mantidos.
- Breve descritivo: o usuário muda a data, o horário ou o profissional de uma consulta em aberto.
- Cenário principal:
    - 1. Ator: na lista de consultas, clica no ícone *Reagendar*.
    - 2. Sistema: exibe o formulário preenchido, com cliente e pet bloqueados.
    - 3. Ator: altera o profissional, a data, o horário ou o motivo e confirma.
    - 4. Sistema: valida, atualiza a consulta e volta à lista com a mensagem "Consulta reagendada com sucesso."
- Cenário alternativo:
    - 1a. Sistema: a consulta está "Concluída" ou "Cancelada"; a ação *Reagendar* não é exibida.
    - 4a. Sistema: a nova data é anterior a hoje ou algum campo é inválido; o formulário é reexibido com as mensagens de validação.
- Restrições/Validações: as mesmas do UC14 para profissional, data, horário e motivo.
- Dados relacionados: `atendimento`, `funcionario`.

## UC16 – Cancelar consulta

- Nome: Cancelar consulta
- Ator: Usuário
- Pré-condições: o ator está autenticado; a consulta existe e está "Pendente" ou "Confirmada".
- Pós-condições: a consulta passa ao estado "Cancelada" e continua no histórico.
- Breve descritivo: o usuário cancela uma consulta em aberto sem apagá-la.
- Cenário principal:
    - 1. Ator: na lista de consultas, clica no ícone *Cancelar*.
    - 2. Sistema: pede confirmação ("Cancelar a consulta de *pet*?").
    - 3. Ator: confirma.
    - 4. Sistema: altera o estado para "Cancelada" e exibe "Status da consulta atualizado."
- Cenário alternativo:
    - 3a. Ator: não confirma.
    - 4a. Sistema: nada é alterado.
    - 1a. Ator: escolhe "Cancelada" no seletor de estado da consulta (UC19).
    - 2b. Sistema: altera o estado imediatamente, sem pedir confirmação.
- Restrições/Validações: o cancelamento não exclui a consulta.
- Dados relacionados: `atendimento` (ic_status_atendimento).

## UC17 – Listar consultas

- Nome: Listar consultas
- Ator: Usuário
- Pré-condições: o ator está autenticado.
- Pós-condições: nenhuma alteração de dados.
- Breve descritivo: o usuário acompanha a agenda e acessa as ações de cada consulta.
- Cenário principal:
    - 1. Ator: acessa *Consultas* no menu.
    - 2. Sistema: exibe todas as consultas, das mais recentes para as mais antigas, com data e hora, pet, cliente, veterinário, clínica, seletor de estado e ações conforme o estado.
- Cenário alternativo:
    - 1a. Ator: no painel, clica em *Ver todas* na agenda de hoje.
    - 2a. Sistema: exibe a lista filtrada pela data de hoje.
    - 2b. Sistema: não há consultas; exibe "Nenhuma consulta encontrada com esses filtros."
- Restrições/Validações: "Pendente"/"Confirmada" exibem *Reagendar* e *Cancelar*; "Concluída" exibe *Adicionar exames*; "Cancelada" não exibe ações.
- Dados relacionados: `atendimento`, `pet`, `tutor`, `funcionario`, `clinicas`.

## UC18 – Buscar/filtrar consultas

- Nome: Buscar/filtrar consultas
- Ator: Usuário
- Pré-condições: o ator está autenticado.
- Pós-condições: nenhuma alteração de dados.
- Breve descritivo: o usuário localiza consultas por data, cliente, pet e estado.
- Cenário principal:
    - 1. Ator: na lista de consultas, preenche um ou mais filtros (data, cliente, pet, status) e envia.
    - 2. Sistema: exibe apenas as consultas que atendem a todos os filtros preenchidos, mantendo os filtros no formulário.
- Cenário alternativo:
    - 2a. Sistema: nenhuma consulta corresponde; exibe "Nenhuma consulta encontrada com esses filtros."
    - 1a. Ator: clica em *Limpar*.
    - 2b. Sistema: exibe a lista sem filtros.
- Restrições/Validações: data e status por igualdade; cliente e pet por correspondência parcial do nome; filtros vazios são ignorados.
- Dados relacionados: `atendimento`, `pet`, `tutor`.

## UC19 – Alterar estado da consulta

- Nome: Alterar estado da consulta
- Ator: Usuário
- Pré-condições: o ator está autenticado; a consulta existe.
- Pós-condições: o estado da consulta é atualizado.
- Breve descritivo: o usuário registra o andamento do atendimento (Pendente → Confirmada → Concluída, ou Cancelada).
- Cenário principal:
    - 1. Ator: na lista de consultas, escolhe um novo estado no seletor da consulta.
    - 2. Sistema: envia a alteração automaticamente, grava o novo estado e exibe "Status da consulta atualizado."
- Cenário alternativo:
    - 2a. Sistema: o estado enviado não é uma das quatro opções; a alteração é recusada com "O status selecionado é inválido."
    - 2b. Sistema: o novo estado é "Concluída"; a ação *Adicionar exames* passa a ser exibida para a consulta.
- Restrições/Validações: estados válidos: Pendente, Confirmada, Concluída, Cancelada; qualquer transição é permitida.
- Dados relacionados: `atendimento` (ic_status_atendimento).

## UC20 – Notificar cliente sobre agendamento/cancelamento/reagendamento

Não implementado. Ver RF20 em `requisitos_funcionais.md`.

## UC21 – Adicionar exames a consulta concluída

- Nome: Adicionar lista de exames a consulta concluída
- Ator: Usuário
- Pré-condições: o ator está autenticado; existe ao menos uma consulta "Concluída".
- Pós-condições: um ou mais exames, com arquivo, são vinculados à consulta.
- Breve descritivo: o usuário registra os exames realizados em um atendimento concluído.
- Cenário principal:
    - 1. Ator: na lista de consultas, clica no ícone *Adicionar exames* de uma consulta concluída.
    - 2. Sistema: exibe os dados da consulta, os exames já anexados e uma linha para um novo exame (nome com sugestões, observação e arquivo).
    - 3. Ator: preenche a linha, clica em *Adicionar outro exame* para incluir mais exames, anexa os arquivos (UC22) e clica em *Salvar exames*.
    - 4. Sistema: valida, grava cada exame vinculado à consulta e exibe a lista de exames filtrada pelo pet, com a mensagem "Exames anexados com sucesso."
- Cenário alternativo:
    - 1a. Ator: acessa *Exames* no menu e clica em *Adicionar exames*.
    - 2a. Sistema: lista as consultas concluídas para escolha; ao escolher uma, segue para a etapa 2. Se não houver nenhuma, exibe "Nenhuma consulta concluída ainda."
    - 2b. Sistema: a consulta escolhida (pela URL) não está "Concluída"; em vez do formulário, exibe "Esta consulta está como “*estado*”. Conclua a consulta antes de adicionar exames."
    - 3a. Ator: remove uma das linhas antes de salvar; a última linha não pode ser removida.
    - 4a. Sistema: a consulta não está "Concluída"; o envio é recusado com "Só consultas concluídas podem receber exames."
    - 4b. Sistema: algum exame está sem nome ou sem arquivo; o formulário é reexibido com as mensagens de validação.
- Restrições/Validações: ao menos um exame por envio; nome até 100 caracteres; observação até 255; arquivo obrigatório; novos envios acrescentam exames aos existentes.
- Dados relacionados: `exame` (id_atendimento, nm_exame, ds_observacao, nm_arquivo, nm_arquivo_original), `atendimento`.

## UC22 – Anexar arquivo de exame

- Nome: Upload/anexo de arquivo de exame (PDF, imagem)
- Ator: Usuário
- Pré-condições: o ator está no formulário de exames de uma consulta concluída (UC21).
- Pós-condições: o arquivo é gravado em `public/uploads/exames` e fica disponível para download.
- Breve descritivo: o usuário envia o laudo ou a imagem do exame, que poderá ser baixado depois.
- Cenário principal:
    - 1. Ator: em uma linha de exame, seleciona um arquivo PDF ou de imagem.
    - 2. Sistema: o seletor oferece apenas PDF e imagens.
    - 3. Ator: salva o formulário.
    - 4. Sistema: valida tipo e tamanho, grava o arquivo com um nome gerado (nome do exame + data/hora + sufixo aleatório) e guarda o nome original.
    - 5. Ator: na lista de exames ou no histórico do pet, clica no arquivo.
    - 6. Sistema: inicia o download com o nome original do arquivo.
- Cenário alternativo:
    - 4a. Sistema: o arquivo tem extensão não aceita; o formulário é reexibido com "O arquivo deve ser PDF ou imagem."
    - 4b. Sistema: o arquivo excede 5 MB ou o envio falhou; o formulário é reexibido com a mensagem de validação.
- Restrições/Validações: extensões PDF, JPG, JPEG, PNG e WEBP; até 5 MB por arquivo.
- Dados relacionados: `exame` (nm_arquivo, nm_arquivo_original); pasta `public/uploads/exames`.

## UC23 – Entrar no sistema (login)

- Nome: Entrar no sistema
- Ator: Visitante
- Pré-condições: o visitante possui uma conta (`users`).
- Pós-condições: a sessão é iniciada (e regenerada) e o painel do perfil é exibido.
- Breve descritivo: o visitante se autentica com e-mail e senha.
- Cenário principal:
    - 1. Ator: acessa `/login` (ou `/`, que redireciona para o login).
    - 2. Sistema: exibe o formulário com e-mail e senha.
    - 3. Ator: informa as credenciais e envia.
    - 4. Sistema: valida as credenciais, inicia a sessão e redireciona para o painel do perfil (`/dono/dashboard` ou `/funcionario/dashboard`).
- Cenário alternativo:
    - 4a. Sistema: e-mail ou senha incorretos; exibe "E-mail ou senha inválidos."
    - 4b. Sistema: 5 tentativas falhas no último minuto para o mesmo e-mail e IP; exibe "Muitas tentativas. Aguarde um minuto e tente novamente."
    - 4c. Sistema: e-mail vazio ou mal formado; exibe a mensagem de validação.
    - 3a. Ator: clica em *Esqueci minha senha* (UC25).
- Restrições/Validações: o e-mail é normalizado (minúsculas, sem espaços); limite de 10 requisições por minuto na rota de login.
- Dados relacionados: `users` (email, password, perfil), `sessions`.

## UC24 – Sair do sistema (logout)

- Nome: Sair do sistema
- Ator: Usuário
- Pré-condições: o ator está autenticado.
- Pós-condições: a sessão é invalidada e o token CSRF é renovado.
- Breve descritivo: o usuário encerra a sua sessão.
- Cenário principal:
    - 1. Ator: clica em *Sair* no menu lateral.
    - 2. Sistema: encerra a sessão e exibe a tela de login.
- Cenário alternativo:
    - (não há)
- Restrições/Validações: a saída é feita por POST com token CSRF.
- Dados relacionados: `sessions`.

## UC25 – Recuperar senha

- Nome: Recuperar senha
- Ator: Visitante
- Pré-condições: nenhuma.
- Pós-condições: a senha da conta é redefinida e o visitante pode entrar com a nova senha.
- Breve descritivo: o visitante solicita um link por e-mail e cria uma nova senha.
- Cenário principal:
    - 1. Ator: na tela de login, clica em *Esqueci minha senha*, informa o e-mail e envia.
    - 2. Sistema: se o e-mail existir, envia o link de redefinição; em qualquer caso, exibe "Se o e-mail estiver cadastrado, enviaremos um link para criar uma nova senha."
    - 3. Ator: abre o link recebido, informa e confirma a nova senha.
    - 4. Sistema: valida o token, grava a nova senha e exibe o login com "Senha redefinida. Entre com a nova senha."
- Cenário alternativo:
    - 4a. Sistema: o token é inválido ou expirou; exibe "Link inválido ou expirado. Peça um novo link de recuperação."
    - 4b. Sistema: a senha tem menos de 8 caracteres ou a confirmação não confere; exibe a mensagem de validação.
    - 2a. Sistema: mais de 5 solicitações por minuto; a requisição é recusada (HTTP 429).
- Restrições/Validações: senha de 8 a 72 caracteres, confirmada; a resposta não revela se o e-mail existe. No ambiente local, o e-mail é gravado no log (`MAIL_MAILER=log`) em vez de enviado.
- Dados relacionados: `users`, `password_reset_tokens`.
