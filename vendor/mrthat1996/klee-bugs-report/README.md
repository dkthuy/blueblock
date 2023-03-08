# Klee Bugs Report

## Install

Install package

```shell
composer require mrthat1996/klee-bugs-report
```

Add ServiceProvider

```shell
Mrthat1996\KleeBugsReport\Providers\KleeBugsReportServiceProvider::class
```

Public configuration

```shell
php artisan vendor:publish --provider="Mrthat1996\KleeBugsReport\Providers\ServiceProvider"
```