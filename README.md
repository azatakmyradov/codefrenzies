<p align="center" style="font-size: 60px;"><a href="https://codefrenzies.com">CodeFrenzies</a></p>

<p align="center">
<a href="https://github.com/azatakmyradov/blog-laravel/actions/workflows/laravel.yml"><img src="https://github.com/azatakmyradov/blog-laravel/actions/workflows/laravel.yml/badge.svg" alt="Build Status"></a>

## Installation

Create .env file
```
cp .env.example .env
```

Install composer components
```
composer install --ignore-platform-reqs
```

Install NPM packages
```
npm install
```

Generate app key
```
php artisan key:generate
```

## Run

Development:
```
npm run dev
```

Production
```
npm run build
```

## Testing
```
php artisan test
```
