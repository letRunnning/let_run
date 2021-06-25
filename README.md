# Developer manaual

## Install tutorial

### install [composer](https://getcomposer.org/download/)

### create ci dummy project
```shell
composer create-project codeigniter/framework dummy
```
### download project
```shell
## clone project
git clone git@gitlab.com:ydagov/yda_ci.git
## assign directory
cd yda_ci
## copy config from dummy project
cp -r ../dummy/application/config/ application/
```
### setting config
* application/config/config.php
```php
$config['base_url'] = 'http://localhost/yda_ci/';
$config['index_page'] = '';
$config['enable_hooks'] = TRUE;
$config['composer_autoload'] = __DIR__ . '/autoload.php';
$config['sess_save_path'] = sys_get_temp_dir();
```
* application/config/database.php
```php
$db['default'] = array(
    'username' => 'root',
    'password' => '',
    'database' => 'yda',
);
```
* application/config/autoload.php
```php
$autoload['libraries'] = array('database', 'session');
$autoload['helper'] = array('url');
```
* application/config/routes.php
```php
$route['default_controller'] = 'user';
```
* application/config/hooks.php
```php
$hook['post_controller'] = [
    'class' => 'QueryLogger',
    'function' => 'save',
    'filename' => 'QueryLogger.php',
    'filepath' => 'hooks',
    'params' => ''
];
```
### database setting
* copy 'schema.sql' to your phpmyadmin and execute
* copy 'seeder.sql' to your phpmyadmin and execute

## Syntax rules

### Name rule definition
* snake_case/SNAKE_CASE
    * 此類命名又細分為全小寫(snake_case)和全大寫(SNAKE_CASE)類型
    * 使用底線將名詞分開
* camelCase
    * 使用大寫將名詞分開
* PascalCase
    * 名詞的開頭皆為大寫
* kebeb-case
    * 皆為小寫
    * 使用破折號將名詞分開

### Database name
* 採用snake_case(因為有些資料庫是case insensitive)
### Directory
* 配合主流網頁框架的命名方式
* 無上述情況時，皆採用snake_case
### Files name
* 當內容為物件時，採用PascalCase
* 無上述情況時，皆採用snake_case
### Variable name
* 請盡量避免縮寫
* 當變數為常數時，採用SNAKE_CASE，其餘採用camelCase
* 如變數內容為array型態，名詞請使用複數型態
* 變數需盡可能採用{名詞、形容詞+名詞、名詞+名詞}結構
### Function name
* 為了與變數名稱做出區隔，故採用snake_case

## Development tutorial
```shell
## ensure you are at the project root directory
cd yda_ci
## direct current branch to 'dev' 
git checkout dev
## create new branch from 'dev'
git checkout -b <new_branch>
```