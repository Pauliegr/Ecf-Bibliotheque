#!/bin/bash

# # Suppression de toutes les tables
# php bin/console doctrine:schema:drop --full-database --force --no-interaction
# # Création du schéma BD
# php bin/console doctrine:migrations:migrate --no-interaction
# # Validation du schéma BD
# php bin/console doctrine:schema:validate
# injection des données de teste dans la BDD
php bin/console doctrine:fixtures:load --no-interaction

# php bin/console ma:mi
# php bin/console do:mi:di
# php bin/console do:mi:mi
