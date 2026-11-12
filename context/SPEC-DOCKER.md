# Specification — local Docker development

## Goal

Run the application locally using Docker, without PHP or Composer installed on the host.

## Acceptance criteria

- Docker infrastructure lives in `docker/`; Compose bind-mounts the project and serves Laravel on localhost.
- A fresh installation uses persistent SQLite and the existing demo seeder.
- The frontend assets can be built in a container.
- A short how-to explains setup, startup and shutdown.
- The application responds over HTTP after setup.

## Constraints and non-goals

- Do not reset an existing database or modify application business rules.
- Use existing dependencies, migrations and seeders; no host PHP or Composer installation.
- This is a local development setup, not a production deployment.

## Open questions

None.
