## Project Overview

This project is a URL shortener service. It allows users to create short URLs that redirect to a destination URL. The service also keeps track of the number of views for each short URL.

#### Dashboard Page:
![image description](/public/images/dashboard.png)


## Prerequisites

- PHP 7.4 or higher
- MySQL or any other database
- Composer


## Installation

1. Clone the repository
git clone repoURL

2. Install dependencies

```bash
  npm install
```

Run mix

```bash
  npm run dev
```

Install PHP dependencies

```bash
  composer install
```

Generate Key

```bash
  php artisan key:generate
```

3. Create a `.env` file and set the database configurations
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=url_shortener
DB_USERNAME=root
DB_PASSWORD=

4. Run the migrations to create the necessary tables
```bash
php artisan migrate
```

5. Start the application
```bash
php artisan serve
```

### Testing

To run the tests, use the following command:
```bash
php artisan test
```
Results
![image description](/public/images/tests.png)


### Job to delete inactive URLs
To run job immediately, run 
```bash
php artisan url:cleanup
```
After running above command you can see running Job in laravel telescope by visiting 'APP_URL'/telescope/jobs
![image description](/public/images/job.png)

### Post API
To shortening URL API route is 'APP_URL'/api/shorten
![image description](/public/images/api.png)

## Conclusion

This is a URL-shortening service that allows users to shorten long URLs and track the number of times the link has been opened. The service is built using the Laravel framework, which is a popular PHP framework known for its elegant syntax and efficient performance. The website follows best practices for optimized and efficient code, ensuring that the service is fast and reliable for users.

The website also includes a form for creating new URLs, which is only accessible to logged-in users. This added security feature ensures that only authorized users can create new shortened URLs, preventing any potential misuse of the service. The form allows users to input a long URL and then generate a shortened version that can be shared with others. The service also tracks the number of times the link has been opened, giving users valuable insights into the performance of their shortened links.
