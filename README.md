# Database Table
Messages
```
CREATE TABLE `messages` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `userid` varchar(32) NOT NULL,
 `message` varchar(128) NOT NULL,
 `created` varchar(32) NOT NULL,
 `deleted` int(1),
 `deleter` varchar(32),
 PRIMARY KEY (`id`)
) 
```