# Plan — local Docker development

Specification: `context/SPEC-DOCKER.md`. Approved in conversation.

- [x] Update project guidance to permit container-based setup.
- [x] Add Compose, PHP image and a concise how-to under `docker/`.
- [x] Build images and assets; initialize a new SQLite database and demo data.
- [x] Verify the HTTP response and review the changes.

The Boost installer was reviewed but deferred: it can write agent configuration and guidance outside the Docker setup. No application code was changed. The PHP image uses 8.5 because the locked dependencies require at least 8.4.1.
