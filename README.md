# <center>Guitare_app (*php vanilla-projet étude*)<center>
Cette application est un projet de fin d'unité d'enseignement faite au CNAM. La consigne était de concevoir et réaliser un site de e-commerce. Pour tester c'est [par ici](https://nanookpandora.com/guitare_app/) :)
Un dossier complet est disponible [ici](https://github.com/nanookOlive/guitare_app/blob/main/Dossier%20nfa21.pdf) qui détaille l'ensemble des fonctionnalités, leur conception et réalisation. 


# Les fonctionnalités

#### - visiteurs :
* voir l'ensemble des produits référencés 
* voir le détail de chaque produit
* trier les produits selon différents critères
* afficher les distributeurs d'un produit en particulier sur une carte
* se créer un compte 
* se connecter à son profil

#### - utilisateur :
* créer ou supprimer des collections de produits favoris 
* mettre des produits en favoris
* suppression de son compte

#### - admin :
* ensemble de CRUD sur les produits ainsi que les entités liées 
* outil de newsletter 


# Contraintes techniques 

Des contraintes dans la conception et la réalisation étaient imposées, ce projet étant noté et servant à la validation d'une unité d'enseignement :
* pas de conception MVC
* toutes les classes et tous les repository associés aux classes doivent être fait "à la main"
* les pages doivent être dynamisées avec l'utilisation de requêtes AJAX 
* l'utilisateur doit valider son inscription via un mail envoyé automatiquement par l'application
* avoir une gestion d'erreur
* un système d'authentification
* une gestion de la session
