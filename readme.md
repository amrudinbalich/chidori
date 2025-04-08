⚡️ Chidori — Lightweight PHP starter kit with custom routing, autoloading, and DI foundation. No bloat. Just control.


General Schema:

my_proj/
│
├── public/                 # Public root - ulaz za sve requeste
│   └── index.php           # Glavni entrypoint, kao kod svakog modernog frameworka
│
├── src/                    # Tvoj vlastiti kod (Composer autoload-ovan)
│   ├── Core/               # Generalne helpers/util klase (App, Router, Session, Auth...)
│   │   └── Router.php
│   │   └── App.php
│   │   └── Session.php
│   │   └── Auth.php
│   │
│   ├── Controllers/        # Kontroleri koji renderuju pageove ili API-je
│   │   └── HomeController.php
│   │   └── ProductController.php
│   │
│   ├── Models/             # Baza, ORM, entiteti
│   │   └── User.php
│   │   └── Product.php
│   │
│   └── Views/              # Blade-style ili plain PHP view-ovi
│       ├── layout/
│       ├── components/
│       └── home.php
│
├── routes/
│   └── web.php             # Rute za web
│
├── vendor/                 # Composer vendor folder (3rd party libovi)
├── composer.json           # Composer definicija + autoload
├── .htaccess               # Rewrite za Apache (sve ide na /public/index.php)
└── README.md
