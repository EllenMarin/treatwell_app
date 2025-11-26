✅ Resumo do Projeto

O projeto consiste em uma plataforma completa de agendamento online voltada para salões de beleza, spas, barbearias e centros de bem-estar, desenvolvida com Laravel 11, totalmente containerizada com Docker.

A aplicação permite que clientes façam reservas de serviços, enquanto empresas e seus funcionários gerenciam serviços, horários e atendimentos.

⸻

🧰 Ferramentas e Tecnologias Utilizadas

Backend / Framework
	•	Laravel 11.x (principal framework da aplicação)
	•	PHP 8.2+

Banco de Dados
	•	MySQL 8.0

Cache e Filas
	•	Redis para cache, sessões e filas

Ambiente / Infraestrutura
	•	Docker + Docker Compose
	•	Nginx como servidor web
	•	PHP-FPM rodando a aplicação
	•	Containers dedicados para:
	•	app – aplicação PHP
	•	db – MySQL
	•	redis – Redis
	•	nginx – servidor web
	•	queue – worker do Laravel Queue
	•	scheduler – cron do Laravel
	•	mailhog – teste de e-mails

Outras Ferramentas
	•	Composer (gerenciador de dependências)
	•	Mailhog (captura e visualização de e-mails de desenvolvimento)

⸻

🔄 Fluxo de Negócio (Business Flow)

A seguir, o fluxo completo da plataforma, mostrando como clientes, empresas e funcionários interagem.

⸻

1. Registro e Autenticação
	•	Usuários se registram como clientes ou donos de negócio.
	•	Perfis possuem roles definidas (customer, business, staff, admin).
	•	Login via API: /api/login

⸻

2. Gestão do Negócio (para Donos de Salão / Spa / Barbearia)

O dono do negócio pode:
	1.	Criar e editar seu estabelecimento
	2.	Cadastrar categorias do negócio (ex.: cabelo, estética, massagem)
	3.	Criar planos/serviços:
	•	nome
	•	duração
	•	preço
	•	categoria
	•	disponibilidade
	4.	Cadastrar funcionários (staff)
	5.	Gerenciar agendamentos recebidos

Toda essa gestão acontece em endpoints como:
	•	/api/businesses
	•	/api/businesses/{id}/plans
	•	/api/plans/{id}

⸻

3. Cliente busca serviços e empresas

Um cliente pode:
	•	Visualizar todos os negócios (GET /api/businesses)
	•	Filtrar por categorias
	•	Ver detalhes do negócio e seus serviços (GET /api/businesses/{id}/plans)

⸻

4. Processo de Agendamento (Booking Flow)

O cliente:
	1.	Escolhe um negócio
	2.	Seleciona um serviço (Plan)
	3.	Escolhe data e hora
	4.	(Opcional) escolhe um membro da equipe (staff)

O sistema cria um Booking com status:
	•	pending → aguardando confirmação
	•	confirmed → aprovado pelo negócio
	•	completed → concluído
	•	cancelled → cancelado
	•	no_show → cliente não compareceu

⸻

5. Gestão de Agendamentos (Staff e Donos)

O dono ou funcionário pode:
	•	Confirmar ou recusar um agendamento
	•	Atualizar status
	•	Ver todos os agendamentos do dia
	•	Marcar como concluído ou não comparecimento

Endpoints:
	•	GET /api/bookings
	•	PUT /api/bookings/{id}
	•	DELETE /api/bookings/{id}

⸻

6. Filas e Emails
	•	Sistema usa queues Redis para:
	•	enviar emails de confirmação
	•	notificações de lembrete
	•	processamento assíncrono
	•	Mailhog captura os emails enviados no ambiente de desenvolvimento.

⸻

📦 Resumo Geral

O projeto é uma solução robusta de agendamentos construída em Laravel com arquitetura moderna, oferecendo:
	•	Multi-roles (cliente, dono, staff, admin)
	•	Gestão completa do negócio
	•	Serviços e categorias personalizadas
	•	Sistema de reservas automatizado
	•	Containers Docker para todo ambiente
	•	Filas Redis, emails Mailhog e servidor Nginx
	•	API REST estruturada para integração