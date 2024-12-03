# Projecte de Gestió d'Usuaris
## Daniel Torres Sanchez

Aquest projecte permet gestionar usuaris i articles mitjançant funcionalitats CRUD (crear, llegir, actualitzar, eliminar). Inclou sistemes d'inici de sessió, registre, recuperació de contrasenyes i recordatori d'usuari mitjançant cookies.

## Descripció General

Un sistema que permet la creació i administració d'usuaris, així com la inserció i modificació d'articles. A més, compta amb un sistema d'expiració de sessions i gestió de cookies per recordar els usuaris durant l'autenticació.

### Usuari Admin

S'ha creat un usuari administrador que pot esborrar altres usuaris. Quan un usuari és esborrat, tots els seus articles associats també són esborrats. Aquesta decisió es va prendre per mantenir la integritat i seguretat de la base de dades, ja que els articles podrien contenir informació personal de l'usuari eliminat.

### Tecnologies Utilitzades

- **PHP**: Llenguatge principal per al backend i la lògica del projecte.
- **MySQL**: Base de dades per emmagatzemar usuaris i articles.
- **PHPMailer**: Biblioteca per gestionar l'enviament de correus electrònics.
- **HTML/CSS**: Estructura i disseny de la interfície.

## Canvis Recents

- **Data**: 27/10/2024
- **Descripció de canvis**:
    - Correcció de problemes de numeració d'ID en els articles.
    - Afegit l'apartat per modificar cada article.
    - Implementació d'expiració de sessions automàtiques per inactivitat.
    - Implementació de funcionalitats de cookies per recordar els usuaris.
    - Creació d'un usuari administrador amb capacitat per esborrar altres usuaris i els seus articles associats.

## Estructura del Projecte

```plaintext
/projecte
│
├── Controlador
│   ├── db_connection.php # Fitxer de connexió a la base de dades
│   ├── id_manager.php # Funcions per gestionar i reajustar els IDs dels articles
│   ├── inserir.php # Controlador per inserir nous articles
│   ├── esborrar.php # Controlador per eliminar articles
│   ├── modificar.php # Controlador per modificar articles
│   ├── update_profile.php # Controlador per actualitzar el perfil d'usuari
│   ├── esborrar_usuari.php # Controlador per eliminar usuaris (només per a administradors)
│
├── Estils
│   ├── estils.css # Fitxer CSS amb estils per al projecte
│   ├── editar_perfil.css # Fitxer CSS per a la pàgina d'editar perfil
│   ├── inserir.css # Fitxer CSS per a la pàgina d'inserir articles
│   ├── login_registre.css # Fitxer CSS per a les pàgines de login i registre
│   ├── modificar.css # Fitxer CSS per a la pàgina de modificar articles
│   ├── reenviar_contrasenya.css # Fitxer CSS per a la pàgina de reenviar contrasenya
│   ├── restablir_contrasenya.css # Fitxer CSS per a la pàgina de restablir contrasenya
│
├── PHPMailer # Carpeta per gestionar l'enviament de correus electrònics
│   ├── Exception.php # Classe d'excepcions per PHPMailer
│   ├── PHPMailer.php # Classe principal de PHPMailer
│   └── SMTP.php # Classe per a la configuració SMTP
│
├── Vista # Carpeta amb fitxers de vistes HTML per formularis i seccions estàtiques
│   ├── editar_perfil.php # Formulari HTML per editar el perfil d'usuari
│   ├── inserir.php # Formulari HTML per inserir nous articles
│   ├── login.php # Formulari d'inici de sessió
│   ├── modificar.php # Formulari HTML per modificar articles
│   ├── registre.php # Formulari HTML per registrar un nou usuari
│   ├── vista_inserir.php # Vista per inserir articles
│   ├── vista_login.php # Vista per iniciar sessió
│   ├── vista_modificar.php # Vista per modificar articles
│   ├── vista_nova_contrasenya.php # Vista per recuperar contrasenya
│   ├── vista_registre.php # Vista per registrar un nou usuari
│   ├── vista_reset_password.php # Vista per restablir contrasenya
│
├── [index.php](http://_vscodecontentref_/3) # Pàgina principal del projecte
└── .htaccess # Fitxer de configuració del servidor
