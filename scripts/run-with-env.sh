#!/usr/bin/env bash
# ==============================================================================
# Apex Digital - Portable Environment Test & Command Runner
#
# Automatically discovers PHP, MySQL socket, and WP-CLI binaries across:
# 1. CI / GitHub Actions environments (standard system PATH)
# 2. Local by Flywheel macOS / Linux environments
# 3. Custom developer environments via standard environment variables:
#    - PHP_BIN: Custom PHP binary path
#    - MYSQL_SOCKET: Custom MySQL unix socket path
#    - WP_PATH: Path to WordPress root directory
#    - WP_CLI_BIN: Custom WP-CLI binary path
# ==============================================================================

COMMAND="${1:-test}"

# 1. Resolve PHP Binary
if [[ -n "$PHP_BIN" && -x "$PHP_BIN" ]]; then
    PHP_EXEC="$PHP_BIN"
elif command -v php >/dev/null 2>&1; then
    PHP_EXEC="$(command -v php)"
elif [[ -d "/Applications/Local.app/Contents/Resources/extraResources/lightning-services" ]]; then
    PHP_EXEC="$(find /Applications/Local.app/Contents/Resources/extraResources/lightning-services/php-* -name php 2>/dev/null | head -n 1)"
else
    PHP_EXEC="php"
fi

# 2. Resolve MySQL Socket (if running under Local without standard TCP)
PHP_OPTS=()
if [[ -n "$MYSQL_SOCKET" ]]; then
    PHP_OPTS+=("-d" "mysqli.default_socket=$MYSQL_SOCKET")
elif [[ -d "$HOME/Library/Application Support/Local/run" ]]; then
    FOUND_SOCKET="$(find "$HOME/Library/Application Support/Local/run" -name "mysqld.sock" 2>/dev/null | head -n 1)"
    if [[ -n "$FOUND_SOCKET" ]]; then
        PHP_OPTS+=("-d" "mysqli.default_socket=$FOUND_SOCKET")
    fi
fi

# 3. Resolve WordPress Root Path
if [[ -n "$WP_PATH" && -d "$WP_PATH" ]]; then
    WP_ROOT="$WP_PATH"
elif [[ -f "../wp-load.php" ]]; then
    WP_ROOT="$(cd .. && pwd)"
elif [[ -f "/tmp/wordpress/wp-load.php" ]]; then
    WP_ROOT="/tmp/wordpress"
else
    WP_ROOT="$(pwd)"
fi

# 4. Resolve WP-CLI Binary
if [[ -n "$WP_CLI_BIN" && -x "$WP_CLI_BIN" ]]; then
    WP_CLI="$WP_CLI_BIN"
elif command -v wp >/dev/null 2>&1; then
    WP_CLI="$(command -v wp)"
elif [[ -f "/Applications/Local.app/Contents/Resources/extraResources/bin/wp-cli/wp-cli.phar" ]]; then
    WP_CLI="/Applications/Local.app/Contents/Resources/extraResources/bin/wp-cli/wp-cli.phar"
else
    WP_CLI="wp"
fi

# 5. Resolve Composer Binary
if command -v composer >/dev/null 2>&1; then
    COMPOSER_BIN="$(command -v composer)"
elif [[ -f "/Applications/Local.app/Contents/Resources/extraResources/bin/composer/composer.phar" ]]; then
    COMPOSER_BIN="$PHP_EXEC /Applications/Local.app/Contents/Resources/extraResources/bin/composer/composer.phar"
else
    COMPOSER_BIN="composer"
fi

# 6. Execute Desired Action
case "$COMMAND" in
    lint-php)
        find themes/agency-site plugins/agency-site-core tests -name node_modules -prune -o -name vendor -prune -o -name "*.php" -exec "$PHP_EXEC" -l {} \;
        ;;
    phpcs)
        shift
        "$PHP_EXEC" vendor/bin/phpcs --standard=phpcs.xml --warning-severity=0 "$@"
        ;;
    phpcs-strict)
        shift
        "$PHP_EXEC" vendor/bin/phpcs --standard=phpcs.xml "$@"
        ;;
    phpcbf)
        shift
        "$PHP_EXEC" vendor/bin/phpcbf --standard=phpcs.xml "$@"
        ;;
    phpunit)
        "$PHP_EXEC" "${PHP_OPTS[@]}" vendor/bin/phpunit
        ;;
    behavioural)
        "$PHP_EXEC" "${PHP_OPTS[@]}" "$WP_CLI" --path="$WP_ROOT" eval-file tests/run-all-tests.php
        ;;
    emails)
        "$PHP_EXEC" "${PHP_OPTS[@]}" "$WP_CLI" --path="$WP_ROOT" eval-file tests/send-test-emails.php
        ;;
    wp)
        shift
        "$PHP_EXEC" "${PHP_OPTS[@]}" "$WP_CLI" --path="$WP_ROOT" "$@"
        ;;
    composer)
        shift
        $COMPOSER_BIN "$@"
        ;;
    *)
        echo "Unknown command: $COMMAND"
        echo "Available: lint-php, phpunit, behavioural, emails"
        exit 1
        ;;
esac
