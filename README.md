# Zoo Arcadia

## Description
Application web pour gérer les informations d'un zoo écologique, conformément à l'énoncé fourni. Le site comprend des fonctionnalités pour gérer les habitats, les services, et les interactions utilisateur (contact, navigation, etc.).

---

## Installation

1. Clonez ce dépôt : git clone https://github.com/devmaman/arcadia.git
2. Configurez la base de données en utilisant le fichier SQL fourni dans `database.sql`.
3. Mettez à jour les fichiers `/includes/*` avec vos informations (base de données, email, path image ect..)
4. Hébergez les fichiers sur un serveur prenant en charge PHP et MySQL.

## Fonctionnalités

1. Navigation entre les pages :
- Accueil
- Habitats
- Services
- Contact
- Connexion
2. Gestion des habitats et services (CRUD) pour les administrateurs.
3. Formulaire de contact avec envoi d’email.
4. Interface sécurisée (protection XSS, requêtes préparées).

---

## Dépendances
- PHP >= 7.4
- MySQL >= 5.7
- Navigateur compatible HTML5 et CSS3

---

## Auteur
Développé par BREMAUD Maryline.