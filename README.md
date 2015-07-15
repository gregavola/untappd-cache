### Untappd Cache ###


A simple cache library that uses UntappdPHP (http://github.com/gregavola/UntappdPHP) to cache results to a ```json``` file to avoid hitting your rate limit

# Requirements
PHP 5+<br />
CURL<br />
A writeable directory to store the cache files<br />

# API Setup
In order to get access the API - go https://untappd.com/api and request an API token. Please note it may take up to 2 weeks to a API keys. Only application ideas are accepted at this time to perserve infrastruture and bandwidth.

# Getting Started

1. Do a ```git clone https://github.com/gregavola/untappd-cache``` to pull down the respository
2. Add your ```client_id``` and ```client_secret``` to the ```request.php``` on line 13, 14.
3. Take a look at the examples in ```ex,aple.html``` on how to query the ```request.php``` file by passing the ```bid``` in question.

**Note**: When deploying to your server, make sure the ```cache``` folder has permissions of 777 (is writeable). The full path is located on line 20 of ```request.php```.

When you are completed testing you can deploy the following files to your server under a ```untappd-cache``` folder:
- ```cache\```
- ```untappdPHP.php```
- ```handleCache.php```
- ```request.php```.

You will the make ```ajax``` requests to ```http://yourwesite.com/untappd-cache/request.php?bid=###``` where ### is your Beer ID.

# To Do
Error Handling

# Getting Help
If you need help or have questions, please contact Greg Avola on Twitter at http://twitter.com/gregavola
