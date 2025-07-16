# Prueba técnica - Universidad Santiago de Cali

Tabla de contenidos:

[[_TOC_]]

La siguiente prueba técnica tiene como objetivo evaluar tus conocimientos técnicos relacionados a Laravel, JavaScript, bases de datos relacionales, Bootstrap y la forma en que se escribe el código a nivel de frontend y backend.

**Recomendación**: se recomienda que este archivo sea abierto en un editor que permita renderizar documentos Markdown. En Visual Studio Code, puedes previsualizar este documento ejecutando el comando de "Markdown: Open Preview" (Markdown: abrir previsualización).
## Contexto de la prueba
Una empresa requiere un desarrollo a la medida, con el fin de sistematizar sus procesos y adaptarlos a la actualidad. Se requiere que la aplicación sea web, ya que se desea una alta disponibilidad para realizar las ventas en sus diferentes sedes a nivel nacional.
## Recursos y elementos requeridos a usar
* En la carpeta docs, se comparte el modelo relacional de la base de datos.
* Tecnologías requeridas a usar e implementar:
    * Bootstrap 4.4 o superior.
    * Laravel 8.0
    * [Laravel Permission](https://spatie.be/docs/laravel-permission/v5/introduction) para implementar los roles.
    * Debe de implementar el uso de ajax de jQuery, la API fetch o XMLHTTPRequest para realizar llamadas a la API de Laravel.
* Elementos opcionales, pero que suman puntos adicionales:
    * Manejo de versionamiento haciendo uso de git.
    * [Auditorias de Laravel](https://www.laravel-auditing.com/) para realizar seguimiento a los cambios en el sistema.
    * Implementar migraciones de base de datos.
    * Los archivos de JS deberían de ser guardados en la carpeta resources/js y usar Laravel Mix para minificar el JavaScript.
    * Existe oportunidad de mejora en ciertos aspectos, por lo que se incentiva a ser creativo e intentar mejorar ciertos procesos.
## Requerimientos puntuales
* El sistema debe de permitir realizar la venta de productos y registrar su venta.
* El sistema debe de tener dos roles fundamentales: vendedor y auxiliar de bodega.
    * El auxiliar de bodega tendrá únicamente el acceso al panel de administración de productos (listado productos, creación productos).
    * El vendedor tendrá únicamente el acceso al panel de ventas e historial de ventas (listado, registro venta).

## Instalación
Clona el repositorio:

`git clone https://git.usc.edu.co/admision/pos prueba-usc`

O descarga una copia haciendo uso de GitLab: [Descarga aquí](https://git.usc.edu.co/admision/pos/-/archive/master/pos-master.zip)

Si usarás Apache/XAMPP o nginx para realizar la prueba, clona el repositorio en la carpeta usada para el servidor. La instalación mostrada tomará en cuenta que usarás el servidor web incluido con PHP.

### Instalación del servidor
Puedes instalar este repositorio de dos formas:
1. Puedes hacer uso de la configuración de Docker ya en el repositorio (esta configuración contiene un servidor de MariaDB, phpMyAdmin y Nginx). Solamente debes de ejecutar el comando `docker-compose up` para iniciar un servidor con PHP 8.0 Automáticamente, se instalarán todas las dependencias necesarias y las extensiones de PHP para ejecutar Laravel. El servidor iniciará en http://localhost. (Muy recomendado)
2. Puedes realizar la instalación de forma manual sin usar Docker, en caso de no contar con los recursos para ejecutarlo. Este repositorio contiene ya todos los paquetes necesarios de composer para realizar la prueba técnica, pero deberás de usar el servidor web incluido por PHP o usar XAMPP. (Poco recomendado)
### Instalación con Docker
Para Windows y Mac, deberás de descargar Docker Desktop:
* Windows 10: se requiere la versión 1809 o superior. [Descargar aquí.](https://docs.docker.com/desktop/windows/install/)
* macOS: se requiere 10.15 o superior. [Descargar aquí.](https://docs.docker.com/desktop/mac/install/)
* Linux: deberás buscar en los paquetes de tu distribución. Para las mayores distribuciones:
```bash
# Debian y derivados
sudo apt-get update
sudo apt-get install ca-certificates curl gnupg lsb-release
sudo mkdir -p /etc/apt/keyrings
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg
sudo apt-get update
sudo apt-get install docker-ce docker-ce-cli containerd.io docker-compose-plugin

# Fedora y derivados
sudo dnf -y install dnf-plugins-core
sudo dnf config-manager --add-repo https://download.docker.com/linux/fedora/docker-ce.repo
sudo dnf install docker-ce docker-ce-cli containerd.io docker-compose-plugin

# Arch Linux y derivados
sudo pacman -S docker docker-compose
```

### Instalación manual (sin Docker)
Debes de contar con PHP 7.3 o PHP 8.0 para instalar todas las dependencias. Ten en cuenta que para ejecutar Laravel debes de tener las siguientes extensiones:
* pdo
* sqlite3
* pdo_sqlite
* dom
* tokenizer
* fileinfo
* xml

Adicionalmente en Linux, deberás de contar con el paquete libxml2 instalado.

### Instalación de dependencias
#### Composer
Accede al contenedor de Docker si es necesario (`docker exec -it prueba_usc bash`). Ejecuta los siguientes comandos para instalar las dependencias:

`composer install`

Para la instalación en Docker, especifica que no valide las dependencias, puesto que estas están en el contenedor de Nginx.

`composer install --ignore-platform-reqs`

`cp .env.example .env`

`php artisan config:cache`
#### NPM
Accede al contenedor de Docker si es necesario (`docker exec -it prueba_usc bash`). Ejecuta los siguientes comandos para instalar las dependencias:

`npm install`

## Compila los archivos de npm
Si estás usando Docker, deberás de acceder al contenedor antes de escribir el siguiente comando:

`docker exec -it prueba_usc bash`

Por último, deberás de ejecutar cualquiera de los siguientes comandos:

`npm run dev`

`npm run watch-poll` (Produce el mismo contenido de run dev, pero escucha todos los cambios en los archivos agregados en webpack.mix.js)

## Funcionalidades disponibles para Docker
### Usuario root
Para usar el usuario root, simplemente puedes usar el comando `sudo su`. El usuario usc no tiene contraseña.
### Comandos
En Docker, podrás usar los siguientes comandos dentro del contenedor:
* `fix`: Limpia la caché de la aplicación.
### Gestión de base de datos
Cuentas con phpMyAdmin para gestionar la base de datos de forma visual. Por defecto, está expuesto al puerto 81. [Ingresa aquí](http://localhost:81)

Para iniciar sesión, inicia con el usuario root, sin especificar clave o servidor.
#### Problemas conocidos
* Puede que en Linux iniciar como root en la base de datos no funcione. Alternativamente, puedes crear un usuario con privilegios que te permita iniciar sesión. Puedes realizarlo de la siguiente forma:

```sql
CREATE USER IF NOT EXISTS 'usc'@'%' IDENTIFIED BY '';
GRANT ALL PRIVILEGES ON *.* TO 'usc'@'%';
```
### Base de datos
Cuentas con MariaDB. Para gestionar la base de datos, usa el comando `mariadb` dentro del contenedor `prueba_mariadb`
