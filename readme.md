**⚡️ Chidori --- Feel the power of lightning ⚡️**

## Chidori
Chidori is a lightweight PHP framework designed for rapid development of web applications. Inspired by _**Symfony**_ and _**Laravel**_ - it is built with simplicity and performance in mind, making it an ideal choice for developers who want to create robust applications without the overhead of larger frameworks.

You want to start small? No problem **_Chidori_** is giving you freedom to start smaller and expand as you need. Feel free to add your own packages that integrates within our MVC structure.

## 📁 Project Structure

```aiignore
my_proj/
│
├── public/                 # 🌐 Public root – entry point for all HTTP requests
│   └── index.php           # Main entrypoint (like in all modern frameworks)
│
├── src/                    # 🧠 Your custom PHP code (Composer autoloaded)
│   ├── Core/               # General helpers and utility classes
│   │   ├── Router.php
│   │   ├── App.php
│   │   ├── Session.php
│   │   └── Auth.php
│   │
│   ├── Controllers/        # 🎯 Controllers – handle rendering pages or APIs
│   │   ├── ApiController.php
│   │   └── HomeController.php
│   │
│   ├── Models/             # 🗄️ Database models, ORM, and entities
│       ├── User.php
│       └── Product.php
│
├── views/                  # 🖼️ Views (Blade-style or plain PHP)
│   ├── layout/
│   ├── components/
│   └── home.php
│
├── routes/                 # 🛣️ Defined application routes
│   └── web.php             # Web routes
│
├── vendor/                 # 📦 Composer vendor folder (3rd party libraries)
├── composer.json           # 📝 Composer configuration and autoload definition
├── .htaccess               # ⚙️ Apache rewrite config (everything routes to /public/index.php)
└── README.md               # 📖 Project documentation

```