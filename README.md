# AntiFallDamage

AntiFallDamage prevents fall damage for players in the worlds selected by the server configuration.

[![Build](https://github.com/NhanAZ-Plugins/AntiFallDamage/actions/workflows/build.yml/badge.svg)](https://github.com/NhanAZ-Plugins/AntiFallDamage/actions/workflows/build.yml)

## Requirements and compatibility

- An Axolotl-PM server with plugin API 5.0.0. The exact server source revision used for CI is pinned in the [build workflow](.github/workflows/build.yml).
- PHP 8.1 or newer with the extensions required by Axolotl-PM.

The minimum server patch release and compatibility across every Axolotl-PM 5.x release have not been established independently. The API declaration in [plugin.yml](plugin.yml) is kept at 5.0.0 because the plugin has no verified need for a higher API minimum.

## Installation

1. Download `AntiFallDamage.phar` from the [v2.0.3 release](https://github.com/NhanAZ-Plugins/AntiFallDamage/releases/tag/v2.0.3).
2. Place the PHAR in the server's `plugins` directory.
3. Start the server to generate `config.yml`, then stop it before editing the configuration.
4. Restart the server after changing the configuration.

## Configuration

| Setting | Default | Effect |
|---|---|---|
| `Mode` | `all` | `all` protects players in every world. `whitelist` protects only listed worlds. `blacklist` protects all worlds except listed worlds. |
| `Worlds` | `[]` | World display names used by whitelist and blacklist mode. Matching is case sensitive. |
| `permissions` | `false` | When `true`, only players with `antifalldamage.use` or operator permission are protected. When `false`, every player in a selected world is protected. |

The permission `antifalldamage.use` defaults to operators. Fall damage to other entity types is unaffected. An invalid `Mode` value falls back to `all`. If `Worlds` is not a list, it is treated as empty. The `permissions` setting is enabled only by the YAML boolean `true`.

## Build and validation

CI uses [DevTools v1.0.1](https://github.com/NhanAZ/DevTools/releases/tag/v1.0.1) with a pinned Axolotl-PM source revision. It runs PHPStan level max, lints the source, builds a standalone PHAR, checks the included manifest, source, configuration and license, then uploads the artifact with build metadata.

For a local build with that DevTools release, run:

```sh
php -d phar.readonly=0 path/to/DevTools/bin/devtools.php build --project=. --out=build
```

A successful PHAR build checks packaging. A clean server boot checks plugin loading. Actual player fall damage behavior still requires a Bedrock client or a server test with a real player.

## Upgrade and rollback

Version 2.0.3 keeps the permission and configuration keys. It validates world list types, matches world names exactly and defaults an unknown mode to `all`. Save the existing PHAR and `config.yml` before upgrading. Stop the server before replacing the PHAR. Restore those files if the new matching behavior does not suit your configuration. See [CHANGELOG.md](CHANGELOG.md).

## License and support

The source retains its existing [GNU GPL version 3 license](LICENSE). For support, open a GitHub issue or use [NhanAZ Discord](https://discord.gg/j2X83ujT6c).
