<?php

namespace App\TwigExtensions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters():array
    {
        return [
            new TwigFilter('Somme', [$this, 'Somme']),
            new TwigFilter('DefaultImage',[$this,'DefaultImage']),
            new TwigFilter('Moyenne',[$this,'Moyenne'])
        ];
    }
    public function DefaultImage(string $path):string
    {
        if (strlen(trim($path))==0){
            return 'home.jpg';
        }
        return $path;
    }
    public function Somme(array $tab):float{
        $somme = 0;
        for($i=0;$i<count($tab);$i++){
            $somme += $tab[$i];
        }
        return $somme;
    }
    public function Moyenne(array $tab):float{
        $somme = $this->Somme($tab);
        return $somme/count($tab);
    }
}