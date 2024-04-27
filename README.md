Install mailpit for test environment. 
By default mailpit runs on localhost and port 1025.
If your paramaters are different. please adjust the .env configuration file.

Open a command terminal and run ```php artisan serve```.

Open a separate command terminal open for ```php artisan queue:work``
This would catch and run all background jobs

Open another command terminal opened for ```php artisan feeder```
This would collect all pending feeds and send them to their subscribers