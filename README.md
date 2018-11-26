# Fast CRUD 快速增删改查 
## 本系统是一个基于lamp环境的可以快速构建增删改查的管理系统

### 技术平台
1. CodeIgniter
2. Jquery
3. Bootstrap

### 数据库文件
sql\setup.sql

### 数据库配置文件
backend\database.php

### 项目构建
```shell
mkdir project_folder
cd project_folder
git clone https://github.com/fujianjie/fast-crud-php.git
```

添加apache 域名指向到该文件夹,以xampp 为例

```shell
vim /Applications/XAMPP/etc/extra/httpd-vhosts.conf
```

添加
```apacheconfig
<VirtualHost *:80>
        DocumentRoot "/var/www/project_folder/backend"
        ServerName myprojects.wecms.com
</VirtualHost>
```

```shell
vim /etc/hosts
```

添加
```shell
127.0.0.1 myprojects.wecms.com
```

修改数据库配置文件

```shell
vim /var/www/project_folder/backend/application/config/databases.php
```

```php
$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	'username' => 'username',
	'password' => 'password',
	'database' => 'databasename',
	'dbdriver' => 'mysqli',
	'dbprefix' => 'we_',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => APPPATH.'/cache/',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
```

之后重启apache 即可访问 myprojects.wecms.com







