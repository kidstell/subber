## Installation
Immeiately after cloning the repository at https://github.com/kidstell/subber.git

cd into the app's root directory

Run `php install.php`

Install mailpit for test environment.
By default mailpit runs on localhost and port 1025.
If your paramaters are different. please adjust the .env configuration file.

Download, install and run mailpit,
make sure that mailpit terminal remains open.

Open a command terminal and run ```php artisan serve```.

Open a separate command terminal open for ```php artisan queue:work``
This would catch and run all background jobs.

Open another command terminal opened for ```php artisan feeder```
This would collect all pending feeds and send them to their subscribers.


## Description
The seeding data provisions Users with following emails ['user0@userland.test', 'user1@userland.test', 'user2@userland.test', 'user3@userland.test'].
It also provisons Authors with keys and urls such as ['website1' => 'http://website1.test', 'website2' => 'http://website2.test','website3' => 'http://website3.test', 'website4' => 'http://website4.test'].

Currently, *user4@userland.test* is not subscribed to any website. *website4* also as no articles. 

The payload below copied from postman, would subscribe user4@userland.test to website4
```curl --location 'http://127.0.0.1:8000/api/user/subscribe' \
--form 'email="user4@sxell.com"' \
--form 'website="website4.test"'```


A similar payload shown below would create a new post for website4. 
```curl --location 'http://127.0.0.1:8000/api/author/post/create' \
--form 'title="sample title"' \
--form 'body="samle body text ettttttt"' \
--form 'author="website4"'```

If the `php artisan queue:work` is running, the new post would trigger a background job which would then create a cache of the subscription feed to be pushed.

When we do wish to push these jobs, we can then run ```php artisan feeder:push```.

merci
