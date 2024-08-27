<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public const string PROD_ENV = 'prod';
    public const string DEV_ENV = 'dev';
    public const string PUBLIC_DIR = 'public';

}
