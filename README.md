#SANS DOCKER:
- Lancer un make build et le projet s'installera (js&css, bdd, fixtures, serveur)
- Le site est accessible via l'uri: http://127.0.0.1:8000

#AVEC DOCKER:
- Couper l'apache local et le mysql/mariadb local
- Modifier le fichier app/config/parameters.yml.dist: changer 127.0.0.1 en db pour le database_host
- Lancer un make build_docker et le projet s'installera (js&css, containers, bdd, fixtures)
- Le site est accessible via l'uri: http://127.0.0.1

- malheureusement, je n'ai pas eu le temps de mettre en place un container java, donc la commande assetic:dump doit être exécutée en local. Une amélioration en perspective ;-)

#PHPMYADMIN
- Il est accessible via l'uri: http://127.0.0.1:8080

#MAIL
Pour tester l'envoi des mails, il faut renseigner le mailer_transport, mailer_host, mailer_user et mailer_password dans parameters.yml

NB: j'avais un template tout prêt qui collait à ce type de test. Je me suis fait plaisir!