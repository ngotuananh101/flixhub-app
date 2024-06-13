{ pkgs, ... }: {

  # Which nixpkgs channel to use.
  channel = "stable-23.11"; # or "unstable"

  # Use https://search.nixos.org/packages to find packages
  packages = [
    pkgs.sqlite
    pkgs.php83
    pkgs.php83Packages.composer
    pkgs.php83Extensions.xml
    pkgs.php83Extensions.curl
    pkgs.php83Extensions.dom
    pkgs.php83Extensions.fileinfo
    pkgs.php83Extensions.mbstring
    pkgs.php83Extensions.openssl
    pkgs.php83Extensions.pdo
    pkgs.php83Extensions.pdo_sqlite
    pkgs.php83Extensions.pdo_mysql
    pkgs.php83Extensions.redis
  ];

  # Sets environment variables in the workspace
  env = {
  };

  # Search for the extensions you want on https://open-vsx.org/ and use "publisher.id"
  idx.extensions = [
    "esbenp.prettier-vscode"
    "dbaeumer.vscode-eslint"
    "formulahendry.auto-close-tag"
    "formulahendry.auto-rename-tag"
    "shufo.vscode-blade-formatter"
    "codingyu.laravel-goto-view"
    "MrChetan.laravel-goto-config"
    "MrChetan.goto-laravel-components"
    "stef-k.laravel-goto-controller"
    "devsense.phptools-vscode"
    "cweijan.vscode-database-client2"
  ];

  # Enable previews and customize configuration
  idx.previews = {
    enable = true;
    previews = {
      web = {
        command = [
          "php"
          "artisan"
          "serve"
        ];
        manager = "web";
      };
    };
  };
}
