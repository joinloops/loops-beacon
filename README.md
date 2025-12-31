# Loops Version Service

A small internal Laravel service that fetches the latest Loops release/version information from GitHub, caches it, and serves a JSON payload for clients and infrastructure to determine whether a given version is up to date.

This service is intended for internal use only.

- Loops project: https://joinloops.org

---

## What it does

- Uses a GitHub token (server-side) to query Loops release metadata
- Caches release/version information to reduce GitHub API calls
- Exposes a simple JSON response containing:
  - `name`
  - `version`
  - `url`
  - timestamp for observability

---

## Requirements

- PHP 8.2+
- Composer
- A GitHub token with access to the Loops repository (and permission to read releases)
- Recommended:
  - Redis or Memcached for cache (file cache works for dev)

---

## Installation

```bash
git clone https://github.com/joinloops/loops-beacon loops-version-service
cd loops-version-service

composer install
cp .env.example .env
php artisan key:generate
```
