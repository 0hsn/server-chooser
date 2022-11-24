## Server chooser

**Server chooser** is a web application that you can use to search servers for stored 
data.

### Installation

To install the software the pre-requisites are 
- [PHP 8.1](https://www.php.net/downloads.php)
- [Composer](https://getcomposer.org/download/)
- [Symfony cli](https://symfony.com/download#step-1-install-symfony-cli)

Steps to install:

- Open terminal
- Clone repository
    ```bash
    $ git clone https://github.com/0hsn/server-chooser.git
    ```

- Change to directory
    ```bash
    $ cd server-chooser
    ```
    
- Install packages 
    ```bash
    $ composer install
    ```

- To insert data prepare an `.xlsx` file in following format, and run the command
to covert and store the data in internal datastore.

  ![excel-iamge](docs/excel.png)


- Make sure `/var/uploads` directory is writable

- Build internal data store
    ```bash
    $ php bin/console app:load-excel ~/path-to-excel/LeaseWeb_servers_filters_assignment.xlsx
    ```
  
- Start web server
    ```bash
    $ symfony server:start --no-tls
    ```

- Open browser at given URL. Most of the case it's `http://127.0.0.1:8000`

### Usage

When browser is pointed to server location (most of the case it's 
`http://127.0.0.1:8000`), it's expected to see following page.

Please add or remove filters, and then press _Apply filter_ to get data. 
You'll see pagination at the bottom of search result, based on result 
stored on internal storage.

![ui](docs/ui.png)

### Development

- Fork the repository
- We'll do all new change in a new branch
- Follow _**Installation**_ steps
- Use your preferred IDE / Editor to edit code
- PR the branch against `main` repository

To run tests do following:
- Make sure you have server running
- Run `phpunit`
  ```bash
  $ php bin/phpunit
  ```
