/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  dickaspring
 * Created: Jul 4, 2018
 */

create table unit(
    unit_id int not null auto_increment,
    unit_name varchar(255) not null,
    
    constraint pk_unit_id primary key(unit_id)
);

create table orders(
    orders_item_id int not null auto_increment,
    order_id varchar(255) null,
    item_name varchar(255) null,
    item_quantity int(255) null,
    item_unit varchar(255) null,

    constraint pk_orders_orders_item_id primary key(orders_item_id)
);
