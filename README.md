<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <header>
        <div class="header-conte                <li><strong>Accéder à l'application :</strong>
                    <p>Ouvrir <a href="http://localhost:8000" target="_blank" class="button">http://localhost:8000</a> dans votre navigateur.</p>
                </li>
            </ol>
        </section>

        <section>
            <h2>Fonctionnalités principales</h2>
            <ul>        <div class="logo">Drive Ivoire</div>
            <div class="tagline">La plateforme d'achat, vente et location de véhicules en Côte d'Ivoire</div>
        </div>
    </header>
    <main>
        <section>
            <h2>À propos du projet</h2>
            <p>Drive Ivoire est une plateforme web permettant d'acheter, vendre et louer des véhicules en Côte d'Ivoire. Elle facilite la mise en relation entre particuliers et entreprises, propose un système de messagerie interne, la gestion des favoris, des avis sur les véhicules, et offre une interface d'administration complète pour la gestion des utilisateurs, annonces, marques et types de véhicules.</p>
        </section>EADME - Drive Ivoire</title>
    <style>
        body {
            font-family: 'Figtree', 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }
        header {
            background: #00A99D; /* drive-teal */
            color: #fff;
            padding: 2rem 0;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .logo {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }
        .tagline {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        main {
            padding: 2rem;
            max-width: 900px;
            margin: auto;
            background: #fff;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: -30px;
        }
        h1, h2, h3 {
            color: #00A99D; /* drive-teal */
        }
        h2 {
            border-bottom: 2px solid #F7B500; /* drive-yellow */
            padding-bottom: 0.5rem;
            margin-top: 2rem;
        }
        section {
            margin-bottom: 2.5rem;
        }
        ul {
            margin: 1rem 0;
            padding-left: 1.5rem;
        }
        ul li {
            margin-bottom: 0.5rem;
            position: relative;
        }
        ul li::before {
            content: "";
            position: absolute;
            left: -1.2rem;
            top: 0.6rem;
            width: 8px;
            height: 8px;
            background-color: #F7B500; /* drive-yellow */
            border-radius: 50%;
        }
        code {
            background: #f4f4f4;
            padding: 0.2rem 0.4rem;
            border-radius: 4px;
            border-left: 3px solid #00A99D; /* drive-teal */
        }
        pre {
            background-color: #f8f8f8;
            padding: 1rem;
            border-radius: 6px;
            overflow-x: auto;
            border-left: 4px solid #F7B500; /* drive-yellow */
        }
        a {
            color: #00A99D; /* drive-teal */
            text-decoration: none;
            font-weight: 500;
        }
        a:hover {
            text-decoration: underline;
        }
        .button {
            display: inline-block;
            background-color: #00A99D; /* drive-teal */
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #008f85;
            text-decoration: none;
        }
        ol {
            counter-reset: item;
            padding-left: 0;
        }
        ol li {
            display: block;
            margin-bottom: 1.5rem;
            position: relative;
            padding-left: 2.5rem;
        }
        ol li::before {
            content: counter(item);
            counter-increment: item;
            background-color: #F7B500; /* drive-yellow */
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            left: 0;
            top: 0;
            font-weight: bold;
        }
        footer {
            text-align: center;
            margin-top: 3rem;
            padding: 1.5rem 0;
            background-color: #00A99D; /* drive-teal */
            color: white;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Drive Ivoire</h1>
    </header>
    <main>
        <section>
            <h2>À propos du projet</h2>
            <p>Drive Ivoire est une plateforme web permettant d’acheter, vendre et louer des véhicules en Côte d’Ivoire. Elle facilite la mise en relation entre particuliers et entreprises, propose un système de messagerie interne, la gestion des favoris, des avis sur les véhicules, et offre une interface d’administration complète pour la gestion des utilisateurs, annonces, marques et types de véhicules.</p>
        </section>

        <section>
            <h2>Comment lancer le projet</h2>
            <ol>
                <li><strong>Cloner le dépôt :</strong>
                    <pre><code>git clone &lt;url-du-repo&gt;
cd drive_ivore</code></pre>
                </li>
                <li><strong>Installer les dépendances PHP et JS :</strong>
                    <pre><code>composer install
npm install</code></pre>
                </li>
                <li><strong>Configurer l’environnement :</strong>
                    <ul>
                        <li>Copier <code>.env.example</code> vers <code>.env</code> et adapter les variables (base de données, mail, etc.).</li>
                        <li>Générer la clé d’application :
                            <pre><code>php artisan key:generate</code></pre>
                        </li>
                    </ul>
                </li>
                <li><strong>Lancer les migrations et seeders :</strong>
                    <pre><code>php artisan migrate --seed</code></pre>
                </li>
                <li><strong>Démarrer le serveur de développement :</strong>
                    <pre><code>php artisan serve
npm run dev</code></pre>
                </li>
                <li><strong>Accéder à l’application :</strong>
                    <p>Ouvrir <a href="http://localhost:8000" target="_blank">http://localhost:8000</a> dans votre navigateur.</p>
                </li>
            </ol>
        </section>

        <section>
            <h2>Fonctionnalités principales</h2>
            <ul>
                <li>Gestion des annonces de véhicules : publication, modification, suppression, filtrage par marque et type.</li>
                <li>Messagerie interne : communication directe entre acheteurs et vendeurs.</li>
                <li>Favoris : ajout et gestion des véhicules favoris.</li>
                <li>Avis et notes : possibilité de laisser un avis sur un véhicule.</li>
                <li>Profils utilisateurs : profils particuliers, vendeurs et entreprises avec informations personnalisées.</li>
                <li>Tableau de bord administrateur : gestion des utilisateurs, véhicules, marques, types, statistiques et modération des avis/messages.</li>
                <li>Notifications en temps réel : alertes pour nouveaux messages et activités.</li>
                <li>Progressive Web App (PWA) : installation sur mobile, fonctionnement hors ligne, notifications push.</li>
                <li>Sécurité : authentification, gestion des rôles, protection des routes sensibles.</li>
            </ul>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Drive Ivoire. Tous droits réservés.</p>
        <p>Développé avec passion par l'équipe Drive Ivoire</p>
    </footer>
</body>
</html>
