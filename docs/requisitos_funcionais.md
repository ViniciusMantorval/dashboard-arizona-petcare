# 1. Requisitos Funcionais

Os requisitos abaixo descrevem o comportamento implementado na aplicação Laravel. Na interface, o tutor do animal é chamado de **cliente**; no código, ele corresponde ao model `Tutor`.

**Perfis de acesso** (`users.perfil`):

- **Dono da clínica** (`dono`): acessa todas as funcionalidades, inclusive o cadastro de funcionários.
- **Funcionário** (`funcionario`): acessa clientes, pets, consultas e exames.

A aplicação trabalha com **uma clínica compartilhada**: novos funcionários e consultas são vinculados automaticamente à primeira clínica cadastrada.

## 1.1. RF1 – Cadastrar funcionário

### Descrição

O sistema deve permitir que o dono da clínica cadastre funcionários por meio de um formulário com dados pessoais, contato, especialidade, CRMV, perfil de acesso e senha. O cadastro cria, na mesma transação, a conta de acesso (`User`) e o registro do funcionário, que fica ativo e vinculado à clínica.

### Regras de Negócio

- Somente o perfil **dono** acessa o cadastro de funcionários.
- Nome (até 100 caracteres), e-mail, CPF, telefone, perfil de acesso e senha são obrigatórios.
- O e-mail deve ter formato válido, ter até 120 caracteres e ser único entre as contas de acesso e entre os funcionários.
- O CPF deve ser único entre os funcionários.
- CPF e telefone são armazenados somente com dígitos; as máscaras são aplicadas apenas na interface.
- Especialidade (lista pré-definida) e CRMV são opcionais.
- O perfil de acesso deve ser `dono` ou `funcionario`.
- A senha deve ter no mínimo 8 caracteres e ser confirmada.
- O funcionário é criado como ativo.

### Dados utilizados

Nome, e-mail, CPF, telefone, especialidade, CRMV, perfil de acesso, senha e confirmação, clínica vinculada.

## 1.2. RF2 – Editar dados de funcionário

### Descrição

O sistema deve permitir que o dono da clínica selecione um funcionário e altere os seus dados pessoais, de contato, especialidade, CRMV, perfil de acesso e, opcionalmente, a senha. A alteração atualiza o funcionário e a respectiva conta de acesso.

### Regras de Negócio

- O funcionário deve estar previamente cadastrado.
- Aplicam-se as mesmas validações do RF1.
- O CPF e o e-mail não podem ser alterados para valores já utilizados por outro funcionário ou conta.
- A senha é opcional na edição: se ficar em branco, a senha atual é mantida.

### Dados utilizados

`id_funcionario`, nome, e-mail, CPF, telefone, especialidade, CRMV, perfil de acesso, senha (opcional).

## 1.3. RF3 – Remover/inativar funcionário

### Descrição

O sistema deve permitir que o dono da clínica inative, reative ou exclua um funcionário. A inativação preserva o cadastro e o retira das opções de agendamento. A exclusão remove o funcionário e a sua conta de acesso.

### Regras de Negócio

- A inativação e a reativação alternam a situação ativo/inativo do funcionário.
- Funcionários inativos não são oferecidos para novas consultas.
- A exclusão exige confirmação na interface, que informa que a conta de acesso também será removida.
- O usuário não pode excluir o funcionário vinculado à própria conta.
- A exclusão remove em cascata as consultas atribuídas ao funcionário e os exames dessas consultas.

### Dados utilizados

`id_funcionario`, `user_id`, situação ativo/inativo, consultas e exames vinculados.

**Observação:** a inativação não bloqueia o login da conta de acesso do funcionário.

## 1.4. RF4 – Listar funcionários

### Descrição

O sistema deve apresentar ao dono da clínica a lista de funcionários, com busca por nome, CPF ou e-mail e acesso às ações de edição, inativação e exclusão.

### Regras de Negócio

- A busca usa um único campo e aceita correspondência parcial de nome, e-mail ou CPF (os dígitos do CPF são comparados sem máscara).
- A lista é ordenada pelo nome do funcionário.
- São exibidos nome, CPF, telefone, especialidade, perfil, clínica e situação.
- Deve ser possível limpar a busca.
- Quando não houver resultados, o sistema informa "Nenhum funcionário encontrado."

### Dados utilizados

Nome, e-mail, CPF, telefone, especialidade, perfil, clínica, situação e termo de busca.

## 1.5. RF5 – Cadastrar cliente

### Descrição

O sistema deve permitir que usuários autenticados cadastrem clientes por meio de um formulário com dados pessoais e de contato. O cliente é registrado como ativo.

### Regras de Negócio

- O nome é obrigatório (até 100 caracteres).
- E-mail (formato válido, até 120 caracteres), endereço (até 150), telefone e CPF são opcionais.
- CPF e telefone são armazenados somente com dígitos.
- Não há verificação de unicidade de CPF ou e-mail entre clientes.

### Dados utilizados

Nome, e-mail, CPF, telefone, endereço.

## 1.6. RF6 – Editar dados do cliente

### Descrição

O sistema deve permitir selecionar um cliente e alterar seu nome, CPF, endereço e informações de contato, mantendo o mesmo cadastro e os vínculos com seus pets.

### Regras de Negócio

- O cliente deve estar previamente cadastrado.
- A edição atualiza o mesmo registro, sem criar um novo cliente.
- Aplicam-se as mesmas validações do RF5.
- A alteração não afeta os pets vinculados.
- Após salvar, o sistema exibe a ficha do cliente.

### Dados utilizados

`id_tutor`, nome, CPF, e-mail, telefone e endereço.

## 1.7. RF7 – Remover cliente

### Descrição

O sistema deve permitir excluir definitivamente um cliente cadastrado, junto com seus pets e o histórico desses pets.

### Regras de Negócio

- O cliente deve existir no sistema.
- A interface solicita confirmação antes da exclusão, informando que os pets e o histórico também serão removidos.
- A exclusão remove em cascata os pets do cliente, as consultas desses pets e os registros de exame.

### Dados utilizados

`id_tutor`, nome, pets, consultas e exames vinculados.

**Observação:** a interface não oferece inativação de cliente (o campo `ic_ativo_tutor` existe e é usado para filtrar clientes ativos nos formulários). Os arquivos de exame em `public/uploads/exames` não são apagados do disco na exclusão.

## 1.8. RF8 – Listar clientes

### Descrição

O sistema deve apresentar os clientes cadastrados com seus dados de contato e pets, permitindo localizá-los e acessar a ficha, a edição, a exclusão e o cadastro de novos pets.

### Regras de Negócio

- Os filtros são nome, CPF, e-mail e nome de pet vinculado, todos com correspondência parcial.
- Filtros preenchidos são combinados (todos devem ser atendidos); filtros vazios não restringem o resultado.
- A lista é atualizada enquanto o usuário digita, sem recarregar a página.
- Os resultados são ordenados pelo nome do cliente.
- Cada linha mostra o cliente, o contato, o CPF e os pets, com link para o histórico de cada pet.
- Quando não houver resultados, o sistema informa "Nenhum cliente encontrado."

### Dados utilizados

`id_tutor`, nome, CPF, e-mail, telefone, endereço, pets vinculados e critérios de busca.

## 1.9. RF9 – Cadastrar pet para cada cliente

### Descrição

O sistema deve permitir cadastrar um pet vinculado a um cliente existente, registrando nome, espécie, raça e peso. O pet é cadastrado como ativo.

### Regras de Negócio

- Todo pet deve estar vinculado a um cliente existente; um cliente pode ter vários pets.
- O formulário oferece apenas clientes ativos e pode vir com o cliente pré-selecionado.
- Cliente, nome (até 50 caracteres) e espécie (até 50, com sugestões) são obrigatórios.
- A raça é opcional (até 50 caracteres).
- O peso é opcional; quando informado, deve ser numérico, entre 0 e 999,99 kg, com duas casas decimais. O peso não informado fica vazio e é exibido como "—".

### Dados utilizados

`id_tutor`, nome do pet, espécie, raça, peso e situação ativo/inativo.

## 1.10. RF10 – Editar dados do pet

### Descrição

O sistema deve permitir alterar os dados de um pet cadastrado, inclusive o cliente responsável, mantendo o mesmo registro e o seu histórico.

### Regras de Negócio

- O pet deve estar previamente cadastrado.
- Aplicam-se as mesmas validações do RF9.
- O cliente pode ser trocado por outro cliente ativo; o cliente atual continua disponível na lista mesmo se estiver inativo.
- A edição preserva o identificador do pet, suas consultas e exames.
- Após salvar, o sistema exibe o histórico do pet.

### Dados utilizados

`id_pet`, `id_tutor`, nome do pet, espécie, raça e peso.

## 1.11. RF11 – Remover/inativar pet

### Descrição

O sistema deve permitir inativar, reativar ou excluir definitivamente um pet.

### Regras de Negócio

- O pet deve existir no sistema.
- A inativação e a reativação alternam a situação ativo/inativo, preservando os dados e o histórico.
- Pets inativos não são oferecidos para novas consultas.
- A exclusão exige confirmação, informando que todo o histórico (consultas e exames) será apagado e que a ação não pode ser desfeita.
- A exclusão remove em cascata as consultas do pet e os registros de exame.

### Dados utilizados

`id_pet`, nome do pet, situação ativo/inativo, consultas e exames vinculados.

**Observação:** os arquivos de exame não são apagados do disco na exclusão.

## 1.12. RF12 – Listar pets por cliente

### Descrição

O sistema deve permitir consultar os pets cadastrados, todos ou apenas os de um cliente, com acesso ao histórico, à edição, à inativação e à exclusão.

### Regras de Negócio

- A listagem geral pode ser filtrada por cliente e por busca textual com correspondência parcial de nome, espécie ou raça.
- A listagem de um cliente específico (a partir da ficha do cliente) apresenta somente os pets vinculados a ele.
- A lista é ordenada pelo nome do pet e exibe espécie, raça, peso, cliente e situação.
- Deve ser possível limpar os filtros.
- Quando não houver resultados, o sistema informa "Nenhum pet encontrado."

### Dados utilizados

`id_pet`, `id_tutor`, nome do pet, espécie, raça, peso, nome do cliente, situação e filtros.

## 1.13. RF13 – Visualizar histórico médico completo do pet

### Descrição

O sistema deve permitir visualizar o histórico de consultas e exames de um pet, reunindo os dados do animal e do cliente, os atendimentos e os arquivos de exame.

### Regras de Negócio

- O pet deve existir; caso contrário, o sistema exibe a página de erro 404.
- São exibidas somente as consultas do pet, da mais recente para a mais antiga (data e horário).
- Cada consulta informa data, horário, estado, motivo, profissional e clínica.
- Os exames de cada consulta aparecem como links de download, com o nome original do arquivo.
- Sem consultas, o sistema informa "Este pet ainda não tem consultas."
- A tela oferece atalhos para editar o pet e agendar uma consulta para ele.

### Dados utilizados

`id_pet`, nome, espécie, raça, peso, situação, nome e telefone do cliente, consultas (data, horário, motivo, estado, profissional, clínica) e exames (nome, observação, arquivo).

## 1.14. RF14 – Agendar consulta

### Descrição

O sistema deve permitir agendar uma consulta para um pet, selecionando o profissional, o cliente, o pet, a data e o horário, com motivo opcional.

### Regras de Negócio

- Profissional, pet, data e horário são obrigatórios.
- O formulário oferece apenas funcionários ativos, clientes ativos e pets ativos.
- Ao escolher o cliente, a lista de pets é filtrada para os pets desse cliente.
- A data deve ser hoje ou uma data futura; o horário deve estar no formato HH:MM.
- O motivo é opcional (até 255 caracteres).
- A consulta é vinculada automaticamente à clínica e criada com o estado "Pendente".
- O agendamento pode partir do histórico do pet, com o pet pré-selecionado.

### Dados utilizados

`id_atendimento`, `FUNCIONARIO_id_funcionario`, `id_tutor` (somente para filtrar pets), `PET_id_pet`, `clinica_id`, data, horário, motivo e estado.

## 1.15. RF15 – Reagendar consulta

### Descrição

O sistema deve permitir alterar a data, o horário, o profissional e o motivo de uma consulta, sem alterar o pet, o cliente, a clínica e o estado.

### Regras de Negócio

- A consulta deve estar previamente cadastrada.
- Na listagem, a ação de reagendamento é exibida para consultas "Pendente" ou "Confirmada".
- Cliente e pet aparecem bloqueados no formulário.
- Profissional, data e horário seguem as validações do agendamento (RF14).
- O identificador e o estado atual da consulta são mantidos.

### Dados utilizados

`id_atendimento`, profissional, nova data, novo horário e motivo.

## 1.16. RF16 – Cancelar consulta

### Descrição

O sistema deve permitir cancelar uma consulta, alterando o seu estado para "Cancelada" e preservando o registro no histórico do pet.

### Regras de Negócio

- A consulta deve existir.
- Na listagem, a ação de cancelamento é exibida para consultas "Pendente" ou "Confirmada".
- A interface solicita confirmação antes do cancelamento.
- O cancelamento altera apenas o estado, sem excluir a consulta.

### Dados utilizados

`id_atendimento`, estado atual e novo estado "Cancelada".

## 1.17. RF17 – Listar consultas

### Descrição

O sistema deve apresentar todas as consultas cadastradas com data, horário, pet, cliente, profissional, clínica e estado, oferecendo as ações disponíveis para cada uma.

### Regras de Negócio

- A listagem está disponível para os perfis dono e funcionário, que veem todas as consultas.
- As consultas são ordenadas da data e horário mais recentes para os mais antigos.
- O estado de cada consulta pode ser alterado diretamente na lista (RF19).
- Consultas "Pendente" ou "Confirmada" exibem as ações reagendar e cancelar; consultas "Concluída" exibem a ação de adicionar exames.
- Quando não houver resultados, o sistema informa "Nenhuma consulta encontrada com esses filtros."

### Dados utilizados

`id_atendimento`, data, horário, pet, cliente, profissional, clínica e estado.

## 1.18. RF18 – Buscar/filtrar consultas

### Descrição

O sistema deve permitir localizar consultas filtrando por data, nome do cliente, nome do pet e estado, individualmente ou em conjunto.

### Regras de Negócio

- Os filtros são opcionais; filtros preenchidos são combinados (todos devem ser atendidos).
- Data e estado são comparados por igualdade.
- Cliente e pet aceitam correspondência parcial do nome.
- Deve ser possível limpar os filtros.
- O painel oferece um atalho para as consultas do dia ("Ver todas").

### Dados utilizados

Data, nome do cliente, nome do pet, estado e dados das consultas.

## 1.19. RF19 – Alterar estado da consulta (Pendente, Confirmada, Concluída, Cancelada)

### Descrição

O sistema deve permitir alterar o estado de uma consulta entre "Pendente", "Confirmada", "Concluída" e "Cancelada", refletindo a mudança na listagem e no histórico do pet.

### Regras de Negócio

- A consulta deve existir.
- O estado informado deve ser uma das quatro opções; qualquer transição entre elas é permitida.
- A alteração é enviada assim que o usuário escolhe o novo estado na lista.
- A inclusão de exames fica disponível somente para consultas "Concluída" (RF21).

### Dados utilizados

`id_atendimento`, estado atual e novo estado.

## 1.20. RF20 – Notificar cliente sobre agendamento/cancelamento/reagendamento

**Status: não implementado (trabalho futuro).**

### Descrição

O sistema deverá notificar por e-mail o cliente responsável pelo pet quando uma consulta for agendada, cancelada ou reagendada.

### Regras de Negócio

- A notificação deverá corresponder ao evento ocorrido e ser enviada ao e-mail cadastrado do cliente.
- A mensagem deverá identificar o evento, o pet, a data, o horário e a clínica; no reagendamento, os dados atualizados.

### Dados utilizados

`id_atendimento`, tipo de evento, nome e e-mail do cliente, nome do pet, data, horário, clínica e profissional.

## 1.21. RF21 – Adicionar lista de exames a consultas concluídas

### Descrição

O sistema deve permitir adicionar um ou mais exames a uma consulta concluída, informando para cada exame o nome, observações opcionais e o arquivo.

### Regras de Negócio

- Sem uma consulta selecionada, a tela lista as consultas concluídas para escolha; sem nenhuma, informa "Nenhuma consulta concluída ainda."
- A consulta deve existir e estar no estado "Concluída"; caso contrário, o envio é recusado com a mensagem "Só consultas concluídas podem receber exames."
- Pelo menos um exame deve ser enviado.
- Cada exame exige nome (até 100 caracteres, com sugestões) e arquivo; a observação é opcional (até 255 caracteres).
- É possível adicionar e remover linhas antes de salvar, mantendo ao menos uma linha.
- Novos envios acrescentam exames à consulta, sem substituir os anteriores.
- Após salvar, o sistema exibe a lista de exames filtrada pelo pet da consulta.
- A lista de exames pode ser filtrada por pet; sem resultados, informa "Nenhum exame encontrado."

### Dados utilizados

`id_exame`, `id_atendimento`, nome do exame, observação, arquivo e nome original do arquivo.

## 1.22. RF22 – Upload/anexo de arquivos de exame (PDF, imagem)

### Descrição

O sistema deve permitir anexar arquivos de exame em PDF ou imagem, armazená-los e disponibilizá-los para download.

### Regras de Negócio

- Extensões aceitas: PDF, JPG, JPEG, PNG e WEBP.
- Tamanho máximo por arquivo: 5 MB.
- Envio sem arquivo, com tipo inválido ou acima do limite é recusado com mensagem de validação.
- O arquivo é gravado em `public/uploads/exames` com nome gerado pelo sistema (nome do exame + data/hora + sufixo aleatório), preservando o nome original para o download.
- Os anexos podem ser baixados pela lista de exames e pelo histórico do pet.

### Dados utilizados

`id_exame`, arquivo enviado, nome original, extensão, nome gerado e caminho de armazenamento.

**Observação:** não há tratamento específico para falha de gravação do arquivo no disco; nesse caso, a requisição termina com erro do servidor.
