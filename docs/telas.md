# 4. Telas do sistema

Roteiro de capturas de tela da aplicação em funcionamento. Substitua cada `{Placeholder imagem}` pela imagem correspondente.

**Preparação**

1. Suba a aplicação conforme `docker/README.md` e acesse <http://localhost:8000>.
2. Use os dados de demonstração (`php artisan migrate --seed`):
   - Dono da clínica: `dono@arizonapetcare.test` / `senha12345`
   - Funcionário: `funcionario@arizonapetcare.test` / `senha12345`
3. Salvo indicação em contrário, as telas são capturadas logado como **dono**.
4. Para telas de mensagem (sucesso, erro, confirmação), capture logo após executar a ação indicada.

## Acesso

#### 1. Tela de login
{Placeholder imagem}

Sem estar logado, acesse `/login` e tire a foto.

#### 2. Login com credenciais inválidas
{Placeholder imagem}

Em `/login`, informe um e-mail cadastrado com uma senha errada e clique em *Entrar*. Capture a mensagem "E-mail ou senha inválidos."

#### 3. Recuperação de senha
{Placeholder imagem}

Em `/login`, clique em *Esqueci minha senha* (ou acesse `/recuperar-senha`), informe um e-mail e envie. Capture a mensagem de confirmação.

#### 4. Redefinição de senha
{Placeholder imagem}

Após a etapa anterior, abra o link de redefinição gravado em `storage/logs/laravel.log` (procure por `redefinir-senha`). Capture o formulário de nova senha.

## Painel

#### 5. Painel do dono da clínica
{Placeholder imagem}

Faça login como dono. O sistema abre `/dono/dashboard`, com os indicadores, a agenda de hoje e os exames recentes.

#### 6. Painel do funcionário
{Placeholder imagem}

Saia (*Sair* no menu lateral) e faça login como funcionário. O sistema abre `/funcionario/dashboard`. Note que o menu não mostra *Funcionários*.

#### 7. Acesso negado (403)
{Placeholder imagem}

Ainda logado como funcionário, acesse `/funcionarios` diretamente pela barra de endereço.

## Funcionários (somente dono)

#### 8. Lista de funcionários
{Placeholder imagem}

Logado como dono, clique em *Funcionários* no menu (`/funcionarios`).

#### 9. Busca de funcionários
{Placeholder imagem}

Em `/funcionarios`, digite "Helena" no campo *Buscar* e clique em *Filtrar*.

#### 10. Cadastro de funcionário
{Placeholder imagem}

Em `/funcionarios`, clique em *Novo funcionário* (`/funcionarios/create`).

#### 11. Validação do cadastro de funcionário
{Placeholder imagem}

Em `/funcionarios/create`, informe o e-mail `funcionario@arizonapetcare.test` (já cadastrado) e senhas diferentes, e envie. Capture as mensagens de erro.

#### 12. Edição de funcionário
{Placeholder imagem}

Em `/funcionarios`, clique no ícone *Editar* de um funcionário.

#### 13. Confirmação de exclusão de funcionário
{Placeholder imagem}

Em `/funcionarios`, clique no ícone *Excluir* de um funcionário (que não seja você) e capture a caixa de confirmação. Cancele em seguida.

## Clientes

#### 14. Lista de clientes
{Placeholder imagem}

Clique em *Clientes* no menu (`/tutores`).

#### 15. Filtro de clientes
{Placeholder imagem}

Em `/tutores`, digite parte do nome de um pet (por exemplo, "Thor") no filtro *Pet*. A lista se atualiza enquanto você digita.

#### 16. Cadastro de cliente
{Placeholder imagem}

Em `/tutores`, clique em *Novo cliente* (`/tutores/create`).

#### 17. Ficha do cliente
{Placeholder imagem}

Em `/tutores`, clique no ícone *Ver* de um cliente que tenha pets.

#### 18. Edição de cliente
{Placeholder imagem}

Na ficha do cliente, clique em *Editar*.

#### 19. Confirmação de exclusão de cliente
{Placeholder imagem}

Em `/tutores`, clique no ícone *Excluir* de um cliente e capture a confirmação ("Os pets e o histórico também serão removidos."). Cancele em seguida.

## Pets

#### 20. Lista de pets
{Placeholder imagem}

Clique em *Pets* no menu (`/pets`).

#### 21. Pets de um cliente
{Placeholder imagem}

Na ficha de um cliente, clique em *Ver lista* (`/tutores/{id}/pets`).

#### 22. Cadastro de pet
{Placeholder imagem}

Em `/pets`, clique em *Novo pet* (`/pets/create`). Para mostrar o cliente pré-selecionado, use *Novo pet* na ficha do cliente.

#### 23. Edição de pet
{Placeholder imagem}

Em `/pets`, clique no ícone *Editar* de um pet.

#### 24. Pet inativado
{Placeholder imagem}

Em `/pets`, clique no botão de status de um pet ativo. Capture a mensagem "Pet inativado." e a situação na lista. Reative-o depois.

#### 25. Histórico médico do pet
{Placeholder imagem}

Em `/pets`, clique no ícone *Histórico médico* de um pet com consultas e exames (por exemplo, Nina ou Kiara) (`/pets/{id}`).

## Consultas

#### 26. Lista de consultas
{Placeholder imagem}

Clique em *Consultas* no menu (`/consultas`).

#### 27. Filtro de consultas
{Placeholder imagem}

Em `/consultas`, escolha o status "Concluída" e clique em *Filtrar*.

#### 28. Filtro sem resultados
{Placeholder imagem}

Em `/consultas`, digite um nome inexistente no filtro *Pet* (por exemplo, "zzz") e clique em *Filtrar*. Capture "Nenhuma consulta encontrada com esses filtros."

#### 29. Agendamento de consulta
{Placeholder imagem}

Em `/consultas`, clique em *Agendar consulta* (`/consultas/create`). Escolha um cliente para mostrar a lista de pets filtrada.

#### 30. Validação de data no agendamento
{Placeholder imagem}

Em `/consultas/create`, preencha os campos com uma data anterior a hoje e envie. Capture "A data deve ser hoje ou uma data futura."

#### 31. Reagendamento de consulta
{Placeholder imagem}

Em `/consultas`, clique no ícone *Reagendar* de uma consulta "Pendente" ou "Confirmada".

#### 32. Confirmação de cancelamento de consulta
{Placeholder imagem}

Em `/consultas`, clique no ícone *Cancelar* de uma consulta em aberto e capture a confirmação. Cancele em seguida.

#### 33. Alteração de estado da consulta
{Placeholder imagem}

Em `/consultas`, abra o seletor de status de uma consulta e escolha outro estado. Capture a mensagem "Status da consulta atualizado."

## Exames

#### 34. Lista de exames
{Placeholder imagem}

Clique em *Exames* no menu (`/exames`).

#### 35. Lista de exames filtrada por pet
{Placeholder imagem}

Em `/exames`, escolha um pet no filtro e clique em *Filtrar*.

#### 36. Escolha de consulta concluída
{Placeholder imagem}

Em `/exames`, clique em *Adicionar exames* (`/exames/create`), sem consulta selecionada.

#### 37. Formulário de exames
{Placeholder imagem}

Em `/consultas`, clique no ícone *Adicionar exames* de uma consulta "Concluída". Clique em *Adicionar outro exame* para mostrar duas linhas.

#### 38. Validação de arquivo de exame
{Placeholder imagem}

No formulário de exames, anexe um arquivo de tipo não aceito (por exemplo, `.txt`, escolhendo "Todos os arquivos" no seletor) e salve. Capture "O arquivo deve ser PDF ou imagem."

#### 39. Exames anexados com sucesso
{Placeholder imagem}

No formulário de exames, preencha o nome, anexe um PDF ou imagem de até 5 MB e clique em *Salvar exames*. O sistema abre a lista de exames filtrada pelo pet.

## Responsividade

#### 40. Painel em celular
{Placeholder imagem}

Nas ferramentas de desenvolvedor do navegador, ative a visualização de dispositivo com 360 px de largura e abra o painel.

#### 41. Menu aberto em celular
{Placeholder imagem}

Na mesma visualização, toque no botão de menu no topo da tela.
