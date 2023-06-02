cd news-api
vendor/bin/sail up -d --build
vendor/bin/sail shell // this will redirect you inside the container
 
composer install
chown -R 1000:1000 /var/www/html
php artisan migrate
php artisan db:seed
 
// You need to execute this command to aggregate the news from different source
// This should be in cron | the way it is designed is because of the rate limits on certain
// news api
 
// If you encountered this error "cURL error 60: SSL certificate: unable to get local issuer certificate"
// follow this https://stackoverflow.com/questions/29822686/curl-error-60-ssl-certificate-unable-to-get-local-issuer-certificate

php artisan app:news-aggregator --categoryId=1
php artisan app:news-aggregator --categoryId=2
php artisan app:news-aggregator --categoryId=3
 
php artisan app:news-aggregator --categoryId=4
php artisan app:news-aggregator --categoryId=5
php artisan app:news-aggregator --categoryId=6
 
// If you app_key is blank
php artisan key:generate
 
// News Credentials on .env
NEWS_SOURCE_NEWS_API_URL=https://newsapi.org
NEWS_SOURCE_NEWS_API_KEY=d4c3089e444544f7b04d6f22c374b539
 
NEWS_SOURCE_THE_GUARDIAN_API_URL=https://content.guardianapis.com
NEWS_SOURCE_THE_GUARDIAN_API_KEY=f96d061a-e2f7-4f92-bb2f-b92fce5b7619
 
NEWS_SOURCE_NY_TIMES_API_URL=https://api.nytimes.com
NEWS_SOURCE_NY_TIMES_API_KEY=Ayz9OZ8OsnvBNSlpfmQroiLht2cPrAWu