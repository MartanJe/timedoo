# timedoo
simple timemanager insipred by toggl
 
## Getting Started
The project has been written in Spring and Hibernate frameworks with MySQL database. 

With Maven Jetty plugin it can be easily deployed.

### Prerequisites
*   PHP
*   MySQL
*   HTTP Server (Apache)


### Installing

1. Clone git repo

```
git clone https://github.com/MartanJe/timedoo.git
```

2. Create database using **timedoo_db_dump.sql**

3. Edit DB connection properties accordingly

```
vim ./skiingAreaIS/main/java/resources/application.properties
```

4. Go to project root folder 
```
cd ./skiingAreaIS
```
```
mvn clean install
```
```
mvn jetty:run-war
```
Done! project is deployed to localhost:8080

## Usage
    * Sample Customer account - username: user passwd: user
    * Sample Employee account - username: admin passwd: admin


Project is far from complete. Only these Use Cases were implemented:  

* As customer you can
    *   UC1 - register and log in.
    *   UC2 - anonymously (or logged in) order skipass from e-shop. Basic shopping cart is implemented. No payment or delivery options. (You will get order number with which you'll pay and pick up your order at box office.)

* As employee you can
    *   UC3 - add/remove/edit skipass to e-shop.
    *   UC4 - add/remove/edit RFID cards.
    *   UC5 - mark orders as payed.
    *   UC6 - assign RFID cards to the e-shop orders and lend them to the customers.
    *   UC7 - receive returned RFID cards.
    *   UC8 - create new order.
    *   UC9 - add new employees.
    *   UC10 - watch some basic statistics...

## Built With

* [Nette](https://spring.io/) - The web framework used

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
