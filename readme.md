# Lumen Log Viewer

Log viewer application built with Lumen and VueJS.

&copy; [Jitendra Adhikari](https://github.com/adhocore)

# Installation

This app requires PHP7 to run.

```bash
# Clone repo
git clone git@github.com:adhocore/log-viewer.git
# OR
git clone https://github.com/adhocore/log-viewer.git

cd log-viewer

composer install

# Quick Demo
php -S localhost:8080 -t public

# Then it should be available at http://localhost:8080
```


# Configuration

- The app can be configured using `.env` file at the project root root. It is automatically cloned from `.env.example` during first `composer install`. Or you can do it manually `cp .env.example .env`.
- For a production environment, you might want to set the value of `APP_ENV` to `production` and `APP_DEBUG` to `false`.
- `LOG_PATH` is the directory from where the logs are read. It can be either relative or absolute path. If it is relative then resolved from the root path of this app. The logs files not falling within the `LOG_PATH` are not read by the app.
- **Example 1**: If you have `LOG_PATH=/var/log`, then trying to read `/var/www/log.log` is forbidden but `/var/log/deep/nested/log.log` is allowed.
- **Example 2**: If you omit the full path from input in [log-viewer UI](http://localhost:8080), then it is resolved from the `LOG_PATH` such that `my/log.log` will point to `/var/log/my/log.log`.


# Testing

You can run available functional and unit tests like so:

```bash
cd this/directory

vendor/bin/phpunit
```
