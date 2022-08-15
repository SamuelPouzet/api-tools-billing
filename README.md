Billing tools by Laminas API Tools Skeleton Application
======================================

> ## Billing tools
>Ceci est un utilitaire de gestion par API de notes de frais.
> Cet utilitaire gère via des flux JSON, la création, mise à jour, lecture simple et par liste de notes de frais
> 
> Le logiciel a été codé dans un environnement de PHP 7.3, le serveur de test de chez OVH que j'utilise ne gère pas au delà à ce jour
> 
> J'ai voulu me former sur Laminas API Tools, et ce logiciel est une expérience pour voir un peu ce que cette technologie peut faire
> Il reste quand même pas mal de choses à mettre en place pour que la techno soit pleinement utilisable sur un projet d'envergure, à mon sens. J'envisage de contribuer à l'amélioration de cette techno qui me semble quand même prometteuse, une fois mâture.
> 
> https://api-tools.getlaminas.org/
> 
----

Environnement
------------

Créé sous un serveur Apache 2.4.37, faisant tourner un PHP 7.3 et un mysql 5.7.24
Certaines choses peuvent être améliorées, j'ai mis quelques todo dans le code pour indiquer ce qu'il serait bien de faire dans les versions supérieures. 

Technologies
------------

>## API tools
> Autrefois nommé APIgility, cette technologie assez prometteuse permettra, à terme, de pouvoir créer des API rest très facilement via un panneau d'administration.
> Aujourd'hui, hélas, une partie de ce panneau ne fonctionne pas très bien, et oblige à aller bosser dans le code, ce qui est loin de me déranger.
> >Pourquoi ce choix?
> 
> Surnommé "Zend Addict" par mes collègues, en raison de mon affection pour ce framework (désormais nommé Laminas, depuis sa reprise par LINUX foundation), en raison de la proximité entre sa philosophie et la mienne, il n'a pu m'échapper, qu'il existait API tools, et j'ai eu envie de découvrir cette techologie.
> 
> Et puis, je n'aime pas suivre les courants, les modes. Rester dans les sentiers battus, c'est bien pour le travail, mais, quand je code en dehors, que j'ai le choix des technos, j'aime bien prendre des projets plus divergeants.
> Ce que j'aime dans ce genre de frameworks, c'est qu'on n'a pas l'impression de se faire macher le travail, comme avec les logiciels de Sensio, qu'on n'a parfois plus l'impression de faire du dev, mais uniquement de la configuration, là, je me sens à mon aise dans le code.
>

Installation
------------

### Database

Le module Doctrine et donc migration n'étant pas opérationnel, existants, mais composer génère une erreur, il faut créer la base de données manuellement.
>DROP TABLE IF EXISTS `bill`;
CREATE TABLE IF NOT EXISTS `bill` (
`id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL,
`date_bill` date NOT NULL,
`amount` int(11) NOT NULL,
`currency` tinyint(3) UNSIGNED NOT NULL,
`type` tinyint(3) UNSIGNED NOT NULL,
`date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
`company_id` int(10) UNSIGNED NOT NULL,
PRIMARY KEY (`id`),
KEY `user_id` (`user_id`),
KEY `currency` (`currency`),
KEY `type` (`type`),
KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
>
>DROP TABLE IF EXISTS `company`;
CREATE TABLE IF NOT EXISTS `company` (
`id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
>
>DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
`id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
`firstname` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
`mail` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
`birthdate` date NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

Trois tables sont ainsi générées, bill pour la note de frais, user pour l'utilisateur qui la gère, et company pour la société à facturer
Au départ, je voulais créer une route pour ça, mais, que ce soit en terme de sécurité ou de risque d'erreur, je ne préfère pas.

Routes
------------

En ce qui me concerne, les routes sont appelées via le logiciel Insomnia.
Je n'ai volontairement pas implémenté des delete pour les utilisateurs et les compagnies, pour limiter les risques d'erreurs
Il existe  des routes pour les utilisateurs.
> [get] /user pour obtenir la liste des utilisateurs inscrits 
> 
> [get] /user/{id} pour obtenir les données sur un utilisateur
> 
> [post] /user pour créer un utilisateur an joignant un flux JSON formatté de la sorte
> 
> [put] /user/{id} pour mettre à jour un utilisateur an joignant un flux JSON formatté de la sorte
> 
>> {
"name": "NAME",
"firstName": "FIRSTNAME",
"mail": "mail@domain.fr",
"birthdate": "1970-01-01"
}
>
Pour les compagnies
> [get] /company pour obtenir la liste des compagnies enregistrées
>
> [get] /company/{id} pour obtenir les données sur une compagnie
>
> [post] /company pour créer une compagnie an joignant un flux JSON formatté de la sorte
>
> [put] /company/{id} pour mettre à jour une compagnie an joignant un flux JSON formatté de la sorte
> 
>> {
"name": "ma belle companie"
}
> 
Enfin, pour les notes de frais

> [get] /bill pour obtenir la liste des notes enregistrées, avec les relations associées, ce qui ne me semble, d'origine, pas géré par API tools
>
> [get] /bill/{id} pour obtenir les données sur une note de frais avec l'identifiant concerné
>
> [post] /bill pour créer une note de frais an joignant un flux JSON formatté de la sorte
> 
> [put] /bill/{id} pour mettre à jour une note de frais an joignant un flux JSON formatté de la sorte
> 
>> {
"user_id": "1",
"date_bill": "1970-01-01",
"amount": "500",
"currency": "1",
"type": "1",
"date_create": "1970-01-01 00:00:00",
"company_id": "1"		
}
>
>  [del] /bill/{id} pour supprimer une note de frais
>

Déploiement
------------

Il existe plusieurs moyens de déployer le logiciel, la doc explique ça de manière très précise.
https://api-tools.getlaminas.org/documentation/deployment/intro

Points d'amélioration
--------

API tools ne me semble pas encore mûr, il reste certaines choses à améliorer. Et j'espère que pourrai contribuer à cette amélioration.
En premier lieu, le catch des erreurs 404 pourrait être meilleur, avec l'envoi d'un JSON plutôt que ce 404 brut envoyé à ce jour.

J'ai vu qu'il était possible de gérer une authentification de manière plus poussée, via Oauth2, par exemple, et ça pourrait être une solution sympathique pour upgrader le logiciel.

