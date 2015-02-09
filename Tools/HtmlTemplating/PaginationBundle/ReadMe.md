#Service de pagination

##Installation

il faut ajouter le bundle au kernel :

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Id2i\Tools\HtmlTemplating\PaginationBundle\PaginationBundle(),
    );
}
```


##Utilisation

à venir