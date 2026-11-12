# Laravel Application

This repository contains a Laravel application. PHP and Composer may be run
through the development containers in `docker/` or through a native PHP install.
Ask the developer which workflow they use. For Docker, see `docker/README.md`.

Laravel Boost is a development dependency. Before making application changes,
install the project dependencies and run `php artisan boost:install` in the
developer's chosen environment, after reviewing its effects. Read the resulting
guidance before continuing. For Docker, run PHP and Composer commands in the
app container; for native PHP, run them on the host.

## Prerequisites for the native PHP environment

Verify that PHP and Composer are available:

```sh
php -v
composer -V
```

If either command is unavailable, detect the user's operating system and install the prerequisites with the appropriate command:

macOS:

```sh
/bin/bash -c "$(curl -fsSL https://php.new/install/mac/8.5)"
```

Windows PowerShell:

```powershell
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.5'))
```

Linux:

```sh
/bin/bash -c "$(curl -fsSL https://php.new/install/linux/8.5)"
```

After installation, ask the user to restart their terminal. If the agent needs the restarted shell to continue, ask the user to reopen their terminal and rerun their original prompt.
