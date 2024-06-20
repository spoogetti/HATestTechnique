H&A Location - Plateforme de test technique
========================

"H&A Location - Plateforme de test technique" est une application basée sur la "Symfony Demo Application", qui est une application de référence créée pour montrer comment développer une application Symfony en se basant sur les bonnes pratiques([Symfony Best Practices][1]).

Pré-requis
------------

  * PHP 8.2.0 minimum;
  * L'extension PDO-SQLite PHP activée;
  * Ainsi que lesand the [usual Symfony application requirements][2].

Installation
------------

Pour installer l'application, le plus simple et le plus rapide est de :

**Télécharger Symfony CLI.** Allez sur la page suivante [Download Symfony CLI][4] et installez Symfony CLI. Utilisez ensuite la commande suivante :

```bash
symfony new --demo my_project
```

Usage
-----

Il n'y a normalement rien de particulier à configurer avant de démarrer l'application. Vous pouvez démarrer le serveur symfony local tout de suite avec la commande suivante :

```bash
cd my_project/
symfony serve
```

Ensuite, vous devriez pouvoir accéder à l'adresse suivante (<https://localhost:8000> par défaut). Attention, si vous utilisez WSL2, utilisez bien "localhost" et non pas "127.0.0.1" pour accéder à l'application.

Pour exécuter les tests automatisés, utilisez la commande suivante :

```bash
cd my_project/
./bin/phpunit
```

Les consignes du test techniques sont affichées sur la page d'accueil de l'application.

[1]: https://symfony.com/doc/current/best_practices.html
[2]: https://symfony.com/doc/current/setup.html#technical-requirements
[3]: https://symfony.com/doc/current/setup/web_server_configuration.html
[4]: https://symfony.com/download
[5]: https://symfony.com/book
[6]: https://getcomposer.org/
